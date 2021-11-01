<?php

namespace Briedis\Breezy\Tests;


use Briedis\Breezy\Breezy;
use PHPUnit\Framework\TestCase;

abstract class TestBase extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        if (!class_exists(Credentials::class)) {
            throw new \Exception(
                'Test credentials are not set. Copy "tests/Credentials.php.dist" to "tests/Credentials.php and set needed values'
            );
        }
    }

    /**
     * Retrieve a breezy instance that is singed in already
     * @return Breezy
     */
    protected function breezy()
    {
        $breezy = new Breezy;
        $breezy->signIn(Credentials::$email, Credentials::$password);
        return $breezy;
    }
}