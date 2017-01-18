<?php


namespace Briedis\Breezy\Structures;


class CompanyItem extends BaseItem
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * Company description
     * @var string
     */
    public $description;

    /**
     * Company URL
     * @var string
     */
    public $url;

    /**
     * @var string URL
     */
    public $logo;

    /**
     * Published positions
     * @var PositionItem[]
     */
    public $positions = [];


    /**
     * @inheritdoc
     */
    public static function fromArray(array $rawCompany)
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
}