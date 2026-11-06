<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts;

use SentDm\Compliance\APIResponseOfComplianceRequirements;
use SentDm\Core\Exceptions\APIException;
use SentDm\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface ComplianceContract
{
    /**
     * @api
     *
     * @param string|null $channel Query param: Channel the sender is for: sms, whatsapp or rcs. Defaults to sms, which is the only one answered today — the other two are 501 until their requirements are declared.
     * @param string|null $country Query param: ISO 3166-1 alpha-2 country code, e.g. US, XK, IN
     * @param string|null $type Query param: Sender type: LOCAL, MOBILE, TEN_DLC, TOLL_FREE, SHORT_CODE, ALPHANUMERIC. 10DLC is accepted as a synonym of TEN_DLC, the same as on POST /v3/sender-profiles. Applies to channel=sms, the only channel whose senders have a type.
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveRequirements(
        ?string $channel = null,
        ?string $country = null,
        ?string $type = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfComplianceRequirements;
}
