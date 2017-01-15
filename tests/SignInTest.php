<?php


namespace Draugiem\BreezySync\Tests;


use Draugiem\BreezySync\Breezy;
use Draugiem\BreezySync\Exceptions\BreezySyncException;

class SignInTest extends TestBase
{

    public function testSignInWithoutEmail()
    {
        self::expectException(BreezySyncException::class);

        $breezy = new Breezy;
        $breezy->singIn('', '');
    }

    public function testSignIn()
    {
        $breezy = new Breezy;
        $token = $breezy->singIn(Credentials::$email, Credentials::$password);

        self::assertNotNull($token);
    }
}