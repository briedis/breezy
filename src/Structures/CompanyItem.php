<?php


namespace Briedis\Breezy\Structures;


class CompanyItem extends BaseItem
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * Company description
     * @var string
     */
    public $description;

    /**
     * Company URL
     * @var string
     */
    public $url;

    /**
     * @var string URL
     */
    public $logo;

    /**
     * Published positions
     * @var PositionItem[]
     */
    public $positions = [];
}