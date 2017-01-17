<?php


namespace Briedis\Breezy\Structures;


use Briedis\Breezy\Exceptions\BreezyException;

abstract class BaseItem
{
    /**
     * Raw data retrieved from API
     * @var array
     */
    public $rawData = [];

    /**
     * Convert raw response data to item
     * @param array $rawData
     * @return static
     * @throws BreezyException
     */
    static function fromArray(array $rawData)
    {
        throw new BreezyException(
            'fromArray not implemented for ' . __CLASS__
            . ' with data: ' . print_r($rawData, true)
        );
    }
}