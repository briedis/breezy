<?php


namespace Draugiem\BreezySync;


use Draugiem\BreezySync\Exceptions\BreezyApiException;
use Draugiem\BreezySync\Exceptions\BreezyException;
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
    private function getPositionItem($rawPosition)
    {
        $position = new PositionItem;

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
     * @param $rawCompany
     * @return CompanyItem
     */
    private function getCompanyItem($rawCompany)
    {
        $company = new CompanyItem;

        $company->id = $rawCompany['_id'];
        $company->name = $rawCompany['name'];
        $company->description = $rawCompany['description'];
        $company->url = $rawCompany['url'];
        $company->logo = $rawCompany['logo_url'];

        return $company;
    }
}