<?php


namespace Briedis\Breezy\Tests;


use Briedis\Breezy\Structures\PositionItem;

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
     * @return PositionItem
     */
    private function getPosition()
    {
        $position = new PositionItem;
        $position->name = 'Test API position (' . uniqid(date('r') . '_', true) . ')';
        $position->description = 'Description';
        $position->state = PositionItem::STATE_DRAFT;
        $position->type = PositionItem::TYPE_OTHER;
        $position->category = PositionItem::CATEGORY_OTHER;
        $position->education = PositionItem::EDUCATION_UNSPECIFIED;
        $position->experience = PositionItem::EXPERIENCE_NA;
        return $position;
    }
}