<?php

namespace Briedis\Breezy;

use Briedis\Breezy\Exceptions\BreezyApiException;
use Briedis\Breezy\Exceptions\BreezyException;
use CURLFile;

class BreezyApiClient
{
    const USER_AGENT = 'Breezy PHP wrapper (https://github.com/briedis/breezy)';

    /**
     * @var string
     */
    public $url = 'https://breezy.hr/public/api/v3/';

    /**
     * Last JSON encoded response
     * @var string
     */
    private $lastResponseRaw;

    /**
     * Last parsed response (json decoded)
     * @var array
     */
    private $lastResponse;

    /**
     * Token received after successful sing-in
     * @var string
     */
    private $token;

    /**
     * Set access (authorization) token to be used when calling requests
     * Token can be retrieved from signIn method
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * Perform a GET request to the API
     * @param string $path Request path
     * @param array $params Additional GET parameters as an associative array
     * @return mixed
     */
    public function get($path, $params = [])
    {
        return $this->request('GET', $path, $params);
    }

    /**
     * Perform a DELETE request to the API
     * @param string $path Request path
     * @param array $params Additional GET parameters as an associative array
     * @return mixed
     */
    public function delete($path, $params = [])
    {
        return $this->request('DELETE', $path, $params);
    }

    /**
     * Perform a POST request to the API
     * @param string $path Request path
     * @param array $data Request body data as an associative array
     * @param array $params Additional GET parameters as an associative array
     * @return mixed
     */
    public function post($path, $data = [], $params = [])
    {
        return $this->request('POST', $path, $params, $data);
    }

    /**
     * Perform a PUT request to the API
     * @param string $path Request path
     * @param array $data Request body data as an associative array
     * @param array $params Additional GET parameters as an associative array
     * @return mixed
     */
    public function put($path, $data = [], $params = [])
    {
        return $this->request('PUT', $path, $params, $data);
    }

    /**
     * Return raw response data from the last request
     * @return string|null Response data
     */
    public function getLastResponseRaw()
    {
        return $this->lastResponseRaw;
    }

    /**
     * Return decoded response data from the last request
     * @return array|null Response data
     */
    public function getLastResponse()
    {
        return $this->lastResponse;
    }

    /**
     * Internal request implementation
     * @param string $method POST, GET, etc.
     * @param string $path API endpoint path
     * @param array $query Query parameters
     * @param array|mixed $data Post data
     * @return mixed
     * @throws BreezyException
     */
    private function request($method, $path, array $query = [], $data = null)
    {
        $curl = $this->initCurl($method, $path, $query);

        $bodyLength = 0;
        if ($data !== null) {
            $bodyEncoded = json_encode($data);
            $bodyLength = strlen($bodyEncoded);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $bodyEncoded);
        }

        $headers = $this->getCurlHeaders($bodyLength, 'application/json');

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        return $this->execute($curl);
    }

    /**
     * Upload file contents
     * @param string $path
     * @param string $pathname Full path to the file to upload
     * @param string $filename
     * @param array $query
     * @return mixed
     */
    public function uploadFile($path, $pathname, $filename, array $query = [])
    {
        $curlFile = new CURLFile($pathname);
        $curlFile->setPostFilename($filename);

        $curl = curl_init($this->getUrl($path, $query));
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_USERAGENT, self::USER_AGENT);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type: multipart/form-data',
            'Authorization: ' . $this->token,
        ]);
        curl_setopt($curl, CURLOPT_FRESH_CONNECT, 1);
        curl_setopt($curl, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl, CURLOPT_TIMEOUT, 60);
        curl_setopt($curl, CURLOPT_POSTFIELDS, ['file' => $curlFile]);

        return $this->execute($curl);
    }


    /**
     * @param string $method
     * @param string $path
     * @param array $query Query parameters
     * @return resource cURL handler
     */
    private function initCurl($method, $path, array $query)
    {
        $curl = curl_init($this->getUrl($path, $query));

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 3);

        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);

        curl_setopt($curl, CURLOPT_USERAGENT, self::USER_AGENT);

        return $curl;
    }

    /**
     * @param string $path
     * @param array $query
     * @return string
     */
    private function getUrl($path, array $query)
    {
        $url = $this->url . ltrim($path, '/');
        if ($query) {
            $url .= '?' . http_build_query($query);
        }
        return $url;
    }

    /**
     * Execute cURL handler and return response
     * @param resource $curl
     * @return mixed
     * @throws BreezyApiException
     */
    private function execute($curl)
    {
        $this->lastResponseRaw = null;
        $this->lastResponse = null;

        $responseRaw = curl_exec($curl);

        $responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        $errorNumber = curl_errno($curl);
        $error = curl_error($curl);
        curl_close($curl);

        if ($errorNumber) {
            throw new BreezyApiException('CURL: ' . $error, $errorNumber);
        }

        $response = json_decode($responseRaw, true);

        if ($responseCode >= 400 || !empty($response['error'])) {
            $error = [];

            if (is_array($response)) {
                $response += ['error' => []];
                $error = $response['error'];
            }

            $error += [
                'type' => 'Unknown type',
                'message' => 'Unknown message',
            ];

            throw new BreezyApiException($error['type'] . ': ' . $error['message'], $responseCode);
        }

        $this->lastResponse = $response;
        $this->lastResponseRaw = $responseRaw;

        return $response;
    }

    /**
     * @param int $contentLength
     * @param string $contentType
     * @return array
     */
    private function getCurlHeaders($contentLength, $contentType)
    {
        $headers = [
            'Content-Type: ' . $contentType,
            'Content-Length: ' . $contentLength,
        ];

        if ($this->token) {
            $headers[] = 'Authorization: ' . $this->token;
        }

        return $headers;
    }

    /**
     * Sign in and set access token for consecutive requests
     * @param string $email
     * @param string $password
     * @return string Access token
     */
    public function signIn($email, $password)
    {
        $response = $this->post('signin', [
            'email' => $email,
            'password' => $password,
        ]);

        $token = $response['access_token'];

        // Remember token for all consecutive request
        $this->setToken($token);

        return $token;
    }
}