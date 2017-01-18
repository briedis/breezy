<?php


namespace Briedis\Breezy\Structures;


class CandidateItem extends BaseItem
{
    const STATUS_APPLIED = 'applied';
    const STATUS_FEEDBACK = 'feedback';
    const STATUS_INTERVIEWING = 'interviewing';
    const STATUS_OFFER = 'offer';
    const STATUS_DISQUALIFIED = 'disqualified';
    const STATUS_HIRED = 'hired';

    /**
     * @var string
     */
    public $companyId;

    /**
     * @var string
     */
    public $positionId;

    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $phoneNumber;

    /**
     * @var string
     */
    public $status;

    /**
     * @var string
     */
    public $summary;

    /**
     * If resume exists, full URL will be here (public)
     * @var string|null
     */
    public $resumeUrl;

    /**
     * If resume exists, pdf converted full URL will be here (public)
     * @var string|null
     */
    public $resumeUrlPdf;

    /**
     * @inheritdoc
     */
    public static function fromArray(array $rawCandidate)
    {
        $candidate = new CandidateItem;

        $candidate->rawData = $rawCandidate;
        $candidate->name = $rawCandidate['name'];
        $candidate->positionId = $rawCandidate['position_id'];
        $candidate->email = $rawCandidate['email_address'];
        $candidate->phoneNumber = $rawCandidate['phone_number'];
        $candidate->status = $rawCandidate['status'];
        $candidate->summary = $rawCandidate['summary'];

        if (!empty($rawCandidate['resume'])) {
            $candidate->resumeUrl = $rawCandidate['resume']['url'];
            $candidate->resumeUrlPdf = $rawCandidate['resume']['pdf_url'];
        }

        return $candidate;
    }
}