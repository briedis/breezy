<?php


namespace Briedis\Breezy\Tests;


use Briedis\Breezy\Structures\Candidate;

class AddCandidateTest extends TestBase
{

    public function testAddCandidate()
    {
        $breezy = $this->breezy();

        $candidate = new Candidate;
        $candidate->name = 'API Test Candidate ' . date('Y-m-d H:i:s');
        $candidate->origin = Candidate::ORIGIN_SOURCED; // ORIGIN_APPLIED
        $candidate->summary = "Test summary\nNew line";
        $candidate->phone_number = '12345667890';
        $candidate->email_address = date('Y-m-d H:i:s') . '@example.com';

        $newCandidate = $breezy->addCandidate(Credentials::$companyId, Credentials::$positionId, $candidate);

        self::assertNotNull($newCandidate->id);
        self::assertEquals($candidate->name, $newCandidate->name);
    }

    public function testAddCandidateWithResume()
    {
        $breezy = $this->breezy();

        $candidate = new Candidate;
        $candidate->name = 'API Test Candidate with resume ' . date('Y-m-d H:i:s');
        $candidate->origin = Candidate::ORIGIN_SOURCED;

        $newCandidate = $breezy->addCandidate(Credentials::$companyId, Credentials::$positionId, $candidate);

        self::assertNotNull($newCandidate->id);

        $resume = $breezy->uploadResume(
            Credentials::$companyId,
            Credentials::$positionId,
            $newCandidate->id,
            __DIR__ . '/resources/sample-resume.pdf',
            'my-test-resume.pdf'
        );

        // TODO: HOW TO TEST?
        // self::assertNotNull($newCandidate->resume['url']);
        // self::assertNotNull($newCandidate->resume['pdf_url']);
        // self::assertEquals($newCandidate->resume, $candidate->resume);
    }
}