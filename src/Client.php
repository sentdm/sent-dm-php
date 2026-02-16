<?php

declare(strict_types=1);

namespace SentDm;

use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use SentDm\Core\BaseClient;
use SentDm\Core\Util;
use SentDm\Services\ContactsService;
use SentDm\Services\MessagesService;
use SentDm\Services\NumberLookupService;
use SentDm\Services\TemplatesService;

/**
 * @phpstan-import-type NormalizedRequest from \SentDm\Core\BaseClient
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
class Client extends BaseClient
{
    public string $apiKey;

    public string $senderID;

    /**
     * @api
     */
    public ContactsService $contacts;

    /**
     * @api
     */
    public MessagesService $messages;

    /**
     * @api
     */
    public TemplatesService $templates;

    /**
     * @api
     */
    public NumberLookupService $numberLookup;

    /**
     * @param RequestOpts|null $requestOptions
     */
    public function __construct(
        ?string $apiKey = null,
        ?string $senderID = null,
        ?string $baseUrl = null,
        RequestOptions|array|null $requestOptions = null,
    ) {
        $this->apiKey = (string) ($apiKey ?? Util::getenv('SENT_DM_API_KEY'));
        $this->senderID = (string) ($senderID ?? Util::getenv('SENT_DM_SENDER_ID'));

        $baseUrl ??= Util::getenv('SENT_DM_BASE_URL') ?: 'https://api.sent.dm';

        $options = RequestOptions::parse(
            RequestOptions::with(
                uriFactory: Psr17FactoryDiscovery::findUriFactory(),
                streamFactory: Psr17FactoryDiscovery::findStreamFactory(),
                requestFactory: Psr17FactoryDiscovery::findRequestFactory(),
                transporter: Psr18ClientDiscovery::find(),
            ),
            $requestOptions,
        );

        parent::__construct(
            headers: [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'User-Agent' => sprintf('sent-dm/PHP %s', VERSION),
                'X-Stainless-Lang' => 'php',
                'X-Stainless-Package-Version' => '0.4.0',
                'X-Stainless-Arch' => Util::machtype(),
                'X-Stainless-OS' => Util::ostype(),
                'X-Stainless-Runtime' => php_sapi_name(),
                'X-Stainless-Runtime-Version' => phpversion(),
            ],
            baseUrl: $baseUrl,
            options: $options
        );

        $this->contacts = new ContactsService($this);
        $this->messages = new MessagesService($this);
        $this->templates = new TemplatesService($this);
        $this->numberLookup = new NumberLookupService($this);
    }

    /** @return array<string,string> */
    protected function authHeaders(): array
    {
        return [...$this->customerAPIKey(), ...$this->customerSenderID()];
    }

    /** @return array<string,string> */
    protected function customerAPIKey(): array
    {
        return $this->apiKey ? ['x-api-key' => $this->apiKey] : [];
    }

    /** @return array<string,string> */
    protected function customerSenderID(): array
    {
        return $this->senderID ? ['x-sender-id' => $this->senderID] : [];
    }

    /**
     * @internal
     *
     * @param string|list<string> $path
     * @param array<string,mixed> $query
     * @param array<string,string|int|list<string|int>|null> $headers
     * @param RequestOpts|null $opts
     *
     * @return array{NormalizedRequest, RequestOptions}
     */
    protected function buildRequest(
        string $method,
        string|array $path,
        array $query,
        array $headers,
        mixed $body,
        RequestOptions|array|null $opts,
    ): array {
        return parent::buildRequest(
            method: $method,
            path: $path,
            query: $query,
            headers: [...$this->authHeaders(), ...$headers],
            body: $body,
            opts: $opts,
        );
    }
}
