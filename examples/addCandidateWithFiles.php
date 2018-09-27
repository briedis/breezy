<?php

use \Briedis\Breezy\Breezy;
use \Briedis\Breezy\Structures\Candidate;

// Create a regular breezy class, that does not use caching, always calls API
$breezy = new Breezy();

// Set credentials (Company ID can be retrieved from API (http://developer.breezy.hr/docs/userdetails))
$email = 'your@email';
$password = '*********';
$companyId = '000000000';
$positionId = '000000000';

// Sign in before every consecutive request
$breezy->signIn($email, $password);

// Create candidate
$candidate = new Candidate;
$candidate->name = 'John Doe';
$candidate->origin = Candidate::ORIGIN_SOURCED;
$candidate->summary = 'This is a new candidate.';
$candidate->phone_number = '21234567';
$candidate->email_address = 'candidate@example.com';

// Add candidate
$newCandidate = $breezy->addCandidate($companyId, $positionId, $candidate);

// Upload candidate resume file
$resume = $breezy->uploadResume($companyId, $positionId, $newCandidate->id, '/path/to/resume.pdf', 'my-resume.pdf');

// Upload candidate other documents
$document = $breezy->uploadDocument($companyId, $positionId, $newCandidate->id, '/path/to/document.pdf', 'my-document.pdf');