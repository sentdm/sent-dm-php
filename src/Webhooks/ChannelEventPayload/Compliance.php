<?php

declare(strict_types=1);

namespace SentDm\Webhooks\ChannelEventPayload;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Webhooks\ChannelEventPayload\Compliance\Document;

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
 * @phpstan-import-type DocumentShape from \SentDm\Webhooks\ChannelEventPayload\Compliance\Document
 *
 * @phpstan-type ComplianceShape = array{
 *   brand?: array<string,mixed>|null,
 *   campaign?: array<string,mixed>|null,
 *   documents?: list<Document|DocumentShape>|null,
 * }
 */
final class Compliance implements BaseModel
{
    /** @use SdkModel<ComplianceShape> */
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
     * What has been supplied for this market.
     *
     * Files, not values — the declared halves above carry the values. A document cannot be a JSON value,
     * so it is sent as multipart on the channel call and reported here as a reference.
     *
     * Absent on a list read, which fetches identity but does not compute compliance documents per
     * market. Absent and empty mean different things: absent says the documents were not fetched; empty says
     * the market has been given none.
     *
     * @var list<Document>|null $documents
     */
    #[Optional(list: Document::class, nullable: true)]
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
     * @param list<Document|DocumentShape>|null $documents
     */
    public static function with(
        ?array $brand = null,
        ?array $campaign = null,
        ?array $documents = null
    ): self {
        $self = new self;

        null !== $brand && $self['brand'] = $brand;
        null !== $campaign && $self['campaign'] = $campaign;
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
     * What has been supplied for this market.
     *
     * Files, not values — the declared halves above carry the values. A document cannot be a JSON value,
     * so it is sent as multipart on the channel call and reported here as a reference.
     *
     * Absent on a list read, which fetches identity but does not compute compliance documents per
     * market. Absent and empty mean different things: absent says the documents were not fetched; empty says
     * the market has been given none.
     *
     * @param list<Document|DocumentShape>|null $documents
     */
    public function withDocuments(?array $documents): self
    {
        $self = clone $this;
        $self['documents'] = $documents;

        return $self;
    }
}
