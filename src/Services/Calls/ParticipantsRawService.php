<?php

declare(strict_types=1);

namespace SentDm\Services\Calls;

use SentDm\Calls\APIResponseOfCall;
use SentDm\Calls\Participants\APIResponseOfListOfCallParticipant;
use SentDm\Calls\Participants\CallParticipantTarget;
use SentDm\Calls\Participants\ParticipantAddParams;
use SentDm\Calls\Participants\ParticipantListParams;
use SentDm\Calls\Participants\ParticipantRemoveAllParams;
use SentDm\Calls\Participants\ParticipantRemoveParams;
use SentDm\Calls\Participants\ParticipantUpdateParams;
use SentDm\Client;
use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Util;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\Calls\ParticipantsRawContract;

/**
 * Phone calls from the numbers you hold, driven by your own callback URL.
 *
 * `POST /v3/channels/voice` enables a number for calls, with the callback URL Sent asks what to do with each call on it, and `POST /v3/channels/voice/tokens` mints a short-lived token that lets a user of your app place and receive calls as that number. When a call arrives or a caller presses a key, a signed question is POSTed to the callback URL and the answer decides the call; `POST /v3/channels/voice/{number}/test` checks the URL answers the way we need before a real call reaches it, and `POST /v3/channels/voice/{number}/rotate-secret` replaces the signing secret. The call events themselves (`call.completed` and the rest) arrive through your webhooks.
 *
 * Every call is a record under `/v3/calls`: read it, list its recordings once one is ready, hang it up, start or stop recording, and add, mute or remove conference participants while it is live. A leg to a phone number runs for at most what your balance affords at the destination's rate.
 *
 * @phpstan-import-type CallParticipantTargetShape from \SentDm\Calls\Participants\CallParticipantTarget
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
final class ParticipantsRawService implements ParticipantsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Mutes or unmutes one participant of the conference room a live call is in, named by the participant's own call id from the participants list: send muted true to silence them, muted false to let them be heard again. Muting a participant who is already muted succeeds, as does unmuting one who is not. A participant who is not in this call's room answers 404. A call that has ended answers 409, as does a call that is not in a conference.
     *
     * @param string $participantID Path param: The participant's own call id from the route, as listed by the participants endpoint, for example call_9f2ab000-0000-4000-8000-000000000002
     * @param array{
     *   id: string,
     *   muted?: bool,
     *   sandbox?: bool,
     *   idempotencyKey?: string,
     *   xProfileID?: string,
     * }|ParticipantUpdateParams $params
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
    ): BaseResponse {
        [$parsed, $options] = ParticipantUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $id = $parsed['id'];
        unset($parsed['id']);
        $header_params = [
            'idempotencyKey' => 'Idempotency-Key', 'xProfileID' => 'x-profile-id',
        ];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'patch',
            path: ['v3/calls/%1$s/participants/%2$s', $id, $participantID],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                array_diff_key($parsed, array_flip(array_keys($header_params))),
                array_flip(['id']),
            ),
            options: $options,
            convert: null,
        );
    }

    /**
     * @api
     *
     * Lists who is in the conference room one of your live calls is in: each participant's own call id, who they are, whether the room mutes them, and how long they have been connected. The call itself is one of the participants. Use a participant's id to mute or remove them; it is also a call id, so GET /v3/calls/{id} accepts it. A call that has ended answers 409, as does a call that is not in a conference.
     *
     * @param string $id The call id from the route, as carried by call webhooks and the calls list, for example call_9f2ab000-0000-4000-8000-000000000001
     * @param array{xProfileID?: string}|ParticipantListParams $params
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
    ): BaseResponse {
        [$parsed, $options] = ParticipantListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v3/calls/%1$s/participants', $id],
            headers: Util::array_transform_keys(
                $parsed,
                ['xProfileID' => 'x-profile-id']
            ),
            options: $options,
            convert: APIResponseOfListOfCallParticipant::class,
        );
    }

    /**
     * @api
     *
     * Dials one of your app users or a phone number into a call that is in a conference room, and answers with the participant's own call record. The participant is a call of their own: it has its own id, can be looked up and hung up, and is billed and reported through call.completed and call.failed like any other call. Every participant needs a positive balance. A phone participant is called from caller_id, which must be one of your numbers, or from the call's owning number when omitted, and needs a destination you may call. Only a call your answer connected to a conference can take participants: a call connected to a user or a number answers 409.
     *
     * @param string $id Path param: The call id from the route, as carried by call webhooks and the calls list, for example call_9f2ab000-0000-4000-8000-000000000001
     * @param array{
     *   callerID?: string|null,
     *   sandbox?: bool,
     *   to?: CallParticipantTarget|CallParticipantTargetShape,
     *   idempotencyKey?: string,
     *   xProfileID?: string,
     * }|ParticipantAddParams $params
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
    ): BaseResponse {
        [$parsed, $options] = ParticipantAddParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = [
            'idempotencyKey' => 'Idempotency-Key', 'xProfileID' => 'x-profile-id',
        ];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v3/calls/%1$s/participants', $id],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: APIResponseOfCall::class,
        );
    }

    /**
     * @api
     *
     * Removes one participant from the conference room a live call is in, named by the participant's own call id from the participants list. Their leg ends and is reported through call.completed like any other call; everyone else stays connected. A participant who is not in this call's room answers 404. A call that has ended answers 409, as does a call that is not in a conference.
     *
     * @param string $participantID Path param: The participant's own call id from the route, as listed by the participants endpoint, for example call_9f2ab000-0000-4000-8000-000000000002
     * @param array{
     *   id: string, sandbox?: bool, xProfileID?: string
     * }|ParticipantRemoveParams $params
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
    ): BaseResponse {
        [$parsed, $options] = ParticipantRemoveParams::parseRequest(
            $params,
            $requestOptions,
        );
        $id = $parsed['id'];
        unset($parsed['id']);
        $header_params = ['xProfileID' => 'x-profile-id'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v3/calls/%1$s/participants/%2$s', $id, $participantID],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                array_diff_key($parsed, array_flip(array_keys($header_params))),
                array_flip(['id']),
            ),
            options: $options,
            convert: null,
        );
    }

    /**
     * @api
     *
     * Removes every participant from the conference room a live call is in, the call itself included. Every leg ends and is reported through call.completed like any other call. A room that is already empty answers 204 as well. A call that has ended answers 409, as does a call that is not in a conference.
     *
     * @param string $id Path param: The call id from the route, as carried by call webhooks and the calls list, for example call_9f2ab000-0000-4000-8000-000000000001
     * @param array{
     *   sandbox?: bool, xProfileID?: string
     * }|ParticipantRemoveAllParams $params
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
    ): BaseResponse {
        [$parsed, $options] = ParticipantRemoveAllParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['xProfileID' => 'x-profile-id'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v3/calls/%1$s/participants', $id],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: null,
        );
    }
}
