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
    public function singIn($email, $password)
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
     * Convert position response to item
     * @param array $rawPosition
     * @return PositionItem
     */
    private function getPositionItem($rawPosition)
    {
        $position = new PositionItem;

        $position->id = $rawPosition['_id'];
        $position->name = $rawPosition['name'];
        $position->department = $rawPosition['department'];
        $position->description = $rawPosition['description'];
        $position->type = $rawPosition['type']['name'];
        $position->experience = $rawPosition['experience']['name'];
        $position->createdAt = strtotime($rawPosition['creation_date']);
        $position->updatedAt = strtotime($rawPosition['updated_date']);

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