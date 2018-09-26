<?php


namespace Briedis\Breezy;


use Briedis\Breezy\Exceptions\BreezyException;
use Briedis\Breezy\Structures\Company;
use Briedis\Breezy\Structures\Position;

/**
 * Class that wraps Breezy and allows to add a cached layer for methods to get token, positions etc.
 */
class BreezyCached extends Breezy
{
    /** @var CacheAdapterInterface */
    private $cache;

    /**
     * Pass the cache handler that will perform caching
     * @param CacheAdapterInterface $cache
     * @param BreezyApiClient|null $apiClient Default client is used if nothing is provided
     */
    public function __construct(CacheAdapterInterface $cache, BreezyApiClient $apiClient = null)
    {
        parent::__construct($apiClient);
        $this->cache = $cache;
    }

    /**
     * Sign in and set access token so consecutive requests are authorized
     * @param string $email
     * @param string $password
     * @return string Access token
     */
    public function signIn($email, $password)
    {
        $key = 'token:' . sha1($email . $password);

        $token = $this->cache->get($key);

        if ($token) {
            $this->api->setToken($token);
            return $token;
        }

        $token = parent::signIn($email, $password);

        $this->cache->set($key, $token, 10 * 60);

        return $token;
    }

    /**
     * Get company data
     * @param string $companyId
     * @return Company
     */
    public function getCompany($companyId)
    {
        $key = 'company:' . $companyId;

        $rawCompany = $this->cache->get($key);
        if (is_array($rawCompany)) {
            return Company::fromResponse($rawCompany);
        }

        $company = parent::getCompany($companyId);

        $this->cache->set($key, $company->rawData, 30 * 60);

        return $company;
    }

    /**
     * Get positions
     * @param string $companyId
     * @param string $state State of the position (draft, archived, etc). By default, returns only published. Pass an empty string if you want all
     * @return Position[]
     */
    public function getCompanyPositions($companyId, $state = Position::STATE_PUBLISHED)
    {
        $key = $this->getCompanyPositionKey($companyId, $state);

        $rawPositions = $this->cache->get($key);

        if (is_array($rawPositions)) {
            return array_map(function (array $rawPosition) {
                return Position::fromResponse($rawPosition);
            }, $rawPositions);
        }

        $positions = parent::getCompanyPositions($companyId, $state);

        $rawPositions = array_map(function (Position $position) {
            return $position->rawData;
        }, $positions);

        $this->cache->set($key, $rawPositions, 10 * 60);

        return $positions;
    }

    /**
     * Newly created position
     * @param string $companyId
     * @param Position $position
     * @throws BreezyException
     * @return Position Created position from backend
     */
    public function createPosition($companyId, Position $position)
    {
        $this->cache->forget(
            $this->getCompanyPositionKey($companyId, $position->state)
        );

        return parent::createPosition($companyId, $position);
    }

    /**
     * @param string $companyId
     * @param string $state
     * @return string
     */
    private function getCompanyPositionKey($companyId, $state)
    {
        return 'positions:' . $companyId . ':' . $state;
    }
}