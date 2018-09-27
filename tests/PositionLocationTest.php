<?php


namespace Briedis\Breezy\Tests;


use Briedis\Breezy\Structures\LocationItem;
use Briedis\Breezy\Structures\Position;

class PositionLocationTest extends TestBase
{
    public function testCreateLocationWithoutState()
    {
        $breezy = $this->breezy();

        $position = $this->getPosition();

        $location = [
            'country' => 'LV',
            'city' => 'Riga',
        ];

        $position->location = $location;

        $created = $breezy->createPosition(Credentials::$companyId, $position);

        self::assertEquals($location['country'], $created->location['country']['id']);
        self::assertEquals($location['city'], $created->location['city']);
        self::assertEquals($location['city'] . ', ' . $location['country'], $created->location['name']);
    }

    public function testCreationWithState()
    {
        $breezy = $this->breezy();

        $position = $this->getPosition();

        $location = [
            'country' => 'US',
            'state' => 'CA',
        ];

        $position->location = $location;

        $created = $breezy->createPosition(Credentials::$companyId, $position);

        self::assertEquals($location['country'], $created->location['country']['id']);
        self::assertEquals($location['state'], $created->location['state']['id']);
    }

    /**
     * @return Position
     */
    private function getPosition()
    {
        $position = new Position;
        $position->name = 'Test API position (' . uniqid(date('r') . '_', true) . ')';
        $position->description = 'Description';
        $position->state = Position::STATE_DRAFT;
        $position->type = Position::TYPE_OTHER;
        $position->category = Position::CATEGORY_OTHER;
        $position->education = Position::EDUCATION_UNSPECIFIED;
        $position->experience = Position::EXPERIENCE_NA;
        return $position;
    }
}