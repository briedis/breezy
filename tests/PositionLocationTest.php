<?php


namespace Briedis\Breezy\Tests;


use Briedis\Breezy\Structures\LocationItem;
use Briedis\Breezy\Structures\PositionItem;

class PositionLocationTest extends TestBase
{
    public function testCreateLocationWithoutState()
    {
        $breezy = $this->breezy();

        $position = $this->getPosition();

        $location = new LocationItem;
        $location->countryCode = 'LV';
        $location->countryName = 'Latvia';
        $location->city = 'Riga';

        $position->location = $location;

        $created = $breezy->createPosition($position);

        self::assertEquals($location->countryName, $created->location->countryName);
        self::assertEquals($location->countryCode, $created->location->countryCode);
        self::assertEquals($location->city, $created->location->city);
        self::assertEquals($location->city . ', ' . $location->countryCode, $created->location->name);
    }

    public function testCreationWithState()
    {
        $breezy = $this->breezy();

        $position = $this->getPosition();

        $location = new LocationItem;
        $location->countryCode = 'US';
        $location->countryName = 'United States';
        $location->stateName = 'California';
        $location->stateCode = 'CA';

        $position->location = $location;

        $created = $breezy->createPosition($position);

        self::assertEquals($location->stateName, $created->location->stateName);
        self::assertEquals($location->stateCode, $created->location->stateCode);
    }

    /**
     * @return PositionItem
     */
    private function getPosition()
    {
        $position = new PositionItem;
        $position->companyId = Credentials::$companyId;
        $position->name = 'Test API position (' . uniqid(date('r') . '_', true) . ')';
        $position->description = 'Description';
        $position->state = PositionItem::STATE_CLOSED;
        return $position;
    }
}