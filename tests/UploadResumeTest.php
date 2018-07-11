<?php


namespace Briedis\Breezy\Tests;


use Briedis\Breezy\Exceptions\BreezyException;

class UploadResumeTest extends TestBase
{
    public function testUploadResume()
    {
        $breezy = $this->breezy();

        $pathname = __DIR__ . '/resources/sample-resume.pdf';
        $filename = 'my-resume.pdf';

        $resume = $breezy->uploadResume(Credentials::$companyId, Credentials::$positionId, Credentials::$candidateId, $pathname, $filename);

        // TODO: HOW TO TEST?
    }

    public function testUploadInvalidFileExtension()
    {
        $breezy = $this->breezy();

        $pathname = __DIR__ . '/some-unknown-path/does-not-even-matter.jpg';
        $filename = 'my-resume.jpg';

        self::expectException(BreezyException::class);

        $breezy->uploadResume(Credentials::$companyId, Credentials::$positionId, Credentials::$candidateId, $pathname, $filename);
    }

    public function testUploadDocument()
    {
        $breezy = $this->breezy();

        $pathname = __DIR__ . '/resources/sample-resume.pdf';
        $filename = 'my-document.pdf';

        $document = $breezy->uploadDocument(Credentials::$companyId, Credentials::$positionId, Credentials::$candidateId, $pathname, $filename);

        self::assertEquals($filename, $document['file_name']);
    }
}