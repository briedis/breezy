<?php


namespace Briedis\Breezy\Structures;


class LocationItem extends BaseItem
{
    /**
     * Full country name
     * @var string
     */
    public $countryName;

    /**
     * Two letter country code, uppercase
     * @var string
     */
    public $countryCode;

    /**
     * Display name, usually "City, country code"
     * @var string
     */
    public $name;

    /**
     * City name
     * @var string
     */
    public $city;

    /**
     * Two letter uppercase state code
     * @var string
     */
    public $stateCode;

    /**
     * Full state name
     * @var string
     */
    public $stateName;

    /**
     * @inheritdoc
     */
    public static function fromArray(array $rawLocation)
    {
        $location = new LocationItem;

        $location->rawData = $rawLocation;

        $location->name = $rawLocation['name'];

        if (isset($rawLocation['country'])) {
            $location->countryCode = $rawLocation['country']['id'];
            $location->countryName = $rawLocation['country']['name'];
        }

        if (isset($rawLocation['state'])) {
            $location->stateCode = $rawLocation['state']['id'];
            $location->stateName = $rawLocation['state']['name'];
        }

        if (isset($rawLocation['city'])) {
            $location->city = $rawLocation['city'];
        }

        return $location;
    }
}