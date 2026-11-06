<?php

declare(strict_types=1);

namespace SentDm\SenderProfiles;

use SentDm\Channels\ChannelsState;
use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\SenderProfiles\SenderProfile\Compliance;

/**
 * A sender profile as the API reports it — the same document the create call accepts, plus the read-only
 * facts it cannot: each market's status and what it still owes.
 *
 * No status at the profile, brand or campaign level. Brand and campaign are identity, and
 * identity has no lifecycle. What has one is the registration of a sender in a market, and the approval of
 * a channel — so status lives there, where it says which specific thing is blocked rather than flattening
 * several answers into one.
 *
 * @phpstan-import-type SenderProfileBillingShape from \SentDm\SenderProfiles\SenderProfileBilling
 * @phpstan-import-type ChannelsStateShape from \SentDm\Channels\ChannelsState
 * @phpstan-import-type ComplianceShape from \SentDm\SenderProfiles\SenderProfile\Compliance
 *
 * @phpstan-type SenderProfileShape = array{
 *   id?: string|null,
 *   apiKey?: string|null,
 *   billing?: null|SenderProfileBilling|SenderProfileBillingShape,
 *   channels?: null|ChannelsState|ChannelsStateShape,
 *   compliance?: null|Compliance|ComplianceShape,
 *   createdAt?: \DateTimeInterface|null,
 *   description?: string|null,
 *   name?: string|null,
 *   notifications?: string|null,
 *   organizationID?: string|null,
 *   shortName?: string|null,
 * }
 */
final class SenderProfile implements BaseModel
{
    /** @use SdkModel<SenderProfileShape> */
    use SdkModel;

    #[Optional]
    public ?string $id;

    /**
     * The API key for this profile.
     *
     * Returned by create and by nothing else. It is shown once; a read that repeated it would
     * turn every profile list into a credential dump and put the key into any log or cache that keeps a
     * response body.
     *
     * Omitted rather than null on a read. A key field that is always present and always empty
     * suggests it could be populated, which is an invitation to populate it; absent says there is nothing
     * to look for. Doing it with a serializer condition rather than a second response type keeps create and
     * read on one shape, which is what stops them drifting.
     */
    #[Optional('api_key', nullable: true)]
    public ?string $apiKey;

    /**
     * Who pays for a sender profile's traffic, as a read reports it.
     *
     * Its own type, field for field the same as
     * BillingRequest. Same reason as the brand: a response is not
     * a request, whatever it carries.
     */
    #[Optional(nullable: true)]
    public ?SenderProfileBilling $billing;

    /**
     * The channels a profile sends on. SMS is a list because a profile can send in several markets; WhatsApp
     * and RCS are single, because a profile has one business account and one agent.
     */
    #[Optional(nullable: true)]
    public ?ChannelsState $channels;

    /**
     * What a market has been given: the identity it registers under, its programme, and any documents attached.
     *
     * What it does not carry is what the market asks for. That is the subject of
     * GET /v3/compliance/requirements, and it is the same answer for every caller — a description of what
     * a compliance regime wants, not a record of one customer's progress through it. It was reported here as
     * well for a while, which put the same array in six response shapes and left a caller deciding which of two
     * sources to believe.
     *
     * Present on a list read for markets that register (carrying brand and campaign), but with
     * documents absent — documents are not fetched for a list, because a catalog lookup and a document
     * read per market would multiply across a page. Absent documents is distinct from an empty list:
     * absent says they were not fetched; empty says the market has been given none. The parent object is null
     * only when the market registers with nobody and compliance was not computed — nothing to show at all.
     */
    #[Optional(nullable: true)]
    public ?Compliance $compliance;

    #[Optional('created_at')]
    public ?\DateTimeInterface $createdAt;

    #[Optional(nullable: true)]
    public ?string $description;

    #[Optional]
    public ?string $name;

    /**
     * Who is notified about this profile's events: ORGANIZATION, SENDER_PROFILE, or
     * ORGANIZATION_AND_SENDER_PROFILE. Always present — a profile that never chose reports as
     * ORGANIZATION, the value a create would send to get the default behaviour.
     */
    #[Optional(nullable: true)]
    public ?string $notifications;

    #[Optional('organization_id', nullable: true)]
    public ?string $organizationID;

    #[Optional('short_name', nullable: true)]
    public ?string $shortName;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param SenderProfileBilling|SenderProfileBillingShape|null $billing
     * @param ChannelsState|ChannelsStateShape|null $channels
     * @param Compliance|ComplianceShape|null $compliance
     */
    public static function with(
        ?string $id = null,
        ?string $apiKey = null,
        SenderProfileBilling|array|null $billing = null,
        ChannelsState|array|null $channels = null,
        Compliance|array|null $compliance = null,
        ?\DateTimeInterface $createdAt = null,
        ?string $description = null,
        ?string $name = null,
        ?string $notifications = null,
        ?string $organizationID = null,
        ?string $shortName = null,
    ): self {
        $self = new self;

        null !== $id && $self['id'] = $id;
        null !== $apiKey && $self['apiKey'] = $apiKey;
        null !== $billing && $self['billing'] = $billing;
        null !== $channels && $self['channels'] = $channels;
        null !== $compliance && $self['compliance'] = $compliance;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $description && $self['description'] = $description;
        null !== $name && $self['name'] = $name;
        null !== $notifications && $self['notifications'] = $notifications;
        null !== $organizationID && $self['organizationID'] = $organizationID;
        null !== $shortName && $self['shortName'] = $shortName;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * The API key for this profile.
     *
     * Returned by create and by nothing else. It is shown once; a read that repeated it would
     * turn every profile list into a credential dump and put the key into any log or cache that keeps a
     * response body.
     *
     * Omitted rather than null on a read. A key field that is always present and always empty
     * suggests it could be populated, which is an invitation to populate it; absent says there is nothing
     * to look for. Doing it with a serializer condition rather than a second response type keeps create and
     * read on one shape, which is what stops them drifting.
     */
    public function withAPIKey(?string $apiKey): self
    {
        $self = clone $this;
        $self['apiKey'] = $apiKey;

        return $self;
    }

    /**
     * Who pays for a sender profile's traffic, as a read reports it.
     *
     * Its own type, field for field the same as
     * BillingRequest. Same reason as the brand: a response is not
     * a request, whatever it carries.
     *
     * @param SenderProfileBilling|SenderProfileBillingShape|null $billing
     */
    public function withBilling(SenderProfileBilling|array|null $billing): self
    {
        $self = clone $this;
        $self['billing'] = $billing;

        return $self;
    }

    /**
     * The channels a profile sends on. SMS is a list because a profile can send in several markets; WhatsApp
     * and RCS are single, because a profile has one business account and one agent.
     *
     * @param ChannelsState|ChannelsStateShape|null $channels
     */
    public function withChannels(ChannelsState|array|null $channels): self
    {
        $self = clone $this;
        $self['channels'] = $channels;

        return $self;
    }

    /**
     * What a market has been given: the identity it registers under, its programme, and any documents attached.
     *
     * What it does not carry is what the market asks for. That is the subject of
     * GET /v3/compliance/requirements, and it is the same answer for every caller — a description of what
     * a compliance regime wants, not a record of one customer's progress through it. It was reported here as
     * well for a while, which put the same array in six response shapes and left a caller deciding which of two
     * sources to believe.
     *
     * Present on a list read for markets that register (carrying brand and campaign), but with
     * documents absent — documents are not fetched for a list, because a catalog lookup and a document
     * read per market would multiply across a page. Absent documents is distinct from an empty list:
     * absent says they were not fetched; empty says the market has been given none. The parent object is null
     * only when the market registers with nobody and compliance was not computed — nothing to show at all.
     *
     * @param Compliance|ComplianceShape|null $compliance
     */
    public function withCompliance(Compliance|array|null $compliance): self
    {
        $self = clone $this;
        $self['compliance'] = $compliance;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    public function withDescription(?string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Who is notified about this profile's events: ORGANIZATION, SENDER_PROFILE, or
     * ORGANIZATION_AND_SENDER_PROFILE. Always present — a profile that never chose reports as
     * ORGANIZATION, the value a create would send to get the default behaviour.
     */
    public function withNotifications(?string $notifications): self
    {
        $self = clone $this;
        $self['notifications'] = $notifications;

        return $self;
    }

    public function withOrganizationID(?string $organizationID): self
    {
        $self = clone $this;
        $self['organizationID'] = $organizationID;

        return $self;
    }

    public function withShortName(?string $shortName): self
    {
        $self = clone $this;
        $self['shortName'] = $shortName;

        return $self;
    }
}
