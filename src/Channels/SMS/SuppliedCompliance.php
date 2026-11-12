<?php

declare(strict_types=1);

namespace SentDm\Channels\SMS;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Core\Conversion\MapOf;

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
 * @phpstan-import-type SuppliedDocumentShape from \SentDm\Channels\SMS\SuppliedDocument
 *
 * @phpstan-type SuppliedComplianceShape = array{
 *   brand?: array<string,mixed>|null,
 *   campaign?: array<string,mixed>|null,
 *   campaigns?: list<array<string,mixed>>|null,
 *   documents?: list<SuppliedDocument|SuppliedDocumentShape>|null,
 * }
 */
final class SuppliedCompliance implements BaseModel
{
    /** @use SdkModel<SuppliedComplianceShape> */
    use SdkModel;

    /**
     * The identity this market registers under, with inherit saying whose it is.
     *
     * Reported here rather than on the profile because it belongs to the registration this market
     * files, and only one market files one. It was a top-level block for a while, which put a per-registration
     * value beside a list of markets and left a caller to work out which market it belonged to.
     *
     * Absent for a market that registers with nobody — such a market asks for no identity, so there is
     * none to report. Absent and null mean different things: absent says this market does not ask, null would
     * say it asks and nothing was supplied.
     *
     * Untyped, like the request side, because its members are declared by the market's own schema rather
     * than by a C# class. A typed pair here would be a second definition of what a market wants, free to drift
     * from the one that validates.
     *
     * @var array<string,mixed>|null $brand
     */
    #[Optional(map: 'mixed', nullable: true)]
    public ?array $brand;

    /**
     * The programme this market registers, with inherit saying whose it is.
     *
     * One, not a list. TcrCampaigns permits several and an account built on the admin
     * side may hold them, but this surface offers one — which is what lets the market's PATCH be an
     * upsert rather than a collection with an addressable create behind it. An account holding several is
     * reported as its first and refused on write, rather than half-edited.
     *
     * Carries no id. Nothing addresses a campaign, and an undeclared key would be refused if the
     * caller sent this object back — which it is meant to be able to do.
     *
     * @var array<string,mixed>|null $campaign
     */
    #[Optional(map: 'mixed', nullable: true)]
    public ?array $campaign;

    /**
     * Every campaign this market registers, each with inherit saying whose it is — oldest first.
     *
     * A list, because a market can now be on more than one. POST
     * /v3/channels/sms/compliances/US/TEN_DLC/campaigns adds a campaign of the customer's own beside the one it has, and a
     * profile running on its organization's campaign keeps that one when it adds its own. Campaign
     * can only show one of them, so it stays as it was, for callers that read it, and this is where the rest
     * are.
     *
     * The organization's campaign reads "inherit": true and the customer's own read
     * "inherit": false. Each entry is the shape of Campaign plus id, the campaign's own
     * id, so several can be told apart. Campaign carries no id, because it is sent back to
     * PATCH, which refuses a key it does not declare; this list is read-only.
     *
     * Absent for a market that registers with nobody; empty for one that registers and has no campaign
     * yet.
     *
     * @var list<array<string,mixed>>|null $campaigns
     */
    #[Optional(list: new MapOf('mixed'), nullable: true)]
    public ?array $campaigns;

    /**
     * What has been supplied for this market.
     *
     * Files, not values — the declared halves above carry the values. A document cannot be a JSON value,
     * so it is sent as multipart on the channel call and reported here as a reference.
     *
     * Absent on a list read, which fetches identity but does not compute compliance documents per
     * market. Absent and empty mean different things: absent says the documents were not fetched; empty says
     * the market has been given none.
     *
     * @var list<SuppliedDocument>|null $documents
     */
    #[Optional(list: SuppliedDocument::class, nullable: true)]
    public ?array $documents;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param array<string,mixed>|null $brand
     * @param array<string,mixed>|null $campaign
     * @param list<array<string,mixed>>|null $campaigns
     * @param list<SuppliedDocument|SuppliedDocumentShape>|null $documents
     */
    public static function with(
        ?array $brand = null,
        ?array $campaign = null,
        ?array $campaigns = null,
        ?array $documents = null,
    ): self {
        $self = new self;

        null !== $brand && $self['brand'] = $brand;
        null !== $campaign && $self['campaign'] = $campaign;
        null !== $campaigns && $self['campaigns'] = $campaigns;
        null !== $documents && $self['documents'] = $documents;

        return $self;
    }

    /**
     * The identity this market registers under, with inherit saying whose it is.
     *
     * Reported here rather than on the profile because it belongs to the registration this market
     * files, and only one market files one. It was a top-level block for a while, which put a per-registration
     * value beside a list of markets and left a caller to work out which market it belonged to.
     *
     * Absent for a market that registers with nobody — such a market asks for no identity, so there is
     * none to report. Absent and null mean different things: absent says this market does not ask, null would
     * say it asks and nothing was supplied.
     *
     * Untyped, like the request side, because its members are declared by the market's own schema rather
     * than by a C# class. A typed pair here would be a second definition of what a market wants, free to drift
     * from the one that validates.
     *
     * @param array<string,mixed>|null $brand
     */
    public function withBrand(?array $brand): self
    {
        $self = clone $this;
        $self['brand'] = $brand;

        return $self;
    }

    /**
     * The programme this market registers, with inherit saying whose it is.
     *
     * One, not a list. TcrCampaigns permits several and an account built on the admin
     * side may hold them, but this surface offers one — which is what lets the market's PATCH be an
     * upsert rather than a collection with an addressable create behind it. An account holding several is
     * reported as its first and refused on write, rather than half-edited.
     *
     * Carries no id. Nothing addresses a campaign, and an undeclared key would be refused if the
     * caller sent this object back — which it is meant to be able to do.
     *
     * @param array<string,mixed>|null $campaign
     */
    public function withCampaign(?array $campaign): self
    {
        $self = clone $this;
        $self['campaign'] = $campaign;

        return $self;
    }

    /**
     * Every campaign this market registers, each with inherit saying whose it is — oldest first.
     *
     * A list, because a market can now be on more than one. POST
     * /v3/channels/sms/compliances/US/TEN_DLC/campaigns adds a campaign of the customer's own beside the one it has, and a
     * profile running on its organization's campaign keeps that one when it adds its own. Campaign
     * can only show one of them, so it stays as it was, for callers that read it, and this is where the rest
     * are.
     *
     * The organization's campaign reads "inherit": true and the customer's own read
     * "inherit": false. Each entry is the shape of Campaign plus id, the campaign's own
     * id, so several can be told apart. Campaign carries no id, because it is sent back to
     * PATCH, which refuses a key it does not declare; this list is read-only.
     *
     * Absent for a market that registers with nobody; empty for one that registers and has no campaign
     * yet.
     *
     * @param list<array<string,mixed>>|null $campaigns
     */
    public function withCampaigns(?array $campaigns): self
    {
        $self = clone $this;
        $self['campaigns'] = $campaigns;

        return $self;
    }

    /**
     * What has been supplied for this market.
     *
     * Files, not values — the declared halves above carry the values. A document cannot be a JSON value,
     * so it is sent as multipart on the channel call and reported here as a reference.
     *
     * Absent on a list read, which fetches identity but does not compute compliance documents per
     * market. Absent and empty mean different things: absent says the documents were not fetched; empty says
     * the market has been given none.
     *
     * @param list<SuppliedDocument|SuppliedDocumentShape>|null $documents
     */
    public function withDocuments(?array $documents): self
    {
        $self = clone $this;
        $self['documents'] = $documents;

        return $self;
    }
}
