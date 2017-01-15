<?php

namespace Draugiem\BreezySync\Tests;


use Draugiem\BreezySync\Breezy;

abstract class TestBase extends \PHPUnit_Framework_TestCase
{
    /** @var Breezy */
    protected $breezy;

    protected function setUp()
    {
        parent::setUp();

        if (!class_exists(Credentials::class)) {
            throw new \Exception('Test credentials are not set. Copy "tests/Credentials.php.dist" to "tests/Credentials.php and set needed values');
        }

        $this->breezy = new Breezy;
    }
}