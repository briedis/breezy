<?php


namespace Briedis\Breezy\Tests;


use Briedis\Breezy\Structures\PositionItem;

class PositionTest extends TestBase
{

    public function testGetAllPositions()
    {
        $breezy = $this->breezy();

        $positions = $breezy->getCompanyPositions(Credentials::$companyId, null);

        // If there is a position, it should have an id
        foreach ($positions as $v) {
            self::assertNotNull($v->id);
        }
    }

    public function testGetPublishedPositions()
    {
        $breezy = $this->breezy();

        $positions = $breezy->getCompanyPositions(Credentials::$companyId, PositionItem::STATE_PUBLISHED);

        // If there is a position, it should have a published state
        foreach ($positions as $v) {
            self::assertEquals(PositionItem::STATE_PUBLISHED, $v->state);
        }
    }
}