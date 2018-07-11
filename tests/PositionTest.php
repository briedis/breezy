<?php


namespace Briedis\Breezy\Tests;


use Briedis\Breezy\Structures\PositionItem;

class PositionTest extends TestBase
{
    public function testCreatePosition()
    {
        $breezy = $this->breezy();

        $position = new PositionItem;
        $position->name = 'Test API position (' . uniqid(date('r') . '_', true) . ')';
        $position->description = 'Test description';
        $position->state = PositionItem::STATE_DRAFT;
        $position->location = [
            'country' => 'LV',
            'city' => 'Riga',
        ];
        $position->type = PositionItem::TYPE_OTHER;
        $position->category = PositionItem::CATEGORY_OTHER;
        $position->education = PositionItem::EDUCATION_UNSPECIFIED;
        $position->experience = PositionItem::EXPERIENCE_NA;

        $created = $breezy->createPosition(Credentials::$companyId, $position);

        self::assertNotNull($created->id);
        self::assertEquals(PositionItem::STATE_DRAFT, $created->state);
    }

    public function testGetAllPositions()
    {
        $breezy = $this->breezy();

        $positions = $breezy->getCompanyPositions(Credentials::$companyId, null);

        // If there is a position, it should have an id
        foreach ($positions as $position) {
            self::assertNotNull($position->id);
        }
    }

    public function testGetPublishedPositions()
    {
        $breezy = $this->breezy();

        $positions = $breezy->getCompanyPositions(Credentials::$companyId, PositionItem::STATE_PUBLISHED);

        // If there is a position, it should have a published state
        foreach ($positions as $position) {
            self::assertEquals(PositionItem::STATE_PUBLISHED, $position->state);
        }
    }
}