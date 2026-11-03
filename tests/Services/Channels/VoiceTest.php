<?php

namespace Tests\Services\Channels;

use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client as MockTransporter;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use SentDm\Channels\Voice\APIResponseOfListOfVoiceNumber;
use SentDm\Channels\Voice\APIResponseOfVoiceCallbackTest;
use SentDm\Channels\Voice\APIResponseOfVoiceNumber;
use SentDm\Channels\Voice\APIResponseOfVoiceNumberCreated;
use SentDm\Channels\Voice\APIResponseOfVoiceSecret;
use SentDm\Client;
use SentDm\Core\Util;
use Tests\UnsupportedMockTests;

/**
 * @internal
 */
#[CoversNothing]
final class VoiceTest extends TestCase
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

        $result = $this->client->channels->voice->create();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(APIResponseOfVoiceNumberCreated::class, $result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->channels->voice->retrieve('+12125550100');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(APIResponseOfVoiceNumber::class, $result);
    }

    #[Test]
    public function testUpdate(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->channels->voice->update('number');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(APIResponseOfVoiceNumber::class, $result);
    }

    #[Test]
    public function testUpdateSendsExplicitNullToUnbindAgent(): void
    {
        $transporter = new MockTransporter;
        $transporter->setDefaultResponse(
            Psr17FactoryDiscovery::findResponseFactory()
                ->createResponse()
                ->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(
                    json_encode(['data' => []], flags: Util::JSON_ENCODE_FLAGS) ?: ''
                ))
        );

        $client = new Client(
            baseUrl: 'http://localhost',
            apiKey: 'My API Key',
            requestOptions: ['transporter' => $transporter],
        );

        $client->channels->voice->update('+12125550100', agentID: null);

        $this->assertNotFalse($requested = $transporter->getRequests()[0] ?? false);
        /** @var array<string, mixed> $sent */
        $sent = json_decode((string) $requested->getBody(), true);
        $this->assertArrayHasKey('agent_id', $sent);
        $this->assertNull($sent['agent_id']);
    }

    #[Test]
    public function testUpdateOmitsAgentIdWhenNotPassed(): void
    {
        $transporter = new MockTransporter;
        $transporter->setDefaultResponse(
            Psr17FactoryDiscovery::findResponseFactory()
                ->createResponse()
                ->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(
                    json_encode(['data' => []], flags: Util::JSON_ENCODE_FLAGS) ?: ''
                ))
        );

        $client = new Client(
            baseUrl: 'http://localhost',
            apiKey: 'My API Key',
            requestOptions: ['transporter' => $transporter],
        );

        $client->channels->voice->update('+12125550100', status: 'ACTIVE');

        $this->assertNotFalse($requested = $transporter->getRequests()[0] ?? false);
        /** @var array<string, mixed> $sent */
        $sent = json_decode((string) $requested->getBody(), true);
        $this->assertArrayNotHasKey('agent_id', $sent);
    }

    #[Test]
    public function testList(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->channels->voice->list();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(APIResponseOfListOfVoiceNumber::class, $result);
    }

    #[Test]
    public function testRotateSecret(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->channels->voice->rotateSecret('+12125550100');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(APIResponseOfVoiceSecret::class, $result);
    }

    #[Test]
    public function testTest(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->channels->voice->test('+12025550123');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(APIResponseOfVoiceCallbackTest::class, $result);
    }
}
