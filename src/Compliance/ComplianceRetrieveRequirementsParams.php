<?php

declare(strict_types=1);

namespace SentDm\Compliance;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * **Call this first.** It returns what a channel, country and sender type demand before you can send there — and `setup[]`, the calls that satisfy those demands, in order, each with a body you can copy and send as it stands. You never have to track forty countries' rules yourself.
 *
 * ## Channel
 *
 * `channel` is `sms`, `whatsapp` or `rcs`, and **defaults to `sms`** — so a caller that omits it gets exactly what this endpoint has always returned.
 *
 * `sms` is the only one answered today; the other two are `501` until their requirements are declared. They are refused rather than answered with an empty requirement set, because empty would say the channel demands nothing, and both demand plenty — WhatsApp a business verification and a display name review, RCS a carrier approval. Saying "not yet" is the true answer and the same one `POST /v3/sender-profiles` gives for `channels.whatsapp`.
 *
 * `type` is an SMS sender type, and SMS is the only channel whose senders have one.
 *
 * Requirements vary enormously. US `TEN_DLC` registers a brand and a campaign with The Campaign Registry and asks for a substantial set of values. An alphanumeric sender in one country pre-registers with supporting documents; in another it needs nothing at all. This is the authoritative answer for whichever market you are asking about, and it is the same declaration used to validate the calls themselves — so it can never drift from what is actually enforced.
 *
 * ## `setup[]` — what to do
 *
 * **One step.** `POST /v3/channels/sms` adds the market and records everything it registers with — the identity in `compliance.brand`, the programme in `compliance.campaign`. There were three, in a load-bearing order, while the identity and the campaign were resources of their own; they are members of this call's body now, so there is nothing to sequence.
 *
 * Correct any of it afterwards with `PATCH /v3/channels/sms/{country}/{type}`, which takes the same `compliance` object one key at a time.
 *
 * Each step's `body` has every key that market wants already present, with the values left **blank**. Blank rather than filled with placeholders, because the body is meant to be sent: a null value counts as not supplied, so posting a step verbatim comes back naming every blank you left. `attachments[]` lists files to send as multipart on the channel call, each under the field name given — a file cannot be a JSON value, so documents are never listed in `compliance[]`.
 *
 * Every step is a call for whoever holds the key. To set a **sender profile** up instead, send the same requests with the `x-profile-id` header naming it; there is no separate path.
 *
 * ## `requirements[]` — what each value means
 *
 * Each entry names a key for the `compliance` array, its value type, and whether it is required. `required_when` marks values needed only in certain cases — evaluate it against your own payload, e.g. `brand.entity_type == PUBLIC_PROFIT`. `options` lists accepted values where the market constrains them, and `label` is suitable for rendering a form field.
 *
 * Values Sent supplies on your behalf are never listed: correlation ids, environment flags, carrier elections, and booleans derivable from what you already send.
 *
 * ## When nothing is required
 *
 * `required` is `false` and `requirements` is empty, and the single `setup` step carries no `compliance` array at all. A `sender_id_pattern` may still be present — many markets constrain the sender string without registering anything.
 *
 * @see SentDm\Services\ComplianceService::retrieveRequirements()
 *
 * @phpstan-type ComplianceRetrieveRequirementsParamsShape = array{
 *   channel?: string|null,
 *   country?: string|null,
 *   type?: string|null,
 *   xProfileID?: string|null,
 * }
 */
final class ComplianceRetrieveRequirementsParams implements BaseModel
{
    /** @use SdkModel<ComplianceRetrieveRequirementsParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Channel the sender is for: sms, whatsapp or rcs. Defaults to sms, which is the only one answered today — the other two are 501 until their requirements are declared.
     */
    #[Optional(nullable: true)]
    public ?string $channel;

    /**
     * ISO 3166-1 alpha-2 country code, e.g. US, XK, IN.
     */
    #[Optional(nullable: true)]
    public ?string $country;

    /**
     * Sender type: LOCAL, MOBILE, TEN_DLC, TOLL_FREE, SHORT_CODE, ALPHANUMERIC. 10DLC is accepted as a synonym of TEN_DLC, the same as on POST /v3/sender-profiles. Applies to channel=sms, the only channel whose senders have a type.
     */
    #[Optional(nullable: true)]
    public ?string $type;

    #[Optional]
    public ?string $xProfileID;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(
        ?string $channel = null,
        ?string $country = null,
        ?string $type = null,
        ?string $xProfileID = null,
    ): self {
        $self = new self;

        null !== $channel && $self['channel'] = $channel;
        null !== $country && $self['country'] = $country;
        null !== $type && $self['type'] = $type;
        null !== $xProfileID && $self['xProfileID'] = $xProfileID;

        return $self;
    }

    /**
     * Channel the sender is for: sms, whatsapp or rcs. Defaults to sms, which is the only one answered today — the other two are 501 until their requirements are declared.
     */
    public function withChannel(?string $channel): self
    {
        $self = clone $this;
        $self['channel'] = $channel;

        return $self;
    }

    /**
     * ISO 3166-1 alpha-2 country code, e.g. US, XK, IN.
     */
    public function withCountry(?string $country): self
    {
        $self = clone $this;
        $self['country'] = $country;

        return $self;
    }

    /**
     * Sender type: LOCAL, MOBILE, TEN_DLC, TOLL_FREE, SHORT_CODE, ALPHANUMERIC. 10DLC is accepted as a synonym of TEN_DLC, the same as on POST /v3/sender-profiles. Applies to channel=sms, the only channel whose senders have a type.
     */
    public function withType(?string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    public function withXProfileID(string $xProfileID): self
    {
        $self = clone $this;
        $self['xProfileID'] = $xProfileID;

        return $self;
    }
}
