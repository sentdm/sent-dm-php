<?php

namespace Tests;

use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use SentDm\Core\Util;

/**
 * Every page class hydrates has_more and getNextPage() asks for the next page.
 *
 * @internal
 *
 * @coversNothing
 */
class PageNavigationTest extends TestCase
{
    public function testContactsPageAdvancesToTheNextPage(): void
    {
        $transporter = new Client;
        $transporter->addResponse($this->page(['contacts' => [['id' => 'contact_1']]], hasMore: true));
        $transporter->addResponse($this->page(['contacts' => [['id' => 'contact_2']]], hasMore: false));

        $page1 = $this->client($transporter)->contacts->list(page: 1, pageSize: 1);

        $this->assertTrue($page1->data?->pagination?->hasMore);
        $this->assertTrue($page1->hasNextPage());

        $page2 = $page1->getNextPage();

        $this->assertFalse($page2->data?->pagination?->hasMore);
        $this->assertFalse($page2->hasNextPage());

        $second = $transporter->getRequests()[1] ?? null;
        $this->assertNotNull($second);
        parse_str($second->getUri()->getQuery(), $query);
        $this->assertSame(['page' => '2', 'page_size' => '1'], $query, 'second request: '.$second->getUri());
        $this->assertStringNotContainsString('?', $second->getUri()->getPath());
    }

    public function testTemplatesPageHydratesHasMore(): void
    {
        foreach ([true, false] as $hasMore) {
            $page = $this->client($this->transporter(['templates' => [['id' => 'tpl_1']]], $hasMore))->templates->list();

            $this->assertSame($hasMore, $page->data?->pagination?->hasMore);
            $this->assertSame($hasMore, $page->hasNextPage());
        }
    }

    public function testWebhooksPageHydratesHasMore(): void
    {
        foreach ([true, false] as $hasMore) {
            $page = $this->client($this->transporter(['webhooks' => [['id' => 'wh_1']]], $hasMore))->webhooks->list();

            $this->assertSame($hasMore, $page->data?->pagination?->hasMore);
            $this->assertSame($hasMore, $page->hasNextPage());
        }
    }

    public function testWebhookEventsPageHydratesHasMore(): void
    {
        foreach ([true, false] as $hasMore) {
            $page = $this->client($this->transporter(['events' => [['id' => 'evt_1']]], $hasMore))->webhooks->listEvents('wh_123');

            $this->assertSame($hasMore, $page->data?->pagination?->hasMore);
            $this->assertSame($hasMore, $page->hasNextPage());
        }
    }

    public function testConversationsPageHydratesHasMore(): void
    {
        foreach ([true, false] as $hasMore) {
            $page = $this->client($this->transporter(['messages' => [['id' => 'msg_1']]], $hasMore))->conversations->list();

            $this->assertSame($hasMore, $page->data?->pagination?->hasMore);
            $this->assertSame($hasMore, $page->hasNextPage());
        }
    }

    public function testCallsPageHydratesHasMore(): void
    {
        foreach ([true, false] as $hasMore) {
            $page = $this->client($this->transporter(['calls' => [['id' => 'call_1']]], $hasMore))->voice->calls->list();

            $this->assertSame($hasMore, $page->data?->pagination?->hasMore);
            $this->assertSame($hasMore, $page->hasNextPage());
        }
    }

    public function testVoiceAgentsPageHydratesHasMore(): void
    {
        foreach ([true, false] as $hasMore) {
            $page = $this->client($this->transporter(['agents' => [['id' => 'agent_1']]], $hasMore))->voice->agents->list();

            $this->assertSame($hasMore, $page->data?->pagination?->hasMore);
            $this->assertSame($hasMore, $page->hasNextPage());
        }
    }

    /**
     * @param array<string, mixed> $data
     */
    private function transporter(array $data, bool $hasMore): Client
    {
        $transporter = new Client;
        $transporter->setDefaultResponse($this->page($data, $hasMore));

        return $transporter;
    }

    /**
     * @param array<string, mixed> $data
     */
    private function page(array $data, bool $hasMore): ResponseInterface
    {
        $data['pagination'] = ['page' => 1, 'page_size' => 1, 'total_count' => 2, 'total_pages' => 2, 'has_more' => $hasMore, 'cursors' => null];

        return Psr17FactoryDiscovery::findResponseFactory()
            ->createResponse()
            ->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->withBody(
                Psr17FactoryDiscovery::findStreamFactory()->createStream(
                    json_encode(['success' => true, 'data' => $data], flags: Util::JSON_ENCODE_FLAGS) ?: ''
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
}
