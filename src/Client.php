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
use SentDm\Services\OrganizationsService;
use SentDm\Services\TemplatesService;

/**
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
class Client extends BaseClient
{
    public string $apiKey;

    public string $senderID;

    /**
     * @api
     */
    public TemplatesService $templates;

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
    public NumberLookupService $numberLookup;

    /**
     * @api
     */
    public OrganizationsService $organizations;

    /**
     * @param RequestOpts|null $requestOptions
     */
    public function __construct(
        ?string $apiKey = null,
        ?string $senderID = null,
        ?string $baseUrl = null,
        RequestOptions|array|null $requestOptions = null,
    ) {
        $this->apiKey = (string) ($apiKey ?? getenv('SENT_DM_API_KEY'));
        $this->senderID = (string) ($senderID ?? getenv('SENT_DM_SENDER_ID'));

        $baseUrl ??= getenv('SENT_DM_BASE_URL') ?: 'https://api.sent.dm';

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
                'X-Stainless-Package-Version' => '0.0.1',
                'X-Stainless-Arch' => Util::machtype(),
                'X-Stainless-OS' => Util::ostype(),
                'X-Stainless-Runtime' => php_sapi_name(),
                'X-Stainless-Runtime-Version' => phpversion(),
            ],
            baseUrl: $baseUrl,
            options: $options
        );

        $this->templates = new TemplatesService($this);
        $this->contacts = new ContactsService($this);
        $this->messages = new MessagesService($this);
        $this->numberLookup = new NumberLookupService($this);
        $this->organizations = new OrganizationsService($this);
    }
}
