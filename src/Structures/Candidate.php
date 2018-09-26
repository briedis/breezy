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

    public static function fromResponse(array $rawCandidate)
    {
        $_id = $rawCandidate['_id'];
        $address = $rawCandidate['address'];
        $assigned_to = $rawCandidate['assigned_to'];
        $cover_letter = $rawCandidate['cover_letter'];
        $creation_date = $rawCandidate['creation_date'];
        $education = $rawCandidate['education'];
        $email_address = $rawCandidate['email_address'];
        $followed_by = $rawCandidate['followed_by'];
        $headline = $rawCandidate['headline'];
        $initial = $rawCandidate['initial'];
        $name = $rawCandidate['name'];
        $origin = $rawCandidate['origin'];
        $overall_score = $rawCandidate['overall_score'];
        $phone_number = $rawCandidate['phone_number'];
        $profile_photo_url = $rawCandidate['profile_photo_url'];
        $questionnaire = $rawCandidate['questionnaire'];
        $recruited_by = $rawCandidate['recruited_by'];
        $referred_by = $rawCandidate['referred_by'];
        $sourced_by = $rawCandidate['sourced_by'];
        $resume = $rawCandidate['resume'];
        $social_profiles = $rawCandidate['social_profiles'];
        $source = $rawCandidate['source'];
        $stage = $rawCandidate['stage'];
        $summary = $rawCandidate['summary'];
        $tags = $rawCandidate['tags'];
        $updated_date = $rawCandidate['updated_date'];
        $work_history = $rawCandidate['work_history'];
        $custom_attributes = $rawCandidate['custom_attributes'];

        return new Candidate(
            $_id,
            $address,
            $assigned_to,
            $cover_letter,
            $creation_date,
            $education,
            $email_address,
            $followed_by,
            $headline,
            $initial,
            $name,
            $origin,
            $overall_score,
            $phone_number,
            $profile_photo_url,
            $questionnaire,
            $recruited_by,
            $referred_by,
            $sourced_by,
            $resume,
            $social_profiles,
            $source,
            $stage,
            $summary,
            $tags,
            $updated_date,
            $work_history,
            $custom_attributes
        );
    }

    public function __construct(
        $_id,
        $address,
        $assigned_to,
        $cover_letter,
        $creation_date,
        $education,
        $email_address,
        $followed_by,
        $headline,
        $initial,
        $name,
        $origin,
        $overall_score,
        $phone_number,
        $profile_photo_url,
        $questionnaire,
        $recruited_by,
        $referred_by,
        $sourced_by,
        $resume,
        $social_profiles,
        $source,
        $stage,
        $summary,
        $tags,
        $updated_date,
        $work_history,
        $custom_attributes
    ) {
        $this->_id = $_id;
        $this->address = $address;
        $this->assigned_to = $assigned_to;
        $this->cover_letter = $cover_letter;
        $this->creation_date = $creation_date;
        $this->education = $education;
        $this->email_address = $email_address;
        $this->followed_by = $followed_by;
        $this->headline = $headline;
        $this->initial = $initial;
        $this->name = $name;
        $this->origin = $origin;
        $this->overall_score = $overall_score;
        $this->phone_number = $phone_number;
        $this->profile_photo_url = $profile_photo_url;
        $this->questionnaire = $questionnaire;
        $this->recruited_by = $recruited_by;
        $this->referred_by = $referred_by;
        $this->sourced_by = $sourced_by;
        $this->resume = $resume;
        $this->social_profiles = $social_profiles;
        $this->source = $source;
        $this->stage = $stage;
        $this->summary = $summary;
        $this->tags = $tags;
        $this->updated_date = $updated_date;
        $this->work_history = $work_history;
        $this->custom_attributes = $custom_attributes;
    }
}
