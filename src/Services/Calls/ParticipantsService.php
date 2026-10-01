<?php

declare(strict_types=1);

namespace SentDm\Services\Calls;

use SentDm\Calls\APIResponseOfCall;
use SentDm\Calls\Participants\APIResponseOfListOfCallParticipant;
use SentDm\Calls\Participants\CallParticipantTarget;
use SentDm\Client;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Util;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\Calls\ParticipantsContract;

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
final class ParticipantsService implements ParticipantsContract
{
    /**
     * @api
     */
    public ParticipantsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new ParticipantsRawService($client);
    }

    /**
     * @api
     *
     * Mutes or unmutes one participant of the conference room a live call is in, named by the participant's own call id from the participants list: send muted true to silence them, muted false to let them be heard again. Muting a participant who is already muted succeeds, as does unmuting one who is not. A participant who is not in this call's room answers 404. A call that has ended answers 409, as does a call that is not in a conference.
     *
     * @param string $participantID Path param: The participant's own call id from the route, as listed by the participants endpoint, for example call_9f2ab000-0000-4000-8000-000000000002
     * @param string $id Path param: The call id from the route, as carried by call webhooks and the calls list, for example call_9f2ab000-0000-4000-8000-000000000001
     * @param bool $muted Body param: true to mute the participant, false to unmute them
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $participantID,
        string $id,
        ?bool $muted = null,
        ?bool $sandbox = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): mixed {
        $params = Util::removeNulls(
            [
                'id' => $id,
                'muted' => $muted,
                'sandbox' => $sandbox,
                'idempotencyKey' => $idempotencyKey,
                'xProfileID' => $xProfileID,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($participantID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Lists who is in the conference room one of your live calls is in: each participant's own call id, who they are, whether the room mutes them, and how long they have been connected. The call itself is one of the participants. Use a participant's id to mute or remove them; it is also a call id, so GET /v3/calls/{id} accepts it. A call that has ended answers 409, as does a call that is not in a conference.
     *
     * @param string $id The call id from the route, as carried by call webhooks and the calls list, for example call_9f2ab000-0000-4000-8000-000000000001
     * @param string $xProfileID Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        string $id,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfListOfCallParticipant {
        $params = Util::removeNulls(['xProfileID' => $xProfileID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Dials one of your app users or a phone number into a call that is in a conference room, and answers with the participant's own call record. The participant is a call of their own: it has its own id, can be looked up and hung up, and is billed and reported through call.completed and call.failed like any other call. A phone participant is called from caller_id, which must be one of your numbers, or from the call's owning number when omitted, and needs a destination you may call and a positive balance. Only a call your answer connected to a conference can take participants: a call connected to a user or a number answers 409.
     *
     * @param string $id Path param: The call id from the route, as carried by call webhooks and the calls list, for example call_9f2ab000-0000-4000-8000-000000000001
     * @param string|null $callerID Body param: The number shown to a phone participant as the caller, in E.164 format. Must be one of your numbers. The call's owning number when omitted
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param CallParticipantTarget|CallParticipantTargetShape $to Body param: A participant to add to a call
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function add(
        string $id,
        ?string $callerID = null,
        ?bool $sandbox = null,
        CallParticipantTarget|array|null $to = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfCall {
        $params = Util::removeNulls(
            [
                'callerID' => $callerID,
                'sandbox' => $sandbox,
                'to' => $to,
                'idempotencyKey' => $idempotencyKey,
                'xProfileID' => $xProfileID,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->add($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Removes one participant from the conference room a live call is in, named by the participant's own call id from the participants list. Their leg ends and is reported through call.completed like any other call; everyone else stays connected. A participant who is not in this call's room answers 404. A call that has ended answers 409, as does a call that is not in a conference.
     *
     * @param string $participantID Path param: The participant's own call id from the route, as listed by the participants endpoint, for example call_9f2ab000-0000-4000-8000-000000000002
     * @param string $id Path param: The call id from the route, as carried by call webhooks and the calls list, for example call_9f2ab000-0000-4000-8000-000000000001
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function remove(
        string $participantID,
        string $id,
        ?bool $sandbox = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): mixed {
        $params = Util::removeNulls(
            ['id' => $id, 'sandbox' => $sandbox, 'xProfileID' => $xProfileID]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->remove($participantID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Removes every participant from the conference room a live call is in, the call itself included. Every leg ends and is reported through call.completed like any other call. A room that is already empty answers 204 as well. A call that has ended answers 409, as does a call that is not in a conference.
     *
     * @param string $id Path param: The call id from the route, as carried by call webhooks and the calls list, for example call_9f2ab000-0000-4000-8000-000000000001
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function removeAll(
        string $id,
        ?bool $sandbox = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): mixed {
        $params = Util::removeNulls(
            ['sandbox' => $sandbox, 'xProfileID' => $xProfileID]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->removeAll($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
