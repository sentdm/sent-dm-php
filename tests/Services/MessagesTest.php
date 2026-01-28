<?php

namespace Tests\Services;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use SentDm\Client;
use SentDm\Messages\MessageGetResponse;
use Tests\UnsupportedMockTests;

/**
 * @internal
 */
#[CoversNothing]
final class MessagesTest extends TestCase
{
    protected Client $client;

    protected function setUp(): void
    {
        parent::setUp();

        $testUrl = getenv('TEST_API_BASE_URL') ?: 'http://127.0.0.1:4010';
        $client = new Client(
            apiKey: 'My API Key',
            senderID: 'My Sender ID',
            baseUrl: $testUrl,
        );

        $this->client = $client;
    }

    #[Test]
    public function testRetrieve(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->messages->retrieve(
            '7ba7b820-9dad-11d1-80b4-00c04fd430c8'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(MessageGetResponse::class, $result);
    }

    #[Test]
    public function testSendQuickMessage(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->messages->sendQuickMessage(
            customMessage: 'Hello, this is a test message!',
            phoneNumber: '+1234567890',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertNull($result);
    }

    #[Test]
    public function testSendQuickMessageWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->messages->sendQuickMessage(
            customMessage: 'Hello, this is a test message!',
            phoneNumber: '+1234567890',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertNull($result);
    }

    #[Test]
    public function testSendToContact(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->messages->sendToContact(
            contactID: '6ba7b810-9dad-11d1-80b4-00c04fd430c8',
            templateID: '7ba7b820-9dad-11d1-80b4-00c04fd430c8',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertNull($result);
    }

    #[Test]
    public function testSendToContactWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->messages->sendToContact(
            contactID: '6ba7b810-9dad-11d1-80b4-00c04fd430c8',
            templateID: '7ba7b820-9dad-11d1-80b4-00c04fd430c8',
            templateVariables: ['name' => 'John Doe', 'order_id' => '12345'],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertNull($result);
    }

    #[Test]
    public function testSendToPhone(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->messages->sendToPhone(
            phoneNumber: '+1234567890',
            templateID: '7ba7b820-9dad-11d1-80b4-00c04fd430c8',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertNull($result);
    }

    #[Test]
    public function testSendToPhoneWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->messages->sendToPhone(
            phoneNumber: '+1234567890',
            templateID: '7ba7b820-9dad-11d1-80b4-00c04fd430c8',
            templateVariables: ['name' => 'John Doe', 'order_id' => '12345'],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertNull($result);
    }
}
