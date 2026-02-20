<?php

namespace Tests\Services\Brands;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use SentDm\Brands\Campaigns\APIResponseTcrCampaignWithUseCases;
use SentDm\Brands\Campaigns\CampaignListResponse;
use SentDm\Brands\Campaigns\MessagingUseCaseUs;
use SentDm\Client;
use SentDm\Core\Util;
use Tests\UnsupportedMockTests;

/**
 * @internal
 */
#[CoversNothing]
final class CampaignsTest extends TestCase
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

        $result = $this->client->brands->campaigns->create(
            'a1b2c3d4-e5f6-7890-abcd-ef1234567890',
            campaign: [
                'description' => 'Appointment reminders and account notifications',
                'name' => 'Customer Notifications',
                'type' => 'App',
                'useCases' => [
                    [
                        'messagingUseCaseUs' => MessagingUseCaseUs::ACCOUNT_NOTIFICATION,
                        'sampleMessages' => [
                            'Hi {name}, your appointment is confirmed for {date} at {time}.',
                            'Your order #{order_id} has been shipped. Track at {url}',
                        ],
                    ],
                ],
            ],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(APIResponseTcrCampaignWithUseCases::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->brands->campaigns->create(
            'a1b2c3d4-e5f6-7890-abcd-ef1234567890',
            campaign: [
                'description' => 'Appointment reminders and account notifications',
                'name' => 'Customer Notifications',
                'type' => 'App',
                'useCases' => [
                    [
                        'messagingUseCaseUs' => MessagingUseCaseUs::ACCOUNT_NOTIFICATION,
                        'sampleMessages' => [
                            'Hi {name}, your appointment is confirmed for {date} at {time}.',
                            'Your order #{order_id} has been shipped. Track at {url}',
                        ],
                    ],
                ],
                'helpKeywords' => 'HELP, INFO, SUPPORT',
                'helpMessage' => 'Reply STOP to unsubscribe or contact support@acmecorp.com',
                'messageFlow' => 'User signs up on website and opts in to receive SMS notifications',
                'optinKeywords' => 'YES, START, SUBSCRIBE',
                'optinMessage' => 'You have opted in to Acme Corp notifications. Reply STOP to opt out.',
                'optoutKeywords' => 'STOP, UNSUBSCRIBE, END',
                'optoutMessage' => 'You have been unsubscribed. Reply START to opt back in.',
                'privacyPolicyLink' => 'https://acmecorp.com/privacy',
                'termsAndConditionsLink' => 'https://acmecorp.com/terms',
            ],
            testMode: false,
            idempotencyKey: 'req_abc123_retry1',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(APIResponseTcrCampaignWithUseCases::class, $result);
    }

    #[Test]
    public function testUpdate(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->brands->campaigns->update(
            'b2c3d4e5-f6a7-8901-bcde-f12345678901',
            brandID: 'a1b2c3d4-e5f6-7890-abcd-ef1234567890',
            campaign: [
                'description' => 'Updated appointment reminders and account notifications',
                'name' => 'Customer Notifications Updated',
                'type' => 'App',
                'useCases' => [
                    [
                        'messagingUseCaseUs' => MessagingUseCaseUs::ACCOUNT_NOTIFICATION,
                        'sampleMessages' => [
                            'Hi {name}, your appointment is confirmed for {date} at {time}.',
                            'Your order #{order_id} has been shipped. Track at {url}',
                        ],
                    ],
                ],
            ],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(APIResponseTcrCampaignWithUseCases::class, $result);
    }

    #[Test]
    public function testUpdateWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->brands->campaigns->update(
            'b2c3d4e5-f6a7-8901-bcde-f12345678901',
            brandID: 'a1b2c3d4-e5f6-7890-abcd-ef1234567890',
            campaign: [
                'description' => 'Updated appointment reminders and account notifications',
                'name' => 'Customer Notifications Updated',
                'type' => 'App',
                'useCases' => [
                    [
                        'messagingUseCaseUs' => MessagingUseCaseUs::ACCOUNT_NOTIFICATION,
                        'sampleMessages' => [
                            'Hi {name}, your appointment is confirmed for {date} at {time}.',
                            'Your order #{order_id} has been shipped. Track at {url}',
                        ],
                    ],
                ],
                'helpKeywords' => null,
                'helpMessage' => null,
                'messageFlow' => 'User signs up on website and opts in to receive SMS notifications',
                'optinKeywords' => null,
                'optinMessage' => null,
                'optoutKeywords' => null,
                'optoutMessage' => null,
                'privacyPolicyLink' => null,
                'termsAndConditionsLink' => null,
            ],
            testMode: false,
            idempotencyKey: 'req_abc123_retry1',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(APIResponseTcrCampaignWithUseCases::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->brands->campaigns->list(
            'a1b2c3d4-e5f6-7890-abcd-ef1234567890'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(CampaignListResponse::class, $result);
    }

    #[Test]
    public function testDelete(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->brands->campaigns->delete(
            'b2c3d4e5-f6a7-8901-bcde-f12345678901',
            brandID: 'a1b2c3d4-e5f6-7890-abcd-ef1234567890',
            body: [],
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

        $result = $this->client->brands->campaigns->delete(
            'b2c3d4e5-f6a7-8901-bcde-f12345678901',
            brandID: 'a1b2c3d4-e5f6-7890-abcd-ef1234567890',
            body: ['testMode' => false],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertNull($result);
    }
}
