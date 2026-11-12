<?php

namespace Tests\Services\Channels\SMS;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use SentDm\Channels\SMS\APIResponseOfSMSMarket;
use SentDm\Channels\SMS\TenDlc\APIResponseOfSuppliedCompliance;
use SentDm\Client;
use SentDm\Core\Util;
use Tests\UnsupportedMockTests;

/**
 * @internal
 */
#[CoversNothing]
final class TenDlcTest extends TestCase
{
    protected Client $client;

    protected function setUp(): void
    {
        parent::setUp();

        $testUrl = Util::getenv('TEST_API_BASE_URL') ?: 'http://127.0.0.1:4010';
        $client = new Client(apiKey: 'My API Key', baseUrl: $testUrl);

        $this->client = $client;
    }

    #[Test]
    public function testAddCampaign(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->channels->sms->tenDlc->addCampaign();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(APIResponseOfSMSMarket::class, $result);
    }

    #[Test]
    public function testAddNumbers(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->channels->sms->tenDlc->addNumbers(
            campaignID: '8f14e45f-ceea-467f-a8f0-7c2a3d1b9e01',
            numbers: [[]]
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(APIResponseOfSMSMarket::class, $result);
    }

    #[Test]
    public function testAddNumbersWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->channels->sms->tenDlc->addNumbers(
            campaignID: '8f14e45f-ceea-467f-a8f0-7c2a3d1b9e01',
            numbers: [['areaCode' => '415', 'quantity' => 2]],
            sandbox: false,
            idempotencyKey: 'req_abc123_retry1',
            xProfileID: '182bd5e5-6e1a-4fe4-a799-aa6d9a6ab26e',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(APIResponseOfSMSMarket::class, $result);
    }

    #[Test]
    public function testRetrieveCompliance(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->channels->sms->tenDlc->retrieveCompliance();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(APIResponseOfSuppliedCompliance::class, $result);
    }

    #[Test]
    public function testUpdateCampaign(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->channels->sms->tenDlc->updateCampaign(
            '3f2a6c1e-8b4d-4e2a-9c7f-1d5b0a9e4c21'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(APIResponseOfSMSMarket::class, $result);
    }
}
