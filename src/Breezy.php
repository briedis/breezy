<?php


namespace Draugiem\BreezySync;


class Breezy
{
    /** @var BreezyApiClient */
    private $api;

    public function __construct()
    {
        $this->api = new BreezyApiClient;
    }

    /**
     * @param $email
     * @param $password
     * @return mixed
     */
    public function singIn($email, $password)
    {
        $response = $this->api->post('signin', [
            'email' => $email,
            'password' => $password,
        ]);

        $token = $response['access_token'];

        // Remember token for all consecutive request
        $this->api->setToken($token);

        return $token;
    }
}