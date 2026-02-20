<?php

namespace Tests\Services;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use SentDm\Brands\APIResponseBrandWithKYC;
use SentDm\Brands\BrandListResponse;
use SentDm\Brands\TcrBrandRelationship;
use SentDm\Brands\TcrVertical;
use SentDm\Client;
use SentDm\Core\Util;
use Tests\UnsupportedMockTests;

/**
 * @internal
 */
#[CoversNothing]
final class BrandsTest extends TestCase
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

        $result = $this->client->brands->create(
            brand: [
                'brandRelationship' => TcrBrandRelationship::SMALL_ACCOUNT,
                'contactName' => 'John Smith',
                'vertical' => TcrVertical::PROFESSIONAL,
            ],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(APIResponseBrandWithKYC::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->brands->create(
            brand: [
                'brandRelationship' => TcrBrandRelationship::SMALL_ACCOUNT,
                'contactName' => 'John Smith',
                'vertical' => TcrVertical::PROFESSIONAL,
                'brandName' => null,
                'businessLegalName' => 'Acme Corporation LLC',
                'businessName' => 'Acme Corp',
                'businessRole' => 'CEO',
                'businessURL' => 'https://acmecorp.com',
                'city' => 'New York',
                'contactEmail' => 'john@acmecorp.com',
                'contactPhone' => '+12025551234',
                'contactPhoneCountryCode' => '1',
                'country' => 'US',
                'countryOfRegistration' => 'US',
                'destinationCountries' => [['id' => 'US', 'isMain' => false]],
                'entityType' => 'PRIVATE_PROFIT',
                'expectedMessagingVolume' => '10000',
                'isTcrApplication' => true,
                'notes' => null,
                'phoneNumberPrefix' => '+1',
                'postalCode' => '10001',
                'primaryUseCase' => 'Customer notifications and appointment reminders',
                'state' => 'NY',
                'street' => '123 Main Street',
                'taxID' => '12-3456789',
                'taxIDType' => 'us_ein',
            ],
            testMode: false,
            idempotencyKey: 'req_abc123_retry1',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(APIResponseBrandWithKYC::class, $result);
    }

    #[Test]
    public function testUpdate(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->brands->update(
            'a1b2c3d4-e5f6-7890-abcd-ef1234567890',
            brand: [
                'brandRelationship' => TcrBrandRelationship::SMALL_ACCOUNT,
                'contactName' => 'John Smith',
                'vertical' => TcrVertical::PROFESSIONAL,
            ],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(APIResponseBrandWithKYC::class, $result);
    }

    #[Test]
    public function testUpdateWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->brands->update(
            'a1b2c3d4-e5f6-7890-abcd-ef1234567890',
            brand: [
                'brandRelationship' => TcrBrandRelationship::SMALL_ACCOUNT,
                'contactName' => 'John Smith',
                'vertical' => TcrVertical::PROFESSIONAL,
                'brandName' => null,
                'businessLegalName' => 'Acme Corporation LLC',
                'businessName' => 'Acme Corp Updated',
                'businessRole' => 'CTO',
                'businessURL' => null,
                'city' => null,
                'contactEmail' => 'john@acmecorp.com',
                'contactPhone' => '+12025551234',
                'contactPhoneCountryCode' => '1',
                'country' => 'US',
                'countryOfRegistration' => null,
                'destinationCountries' => [['id' => 'id', 'isMain' => true]],
                'entityType' => null,
                'expectedMessagingVolume' => null,
                'isTcrApplication' => null,
                'notes' => null,
                'phoneNumberPrefix' => null,
                'postalCode' => null,
                'primaryUseCase' => null,
                'state' => null,
                'street' => null,
                'taxID' => null,
                'taxIDType' => null,
            ],
            testMode: false,
            idempotencyKey: 'req_abc123_retry1',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(APIResponseBrandWithKYC::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->brands->list();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BrandListResponse::class, $result);
    }

    #[Test]
    public function testDelete(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->brands->delete(
            'a1b2c3d4-e5f6-7890-abcd-ef1234567890',
            body: []
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertNull($result);
    }

    #[Test]
    public function testDeleteWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->brands->delete(
            'a1b2c3d4-e5f6-7890-abcd-ef1234567890',
            body: ['testMode' => false]
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertNull($result);
    }
}
