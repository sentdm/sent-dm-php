<?php

namespace Tests\Services;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use SentDm\Client;
use SentDm\Templates\TemplateListResponse;
use SentDm\Templates\TemplateResponse;
use Tests\UnsupportedMockTests;

/**
 * @internal
 */
#[CoversNothing]
final class TemplatesTest extends TestCase
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
    public function testCreate(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->templates->create(
            definition: ['body' => []],
            xAPIKey: '',
            xSenderID: '00000000-0000-0000-0000-000000000000',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TemplateResponse::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->templates->create(
            definition: [
                'body' => [
                    'multiChannel' => [
                        'template' => 'Hello {{1:variable}}, thank you for joining our service. We\'re excited to help you with your messaging needs!',
                        'type' => null,
                        'variables' => [
                            [
                                'id' => 1,
                                'name' => 'customerName',
                                'props' => [
                                    'alt' => null,
                                    'mediaType' => null,
                                    'sample' => 'John Doe',
                                    'shortURL' => null,
                                    'url' => null,
                                    'variableType' => 'text',
                                ],
                                'type' => 'variable',
                            ],
                        ],
                    ],
                    'sms' => [
                        'template' => 'template',
                        'type' => 'type',
                        'variables' => [
                            [
                                'id' => 0,
                                'name' => 'name',
                                'props' => [
                                    'alt' => 'alt',
                                    'mediaType' => 'mediaType',
                                    'sample' => 'sample',
                                    'shortURL' => 'shortUrl',
                                    'url' => 'url',
                                    'variableType' => 'variableType',
                                ],
                                'type' => 'type',
                            ],
                        ],
                    ],
                    'whatsapp' => [
                        'template' => 'template',
                        'type' => 'type',
                        'variables' => [
                            [
                                'id' => 0,
                                'name' => 'name',
                                'props' => [
                                    'alt' => 'alt',
                                    'mediaType' => 'mediaType',
                                    'sample' => 'sample',
                                    'shortURL' => 'shortUrl',
                                    'url' => 'url',
                                    'variableType' => 'variableType',
                                ],
                                'type' => 'type',
                            ],
                        ],
                    ],
                ],
                'authenticationConfig' => [
                    'addSecurityRecommendation' => true, 'codeExpirationMinutes' => 0,
                ],
                'buttons' => [
                    [
                        'id' => 0,
                        'props' => [
                            'activeFor' => 0,
                            'autofillText' => 'autofillText',
                            'countryCode' => 'countryCode',
                            'offerCode' => 'offerCode',
                            'otpType' => 'otpType',
                            'packageName' => 'packageName',
                            'phoneNumber' => 'phoneNumber',
                            'quickReplyType' => 'quickReplyType',
                            'signatureHash' => 'signatureHash',
                            'text' => 'text',
                            'url' => 'url',
                            'urlType' => 'urlType',
                        ],
                        'type' => 'type',
                    ],
                ],
                'definitionVersion' => '1.0',
                'footer' => [
                    'template' => 'Best regards, The SentDM Team',
                    'type' => 'text',
                    'variables' => [
                        [
                            'id' => 0,
                            'name' => 'name',
                            'props' => [
                                'alt' => 'alt',
                                'mediaType' => 'mediaType',
                                'sample' => 'sample',
                                'shortURL' => 'shortUrl',
                                'url' => 'url',
                                'variableType' => 'variableType',
                            ],
                            'type' => 'type',
                        ],
                    ],
                ],
                'header' => [
                    'template' => 'Welcome to {{1:variable}}!',
                    'type' => 'text',
                    'variables' => [
                        [
                            'id' => 1,
                            'name' => 'companyName',
                            'props' => [
                                'alt' => null,
                                'mediaType' => null,
                                'sample' => 'SentDM',
                                'shortURL' => null,
                                'url' => null,
                                'variableType' => 'text',
                            ],
                            'type' => 'variable',
                        ],
                    ],
                ],
            ],
            xAPIKey: '',
            xSenderID: '00000000-0000-0000-0000-000000000000',
            category: 'MARKETING',
            language: 'en_US',
            submitForReview: false,
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TemplateResponse::class, $result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->templates->retrieve(
            '7ba7b820-9dad-11d1-80b4-00c04fd430c8',
            xAPIKey: '',
            xSenderID: '00000000-0000-0000-0000-000000000000',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TemplateResponse::class, $result);
    }

    #[Test]
    public function testRetrieveWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->templates->retrieve(
            '7ba7b820-9dad-11d1-80b4-00c04fd430c8',
            xAPIKey: '',
            xSenderID: '00000000-0000-0000-0000-000000000000',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TemplateResponse::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->templates->list(
            page: 0,
            pageSize: 0,
            xAPIKey: '',
            xSenderID: '00000000-0000-0000-0000-000000000000',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TemplateListResponse::class, $result);
    }

    #[Test]
    public function testListWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->templates->list(
            page: 0,
            pageSize: 0,
            xAPIKey: '',
            xSenderID: '00000000-0000-0000-0000-000000000000',
            category: 'category',
            search: 'search',
            status: 'status',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TemplateListResponse::class, $result);
    }

    #[Test]
    public function testDelete(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->templates->delete(
            '7ba7b820-9dad-11d1-80b4-00c04fd430c8',
            xAPIKey: '',
            xSenderID: '00000000-0000-0000-0000-000000000000',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertNull($result);
    }

    #[Test]
    public function testDeleteWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->templates->delete(
            '7ba7b820-9dad-11d1-80b4-00c04fd430c8',
            xAPIKey: '',
            xSenderID: '00000000-0000-0000-0000-000000000000',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertNull($result);
    }
}
