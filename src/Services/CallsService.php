<?php

declare(strict_types=1);

namespace SentDm\Services;

use SentDm\Calls\APIResponseOfCall;
use SentDm\Calls\APIResponseOfCallRecordings;
use SentDm\Calls\Call;
use SentDm\CallsPage;
use SentDm\Client;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Util;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\CallsContract;
use SentDm\Services\Calls\ParticipantsService;

/**
 * Phone calls from the numbers you hold, driven by your own callback URL.
 *
 * `POST /v3/channels/voice` enables a number for calls, with the callback URL Sent asks what to do with each call on it, and `POST /v3/channels/voice/tokens` mints a short-lived token that lets a user of your app place and receive calls as that number. When a call arrives or a caller presses a key, a signed question is POSTed to the callback URL and the answer decides the call; `POST /v3/channels/voice/{number}/test` checks the URL answers the way we need before a real call reaches it, and `POST /v3/channels/voice/{number}/rotate-secret` replaces the signing secret. The call events themselves (`call.completed` and the rest) arrive through your webhooks.
 *
 * Every call is a record under `/v3/calls`: read it, list its recordings once one is ready, hang it up, start or stop recording, and add, mute or remove conference participants while it is live. A leg to a phone number runs for at most what your balance affords at the destination's rate.
 *
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
final class CallsService implements CallsContract
{
    /**
     * @api
     */
    public CallsRawService $raw;

    /**
     * @api
     */
    public ParticipantsService $participants;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new CallsRawService($client);
        $this->participants = new ParticipantsService($client);
    }

    /**
     * @api
     *
     * Retrieves one of your calls by id: the parties, the owning number, the current status with its failure reason, duration, price, recording availability, and a timeline of when the call entered each status.
     *
     * @param string $id The call id from the route, as carried by call webhooks and the calls list, for example call_9f2ab000-0000-4000-8000-000000000001
     * @param string $xProfileID Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfCall {
        $params = Util::removeNulls(['xProfileID' => $xProfileID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Retrieves a paginated list of your calls, most recent first. Filter by direction, status, the owning number, and the time the call started (from and to are inclusive). Use the call webhooks for real-time updates; this list is for looking calls up afterwards.
     *
     * @param string|null $direction Query param: Optional direction filter: outbound for calls placed from your app, inbound for calls to one of your numbers
     * @param \DateTimeInterface|null $from Query param: Only calls started at or after this time (ISO 8601)
     * @param string|null $number Query param: Optional filter on the number that owns the call, one of your voice-enabled numbers in E.164 format
     * @param int $page Query param: Page number (1-indexed)
     * @param int $pageSize Query param: Number of items per page
     * @param string|null $status Query param: Optional status filter: initiated, ringing, answered, completed, failed, no_answer or rejected
     * @param \DateTimeInterface|null $to Query param: Only calls started at or before this time (ISO 8601)
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @return CallsPage<Call>
     *
     * @throws APIException
     */
    public function list(
        ?string $direction = null,
        ?\DateTimeInterface $from = null,
        ?string $number = null,
        ?int $page = null,
        ?int $pageSize = null,
        ?string $status = null,
        ?\DateTimeInterface $to = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): CallsPage {
        $params = Util::removeNulls(
            [
                'direction' => $direction,
                'from' => $from,
                'number' => $number,
                'page' => $page,
                'pageSize' => $pageSize,
                'status' => $status,
                'to' => $to,
                'xProfileID' => $xProfileID,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Ends one of your live calls. The call then ends the way any other call does once the disconnect is reported: an answered call as COMPLETED with call.completed, a call still ringing as NO_ANSWER, REJECTED or FAILED with call.failed. A call that has already ended answers 409, and so does a call with no phone leg, such as one between two app users.
     *
     * @param string $id Path param: The call id from the route, as carried by call webhooks and the calls list, for example call_9f2ab000-0000-4000-8000-000000000001
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function hangup(
        string $id,
        ?bool $sandbox = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): mixed {
        $params = Util::removeNulls(
            [
                'sandbox' => $sandbox,
                'idempotencyKey' => $idempotencyKey,
                'xProfileID' => $xProfileID,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->hangup($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Returns pre-signed links to the recordings of one of your calls, each valid until its url_expires_at. A recording appears once the call was recorded, by a connect answer with record set, a startRecording instruction or the recordings command, and the call.recording_ready webhook has been sent; until then, and for a call that was never recorded, the list is empty. A call recorded more than once lists every recording, oldest first, each under the recording_id its call.recording_ready webhook carried.
     *
     * @param string $id The call id from the route, as carried by call webhooks and the calls list, for example call_9f2ab000-0000-4000-8000-000000000001
     * @param string $xProfileID Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function listRecordings(
        string $id,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfCallRecordings {
        $params = Util::removeNulls(['xProfileID' => $xProfileID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->listRecordings($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Starts or stops recording one of your live calls. Use start to begin recording mid-call, or stop to end a recording, whether it was started here or by a connect answer with record set. A call that has already ended answers 409, and so does a call with no phone leg, such as one between two app users, which can't be recorded.
     *
     * @param string $id Path param: The call id from the route, as carried by call webhooks and the calls list, for example call_9f2ab000-0000-4000-8000-000000000001
     * @param string $action Body param: start to begin recording, stop to end it
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function record(
        string $id,
        ?string $action = null,
        ?bool $sandbox = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): mixed {
        $params = Util::removeNulls(
            [
                'action' => $action,
                'sandbox' => $sandbox,
                'idempotencyKey' => $idempotencyKey,
                'xProfileID' => $xProfileID,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->record($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
