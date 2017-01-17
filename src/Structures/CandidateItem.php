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
}