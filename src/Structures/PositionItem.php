<?php


namespace Briedis\Breezy\Structures;


class PositionItem extends BaseItem
{
    const STATE_DRAFT = 'draft';
    const STATE_PUBLISHED = 'published';
    const STATE_CLOSED = 'closed';

    /**
     * Internal ID
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $companyId;

    /**
     * "Junior programmer", etc.
     * @var string
     */
    public $name;

    /**
     * "Marketing", etc.
     * @var string
     */
    public $department;

    /**
     * @var string HTML
     */
    public $description;

    /**
     * "Full time", etc.
     * @var string
     */
    public $type;

    /**
     * "Junior", etc.
     * @var string
     */
    public $experience;

    /**
     * @var int
     */
    public $updatedAt;

    /**
     * @var int
     */
    public $createdAt;

    /**
     * State of current position
     * @var string
     */
    public $state;

    /**
     * @return bool
     */
    public function isPublished()
    {
        return $this->state === self::STATE_PUBLISHED;
    }

    /**
     * @inheritdoc
     */
    public static function fromArray(array $rawPosition)
    {
        $position = new PositionItem;

        $position->rawData = $rawPosition;
        $position->id = $rawPosition['_id'];
        $position->companyId = $rawPosition['company']['_id'];
        $position->name = $rawPosition['name'];
        $position->department = isset($rawPosition['department']) ? $rawPosition['department'] : '';
        $position->description = $rawPosition['description'];
        $position->type = $rawPosition['type']['name'];
        $position->experience = isset($rawPosition['experience']['name']) ? $rawPosition['experience']['name'] : '';
        $position->createdAt = strtotime($rawPosition['creation_date']);
        $position->updatedAt = strtotime($rawPosition['updated_date']);
        $position->state = $rawPosition['state'];

        return $position;
    }
}