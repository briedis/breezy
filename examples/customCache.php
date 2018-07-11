<?php

use \Briedis\Breezy\CacheAdapterInterface;

class CustomCacheDriver implements CacheAdapterInterface
{
    public function get($key)
    {
        return null; // TODO implement
    }

    public function set($key, $value, $durationInSeconds)
    {
        // TODO implement
    }

    public function forget($key)
    {
        // TODO implement
    }
}