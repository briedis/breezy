<?php

namespace Briedis\Breezy\Structures;

class Position
{
    const STATE_DRAFT = 'draft';
    const STATE_CLOSED = 'closed';
    const STATE_PUBLISHED = 'published';
    const STATE_ARCHIVED = 'archived';
    const STATE_PENDING = 'pending';

    private $_id;
    private $state;
    private $name;
    private $friendly_id;
    private $description;
    private $questionnaire_id;
    private $scorecard_id;

    public static function fromResponse(array $rawPosition)
    {
        $_id = $rawPosition['_id'];
        $state = $rawPosition['state'];
        $name = $rawPosition['name'];
        $friendly_id = $rawPosition['friendly_id'];
        $description = $rawPosition['description'];
        $questionnaire_id = $rawPosition['questionnaire_id'];
        $scorecard_id = $rawPosition['scorecard_id'];
        
        return new Position(
            $_id,
            $state,
            $name,
            $friendly_id,
            $description,
            $questionnaire_id,
            $scorecard_id,
        );
    }

    public function __construct(
        string $_id,
        string $state,
        string $name,
        string $friendly_id,
        string $description,
        string $questionnaire_id,
        string $scorecard_id
    ) {
        $this->_id = $_id;
        $this->state = $state;
        $this->name = $name;
        $this->friendly_id = $friendly_id;
        $this->description = $description;
        $this->questionnaire_id = $questionnaire_id;
        $this->scorecard_id = $scorecard_id;
    }

    public function getCandidates($companyId, $positionId)
    {
        $response = $this->api->get('company/' . $companyId . '/position/' . $positionId . '/candidates');

        $candidates = [];

        foreach ($response as $candidate) {
            $candidates[] = CandidateItem::fromArray($candidate);
        }

        return $candidates;
    }

    /**
     * @return bool
     */
    public function isPublished()
    {
        return $this->state === self::STATE_PUBLISHED;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getFriendlyId()
    {
        return $this->friendly_id;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getQuestionnaireId()
    {
        return $this->questionnaire_id;
    }

    /**
     * @return mixed
     */
    public function getScorecardId()
    {
        return $this->scorecard_id;
    }
}
