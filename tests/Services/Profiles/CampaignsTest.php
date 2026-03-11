<?php

namespace Tests\Services\Profiles;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use SentDm\Client;
use SentDm\Core\Util;
use SentDm\Profiles\Campaigns\APIResponseOfTcrCampaignWithUseCases;
use SentDm\Profiles\Campaigns\CampaignListResponse;
use SentDm\Profiles\Campaigns\MessagingUseCaseUs;
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

        $result = $this->client->profiles->campaigns->create(
            '770e8400-e29b-41d4-a716-446655440002',
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
        $this->assertInstanceOf(
            APIResponseOfTcrCampaignWithUseCases::class,
            $result
        );
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->profiles->campaigns->create(
            '770e8400-e29b-41d4-a716-446655440002',
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
            sandbox: false,
            idempotencyKey: 'req_abc123_retry1',
            xProfileID: '182bd5e5-6e1a-4fe4-a799-aa6d9a6ab26e',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(
            APIResponseOfTcrCampaignWithUseCases::class,
            $result
        );
    }

    #[Test]
    public function testUpdate(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->profiles->campaigns->update(
            'b2c3d4e5-f6a7-8901-bcde-f12345678901',
            profileID: '770e8400-e29b-41d4-a716-446655440002',
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
        $this->assertInstanceOf(
            APIResponseOfTcrCampaignWithUseCases::class,
            $result
        );
    }

    #[Test]
    public function testUpdateWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->profiles->campaigns->update(
            'b2c3d4e5-f6a7-8901-bcde-f12345678901',
            profileID: '770e8400-e29b-41d4-a716-446655440002',
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
            sandbox: false,
            idempotencyKey: 'req_abc123_retry1',
            xProfileID: '182bd5e5-6e1a-4fe4-a799-aa6d9a6ab26e',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(
            APIResponseOfTcrCampaignWithUseCases::class,
            $result
        );
    }

    #[Test]
    public function testList(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->profiles->campaigns->list(
            '770e8400-e29b-41d4-a716-446655440002'
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

        $result = $this->client->profiles->campaigns->delete(
            'b2c3d4e5-f6a7-8901-bcde-f12345678901',
            profileID: '770e8400-e29b-41d4-a716-446655440002',
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

        $result = $this->client->profiles->campaigns->delete(
            'b2c3d4e5-f6a7-8901-bcde-f12345678901',
            profileID: '770e8400-e29b-41d4-a716-446655440002',
            body: ['sandbox' => false],
            xProfileID: '182bd5e5-6e1a-4fe4-a799-aa6d9a6ab26e',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertNull($result);
    }
}
