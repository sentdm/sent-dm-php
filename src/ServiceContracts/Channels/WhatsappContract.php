<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts\Channels;

use SentDm\Channels\Whatsapp\APIResponseOfWhatsappChannel;
use SentDm\Core\Exceptions\APIException;
use SentDm\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface WhatsappContract
{
    /**
     * @api
     *
     * @param string|null $phoneNumberID Body param: The Meta phone-number id of the number on WabaId, which assigns it to this profile as the
     * number it sends from. It is not checked against the account here, so name the account's number; it is
     * refused if another profile already uses it.
     *
     * Optional: omit it to connect the account and settle the number later. Nothing picks one on your
     * behalf.
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string $wabaID Body param: WhatsApp Business Account id — one of the accounts shared into your organization. Required: the
     * organization holds one per client, and nothing but the caller says which is meant here.
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        ?string $phoneNumberID = null,
        ?bool $sandbox = null,
        ?string $wabaID = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfWhatsappChannel;
}
