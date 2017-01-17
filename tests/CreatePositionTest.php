<?php


namespace Briedis\Breezy\Tests;


use Briedis\Breezy\Structures\PositionItem;

class CreatePositionTest extends TestBase
{

    public function testCreatePositions()
    {
        $breezy = $this->breezy();

        $position = new PositionItem;
        $position->companyId = Credentials::$companyId;
        $position->name = 'Test import position (' . uniqid(date('r') . '_', true) . ')';
        $position->description = '<b>Test description</b>';
        $position->state = PositionItem::STATE_CLOSED;

        $created = $breezy->createPosition($position);

        dump($created);
    }
}