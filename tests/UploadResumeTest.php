<?php


namespace Briedis\Breezy\Tests;


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
}