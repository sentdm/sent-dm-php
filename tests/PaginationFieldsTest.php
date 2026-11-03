<?php

namespace Tests;

use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use SentDm\Core\Util;
use SentDm\Webhooks\PaginationMeta;

/**
 * @internal
 *
 * @coversNothing
 */
class PaginationFieldsTest extends TestCase
{
    public function testContactsPageHydratesAndAdvances(): void
    {
        $transporter = new Client;
        $transporter->addResponse($this->jsonResponse([
            'success' => true,
            'data' => [
                'contacts' => [['id' => 'contact_1']],
                'pagination' => ['page' => 1, 'page_size' => 1, 'total_count' => 2, 'total_pages' => 2, 'has_more' => true, 'cursors' => null],
            ],
        ]));
        $transporter->addResponse($this->jsonResponse([
            'success' => true,
            'data' => [
                'contacts' => [['id' => 'contact_2']],
                'pagination' => ['page' => 2, 'page_size' => 1, 'total_count' => 2, 'total_pages' => 2, 'has_more' => false, 'cursors' => null],
            ],
        ]));

        $client = $this->client($transporter);
        $page1 = $client->contacts->list(page: 1, pageSize: 1);

        $this->assertPaginationHydrates(['page' => 1, 'page_size' => 1, 'total_count' => 2, 'total_pages' => 2, 'has_more' => true], $page1->data?->pagination);
        $this->assertTrue($page1->hasNextPage());

        $page2 = $page1->getNextPage();

        $this->assertPaginationHydrates(['page' => 2, 'page_size' => 1, 'total_count' => 2, 'total_pages' => 2, 'has_more' => false], $page2->data?->pagination);
        $this->assertFalse($page2->hasNextPage());

        $requested = $transporter->getRequests()[1] ?? null;
        $this->assertNotNull($requested);
        parse_str($requested->getUri()->getQuery(), $query);
        $this->assertSame('2', $query['page'] ?? null);
    }

    public function testTemplatesPageHydratesAndStopsWhenHasMoreIsFalse(): void
    {
        $transporter = new Client;
        $transporter->setDefaultResponse($this->jsonResponse([
            'success' => true,
            'data' => [
                'templates' => [],
                'pagination' => ['page' => 3, 'page_size' => 10, 'total_count' => 30, 'total_pages' => 3, 'has_more' => false, 'cursors' => null],
            ],
        ]));

        $page = $this->client($transporter)->templates->list();

        $this->assertPaginationHydrates(['page' => 3, 'page_size' => 10, 'total_count' => 30, 'total_pages' => 3, 'has_more' => false], $page->data?->pagination);
        $this->assertFalse($page->hasNextPage());
    }

    public function testWebhooksPageHydratesFullPagination(): void
    {
        $transporter = new Client;
        $transporter->setDefaultResponse($this->jsonResponse([
            'success' => true,
            'data' => [
                'webhooks' => [],
                'pagination' => ['page' => 1, 'page_size' => 25, 'total_count' => 1, 'total_pages' => 1, 'has_more' => false, 'cursors' => null],
            ],
        ]));

        $page = $this->client($transporter)->webhooks->list();

        $this->assertPaginationHydrates(['page' => 1, 'page_size' => 25, 'total_count' => 1, 'total_pages' => 1, 'has_more' => false], $page->data?->pagination);
    }

    public function testWebhookEventsPageHydratesFullPagination(): void
    {
        $transporter = new Client;
        $transporter->setDefaultResponse($this->jsonResponse([
            'success' => true,
            'data' => [
                'events' => [],
                'pagination' => ['page' => 1, 'page_size' => 25, 'total_count' => 7, 'total_pages' => 1, 'has_more' => false, 'cursors' => null],
            ],
        ]));

        $page = $this->client($transporter)->webhooks->listEvents('wh_123');

        $this->assertPaginationHydrates(['page' => 1, 'page_size' => 25, 'total_count' => 7, 'total_pages' => 1, 'has_more' => false], $page->data?->pagination);
    }

    public function testConversationsPageHydratesFullPagination(): void
    {
        $transporter = new Client;
        $transporter->setDefaultResponse($this->jsonResponse([
            'success' => true,
            'data' => [
                'messages' => [['id' => 'msg_1']],
                'pagination' => ['page' => 2, 'page_size' => 20, 'total_count' => 41, 'total_pages' => 3, 'has_more' => true, 'cursors' => null],
            ],
        ]));

        $page = $this->client($transporter)->conversations->list();

        $this->assertPaginationHydrates(['page' => 2, 'page_size' => 20, 'total_count' => 41, 'total_pages' => 3, 'has_more' => true], $page->data?->pagination);
        $this->assertTrue($page->hasNextPage());
    }

    public function testCallsPageHydratesFullPagination(): void
    {
        $transporter = new Client;
        $transporter->setDefaultResponse($this->jsonResponse([
            'success' => true,
            'data' => [
                'calls' => [],
                'pagination' => ['page' => 1, 'page_size' => 25, 'total_count' => 0, 'total_pages' => 0, 'has_more' => false, 'cursors' => null],
            ],
        ]));

        $page = $this->client($transporter)->voice->calls->list();

        $this->assertPaginationHydrates(['page' => 1, 'page_size' => 25, 'total_count' => 0, 'total_pages' => 0, 'has_more' => false], $page->data?->pagination);
    }

    public function testVoiceAgentsPageHydratesFullPagination(): void
    {
        $transporter = new Client;
        $transporter->setDefaultResponse($this->jsonResponse([
            'success' => true,
            'data' => [
                'agents' => [],
                'pagination' => ['page' => 1, 'page_size' => 25, 'total_count' => 4, 'total_pages' => 1, 'has_more' => false, 'cursors' => null],
            ],
        ]));

        $page = $this->client($transporter)->voice->agents->list();

        $this->assertPaginationHydrates(['page' => 1, 'page_size' => 25, 'total_count' => 4, 'total_pages' => 1, 'has_more' => false], $page->data?->pagination);
    }

    /**
     * @param array<string, mixed> $body
     */
    private function jsonResponse(array $body): ResponseInterface
    {
        return Psr17FactoryDiscovery::findResponseFactory()
            ->createResponse()
            ->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->withBody(
                Psr17FactoryDiscovery::findStreamFactory()->createStream(
                    json_encode($body, flags: Util::JSON_ENCODE_FLAGS) ?: ''
                )
            )
        ;
    }

    private function client(Client $transporter): \SentDm\Client
    {
        return new \SentDm\Client(
            baseUrl: 'http://localhost',
            apiKey: 'My API Key',
            requestOptions: ['transporter' => $transporter],
        );
    }

    /**
     * @param array<string, mixed> $pagination
     */
    private function assertPaginationHydrates(array $pagination, ?PaginationMeta $meta): void
    {
        $this->assertNotNull($meta);
        $this->assertSame($pagination['page'], $meta->page);
        $this->assertSame($pagination['page_size'], $meta->pageSize);
        $this->assertSame($pagination['total_count'], $meta->totalCount);
        $this->assertSame($pagination['total_pages'], $meta->totalPages);
        $this->assertSame($pagination['has_more'], $meta->hasMore);
    }
}
