[![Latest Stable Version](https://poser.pugx.org/briedis/breezy/v/stable.svg)](https://packagist.org/packages/briedis/breezy)
[![Latest Unstable Version](https://poser.pugx.org/briedis/breezy/v/unstable.svg)](https://packagist.org/packages/briedis/breezy)

# Simple Breezy PHP API wrapper

Installation using Composer:

`composer require briedis/breezy --no-dev`

# Usage examples
```
<?php
/*
 * Create a cached class (works faster, caches some of the API requests)
 */
$breezy = new \Briedis\Breezy\BreezyCached(new CustomCacheDriver);


/*
 * Create a regular breezy class, that does not use caching, always calls API
 */
$breezy = new \Briedis\Breezy\Breezy();


/*
 * Set credentials (Company ID can be retrieved from API (http://developer.breezy.hr/docs/userdetails))
 */
$email = 'your@email';
$password = '*********';
$companyId = '000000000';


/*
 * Sign in before every consecutive request
 */

$breezy->signIn($email, $password);


/*
 * Get data about company (description, logo, etc)
 */

$company = $breezy->getCompany($companyId);
echo $company->name;
echo $company->description;
echo '<img src="' . htmlspecialchars($company->logo) . '">';


/*
 * Getting current positions
 */

foreach ($breezy->getCompanyPositions($companyId) as $v) {
    echo $v->name;
}


/*
 * Adding a candidate
 */

// Upload a resume
$resume = $breezy->uploadResume($companyId, '/path/to/resume.pdf', 'my-resume.pdf');

// Set candidate data
$candidate = new \Briedis\Breezy\Structures\CandidateItem;
$candidate->name = 'Candidate Name';
$candidate->phone_number = '1234567890';
$candidate->email_address = 'candidate@email';

// Create the candidate (resume is optional)
$createdCandidate = $breezy->addCandidate($companyId, candidate, $resume);


/*
 * Adding a position
 */

$position = new \Briedis\Breezy\Structures\PositionItem;
$position->name = 'Position name';
$position->description = '<h1>Description</h1>';
$position->state = \Briedis\Breezy\Structures\PositionItem::STATE_PUBLISHED;

$breezy->createPosition($companyId, $position);


/*
 * Implement your own caching class if you want to use the cached driver
 */

class CustomCacheDriver implements Briedis\Breezy\CacheAdapterInterface
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
```