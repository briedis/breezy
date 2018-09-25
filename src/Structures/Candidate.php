<?php

namespace Briedis\Breezy\Structures;

class Candidate
{
    const ORIGIN_APPLIED = 'applied';
    const ORIGIN_RECRUITER = 'recruiter';
    const ORIGIN_REFERRAL = 'referral';
    const ORIGIN_SOURCED = 'sourced';

    /**
     * @var string
     */
    public $id = '';

    /**
     * @var string
     */
    public $address = '';

    /**
     * @var array
     */
    public $assigned_to = [];

    /**
     * @var string
     */
    public $cover_letter = '';

    /**
     * @var string
     */
    public $creation_date = '';

    /**
     * @var array
     */
    public $education = [];

    /**
     * @var string
     */
    public $email_address = '';

    /**
     * @var string
     */
    public $followed_by = '';

    /**
     * @var string
     */
    public $headline = '';

    /**
     * @var string
     */
    public $initial = '';

    /**
     * @var string
     */
    public $name = '';

    /**
     * @var string
     */
    public $origin = '';

    /**
     * @var array
     */
    public $overall_score = [];

    /**
     * @var string
     */
    public $phone_number = '';

    /**
     * @var string
     */
    public $profile_photo_url = '';

    /**
     * @var array
     */
    public $questionnaire = [];

    /**
     * @var array
     */
    public $recruited_by = [];

    /**
     * @var array
     */
    public $referred_by = [];

    /**
     * @var array
     */
    public $sourced_by = [];

    /**
     * @var array
     */
    public $resume = [];

    /**
     * @var array
     */
    public $social_profiles = [];

    /**
     * @var array
     */
    public $source = [];

    /**
     * @var array
     */
    public $stage = [];

    /**
     * @var string
     */
    public $summary = '';

    /**
     * @var array
     */
    public $tags = [];

    /**
     * @var string
     */
    public $updated_date = '';

    /**
     * @var array
     */
    public $work_history = [];

    /**
     * @inheritdoc
     */
    public static function fromArray(array $rawCandidate)
    {
        $candidate = new Candidate;

        $candidate->rawData = $rawCandidate;

        $candidate->id = $rawCandidate['_id'];
        $candidate->address = $rawCandidate['address'] ?? '';
        $candidate->assigned_to = $rawCandidate['assigned_to'] ?? [];
        $candidate->cover_letter = $rawCandidate['cover_letter'] ?? '';
        $candidate->creation_date = $rawCandidate['creation_date'] ?? '';
        $candidate->education = $rawCandidate['education'] ?? [];
        $candidate->email_address = $rawCandidate['email_address'] ?? '';
        $candidate->followed_by = $rawCandidate['followed_by'] ?? '';
        $candidate->headline = $rawCandidate['headline'] ?? '';
        $candidate->initial = $rawCandidate['initial'] ?? '';
        $candidate->name = $rawCandidate['name'] ?? '';
        $candidate->origin = $rawCandidate['origin'] ?? '';
        $candidate->overall_score = $rawCandidate['overall_score'] ?? [];
        $candidate->phone_number = $rawCandidate['phone_number'] ?? '';
        $candidate->profile_photo_url = $rawCandidate['profile_photo_url'] ?? '';
        $candidate->questionnaire = $rawCandidate['questionnaire'] ?? [];
        $candidate->recruited_by = $rawCandidate['recruited_by'] ?? [];
        $candidate->referred_by = $rawCandidate['referred_by'] ?? [];
        $candidate->sourced_by = $rawCandidate['sourced_by'] ?? [];
        $candidate->resume = $rawCandidate['resume'] ?? [];
        $candidate->social_profiles = $rawCandidate['social_profiles'] ?? [];
        $candidate->source = $rawCandidate['source'] ?? [];
        $candidate->stage = $rawCandidate['stage'] ?? [];
        $candidate->summary = $rawCandidate['summary'] ?? '';
        $candidate->tags = $rawCandidate['tags'] ?? [];
        $candidate->updated_date = $rawCandidate['updated_date'] ?? '';
        $candidate->work_history = $rawCandidate['work_history'] ?? [];

        return $candidate;
    }
}
