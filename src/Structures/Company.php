<?php

namespace Briedis\Breezy\Structures;

class Company
{
    private $id;
    private $name;
    private $friendly_id;
    private $creation_date;
    private $updated_date;
    private $member_count;
    private $initial;
    public static function fromResponse(array $rawCompany)

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getFriendlyId()
    {
        return $this->friendly_id;
    }

    /**
     * @return mixed
     */
    public function getCreationDate()
    {
        return $this->creation_date;
    }

    /**
     * @return mixed
     */
    public function getUpdatedDate()
    {
        return $this->updated_date;
    }

    /**
     * @return mixed
     */
    public function getMemberCount()
    {
        return $this->member_count;
    }

    /**
     * @inheritdoc
     */
    {
        $company = new Company;

        $company->rawData = $rawCompany;

        $company->id = $rawCompany['_id'];
        $company->name = $rawCompany['name'];
        $company->friendly_id = $rawCompany['friendly_id'];
        $company->creation_date = $rawCompany['creation_date'];
        $company->updated_date = $rawCompany['updated_date'];
        $company->member_count = $rawCompany['member_count'];
        $company->initial = $rawCompany['initial'];

        return $company;
    }
}
