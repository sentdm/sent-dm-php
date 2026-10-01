<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts\Channels;

use SentDm\Channels\Voice\APIResponseOfListOfVoiceNumber;
use SentDm\Channels\Voice\APIResponseOfVoiceCallbackTest;
use SentDm\Channels\Voice\APIResponseOfVoiceNumber;
use SentDm\Channels\Voice\APIResponseOfVoiceNumberCreated;
use SentDm\Channels\Voice\APIResponseOfVoiceSecret;
use SentDm\Channels\Voice\APIResponseOfVoiceToken;
use SentDm\Channels\Voice\VoiceCreateParams;
use SentDm\Channels\Voice\VoiceCreateTokenParams;
use SentDm\Channels\Voice\VoiceListParams;
use SentDm\Channels\Voice\VoiceRetrieveParams;
use SentDm\Channels\Voice\VoiceRotateSecretParams;
use SentDm\Channels\Voice\VoiceTestParams;
use SentDm\Channels\Voice\VoiceUpdateParams;
use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface VoiceRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|VoiceCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfVoiceNumberCreated>
     *
     * @throws APIException
     */
    public function create(
        array|VoiceCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $number The number in E.164 format with the plus sign URL-encoded, e.g. %2B12125550100
     * @param array<string,mixed>|VoiceRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfVoiceNumber>
     *
     * @throws APIException
     */
    public function retrieve(
        string $number,
        array|VoiceRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $number Path param: The number in E.164 format with the plus sign URL-encoded, e.g. %2B12125550100
     * @param array<string,mixed>|VoiceUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfVoiceNumber>
     *
     * @throws APIException
     */
    public function update(
        string $number,
        array|VoiceUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|VoiceListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfListOfVoiceNumber>
     *
     * @throws APIException
     */
    public function list(
        array|VoiceListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|VoiceCreateTokenParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfVoiceToken>
     *
     * @throws APIException
     */
    public function createToken(
        array|VoiceCreateTokenParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $number Path param: The voice number from the route, in E.164 format with the plus sign URL-encoded (%2B),
     * for example /v3/channels/voice/%2B12025550123/rotate-secret.
     * @param array<string,mixed>|VoiceRotateSecretParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfVoiceSecret>
     *
     * @throws APIException
     */
    public function rotateSecret(
        string $number,
        array|VoiceRotateSecretParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $number Path param: The voice number from the route, in E.164 format with the plus sign URL-encoded (%2B),
     * for example /v3/channels/voice/%2B12025550123/test. The test question goes to this
     * number's callback URL and is signed with this number's secret.
     * @param array<string,mixed>|VoiceTestParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfVoiceCallbackTest>
     *
     * @throws APIException
     */
    public function test(
        string $number,
        array|VoiceTestParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
