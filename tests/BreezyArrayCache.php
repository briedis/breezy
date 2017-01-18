<?php


namespace Briedis\Breezy\Tests;


use Briedis\Breezy\CacheAdapterInterface;

/**
 * Simple array cache implementation for testing purposes
 */
class BreezyArrayCache implements CacheAdapterInterface
{
    /** @var array */
    private $cache = [];

    /**
     * @inheritdoc
     */
    public function get($key)
    {
        return isset($this->cache[$key]) ? $this->cache[$key] : null;
    }

    /**
     * @inheritdoc
     */
    public function set($key, $value, $durationInSeconds)
    {
        $this->cache[$key] = $value;
    }

    /**
     * @inheritdoc
     */
    public function forget($key)
    {
        unset($this->cache[$key]);
    }
}