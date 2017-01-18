<?php


namespace Briedis\Breezy\Tests;


use Briedis\Breezy\Breezy;
use Briedis\Breezy\Exceptions\BreezyApiException;

class AccessCompanyUnauthorizedTest extends TestBase
{

    public function testAccessWithoutAuthorization()
    {
        $breezy = new Breezy;

        self::expectException(BreezyApiException::class);

        $breezy->getCompaniesWithPositions();
    }
}