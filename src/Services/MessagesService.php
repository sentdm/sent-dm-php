<?php

declare(strict_types=1);

namespace SentDm\Services;

use SentDm\Client;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Util;
use SentDm\Messages\MessageGetActivitiesResponse;
use SentDm\Messages\MessageGetStatusResponse;
use SentDm\Messages\MessageSendParams\Template;
use SentDm\Messages\MessageSendResponse;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\MessagesContract;

/**
 * Send and track SMS and WhatsApp messages.
 *
 * @phpstan-import-type TemplateShape from \SentDm\Messages\MessageSendParams\Template
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
final class MessagesService implements MessagesContract
{
    /**
     * @api
     */
    public MessagesRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new MessagesRawService($client);
    }

    /**
     * @api
     *
     * Retrieves the activity log for a specific message. Activities track the message lifecycle including acceptance, processing, sending, delivery, and any errors.
     *
     * @param string $id Message ID from route parameter
     * @param string $xProfileID Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveActivities(
        string $id,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): MessageGetActivitiesResponse {
        $params = Util::removeNulls(['xProfileID' => $xProfileID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveActivities($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Retrieves the current status and details of a message by ID. Includes delivery status, timestamps, and error information if applicable.
     *
     * @param string $id Message ID
     * @param string $xProfileID Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveStatus(
        string $id,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): MessageGetStatusResponse {
        $params = Util::removeNulls(['xProfileID' => $xProfileID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveStatus($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Sends a message to one or more recipients using a template. Supports multi-channel broadcast — when multiple channels are specified (e.g. ["sms", "whatsapp"]), a separate message is created for each (recipient, channel) pair. Returns immediately with per-recipient message IDs for async tracking via webhooks or the GET /messages/{id} endpoint.
     *
     * @param list<string>|null $channel Body param: Channels to broadcast on, e.g. ["whatsapp", "sms"].
     * Each channel produces a separate message per recipient.
     * "sent" = auto-detect, "rcs" = reserved (skipped).
     * Defaults to ["sent"] (auto-detect) if omitted.
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param Template|TemplateShape $template Body param: Template reference (by id or name, with optional parameters)
     * @param list<string> $to Body param: List of recipient phone numbers in E.164 format (multi-recipient fan-out)
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function send(
        ?array $channel = null,
        ?bool $sandbox = null,
        Template|array|null $template = null,
        ?array $to = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): MessageSendResponse {
        $params = Util::removeNulls(
            [
                'channel' => $channel,
                'sandbox' => $sandbox,
                'template' => $template,
                'to' => $to,
                'idempotencyKey' => $idempotencyKey,
                'xProfileID' => $xProfileID,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->send(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
