<?php

declare(strict_types=1);

namespace SentDm\Compliance;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * Everything a market expects of a sender, for one channel, country and sender type.
 *
 * @phpstan-import-type ComplianceSetupStepShape from \SentDm\Compliance\ComplianceSetupStep
 *
 * @phpstan-type ComplianceRequirementsShape = array{
 *   channel?: string|null,
 *   country?: string|null,
 *   required?: bool|null,
 *   requirements?: list<mixed>|null,
 *   senderIDPattern?: string|null,
 *   setup?: list<ComplianceSetupStep|ComplianceSetupStepShape>|null,
 *   type?: string|null,
 * }
 */
final class ComplianceRequirements implements BaseModel
{
    /** @use SdkModel<ComplianceRequirementsShape> */
    use SdkModel;

    /**
     * Channel the requirements apply to — sms, whatsapp or rcs.
     *
     * Echoed so the document says which channel it describes. It always described one: setup's
     * last step is a specific channel path, and every type is an SMS sender type — but a caller reading
     * the payload had to infer that from the path to know it.
     */
    #[Optional]
    public ?string $channel;

    /**
     * ISO 3166-1 alpha-2 country the requirements apply to.
     */
    #[Optional]
    public ?string $country;

    /**
     * Whether this market demands anything before a sender can be registered. When false, the
     * compliance array may be omitted entirely and the profile is ready once provisioned.
     */
    #[Optional]
    public ?bool $required;

    /**
     * Values to supply in compliance. Empty when the market demands nothing. Values Sent
     * supplies on your behalf are never listed, and neither are ones it derives from what you send.
     *
     * @var list<mixed>|null $requirements
     */
    #[Optional(list: ComplianceRequirement::class)]
    public ?array $requirements;

    /**
     * Pattern the sender's own value must match, where the market dictates one — alphanumeric
     * sender ids and short codes. Null when the value is carrier-assigned.
     */
    #[Optional('sender_id_pattern', nullable: true)]
    public ?string $senderIDPattern;

    /**
     * The calls that set this market up, in the order they have to be made, each carrying a body that can be
     * sent as it stands.
     *
     * This is the answer to "what do I actually do". Requirements describes each value
     * the market wants; this assembles those descriptions into the requests that supply them, so a caller — or an
     * agent acting for one — copies a body out and sends it rather than building one from a table.
     *
     * The last step is always the channel itself, and it is where the regime's own values are supplied.
     * The one before it, where there is one, is the brand a registering market files against — so it is a step of
     * its own and the channel call refuses until it exists. A market that registers with nobody has one step.
     *
     * @var list<ComplianceSetupStep>|null $setup
     */
    #[Optional(list: ComplianceSetupStep::class)]
    public ?array $setup;

    /**
     * Sender type the requirements apply to.
     *
     * Non-nullable while sms is the only channel answered here, because it is the only channel
     * whose senders have a type — the day another one is answered, this becomes nullable along with it. Not
     * nullable in advance: nothing can emit null today, and publishing a shape the API never sends is the
     * same mistake as publishing a field it does not have.
     */
    #[Optional]
    public ?string $type;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<mixed>|null $requirements
     * @param list<ComplianceSetupStep|ComplianceSetupStepShape>|null $setup
     */
    public static function with(
        ?string $channel = null,
        ?string $country = null,
        ?bool $required = null,
        ?array $requirements = null,
        ?string $senderIDPattern = null,
        ?array $setup = null,
        ?string $type = null,
    ): self {
        $self = new self;

        null !== $channel && $self['channel'] = $channel;
        null !== $country && $self['country'] = $country;
        null !== $required && $self['required'] = $required;
        null !== $requirements && $self['requirements'] = $requirements;
        null !== $senderIDPattern && $self['senderIDPattern'] = $senderIDPattern;
        null !== $setup && $self['setup'] = $setup;
        null !== $type && $self['type'] = $type;

        return $self;
    }

    /**
     * Channel the requirements apply to — sms, whatsapp or rcs.
     *
     * Echoed so the document says which channel it describes. It always described one: setup's
     * last step is a specific channel path, and every type is an SMS sender type — but a caller reading
     * the payload had to infer that from the path to know it.
     */
    public function withChannel(string $channel): self
    {
        $self = clone $this;
        $self['channel'] = $channel;

        return $self;
    }

    /**
     * ISO 3166-1 alpha-2 country the requirements apply to.
     */
    public function withCountry(string $country): self
    {
        $self = clone $this;
        $self['country'] = $country;

        return $self;
    }

    /**
     * Whether this market demands anything before a sender can be registered. When false, the
     * compliance array may be omitted entirely and the profile is ready once provisioned.
     */
    public function withRequired(bool $required): self
    {
        $self = clone $this;
        $self['required'] = $required;

        return $self;
    }

    /**
     * Values to supply in compliance. Empty when the market demands nothing. Values Sent
     * supplies on your behalf are never listed, and neither are ones it derives from what you send.
     *
     * @param list<mixed> $requirements
     */
    public function withRequirements(array $requirements): self
    {
        $self = clone $this;
        $self['requirements'] = $requirements;

        return $self;
    }

    /**
     * Pattern the sender's own value must match, where the market dictates one — alphanumeric
     * sender ids and short codes. Null when the value is carrier-assigned.
     */
    public function withSenderIDPattern(?string $senderIDPattern): self
    {
        $self = clone $this;
        $self['senderIDPattern'] = $senderIDPattern;

        return $self;
    }

    /**
     * The calls that set this market up, in the order they have to be made, each carrying a body that can be
     * sent as it stands.
     *
     * This is the answer to "what do I actually do". Requirements describes each value
     * the market wants; this assembles those descriptions into the requests that supply them, so a caller — or an
     * agent acting for one — copies a body out and sends it rather than building one from a table.
     *
     * The last step is always the channel itself, and it is where the regime's own values are supplied.
     * The one before it, where there is one, is the brand a registering market files against — so it is a step of
     * its own and the channel call refuses until it exists. A market that registers with nobody has one step.
     *
     * @param list<ComplianceSetupStep|ComplianceSetupStepShape> $setup
     */
    public function withSetup(array $setup): self
    {
        $self = clone $this;
        $self['setup'] = $setup;

        return $self;
    }

    /**
     * Sender type the requirements apply to.
     *
     * Non-nullable while sms is the only channel answered here, because it is the only channel
     * whose senders have a type — the day another one is answered, this becomes nullable along with it. Not
     * nullable in advance: nothing can emit null today, and publishing a shape the API never sends is the
     * same mistake as publishing a field it does not have.
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
