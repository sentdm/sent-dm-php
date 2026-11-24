<?php

declare(strict_types=1);

namespace SentDm\Services\Channels\SMS;

use SentDm\Channels\Markets\APIResponseOfChannelMarket;
use SentDm\Channels\SMS\TenDlc\TenDlcAddCampaignParams;
use SentDm\Channels\SMS\TenDlc\TenDlcCampaignUseCase;
use SentDm\Channels\SMS\TenDlc\TenDlcListCampaignsParams;
use SentDm\Channels\SMS\TenDlc\TenDlcListCampaignsResponse;
use SentDm\Channels\SMS\TenDlc\TenDlcUpdateCampaignParams;
use SentDm\Client;
use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Util;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\Channels\SMS\TenDlcRawContract;

/**
 * The senders you send from, one per channel.
 *
 * **SMS is a list of markets**, each keyed by `(country, number_type)` — a customer can hold `us/10dlc` and `gb/alphanumeric` at once, so a market is addressed by the pair rather than by country alone. **WhatsApp and RCS are single**: a customer has one business account and one agent. **Voice is per number**: each number you hold can carry phone calls on its own (`POST /v3/channels/voice`), each with the callback URL Sent asks what to do with its calls, one of them is the default line for calls placed from your app, and voice tokens are minted with `POST /v3/voice/tokens`. Read your voice numbers with `GET /v3/channels/voice` and change one with `PATCH /v3/channels/voice/{number}`.
 *
 * ## Compliance lives on the market
 *
 * Adding a market records everything that market registers with, in its `compliance` object. Only **US `TEN_DLC`** registers with a regime — The Campaign Registry — and it is the only market whose compliance carries `brand` and `campaign`. Everywhere else compliance is documents, and many markets ask for none at all.
 *
 * `GET` and `PATCH` on a market return and accept the same shape, so what comes back can be sent back: an omitted key is left alone, and a key reported in `requirements` is the path into the body that clears it.
 *
 * Call `GET /v3/compliance/requirements` first — it answers what a market demands before you hold it, with a body you can fill in and post.
 *
 * @phpstan-import-type TenDlcCampaignUseCaseShape from \SentDm\Channels\SMS\TenDlc\TenDlcCampaignUseCase
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
final class TenDlcRawService implements TenDlcRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Registers **a new campaign** on the US `TEN_DLC` market you already hold — the one market that registers campaigns. Use it when you want numbers for a different use case than the market's existing campaign covers. The campaign is filed under the brand the market files under — your organization's when you inherit its identity.
     *
     * ## What to send
     *
     * The new campaign's fields, at the top level of the body: use cases, consent narrative, volume, sample messages and keywords, under their keys (`description`, `message_flow`, `use_cases`, `volume`, …). It has to be complete. A rejected field is keyed by its name (`description`). `id` and `inherit` are ignored, so an entry of `campaigns` can be sent as read.
     *
     * The identity is the market's and is not sent here. A market whose identity has no registration yet, or one not yet submitted for review, is `400`.
     *
     * ## What happens
     *
     * The campaign is recorded and goes for review; it is not filed with The Campaign Registry by this call. **It comes without numbers**: send its `id` from `compliance.campaigns` to `POST /v3/channels/sms/{country}/{type}/numbers` to give it some. **The campaign you already have, and its numbers, are not touched** — including a campaign you run on from your organization.
     *
     * **Each call files a new campaign**, which is charged when it is submitted. Send an `Idempotency-Key` so a retried request does not file a second one.
     *
     * To change a campaign, use `PATCH /v3/channels/sms/US/TEN_DLC/campaigns/{campaignId}`; `PATCH /v3/channels/sms/US/TEN_DLC` changes the brand and documents only, and refuses a campaign or numbers (`400`).
     *
     * Returns **the market**, in the shape `GET /v3/channels/sms/US/TEN_DLC` returns, with `202`.
     *
     * @param array{
     *   description: string,
     *   helpKeywords: string,
     *   helpMessage: string,
     *   messageFlow: string,
     *   optInKeywords: string,
     *   optInMessage: string,
     *   optOutKeywords: string,
     *   optOutMessage: string,
     *   privacyPolicyLink: string,
     *   termsAndConditionsLink: string,
     *   useCases: list<TenDlcCampaignUseCase|TenDlcCampaignUseCaseShape>,
     *   volume: string,
     *   idempotencyKey: string,
     *   sandbox?: bool,
     *   xProfileID?: string,
     * }|TenDlcAddCampaignParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfChannelMarket>
     *
     * @throws APIException
     */
    public function addCampaign(
        array|TenDlcAddCampaignParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TenDlcAddCampaignParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = [
            'idempotencyKey' => 'Idempotency-Key', 'xProfileID' => 'x-profile-id',
        ];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v3/channels/sms/US/TEN_DLC/campaigns',
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: APIResponseOfChannelMarket::class,
        );
    }

    /**
     * @api
     *
     * Every campaign your US `TEN_DLC` market registers, oldest first, each with its `id`, where it stands and `inherit` (`true` for your organization's) beside its fields — the list `GET /v3/channels/sms/US/TEN_DLC` reports under `compliance.campaigns`. Add one with `POST` on this path, and change one of your own with `PATCH /v3/channels/sms/US/TEN_DLC/campaigns/{id}`.
     *
     * Each campaign has a `status` of its own, so a market on several says which is approved: `ACTIVE` once the carriers have elected it, `PENDING_REVIEW` until then, `ACTION_NEEDED` when it came back for correction, `DECLINED` when the carriers refused it, `INACTIVE` once it has ended. Why the market is held up is the market's own `reason`, which names the campaign concerned. `status` is read-only and ignored when the entry is sent back.
     *
     * A customer without a US `TEN_DLC` market is `404`.
     *
     * @param array{xProfileID?: string}|TenDlcListCampaignsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TenDlcListCampaignsResponse>
     *
     * @throws APIException
     */
    public function listCampaigns(
        array|TenDlcListCampaignsParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TenDlcListCampaignsParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v3/channels/sms/US/TEN_DLC/campaigns',
            headers: Util::array_transform_keys(
                $parsed,
                ['xProfileID' => 'x-profile-id']
            ),
            options: $options,
            convert: TenDlcListCampaignsResponse::class,
        );
    }

    /**
     * @api
     *
     * Changes **one campaign of your own** on the US `TEN_DLC` market, named by its `id` in the market's `compliance.campaigns`.
     *
     * ## What to send
     *
     * The fields to change, at the top level of the body, under their keys (`description`, `message_flow`, `use_cases`, `help_message`, …). A field you leave out keeps its value, and a rejected one is keyed by its name. `id` and `"inherit": false` are ignored, so an entry of `campaigns` can be sent as read; `"inherit": true` is `400`, because this call changes a campaign's fields, not whose campaign you run on. The campaign only: add numbers with `POST /v3/channels/sms/US/TEN_DLC/numbers`, and change the brand or documents with `PATCH /v3/channels/sms/US/TEN_DLC`.
     *
     * ## When it can be changed
     *
     * Until it is filed with The Campaign Registry, and again when we ask you to correct it. That correction sends it back for review. A filed campaign is otherwise `409`, and so is a change between low and high volume once it is registered. A campaign you run on from your organization is `409` too: it is the organization's to change. So is one out of service: expired, deactivated or released.
     *
     * Returns **the market**, in the shape `GET /v3/channels/sms/US/TEN_DLC` returns.
     *
     * @param string $campaignID Path param: The campaign: its id in the market's compliance.campaigns.
     * @param array{
     *   description?: string,
     *   helpKeywords?: string,
     *   helpMessage?: string,
     *   messageFlow?: string,
     *   optInKeywords?: string,
     *   optInMessage?: string,
     *   optOutKeywords?: string,
     *   optOutMessage?: string,
     *   privacyPolicyLink?: string,
     *   sandbox?: bool,
     *   termsAndConditionsLink?: string,
     *   useCases?: list<TenDlcCampaignUseCase|TenDlcCampaignUseCaseShape>,
     *   volume?: string,
     *   idempotencyKey?: string,
     *   xProfileID?: string,
     * }|TenDlcUpdateCampaignParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfChannelMarket>
     *
     * @throws APIException
     */
    public function updateCampaign(
        string $campaignID,
        array|TenDlcUpdateCampaignParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TenDlcUpdateCampaignParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = [
            'idempotencyKey' => 'Idempotency-Key', 'xProfileID' => 'x-profile-id',
        ];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'patch',
            path: ['v3/channels/sms/US/TEN_DLC/campaigns/%1$s', $campaignID],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: APIResponseOfChannelMarket::class,
        );
    }
}
