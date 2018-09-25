<?php

use \Briedis\Breezy\Breezy;
use \Briedis\Breezy\Structures\Position;

// Create a regular breezy class, that does not use caching, always calls API
$breezy = new Breezy();

// Set credentials (Company ID can be retrieved from API (http://developer.breezy.hr/docs/userdetails))
$email = 'your@email';
$password = '*********';
$companyId = '000000000';

// Sign in before every consecutive request
$breezy->signIn($email, $password);

// Create position
$position = new Position;
$position->name = 'Web Developer';
$position->description = 'This is a developer';
$position->state = Position::STATE_DRAFT;
$position->location = [
	'country' => 'LV',
	'city' => 'Riga',
];
$position->type = Position::TYPE_OTHER;
$position->category = Position::CATEGORY_OTHER;
$position->education = Position::EDUCATION_UNSPECIFIED;
$position->experience = Position::EXPERIENCE_NA;

// Add position
$newPosition = $breezy->createPosition($companyId, $position);
