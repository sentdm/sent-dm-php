<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts\Voice;

use SentDm\Core\Exceptions\APIException;
use SentDm\RequestOptions;
use SentDm\Voice\Catalogue\APIResponseOfVoiceCatalogue;

/**
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface CatalogueContract
{
    /**
     * @api
     *
     * @param string $xProfileID Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfVoiceCatalogue;
}
