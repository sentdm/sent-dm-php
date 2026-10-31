<?php

namespace Tests;

use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client;
use PHPUnit\Framework\TestCase;
use SentDm\Core\Util;

/**
 * @internal
 *
 * @coversNothing
 */
class ClientTest extends TestCase
{
    public function testDefaultHeaders(): void
    {
        $transporter = new Client;
        $mockRsp = Psr17FactoryDiscovery::findResponseFactory()
            ->createResponse()
            ->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(json_encode([], flags: Util::JSON_ENCODE_FLAGS) ?: ''))
        ;

        $transporter->setDefaultResponse($mockRsp);

        $client = new \SentDm\Client(
            baseUrl: 'http://localhost',
            apiKey: 'My API Key',
            requestOptions: ['transporter' => $transporter],
        );

        $client->messages->send();

        $this->assertNotFalse($requested = $transporter->getRequests()[0] ?? false);

        foreach (['accept', 'content-type'] as $header) {
            $sent = $requested->getHeaderLine($header);
            $this->assertNotEmpty($sent);
        }
    }

    public function testBodylessDeleteOmitsContentType(): void
    {
        $transporter = new Client;
        $transporter->setDefaultResponse(
            Psr17FactoryDiscovery::findResponseFactory()->createResponse()->withStatus(204)
        );

        $client = new \SentDm\Client(
            baseUrl: 'http://localhost',
            apiKey: 'My API Key',
            requestOptions: ['transporter' => $transporter],
        );

        $client->webhooks->delete('d4f5a6b7-c8d9-4e0f-a1b2-c3d4e5f6a7b8');

        $this->assertNotFalse($requested = $transporter->getRequests()[0] ?? false);
        $this->assertSame('DELETE', $requested->getMethod());
        $this->assertSame('', $requested->getHeaderLine('content-type'));
        $this->assertSame('', (string) $requested->getBody());
    }

    public function testBodylessGetKeepsDefaultContentType(): void
    {
        $transporter = new Client;
        $mockRsp = Psr17FactoryDiscovery::findResponseFactory()
            ->createResponse()
            ->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(json_encode([], flags: Util::JSON_ENCODE_FLAGS) ?: ''))
        ;
        $transporter->setDefaultResponse($mockRsp);

        $client = new \SentDm\Client(
            baseUrl: 'http://localhost',
            apiKey: 'My API Key',
            requestOptions: ['transporter' => $transporter],
        );

        $client->messages->retrieveStatus('msg_123');

        $this->assertNotFalse($requested = $transporter->getRequests()[0] ?? false);
        $this->assertSame('GET', $requested->getMethod());
        $this->assertSame('application/json', $requested->getHeaderLine('content-type'));
    }

    public function testDeleteWithExplicitBodyKeepsContentType(): void
    {
        $transporter = new Client;
        $transporter->setDefaultResponse(
            Psr17FactoryDiscovery::findResponseFactory()->createResponse()->withStatus(204)
        );

        $client = new \SentDm\Client(
            baseUrl: 'http://localhost',
            apiKey: 'My API Key',
            requestOptions: ['transporter' => $transporter],
        );

        $client->profiles->delete('770e8400-e29b-41d4-a716-446655440002');

        $this->assertNotFalse($requested = $transporter->getRequests()[0] ?? false);
        $this->assertSame('DELETE', $requested->getMethod());
        $this->assertSame('application/json', $requested->getHeaderLine('content-type'));
        $this->assertSame('{}', (string) $requested->getBody());
    }
}
