<?php


namespace Briedis\Breezy\Tests;


use Briedis\Breezy\Structures\Position;

class PositionTest extends TestBase
{
    public function testCreatePosition()
    {
        $breezy = $this->breezy();

        $position = new Position;
        $position->name = 'Test API position (' . uniqid(date('r') . '_', true) . ')';
        $position->description = 'Test description';
        $position->state = Position::STATE_DRAFT;
        $position->location = [
            'country' => 'LV',
            'city' => 'Riga',
        ];
        $position->type = Position::TYPE_OTHER;
        $position->category = Position::CATEGORY_OTHER;
        $position->education = Position::EDUCATION_UNSPECIFIED;
        $position->experience = Position::EXPERIENCE_NA;

        $created = $breezy->createPosition(Credentials::$companyId, $position);

        self::assertNotNull($created->id);
        self::assertEquals(Position::STATE_DRAFT, $created->state);
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

        $positions = $breezy->getCompanyPositions(Credentials::$companyId, Position::STATE_PUBLISHED);

        // If there is a position, it should have a published state
        foreach ($positions as $position) {
            self::assertEquals(Position::STATE_PUBLISHED, $position->state);
        }
    }
}