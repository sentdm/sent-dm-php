<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts;

use SentDm\Contacts\APIResponseContact;
use SentDm\Contacts\ContactCreateParams;
use SentDm\Contacts\ContactDeleteParams;
use SentDm\Contacts\ContactListParams;
use SentDm\Contacts\ContactListResponse;
use SentDm\Contacts\ContactUpdateParams;
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
     * @param array<string,mixed>|ContactCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseContact>
     *
     * @throws APIException
     */
    public function create(
        array|ContactCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id Contact ID from route parameter
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseContact>
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id Path param: Contact ID from route parameter
     * @param array<string,mixed>|ContactUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseContact>
     *
     * @throws APIException
     */
    public function update(
        string $id,
        array|ContactUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

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
     * @param string $id Contact ID from route parameter
     * @param array<string,mixed>|ContactDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function delete(
        string $id,
        array|ContactDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
