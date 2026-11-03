<?php

namespace Tests;

use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use SentDm\Core\Util;

/**
 * @internal
 *
 * @coversNothing
 */
class ProfileCompleteTest extends TestCase
{
    public function testCompleteReturnsNullOnA204InsteadOfThrowing(): void
    {
        $transporter = new Client;
        $transporter->setDefaultResponse(
            $this->responseFactory()->createResponse(204)
        );

        $client = new \SentDm\Client(
            baseUrl: 'http://localhost',
            apiKey: 'My API Key',
            requestOptions: ['transporter' => $transporter],
        );

        $result = $client->profiles->complete(
            '660e8400-e29b-41d4-a716-446655440000',
            webHookURL: 'https://your-app.com/webhook/profile-complete',
        );

        $this->assertNull($result);
    }

    public function testCompleteStillForwardsXProfileIdOnA204(): void
    {
        $transporter = new Client;
        $transporter->setDefaultResponse(
            $this->responseFactory()->createResponse(204)
        );

        $client = new \SentDm\Client(
            baseUrl: 'http://localhost',
            apiKey: 'My API Key',
            requestOptions: ['transporter' => $transporter],
        );

        $result = $client->profiles->complete(
            '660e8400-e29b-41d4-a716-446655440000',
            webHookURL: 'https://your-app.com/webhook/profile-complete',
            xProfileID: '182bd5e5-6e1a-4fe4-a799-aa6d9a6ab26e',
        );

        $this->assertNull($result);

        $requested = $transporter->getRequests()[0] ?? null;
        $this->assertNotNull($requested);
        $this->assertSame(
            '182bd5e5-6e1a-4fe4-a799-aa6d9a6ab26e',
            $requested->getHeaderLine('x-profile-id')
        );
    }

    public function testCompleteParsesTheAlreadyOnboarded200Response(): void
    {
        $transporter = new Client;
        $transporter->setDefaultResponse($this->jsonResponse(200, [
            'success' => true,
            'data' => ['status' => 'approved', 'message' => 'Profile is already completed'],
            'error' => null,
        ]));

        $client = new \SentDm\Client(
            baseUrl: 'http://localhost',
            apiKey: 'My API Key',
            requestOptions: ['transporter' => $transporter],
        );

        $result = $client->profiles->complete(
            '660e8400-e29b-41d4-a716-446655440000',
            webHookURL: 'https://your-app.com/webhook/profile-complete',
        );

        $this->assertNotNull($result);
        $this->assertNotNull($result->data);
        $this->assertSame('approved', $result->data->status);
        $this->assertSame('Profile is already completed', $result->data->message);
    }

    public function testCompleteParsesTheInProgress202Response(): void
    {
        $transporter = new Client;
        $transporter->setDefaultResponse($this->jsonResponse(202, [
            'success' => true,
            'data' => ['message' => 'Profile completion in progress'],
            'error' => null,
        ]));

        $client = new \SentDm\Client(
            baseUrl: 'http://localhost',
            apiKey: 'My API Key',
            requestOptions: ['transporter' => $transporter],
        );

        $result = $client->profiles->complete(
            '660e8400-e29b-41d4-a716-446655440000',
            webHookURL: 'https://your-app.com/webhook/profile-complete',
        );

        $this->assertNotNull($result);
        $this->assertSame('Profile completion in progress', $result->data?->message);
    }

    private function responseFactory(): ResponseFactoryInterface
    {
        return Psr17FactoryDiscovery::findResponseFactory();
    }

    /**
     * @param array<string, mixed> $body
     */
    private function jsonResponse(int $status, array $body): ResponseInterface
    {
        return $this->responseFactory()
            ->createResponse($status)
            ->withHeader('Content-Type', 'application/json')
            ->withBody(
                Psr17FactoryDiscovery::findStreamFactory()->createStream(
                    json_encode($body, flags: Util::JSON_ENCODE_FLAGS) ?: ''
                )
            )
        ;
    }
}
