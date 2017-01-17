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
}