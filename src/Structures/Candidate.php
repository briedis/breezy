<?php

namespace Briedis\Breezy\Structures;

class Candidate
{
    private $id;
    const ORIGIN_APPLIED = 'applied';
    const ORIGIN_RECRUITER = 'recruiter';
    const ORIGIN_REFERRAL = 'referral';
    const ORIGIN_SOURCED = 'sourced';

    private $address;
    private $assigned_to;
    private $cover_letter;
    private $creation_date;
    private $education;
    private $email_address;
    private $followed_by;
    private $headline;
    private $initial;
    private $name;
    private $origin;
    private $overall_score;
    private $phone_number;
    private $profile_photo_url;
    private $questionnaire;
    private $recruited_by;
    private $referred_by;
    private $sourced_by;
    private $resume;
    private $social_profiles;
    private $source;
    private $stage;
    private $summary;
    private $tags;
    private $updated_date;
    private $work_history;
    private $custom_attributes;

    public static function fromResponse(array $rawCandidate)
    {
        $id = $rawCandidate['_id'];
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
            $id,
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
        string $id,
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
        $this->id = $id;
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
