<?php

namespace Tests\Services\Channels;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use SentDm\Channels\Markets\APIResponseOfChannelMarket;
use SentDm\Channels\Markets\APIResponseOfListOfChannelMarket;
use SentDm\Channels\Markets\APIResponseOfMarketNumbers;
use SentDm\Client;
use SentDm\Core\Util;
use Tests\UnsupportedMockTests;

/**
 * @internal
 */
#[CoversNothing]
final class MarketsTest extends TestCase
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
    public function testRetrieve(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->channels->markets->retrieve(
            'ten_dlc',
            channel: 'sms',
            country: 'US'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(APIResponseOfChannelMarket::class, $result);
    }

    #[Test]
    public function testRetrieveWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->channels->markets->retrieve(
            'ten_dlc',
            channel: 'sms',
            country: 'US',
            xProfileID: '182bd5e5-6e1a-4fe4-a799-aa6d9a6ab26e',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(APIResponseOfChannelMarket::class, $result);
    }

    #[Test]
    public function testUpdate(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->channels->markets->update(
            'ten_dlc',
            channel: 'sms',
            country: 'US'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(APIResponseOfChannelMarket::class, $result);
    }

    #[Test]
    public function testUpdateWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->channels->markets->update(
            'ten_dlc',
            channel: 'sms',
            country: 'US',
            compliance: [
                'brand' => [
                    'businessName' => 'xxx',
                    'city' => 'city',
                    'contactEmail' => 'dev@stainless.com',
                    'contactName' => 'contact_name',
                    'contactPhone' => 'contact_phone',
                    'country' => 'country',
                    'einIssuingCountry' => 'ein_issuing_country',
                    'entityType' => 'PRIVATE_PROFIT',
                    'inherit' => true,
                    'legalName' => 'legal_name',
                    'postalCode' => 'postal_code',
                    'state' => 'state',
                    'street' => 'street',
                    'taxID' => 'xx',
                    'taxIDType' => 'tax_id_type',
                    'website' => 'website',
                ],
                'campaign' => [
                    'description' => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
                    'helpKeywords' => 'help_keywords',
                    'helpMessage' => 'xxxxxxxxxxxxxxxxxxxx',
                    'inherit' => true,
                    'messageFlow' => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
                    'optInKeywords' => 'opt_in_keywords',
                    'optInMessage' => 'xxxxxxxxxxxxxxxxxxxx',
                    'optOutKeywords' => 'opt_out_keywords',
                    'optOutMessage' => 'xxxxxxxxxxxxxxxxxxxx',
                    'privacyPolicyLink' => 'privacy_policy_link',
                    'termsAndConditionsLink' => 'terms_and_conditions_link',
                    'useCases' => [
                        ['sampleMessages' => [(object) []], 'useCase' => 'MARKETING'],
                    ],
                    'volume' => 'volume',
                ],
            ],
            sandbox: false,
            idempotencyKey: 'req_abc123_retry1',
            xProfileID: '182bd5e5-6e1a-4fe4-a799-aa6d9a6ab26e',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(APIResponseOfChannelMarket::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->channels->markets->list('channel');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(APIResponseOfListOfChannelMarket::class, $result);
    }

    #[Test]
    public function testAddNumbers(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->channels->markets->addNumbers(
            'TEN_DLC',
            channel: 'sms',
            country: 'US',
            numbers: [[], []],
            idempotencyKey: 'req_abc123_retry1',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(APIResponseOfChannelMarket::class, $result);
    }

    #[Test]
    public function testAddNumbersWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->channels->markets->addNumbers(
            'TEN_DLC',
            channel: 'sms',
            country: 'US',
            numbers: [
                ['areaCode' => '415', 'quantity' => 2],
                ['areaCode' => '212', 'quantity' => 1],
            ],
            idempotencyKey: 'req_abc123_retry1',
            campaignID: '8f14e45f-ceea-467f-a8f0-7c2a3d1b9e01',
            sandbox: false,
            xProfileID: '182bd5e5-6e1a-4fe4-a799-aa6d9a6ab26e',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(APIResponseOfChannelMarket::class, $result);
    }

    #[Test]
    public function testListNumbers(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->channels->markets->listNumbers(
            'type',
            channel: 'channel',
            country: 'country'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(APIResponseOfMarketNumbers::class, $result);
    }

    #[Test]
    public function testListNumbersWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->channels->markets->listNumbers(
            'type',
            channel: 'channel',
            country: 'country',
            campaignID: '182bd5e5-6e1a-4fe4-a799-aa6d9a6ab26e',
            xProfileID: '182bd5e5-6e1a-4fe4-a799-aa6d9a6ab26e',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(APIResponseOfMarketNumbers::class, $result);
    }

    #[Test]
    public function testReplaceNumbers(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->channels->markets->replaceNumbers(
            'TEN_DLC',
            channel: 'sms',
            country: 'US',
            numbers: [[], []]
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(APIResponseOfChannelMarket::class, $result);
    }

    #[Test]
    public function testReplaceNumbersWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->channels->markets->replaceNumbers(
            'TEN_DLC',
            channel: 'sms',
            country: 'US',
            numbers: [
                ['areaCode' => '415', 'quantity' => 2],
                ['areaCode' => '212', 'quantity' => 1],
            ],
            campaignID: '8f14e45f-ceea-467f-a8f0-7c2a3d1b9e01',
            sandbox: false,
            idempotencyKey: 'req_abc123_retry1',
            xProfileID: '182bd5e5-6e1a-4fe4-a799-aa6d9a6ab26e',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(APIResponseOfChannelMarket::class, $result);
    }
}
