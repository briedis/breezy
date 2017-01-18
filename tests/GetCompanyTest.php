<?php


namespace Briedis\Breezy\Tests;


class GetCompanyTest extends TestBase
{
    public function testGetCompany()
    {
        $breezy = $this->breezy();

        $company = $breezy->getCompany(Credentials::$companyId);

        self::assertEquals(Credentials::$companyId, $company->id);
    }
}