<?php


namespace Briedis\Breezy\Tests;


use Briedis\Breezy\Structures\CandidateItem;
use Briedis\Breezy\Structures\ResumeItem;

class AddCandidateTest extends TestBase
{

    public function testAddCandidate()
    {
        $breezy = $this->breezy();

        $candidate = new CandidateItem;

        $candidate->companyId = Credentials::$companyId;
        $candidate->positionId = Credentials::$positionId;

        $candidate->name = 'API Test Candidate ' . date('Y-m-d H:i:s');
        $candidate->status = CandidateItem::STATUS_APPLIED;
        $candidate->summary = "Test summary\nNew line";
        $candidate->phoneNumber = '12345667890';

        $newCandidate = $breezy->addCandidate($candidate);

        self::assertNotNull($newCandidate->id);
        self::assertEquals($candidate->name, $newCandidate->name);
    }

    public function testAddCandidateWithResume()
    {
        $breezy = $this->breezy();

        $resume = $breezy->uploadResume(
            Credentials::$companyId,
            __DIR__ . '/resources/sample-resume.pdf',
            'my-test-resume.pdf'
        );

        self::assertInstanceOf(ResumeItem::class, $resume);

        $candidate = new CandidateItem;
        $candidate->companyId = Credentials::$companyId;
        $candidate->positionId = Credentials::$positionId;
        $candidate->name = 'API Test Candidate with resume ' . date('Y-m-d H:i:s');

        $candidateReturn = $breezy->addCandidate($candidate, $resume);

        self::assertNotNull($candidateReturn->resumeUrl);
        self::assertNotNull($candidateReturn->resumeUrlPdf);
    }
}