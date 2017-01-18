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

        $resume = $breezy->uploadResume(Credentials::$companyId, $pathname, $filename);

        self::assertTrue($resume->size > 0);
        self::assertTrue(strpos($resume->url, $filename) !== false);
    }

    public function testUploadInvalidFileExtension()
    {
        $breezy = $this->breezy();

        $pathname = __DIR__ . '/some-unknown-path/does-not-even-matter.jpg';
        $filename = 'my-resume.jpg';

        self::expectException(BreezyException::class);

        $breezy->uploadResume(Credentials::$companyId, $pathname, $filename);
    }
}