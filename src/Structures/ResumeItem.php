<?php


namespace Briedis\Breezy\Structures;


class ResumeItem extends BaseItem
{
    /**
     * Breezy URL where files resides
     * @var string
     */
    public $url;

    /**
     * Size in bytes
     * @var int
     */
    public $size;

    /**
     * @inheritdoc
     */
    public static function fromArray(array $rawResume)
    {
        $resume = new ResumeItem;

        $resume->rawData = $rawResume;

        $resume->url = $rawResume['url'];
        $resume->size = $rawResume['file_size'];

        return $resume;
    }
}