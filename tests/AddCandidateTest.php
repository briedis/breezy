<?php


namespace Briedis\Breezy\Tests;


use Briedis\Breezy\Structures\CandidateItem;

class AddCandidateTest extends TestBase
{

    public function testAddCandidate()
    {
        $breezy = $this->breezy();

        $candidate = new CandidateItem;

        $candidate->companyId = Credentials::$companyId;
        $candidate->positionId = Credentials::$positionId;

        $candidate->name = 'API Test Candidate';
        $candidate->status = CandidateItem::STATUS_APPLIED;
        $candidate->summary = "Test html summary\nNew line";
        $candidate->phoneNumber = '12345667890';

        $breezy->addCandidate($candidate);
    }
}