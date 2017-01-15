<?php


namespace Draugiem\BreezySync\Tests;


use Draugiem\BreezySync\Breezy;
use Draugiem\BreezySync\Exceptions\BreezyException;

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