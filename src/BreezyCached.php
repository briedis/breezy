<?php


namespace Briedis\Breezy;


use Briedis\Breezy\Exceptions\BreezyException;
use Briedis\Breezy\Structures\CompanyItem;
use Briedis\Breezy\Structures\PositionItem;

/**
 * Class that wraps Breezy and allows to add a cached layer for methods to get token, positions etc.
 */
class BreezyCached extends Breezy
{
    const PREFIX = 'br:';

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
        $key = self::PREFIX . 'token:' . sha1($email . $password);

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
     * @return CompanyItem
     * @throws BreezyException
     */
    public function getCompany($companyId)
    {
        $key = self::PREFIX . 'company:' . $companyId;

        $rawCompany = $this->cache->get($key);
        if (is_array($rawCompany)) {
            return CompanyItem::fromArray($rawCompany);
        }

        $company = parent::getCompany($companyId);

        $this->cache->set($key, $company->rawData, 30 * 60);

        return $company;
    }

    /**
     * Get position data
     * @param $companyId
     * @param $positionId
     * @return PositionItem
     * @throws BreezyException
     */
    public function getPosition($companyId, $positionId)
    {
        $key = self::PREFIX . 'position:' . $positionId;

        $rawPosition = $this->cache->get($key);
        if (is_array($rawPosition)) {
            return PositionItem::fromArray($rawPosition);
        }

        $position = parent::getPosition($companyId, $positionId);

        $this->cache->set($key, $position->rawData, 30 * 60);

        return $position;
    }

    /**
     * Get positions
     * @param string $companyId
     * @param string $state State of the position (draft, archived, etc). By default, returns only published. Pass an empty string if you want all
     * @return PositionItem[]
     * @throws BreezyException
     */
    public function getCompanyPositions($companyId, $state = PositionItem::STATE_PUBLISHED)
    {
        $key = $this->getCompanyPositionKey($companyId, $state);

        $rawPositions = $this->cache->get($key);

        if (is_array($rawPositions)) {
            return array_map(function (array $rawPosition) {
                return PositionItem::fromArray($rawPosition);
            }, $rawPositions);
        }

        $positions = parent::getCompanyPositions($companyId, $state);

        $rawPositions = array_map(function (PositionItem $position) {
            return $position->rawData;
        }, $positions);

        $this->cache->set($key, $rawPositions, 10 * 60);

        return $positions;
    }

    /**
     * Newly created position
     * @param string $companyId
     * @param PositionItem $position
     * @throws BreezyException
     * @return PositionItem Created position from backend
     */
    public function createPosition($companyId, PositionItem $position)
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
        return self::PREFIX . 'positions:' . $companyId . ':' . $state;
    }
}