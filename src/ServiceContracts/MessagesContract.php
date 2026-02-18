<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts;

use SentDm\Core\Exceptions\APIException;
use SentDm\Messages\MessageGetActivitiesResponse;
use SentDm\Messages\MessageGetStatusResponse;
use SentDm\Messages\MessageSendParams\Template;
use SentDm\Messages\MessageSendResponse;
use SentDm\RequestOptions;

/**
 * @phpstan-import-type TemplateShape from \SentDm\Messages\MessageSendParams\Template
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface MessagesContract
{
    /**
     * @api
     *
     * @param string $id Message ID from route parameter
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveActivities(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): MessageGetActivitiesResponse;

    /**
     * @api
     *
     * @param string $id Message ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveStatus(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): MessageGetStatusResponse;

    /**
     * @api
     *
     * @param list<string>|null $channel Body param: Channels to broadcast on, e.g. ["whatsapp", "sms"].
     * Each channel produces a separate message per recipient.
     * "sent" = auto-detect, "rcs" = reserved (skipped).
     * Defaults to ["sent"] (auto-detect) if omitted.
     * @param Template|TemplateShape $template Body param: Template reference (by id or name, with optional parameters)
     * @param bool $testMode Body param: Test mode flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param list<string> $to Body param: List of recipient phone numbers in E.164 format (multi-recipient fan-out)
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function send(
        ?array $channel = null,
        Template|array|null $template = null,
        ?bool $testMode = null,
        ?array $to = null,
        ?string $idempotencyKey = null,
        RequestOptions|array|null $requestOptions = null,
    ): MessageSendResponse;
}
