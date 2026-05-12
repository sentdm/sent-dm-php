<?php

declare(strict_types=1);

namespace SentDm;

use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use SentDm\Core\BaseClient;
use SentDm\Core\Implementation\StreamingHttpClient;
use SentDm\Core\Util;
use SentDm\Services\ContactsService;
use SentDm\Services\MeService;
use SentDm\Services\MessagesService;
use SentDm\Services\NumbersService;
use SentDm\Services\ProfilesService;
use SentDm\Services\TemplatesService;
use SentDm\Services\UsersService;
use SentDm\Services\WebhooksService;

/**
 * @phpstan-import-type NormalizedRequest from \SentDm\Core\BaseClient
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
class Client extends BaseClient
{
    public string $apiKey;

    /**
     * @api
     */
    public WebhooksService $webhooks;

    /**
     * @api
     */
    public UsersService $users;

    /**
     * @api
     */
    public TemplatesService $templates;

    /**
     * @api
     */
    public ProfilesService $profiles;

    /**
     * @api
     */
    public NumbersService $numbers;

    /**
     * @api
     */
    public MessagesService $messages;

    /**
     * @api
     */
    public ContactsService $contacts;

    /**
     * @api
     */
    public MeService $me;

    /**
     * @param RequestOpts|null $requestOptions
     */
    public function __construct(
        ?string $apiKey = null,
        ?string $baseUrl = null,
        RequestOptions|array|null $requestOptions = null,
    ) {
        $this->apiKey = (string) ($apiKey ?? Util::getenv('SENT_DM_API_KEY'));

        $baseUrl ??= Util::getenv('SENT_BASE_URL') ?: 'https://api.sent.dm';

        $options = RequestOptions::parse(
            RequestOptions::with(
                uriFactory: Psr17FactoryDiscovery::findUriFactory(),
                streamFactory: Psr17FactoryDiscovery::findStreamFactory(),
                requestFactory: Psr17FactoryDiscovery::findRequestFactory(),
                transporter: Psr18ClientDiscovery::find(),
            ),
            $requestOptions,
        );

        if (is_null($options->streamingTransporter)) {
            assert(!is_null($options->transporter));
            $options->streamingTransporter = new StreamingHttpClient($options->transporter);
        }

        /** @var array<string, string|null> $headers */
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'User-Agent' => sprintf('Sent/PHP %s', VERSION),
            'X-Stainless-Lang' => 'php',
            'X-Stainless-Package-Version' => '0.20.2',
            'X-Stainless-Arch' => Util::machtype(),
            'X-Stainless-OS' => Util::ostype(),
            'X-Stainless-Runtime' => php_sapi_name(),
            'X-Stainless-Runtime-Version' => phpversion(),
        ];

        $customHeadersEnv = Util::getenv('SENT_CUSTOM_HEADERS');
        if (null !== $customHeadersEnv) {
            foreach (explode("\n", $customHeadersEnv) as $line) {
                $colon = strpos($line, ':');
                if (false !== $colon) {
                    $headers[trim(substr($line, 0, $colon))] = trim(substr($line, $colon + 1));
                }
            }
        }

        parent::__construct(
            headers: $headers,
            baseUrl: $baseUrl,
            options: $options
        );

        $this->webhooks = new WebhooksService($this);
        $this->users = new UsersService($this);
        $this->templates = new TemplatesService($this);
        $this->profiles = new ProfilesService($this);
        $this->numbers = new NumbersService($this);
        $this->messages = new MessagesService($this);
        $this->contacts = new ContactsService($this);
        $this->me = new MeService($this);
    }

    /** @return array<string,string> */
    protected function authHeaders(): array
    {
        return $this->apiKey ? ['x-api-key' => $this->apiKey] : [];
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
