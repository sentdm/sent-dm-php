<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts\Voice;

use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\RequestOptions;
use SentDm\Voice\Catalogue\APIResponseOfVoiceCatalogue;
use SentDm\Voice\Catalogue\CatalogueListParams;

/**
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface CatalogueRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|CatalogueListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfVoiceCatalogue>
     *
     * @throws APIException
     */
    public function list(
        array|CatalogueListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
