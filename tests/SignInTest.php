<?php


namespace Briedis\Breezy\Tests;


use Briedis\Breezy\Breezy;
use Briedis\Breezy\Exceptions\BreezyException;

class SignInTest extends TestBase
{

    public function testSignInWithoutEmail()
    {
        self::expectException(BreezyException::class);

        $breezy = new Breezy;
        $breezy->signIn('', '');
    }

    public function testSignIn()
    {
        $breezy = new Breezy;
        $token = $breezy->signIn(Credentials::$email, Credentials::$password);

        self::assertNotNull($token);
    }
}