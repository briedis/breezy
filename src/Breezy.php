<?php


namespace Draugiem\BreezySync;


use Draugiem\BreezySync\Exceptions\BreezyApiException;
use Draugiem\BreezySync\Exceptions\BreezyException;
use Draugiem\BreezySync\Structures\CandidateItem;
use Draugiem\BreezySync\Structures\CompanyItem;
use Draugiem\BreezySync\Structures\PositionItem;

class Breezy
{
    /** @var BreezyApiClient */
    private $api;

    public function __construct()
    {
        $this->api = new BreezyApiClient;
    }

    /**
     * @param $email
     * @param $password
     * @return mixed
     */
    public function signIn($email, $password)
    {
        $response = $this->api->post('signin', [
            'email' => $email,
            'password' => $password,
        ]);

        $token = $response['access_token'];

        // Remember token for all consecutive request
        $this->api->setToken($token);

        return $token;
    }

    /**
     * Get companies with positions
     * @return CompanyItem[]
     * @throws BreezyApiException
     * @throws BreezyException
     */
    public function getCompaniesWithPositions()
    {
        $response = $this->api->get('user/details');

        $re = [];

        foreach ($response as $v) {
            $company = $this->getCompanyItem($v['company']);

            foreach ($v['positions'] as $v2) {
                $company->positions[] = $this->getPositionItem($v2);
            }

            $re[] = $company;
        }

        return $re;
    }

    /**
     * @param CandidateItem $candidate
     * @return CandidateItem
     */
    public function addCandidate(CandidateItem $candidate)
    {
        $path = '/company/' . $candidate->companyId . '/position/' . $candidate->positionId . '/candidates';

        $rawCandidate = $this->api->post($path, [
            'name' => $candidate->name,
            'email_address' => $candidate->email,
            'phone_number' => $candidate->phoneNumber,
            'summary' => $candidate->summary,
            'status' => $candidate->status,
        ]);

        return $this->getCandidateItem($rawCandidate);
    }

    /**
     * Newly created position
     * @param PositionItem $position
     * @throws BreezyException
     * @return PositionItem Created position from backend
     */
    public function createPosition(PositionItem $position)
    {
        if (!$position->companyId) {
            throw new BreezyException('Company id is not set');
        }

        $response = $this->api->post('company/' . $position->companyId . '/positions', [
            'name' => $position->name,
            'description' => $position->description,
            'state' => $position->state,
            'type' => [
                'id' => 'fullTime',
                'name' => 'Full-Time',
            ],
        ]);

        return $this->getPositionItem($response);
    }

    /**
     * Convert position response to item
     * @param array $rawPosition
     * @return PositionItem
     */
    private function getPositionItem(array $rawPosition)
    {
        $position = new PositionItem;

        $position->rawData = $rawPosition;
        $position->id = $rawPosition['_id'];
        $position->companyId = $rawPosition['company']['_id'];
        $position->name = $rawPosition['name'];
        $position->department = isset($rawPosition['department']) ? $rawPosition['department'] : '';
        $position->description = $rawPosition['description'];
        $position->type = $rawPosition['type']['name'];
        $position->experience = isset($rawPosition['experience']['name']) ? $rawPosition['experience']['name'] : '';
        $position->createdAt = strtotime($rawPosition['creation_date']);
        $position->updatedAt = strtotime($rawPosition['updated_date']);
        $position->state = $rawPosition['state'];

        return $position;
    }

    /**
     * Convert company response to item
     * @param array $rawCompany
     * @return CompanyItem
     */
    private function getCompanyItem(array $rawCompany)
    {
        $company = new CompanyItem;

        $company->rawData = $rawCompany;
        $company->id = $rawCompany['_id'];
        $company->name = $rawCompany['name'];
        $company->description = $rawCompany['description'];
        $company->url = $rawCompany['url'];
        $company->logo = $rawCompany['logo_url'];

        return $company;
    }

    /**
     * Convert
     * @param $rawCandidate
     * @return CandidateItem
     */
    private function getCandidateItem(array $rawCandidate)
    {
        $candidate = new CandidateItem;

        $candidate->rawData = $rawCandidate;
        $candidate->name = $rawCandidate['name'];
        $candidate->positionId = $rawCandidate['position_id'];
        $candidate->email = $rawCandidate['email_address'];
        $candidate->phoneNumber = $rawCandidate['phone_number'];
        $candidate->status = $rawCandidate['status'];
        $candidate->summary = $rawCandidate['summary'];

        return $candidate;
    }
}