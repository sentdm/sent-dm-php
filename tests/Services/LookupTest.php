<?php

namespace Tests\Services;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use SentDm\Client;
use SentDm\Core\Util;
use SentDm\Lookup\LookupGetPhoneInfoResponse;
use Tests\UnsupportedMockTests;

/**
 * @internal
 */
#[CoversNothing]
final class LookupTest extends TestCase
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
    public function testRetrievePhoneInfo(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->lookup->retrievePhoneInfo('phoneNumber');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(LookupGetPhoneInfoResponse::class, $result);
    }
}
