<?php


namespace Briedis\Breezy;


use Briedis\Breezy\Exceptions\BreezyException;
use Briedis\Breezy\Structures\CandidateItem;
use Briedis\Breezy\Structures\CompanyItem;
use Briedis\Breezy\Structures\PositionItem;

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
     * Get company data
     * @param string $companyId
     * @return CompanyItem
     */
    public function getCompany($companyId)
    {
        $response = $this->api->get('company/' . $companyId . '/'); // Trailing slash is needed for this request until it's fixed

        return CompanyItem::fromArray($response);
    }

    /**
     * Get positions
     * @param string $companyId
     * @param string $state State of the position (draft, archived, etc). By default, returns only published. Pass an empty string if you want all
     * @return PositionItem[]
     */
    public function getCompanyPositions($companyId, $state = PositionItem::STATE_PUBLISHED)
    {
        $params = [];

        if ($state) {
            $params['state'] = $state;
        }

        $response = $this->api->get('company/' . $companyId . '/positions/', $params);

        $positions = [];

        foreach ($response as $position) {
            $positions[] = PositionItem::fromArray($position);
        }

        return $positions;
    }

    /**
     * Get candidate
     * @param string $companyId
     * @param string $positionId
     * @param string $candidateId
     * @return CandidateItem
     */
    public function getCandidate($companyId, $positionId, $candidateId)
    {
        $response = $this->api->get('company/' . $companyId . '/position/' . $positionId . '/candidate/' . $candidateId);

        $candidate = CandidateItem::fromArray($response);

        return $candidate;
    }

    /**
     * Add candidate
     * @param string $companyId
     * @param string $positionId
     * @param CandidateItem $candidate
     * @return CandidateItem
     */
    public function addCandidate($companyId, $positionId, CandidateItem $candidate)
    {
        $response = $this->api->post('/company/' . $companyId . '/position/' . $positionId . '/candidates', $candidate);

        return CandidateItem::fromArray($response);
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
            throw new BreezyException('Extension "' . $extension . '" is not within allowed list: ' . implode(', ', self::$allowedFileExtensions));
        }

        $response = $this->api->uploadFile('company/' . $companyId . '/position/' . $positionId . '/candidate/' . $candidateId . '/resume', $pathname, $filename);

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
            throw new BreezyException('Extension "' . $extension . '" is not within allowed list: ' . implode(', ', self::$allowedFileExtensions));
        }

        $response = $this->api->uploadFile('company/' . $companyId . '/position/' . $positionId . '/candidate/' . $candidateId . '/documents', $pathname, $filename);

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
     * @param PositionItem $position
     * @throws BreezyException
     * @return PositionItem Created position from backend
     */
    public function createPosition($companyId, PositionItem $position)
    {
        $response = $this->api->post('company/' . $companyId . '/positions', $position);

        return PositionItem::fromArray($response);
    }
}