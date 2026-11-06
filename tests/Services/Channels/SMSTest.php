<?php

namespace Tests\Services\Channels;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use SentDm\Channels\SMS\APIResponseOfListOfSMSMarket;
use SentDm\Channels\SMS\APIResponseOfSMSMarket;
use SentDm\Client;
use SentDm\Core\Util;
use Tests\UnsupportedMockTests;

/**
 * @internal
 */
#[CoversNothing]
final class SMSTest extends TestCase
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
    public function testCreate(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->channels->sms->create(numberType: 'TEN_DLC');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(APIResponseOfSMSMarket::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->channels->sms->create(
            numberType: 'TEN_DLC',
            areaCodes: ['415', '628'],
            compliance: [
                'brand' => [
                    'businessName' => 'business_name',
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
                    'taxID' => 'tax_id',
                    'taxIDType' => 'tax_id_type',
                    'website' => 'website',
                ],
                'campaign' => [
                    'description' => 'description',
                    'helpKeywords' => 'help_keywords',
                    'helpMessage' => 'help_message',
                    'inherit' => true,
                    'messageFlow' => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
                    'optInKeywords' => 'opt_in_keywords',
                    'optInMessage' => 'opt_in_message',
                    'optOutKeywords' => 'opt_out_keywords',
                    'optOutMessage' => 'opt_out_message',
                    'privacyPolicyLink' => 'privacy_policy_link',
                    'termsAndConditionsLink' => 'terms_and_conditions_link',
                    'useCases' => [
                        ['sampleMessages' => [(object) []], 'useCase' => 'MARKETING'],
                    ],
                    'volume' => 'volume',
                ],
            ],
            country: 'US',
            numbers: [['areaCode' => 'area_code', 'quantity' => 0]],
            sandbox: false,
            senderValue: null,
            idempotencyKey: 'req_abc123_retry1',
            xProfileID: '182bd5e5-6e1a-4fe4-a799-aa6d9a6ab26e',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(APIResponseOfSMSMarket::class, $result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->channels->sms->retrieve('ten_dlc', country: 'US');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(APIResponseOfSMSMarket::class, $result);
    }

    #[Test]
    public function testRetrieveWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->channels->sms->retrieve(
            'ten_dlc',
            country: 'US',
            xProfileID: '182bd5e5-6e1a-4fe4-a799-aa6d9a6ab26e',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(APIResponseOfSMSMarket::class, $result);
    }

    #[Test]
    public function testUpdate(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->channels->sms->update('ten_dlc', country: 'US');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(APIResponseOfSMSMarket::class, $result);
    }

    #[Test]
    public function testUpdateWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->channels->sms->update(
            'ten_dlc',
            country: 'US',
            compliance: [
                'brand' => [
                    'businessName' => 'business_name',
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
                    'taxID' => 'tax_id',
                    'taxIDType' => 'tax_id_type',
                    'website' => 'website',
                ],
                'campaign' => [
                    'description' => 'description',
                    'helpKeywords' => 'help_keywords',
                    'helpMessage' => 'help_message',
                    'inherit' => true,
                    'messageFlow' => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
                    'optInKeywords' => 'opt_in_keywords',
                    'optInMessage' => 'opt_in_message',
                    'optOutKeywords' => 'opt_out_keywords',
                    'optOutMessage' => 'opt_out_message',
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
        $this->assertInstanceOf(APIResponseOfSMSMarket::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->channels->sms->list();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(APIResponseOfListOfSMSMarket::class, $result);
    }
}
