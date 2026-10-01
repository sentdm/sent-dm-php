<?php

declare(strict_types=1);

namespace SentDm\Services;

use SentDm\Calls\APIResponseOfCall;
use SentDm\Calls\APIResponseOfCallRecordings;
use SentDm\Calls\Call;
use SentDm\Calls\CallHangupParams;
use SentDm\Calls\CallListParams;
use SentDm\Calls\CallListRecordingsParams;
use SentDm\Calls\CallRecordParams;
use SentDm\Calls\CallRetrieveParams;
use SentDm\CallsPage;
use SentDm\Client;
use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Util;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\CallsRawContract;

/**
 * Phone calls from the numbers you hold, driven by your own callback URL.
 *
 * `POST /v3/channels/voice` enables a number for calls, with the callback URL Sent asks what to do with each call on it, and `POST /v3/channels/voice/tokens` mints a short-lived token that lets a user of your app place and receive calls as that number. When a call arrives or a caller presses a key, a signed question is POSTed to the callback URL and the answer decides the call; `POST /v3/channels/voice/{number}/test` checks the URL answers the way we need before a real call reaches it, and `POST /v3/channels/voice/{number}/rotate-secret` replaces the signing secret. The call events themselves (`call.completed` and the rest) arrive through your webhooks.
 *
 * Every call is a record under `/v3/calls`: read it, list its recordings once one is ready, hang it up, start or stop recording, and add, mute or remove conference participants while it is live. A leg to a phone number runs for at most what your balance affords at the destination's rate.
 *
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
final class CallsRawService implements CallsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Retrieves one of your calls by id: the parties, the owning number, the current status with its failure reason, duration, price, recording availability, and a timeline of when the call entered each status.
     *
     * @param string $id The call id from the route, as carried by call webhooks and the calls list, for example call_9f2ab000-0000-4000-8000-000000000001
     * @param array{xProfileID?: string}|CallRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfCall>
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        array|CallRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = CallRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v3/calls/%1$s', $id],
            headers: Util::array_transform_keys(
                $parsed,
                ['xProfileID' => 'x-profile-id']
            ),
            options: $options,
            convert: APIResponseOfCall::class,
        );
    }

    /**
     * @api
     *
     * Retrieves a paginated list of your calls, most recent first. Filter by direction, status, the owning number, and the time the call started (from and to are inclusive). Use the call webhooks for real-time updates; this list is for looking calls up afterwards.
     *
     * @param array{
     *   direction?: string|null,
     *   from?: \DateTimeInterface|null,
     *   number?: string|null,
     *   page?: int,
     *   pageSize?: int,
     *   status?: string|null,
     *   to?: \DateTimeInterface|null,
     *   xProfileID?: string,
     * }|CallListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CallsPage<Call>>
     *
     * @throws APIException
     */
    public function list(
        array|CallListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = CallListParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(
            ['direction', 'from', 'number', 'page', 'pageSize', 'status', 'to']
        );

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v3/calls',
            query: Util::array_transform_keys(
                array_intersect_key($parsed, $query_params),
                ['pageSize' => 'page_size']
            ),
            headers: Util::array_transform_keys(
                $header_params,
                ['xProfileID' => 'x-profile-id']
            ),
            options: $options,
            convert: Call::class,
            page: CallsPage::class,
        );
    }

    /**
     * @api
     *
     * Ends one of your live calls. The call then ends the way any other call does: its status moves to completed and call.completed is sent once the disconnect is reported. A call that has already ended answers 409, and so does a call with no phone leg, such as one between two app users.
     *
     * @param string $id Path param: The call id from the route, as carried by call webhooks and the calls list, for example call_9f2ab000-0000-4000-8000-000000000001
     * @param array{
     *   sandbox?: bool, idempotencyKey?: string, xProfileID?: string
     * }|CallHangupParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function hangup(
        string $id,
        array|CallHangupParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = CallHangupParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = [
            'idempotencyKey' => 'Idempotency-Key', 'xProfileID' => 'x-profile-id',
        ];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v3/calls/%1$s/hangup', $id],
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

    /**
     * @api
     *
     * Returns pre-signed links to the recordings of one of your calls, each valid until its url_expires_at. A recording appears once the call was recorded, by a connect answer with record set, a startRecording instruction or the recordings command, and the call.recording_ready webhook has been sent; until then, and for a call that was never recorded, the list is empty. A call recorded more than once lists every recording, oldest first, each under the recording_id its call.recording_ready webhook carried.
     *
     * @param string $id The call id from the route, as carried by call webhooks and the calls list, for example call_9f2ab000-0000-4000-8000-000000000001
     * @param array{xProfileID?: string}|CallListRecordingsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfCallRecordings>
     *
     * @throws APIException
     */
    public function listRecordings(
        string $id,
        array|CallListRecordingsParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = CallListRecordingsParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v3/calls/%1$s/recordings', $id],
            headers: Util::array_transform_keys(
                $parsed,
                ['xProfileID' => 'x-profile-id']
            ),
            options: $options,
            convert: APIResponseOfCallRecordings::class,
        );
    }

    /**
     * @api
     *
     * Starts or stops recording one of your live calls. Use start to begin recording mid-call, or stop to end a recording, whether it was started here or by a connect answer with record set. A call that has already ended answers 409, and so does a call with no phone leg, such as one between two app users, which can't be recorded.
     *
     * @param string $id Path param: The call id from the route, as carried by call webhooks and the calls list, for example call_9f2ab000-0000-4000-8000-000000000001
     * @param array{
     *   action?: string, sandbox?: bool, idempotencyKey?: string, xProfileID?: string
     * }|CallRecordParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function record(
        string $id,
        array|CallRecordParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = CallRecordParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = [
            'idempotencyKey' => 'Idempotency-Key', 'xProfileID' => 'x-profile-id',
        ];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v3/calls/%1$s/recordings', $id],
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
