<?php

namespace Tests\Services\Channels\SMS;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use SentDm\Channels\Markets\APIResponseOfChannelMarket;
use SentDm\Channels\SMS\TenDlc\TenDlcListCampaignsResponse;
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

        $result = $this->client->channels->sms->tenDlc->addCampaign(
            description: 'Appointment reminders for patients who opted in when booking.',
            helpKeywords: 'help_keywords',
            helpMessage: 'xxxxxxxxxxxxxxxxxxxx',
            messageFlow: 'Patients opt in on the booking form by checking a consent box.',
            optInKeywords: 'opt_in_keywords',
            optInMessage: 'xxxxxxxxxxxxxxxxxxxx',
            optOutKeywords: 'opt_out_keywords',
            optOutMessage: 'xxxxxxxxxxxxxxxxxxxx',
            privacyPolicyLink: 'privacy_policy_link',
            termsAndConditionsLink: 'terms_and_conditions_link',
            useCases: [
                [
                    'sampleMessages' => [
                        'Reminder: your appointment is tomorrow at 10:00. Reply STOP to opt out.',
                    ],
                    'useCase' => 'ACCOUNT_NOTIFICATION',
                ],
            ],
            volume: 'volume',
            idempotencyKey: 'req_abc123_retry1',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(APIResponseOfChannelMarket::class, $result);
    }

    #[Test]
    public function testAddCampaignWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->channels->sms->tenDlc->addCampaign(
            description: 'Appointment reminders for patients who opted in when booking.',
            helpKeywords: 'help_keywords',
            helpMessage: 'xxxxxxxxxxxxxxxxxxxx',
            messageFlow: 'Patients opt in on the booking form by checking a consent box.',
            optInKeywords: 'opt_in_keywords',
            optInMessage: 'xxxxxxxxxxxxxxxxxxxx',
            optOutKeywords: 'opt_out_keywords',
            optOutMessage: 'xxxxxxxxxxxxxxxxxxxx',
            privacyPolicyLink: 'privacy_policy_link',
            termsAndConditionsLink: 'terms_and_conditions_link',
            useCases: [
                [
                    'sampleMessages' => [
                        'Reminder: your appointment is tomorrow at 10:00. Reply STOP to opt out.',
                    ],
                    'useCase' => 'ACCOUNT_NOTIFICATION',
                ],
            ],
            volume: 'volume',
            idempotencyKey: 'req_abc123_retry1',
            sandbox: false,
            xProfileID: '182bd5e5-6e1a-4fe4-a799-aa6d9a6ab26e',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(APIResponseOfChannelMarket::class, $result);
    }

    #[Test]
    public function testListCampaigns(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->channels->sms->tenDlc->listCampaigns();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TenDlcListCampaignsResponse::class, $result);
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
        $this->assertInstanceOf(APIResponseOfChannelMarket::class, $result);
    }
}
