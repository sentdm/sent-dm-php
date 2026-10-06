<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts\Calls;

use SentDm\Calls\APIResponseOfCall;
use SentDm\Calls\Participants\APIResponseOfListOfCallParticipant;
use SentDm\Calls\Participants\ParticipantAddParams;
use SentDm\Calls\Participants\ParticipantListParams;
use SentDm\Calls\Participants\ParticipantRemoveAllParams;
use SentDm\Calls\Participants\ParticipantRemoveParams;
use SentDm\Calls\Participants\ParticipantUpdateParams;
use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface ParticipantsRawContract
{
    /**
     * @api
     *
     * @param string $participantID Path param: The participant's own call id from the route, as listed by the participants endpoint, for example call_9f2ab000-0000-4000-8000-000000000002
     * @param array<string,mixed>|ParticipantUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function update(
        string $participantID,
        array|ParticipantUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id The call id from the route, as carried by call webhooks and the calls list, for example call_9f2ab000-0000-4000-8000-000000000001
     * @param array<string,mixed>|ParticipantListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfListOfCallParticipant>
     *
     * @throws APIException
     */
    public function list(
        string $id,
        array|ParticipantListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id Path param: The call id from the route, as carried by call webhooks and the calls list, for example call_9f2ab000-0000-4000-8000-000000000001
     * @param array<string,mixed>|ParticipantAddParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfCall>
     *
     * @throws APIException
     */
    public function add(
        string $id,
        array|ParticipantAddParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $participantID Path param: The participant's own call id from the route, as listed by the participants endpoint, for example call_9f2ab000-0000-4000-8000-000000000002
     * @param array<string,mixed>|ParticipantRemoveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function remove(
        string $participantID,
        array|ParticipantRemoveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id Path param: The call id from the route, as carried by call webhooks and the calls list, for example call_9f2ab000-0000-4000-8000-000000000001
     * @param array<string,mixed>|ParticipantRemoveAllParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function removeAll(
        string $id,
        array|ParticipantRemoveAllParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
