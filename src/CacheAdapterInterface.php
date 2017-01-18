<?php


namespace Briedis\Breezy;


interface CacheAdapterInterface
{
    const CACHE_KEY_PREFIX = 'breezy:';

    /**
     * Retrieve item from cache
     *
     * @param string $key
     * @return array|null|false Array or a primitive value or null/false if nothing is present
     */
    public function get($key);

    /**
     * Cache given array
     *
     * @param string $key
     * @param mixed $value Array or a primitive value
     * @param $durationInSeconds
     */
    public function set($key, $value, $durationInSeconds);

    /**
     * Remove key from cache
     *
     * @param string $key
     */
    public function forget($key);
}