<?php


namespace Draugiem\BreezySync\Structures;


class PositionItem
{
    /**
     * Internal ID
     * @var string
     */
    public $id;

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
}