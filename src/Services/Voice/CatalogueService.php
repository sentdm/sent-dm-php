<?php

declare(strict_types=1);

namespace SentDm\Services\Voice;

use SentDm\Client;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Util;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\Voice\CatalogueContract;
use SentDm\Voice\Catalogue\APIResponseOfVoiceCatalogue;

/**
 * Phone calls from the numbers you hold, driven by your own callback URL.
 *
 * `POST /v3/channels/voice` enables a number for calls, with the callback URL Sent asks what to do with each call on it, and `POST /v3/voice/tokens` mints a short-lived token that lets a user of your app place and receive calls as that number. When a call arrives or a caller presses a key, a signed question is POSTed to the callback URL and the answer decides the call; `POST /v3/channels/voice/{number}/test` checks the URL answers the way we need before a real call reaches it, and `POST /v3/channels/voice/{number}/rotate-secret` replaces the signing secret. The call events themselves (`call.completed` and the rest) arrive through your webhooks.
 *
 * Every call is a record under `/v3/voice/calls`: read it, list its recordings once one is ready, hang it up, start or stop recording, and add, mute or remove conference participants while it is live. A leg to a phone number runs for at most what your balance affords at the destination's rate.
 *
 * **Voice agents.** `POST /v3/voice/agents` creates an agent that answers calls through the Sent Voice Gateway: `session_type` says whether Sent carries the call as text (speech recognised and spoken for the agent) or as audio, `websocket_url` is where the gateway dials the agent for each call (leave it out and the agent dials in with your API key), and `tools`, `transfer_targets`, `fallback` and `limits` say what it may do on a call. The agent's `signing_secret` is shown on create and on `POST /v3/voice/agents/{id}/rotate-secret` only. Voices and languages for text sessions come from `GET /v3/voice/voices`. A number takes calls to an agent once it is bound to it on `/v3/channels/voice`.
 *
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
final class CatalogueService implements CatalogueContract
{
    /**
     * @api
     */
    public CatalogueRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new CatalogueRawService($client);
    }

    /**
     * @api
     *
     * The names a voice agent's `speech.voice` and `speech.language` accept, with the default marked. The list grows as voices are added; a name is never removed without notice.
     *
     * @param string $xProfileID Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null
    ): APIResponseOfVoiceCatalogue {
        $params = Util::removeNulls(['xProfileID' => $xProfileID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
