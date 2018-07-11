<?php


namespace Briedis\Breezy\Structures;


class CompanyItem extends BaseItem
{
    /**
     * @var string
     */
    public $id = '';

    /**
     * @var string
     */
    public $name = '';

    /**
     * @var string
     */
    public $friendly_id = '';

    /**
     * @var string
     */
    public $creation_date = '';

    /**
     * @var string
     */
    public $updated_date = '';

    /**
     * @var number
     */
    public $member_count;

    /**
     * @var string
     */
    public $initial = '';

    /**
     * @inheritdoc
     */
    public static function fromArray(array $rawCompany)
    {
        $company = new CompanyItem;

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