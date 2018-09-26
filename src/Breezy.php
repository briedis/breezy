<?php

namespace Briedis\Breezy;

use Briedis\Breezy\Exceptions\BreezyException;
use Briedis\Breezy\Structures\Candidate;
use Briedis\Breezy\Structures\Company;
use Briedis\Breezy\Structures\Position;

class Breezy
{
    /**
     * List of allowed extensions for the resume
     * @var array
     */
    public static $allowedFileExtensions = ['pdf', 'doc', 'docx', 'txt', 'rtf'];

    /** @var BreezyApiClient */
    protected $api;

    /**
     * If api implementation is not provided, we initialize it in constructor
     * @param BreezyApiClient|null $apiClient
     */
    public function __construct(BreezyApiClient $apiClient = null)
    {
        $this->api = $apiClient ? $apiClient : new BreezyApiClient;
    }

    /**
     * Sign in and set access token so consecutive requests are authorized
     * @param string $email
     * @param string $password
     * @return string Access token
     */
    public function signIn($email, $password)
    {
        $token = $this->api->signIn($email, $password);
        
        return $token;
    }

    /**
     * Set authorization token for next requests
     * @param string $token
     */
    public function setToken($token)
    {
        $this->api->setToken($token);
    }

    /**
     * Get company data
     * @param string $companyId
     * @return Company
     * @throws BreezyException
     */
    public function getCompany($companyId)
    {
        $response = $this->api->get('company/' . $companyId . '/'); // Trailing slash is needed for this request until it's fixed

        return Company::fromResponse($response);
    }

    /**
     * Get positions
     * @param string $companyId
     * @param string $state State of the position (draft, archived, etc). By default, returns only published. Pass an empty string if you want all
     * @return Position[]
     * @throws BreezyException
     */
    public function getCompanyPositions($companyId, $state = Position::STATE_PUBLISHED)
    {
        $params = [];

        if ($state) {
            $params['state'] = $state;
        }

        $response = $this->api->get('company/' . $companyId . '/positions/', $params);

        $positions = [];

        foreach ($response as $position) {
            $positions[] = Position::fromResponse($position);
        }

        return $positions;
    }

    /**
     * Get candidate
     * @param string $companyId
     * @param string $positionId
     * @param string $candidateId
     * @return Candidate
     * @throws BreezyException
     */
    public function getCandidate($companyId, $positionId, $candidateId)
    {
        $response = $this->api->get('company/' . $companyId . '/position/' . $positionId . '/candidate/' . $candidateId);

        $candidate = Candidate::fromResponse($response);

        return $candidate;
    }

    /**
     * Add candidate
     * @param string $companyId
     * @param string $positionId
     * @param Candidate $candidate
     * @return Candidate
     * @throws BreezyException
     */
    public function addCandidate($companyId, $positionId, Candidate $candidate)
    {
        $response = $this->api->post('/company/' . $companyId . '/position/' . $positionId . '/candidates', $candidate);

        return Candidate::fromResponse($response);
    }

    /**
     * Upload resume file for candidate
     * @param string $companyId
     * @param string $positionId
     * @param string $candidateId
     * @param string $pathname Full path to the file
     * @param string $filename Actual files filename that will appear in the system
     * @throws BreezyException
     * @return mixed
     */
    public function uploadResume($companyId, $positionId, $candidateId, $pathname, $filename)
    {
        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        if (!in_array($extension, self::$allowedFileExtensions, true)) {
            throw new BreezyException(
                'Extension "' . $extension . '" is not within allowed list: '
                . implode(', ', self::$allowedFileExtensions)
            );
        }

        $response = $this->api->uploadFile(
            'company/' . $companyId . '/position/' . $positionId . '/candidate/' . $candidateId . '/resume',
            $pathname,
            $filename
        );

        return $response;
    }

    /**
     * Upload document for candidate
     * @param string $companyId
     * @param string $positionId
     * @param string $candidateId
     * @param string $pathname Full path to the file
     * @param string $filename Actual files filename that will appear in the system
     * @throws BreezyException
     * @return array
     */
    public function uploadDocument($companyId, $positionId, $candidateId, $pathname, $filename)
    {
        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        if (!in_array($extension, self::$allowedFileExtensions, true)) {
            throw new BreezyException(
                'Extension "' . $extension . '" is not within allowed list: '
                . implode(', ', self::$allowedFileExtensions)
            );
        }

        $response = $this->api->uploadFile(
            'company/' . $companyId . '/position/' . $positionId . '/candidate/' . $candidateId . '/documents',
            $pathname,
            $filename
        );

        return $response;
    }

    /**
     * Get candidate documents
     * @param string $companyId
     * @param string $positionId
     * @param string $candidateId
     * @return array
     */
    public function getDocuments($companyId, $positionId, $candidateId)
    {
        $response = $this->api->get('company/' . $companyId . '/position/' . $positionId . '/candidate/' . $candidateId . '/documents/');

        return $response;
    }

    /**
     * Newly created position
     * @param string $companyId
     * @param Position $position
     * @throws BreezyException
     * @return Position Created position from backend
     */
    public function createPosition($companyId, Position $position)
    {
        $response = $this->api->post('company/' . $companyId . '/positions', $position);

        return Position::fromResponse($response);
    }
}
