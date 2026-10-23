<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts\Voice;

use SentDm\Core\Exceptions\APIException;
use SentDm\RequestOptions;
use SentDm\Voice\Tokens\APIResponseOfVoiceToken;

/**
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface TokensContract
{
    /**
     * @api
     *
     * @param string $identity Body param: Your identifier for the app user, such as an agent or account id. Letters, digits, hyphens and underscores only, up to 200 characters.
     * @param string|null $number Body param: One of your voice-enabled phone numbers in E.164 format. Calls placed by this identity are routed through that number. Omit to use your default app-call number.
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param int|null $ttl Body param: Token lifetime in seconds. Defaults to 600 and cannot exceed 3600.
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        ?string $identity = null,
        ?string $number = null,
        ?bool $sandbox = null,
        ?int $ttl = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfVoiceToken;
}
