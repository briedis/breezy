<?php


namespace Briedis\Breezy\Tests;


use Briedis\Breezy\BreezyApiClient;
use Briedis\Breezy\BreezyCached;
use Briedis\Breezy\CacheAdapterInterface;
use Briedis\Breezy\Structures\PositionItem;
use Mockery;

class CacheTest extends TestBase
{
    /** @var CacheAdapterInterface */
    private $cache;

    /** @var Mockery\Mock|BreezyApiClient */
    private $apiMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->apiMock = Mockery::mock(BreezyApiClient::class)->makePartial();
        $this->cache = new BreezyArrayCache;
    }

    /**
     * @return BreezyCached
     */
    protected function breezy()
    {
        return new BreezyCached($this->cache, $this->apiMock);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testRememberToken()
    {
        $this->apiMock->shouldReceive('post')->once()->passthru();

        $token = $this->breezy()->signIn(Credentials::$email, Credentials::$password);

        $token2 = $this->breezy()->signIn(Credentials::$email, Credentials::$password);

        self::assertEquals($token, $token2);
    }

    public function testRememberPositions()
    {
        $this->breezy()->signIn(Credentials::$email, Credentials::$password);

        $this->apiMock->shouldReceive('get')->once()->passthru();

        $positions = $this->breezy()->getCompanyPositions(Credentials::$companyId);

        $positions2 = $this->breezy()->getCompanyPositions(Credentials::$companyId);

        self::assertEquals($positions, $positions2);
    }

    public function testRememberCompany()
    {
        $this->breezy()->signIn(Credentials::$email, Credentials::$password);

        $this->apiMock->shouldReceive('get')->once()->passthru();

        $company = $this->breezy()->getCompany(Credentials::$companyId);

        $company2 = $this->breezy()->getCompany(Credentials::$companyId);

        self::assertEquals($company, $company2);
    }

    public function testCacheBustWhenAddingPosition()
    {
        $this->breezy()->signIn(Credentials::$email, Credentials::$password);

        $this->apiMock->shouldReceive('get')->twice()->passthru();

        $position = new PositionItem;
        $position->name = 'Test API position (' . uniqid(date('r') . '_', true) . ')';
        $position->description = 'Description';
        $position->state = PositionItem::STATE_DRAFT;
        $position->type = PositionItem::TYPE_OTHER;
        $position->category = PositionItem::CATEGORY_OTHER;
        $position->education = PositionItem::EDUCATION_UNSPECIFIED;
        $position->experience = PositionItem::EXPERIENCE_NA;
        $position->location = [
            'country' => 'LV',
            'city' => 'Riga',
        ];

        $positions = $this->breezy()->getCompanyPositions(Credentials::$companyId, $position->state);

        $this->breezy()->createPosition(Credentials::$companyId, $position);

        $positions2 = $this->breezy()->getCompanyPositions(Credentials::$companyId, $position->state);

        self::assertGreaterThan(count($positions), count($positions2));
    }
}