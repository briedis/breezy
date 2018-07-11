<?php

use \Briedis\Breezy\Breezy;
use \Briedis\Breezy\Structures\PositionItem;

// Create a regular breezy class, that does not use caching, always calls API
$breezy = new Breezy();

// Set credentials (Company ID can be retrieved from API (http://developer.breezy.hr/docs/userdetails))
$email = 'your@email';
$password = '*********';
$companyId = '000000000';

// Sign in before every consecutive request
$breezy->signIn($email, $password);

// Create position
$position = new PositionItem;
$position->name = 'Web Developer';
$position->description = 'This is a developer';
$position->state = PositionItem::STATE_DRAFT;
$position->location = [
	'country' => 'LV',
	'city' => 'Riga',
];
$position->type = PositionItem::TYPE_OTHER;
$position->category = PositionItem::CATEGORY_OTHER;
$position->education = PositionItem::EDUCATION_UNSPECIFIED;
$position->experience = PositionItem::EXPERIENCE_NA;

// Add position
$newPosition = $breezy->createPosition($companyId, $position);
