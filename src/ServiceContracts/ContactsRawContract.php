<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts;

use SentDm\Contacts\ContactListItem;
use SentDm\Contacts\ContactListParams;
use SentDm\Contacts\ContactListResponse;
use SentDm\Contacts\ContactRetrieveByPhoneParams;
use SentDm\Contacts\ContactRetrieveIDParams;
use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface ContactsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|ContactListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ContactListResponse>
     *
     * @throws APIException
     */
    public function list(
        array|ContactListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|ContactRetrieveByPhoneParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ContactListItem>
     *
     * @throws APIException
     */
    public function retrieveByPhone(
        array|ContactRetrieveByPhoneParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|ContactRetrieveIDParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ContactListItem>
     *
     * @throws APIException
     */
    public function retrieveID(
        array|ContactRetrieveIDParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
