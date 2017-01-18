<?php


namespace Briedis\Breezy;


use Briedis\Breezy\Exceptions\BreezyApiException;
use Briedis\Breezy\Exceptions\BreezyException;
use Briedis\Breezy\Structures\CandidateItem;
use Briedis\Breezy\Structures\CompanyItem;
use Briedis\Breezy\Structures\PositionItem;
use Briedis\Breezy\Structures\ResumeItem;

class Breezy
{
    /**
     * List of allowed extensions for the resume
     * @var array
     */
    public static $allowedResumeExtensions = ['pdf', 'doc', 'docx', 'txt', 'rtf'];

    /** @var BreezyApiClient */
    private $api;

    public function __construct()
    {
        $this->api = new BreezyApiClient;
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
     * Get companies with positions
     * @return CompanyItem[]
     * @throws BreezyApiException
     * @throws BreezyException
     */
    public function getCompaniesWithPositions()
    {
        $response = $this->api->get('user/details');

        $re = [];

        foreach ($response as $v) {
            $company = CompanyItem::fromArray($v['company']);

            foreach ($v['positions'] as $v2) {
                $company->positions[] = PositionItem::fromArray($v2);
            }

            $re[] = $company;
        }

        return $re;
    }

    /**
     * @param CandidateItem $candidate
     * @param ResumeItem $resume Optional resume
     * @return CandidateItem
     */
    public function addCandidate(CandidateItem $candidate, ResumeItem $resume = null)
    {
        $path = '/company/' . $candidate->companyId . '/position/' . $candidate->positionId . '/candidates';

        $data = [
            'name' => $candidate->name,
            'email_address' => $candidate->email,
            'phone_number' => $candidate->phoneNumber,
            'summary' => $candidate->summary,
            'status' => $candidate->status,
        ];

        if ($resume) {
            $data['resume'] = [
                'url' => $resume->url,
            ];
        }

        $rawCandidate = $this->api->post($path, $data);

        return CandidateItem::fromArray($rawCandidate);
    }

    /**
     * Create a new resume file, which can later be used when adding a candidate to a position
     * @param string $companyId
     * @param string $pathname Full path to the file
     * @param string $filename Actual files filename that will appear in the system
     * @return ResumeItem
     * @throws BreezyException
     */
    public function uploadResume($companyId, $pathname, $filename)
    {
        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        if (!in_array($extension, self::$allowedResumeExtensions, true)) {
            throw new BreezyException(
                'Extension "' . $extension . '" is not within allowed list: '
                . implode(', ', self::$allowedResumeExtensions)
            );
        }

        $response = $this->api->uploadFile(
            'company/' . $companyId . '/upload/resume',
            $pathname,
            $filename
        );

        return ResumeItem::fromArray($response);
    }

    /**
     * Newly created position
     * @param PositionItem $position
     * @throws BreezyException
     * @return PositionItem Created position from backend
     */
    public function createPosition(PositionItem $position)
    {
        if (!$position->companyId) {
            throw new BreezyException('Company id is not set');
        }

        $response = $this->api->post('company/' . $position->companyId . '/positions', [
            'name' => $position->name,
            'description' => $position->description,
            'state' => $position->state,
            'type' => [
                'id' => 'fullTime',
                'name' => 'Full-Time',
            ],
        ]);

        return PositionItem::fromArray($response);
    }
}