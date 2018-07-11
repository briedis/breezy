<?php

use \Briedis\Breezy\Breezy;
use \Briedis\Breezy\BreezyCached;

// Create a regular breezy class, that does not use caching, always calls API
$breezy = new Breezy();

// To use cached version
$breezy = new BreezyCached(new CustomCacheDriver);

// Set credentials (Company ID can be retrieved from API (http://developer.breezy.hr/docs/userdetails))
$email = 'your@email';
$password = '*********';
$companyId = '000000000';

// Sign in before every consecutive request
$breezy->signIn($email, $password);

// Getting current positions
$positions = $breezy->getCompanyPositions($companyId);

foreach ($positions as $position) {
    echo $position->name;
}