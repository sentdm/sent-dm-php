<?php

declare(strict_types=1);

namespace SentDm\Profiles\Campaigns\CampaignUpdateParams;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Profiles\Campaigns\CampaignUpdateParams\Campaign\UseCase;

/**
 * Campaign data for create or update operation.
 *
 * @phpstan-import-type UseCaseShape from \SentDm\Profiles\Campaigns\CampaignUpdateParams\Campaign\UseCase
 *
 * @phpstan-type CampaignShape = array{
 *   description: string,
 *   name: string,
 *   type: string,
 *   useCases: list<UseCase|UseCaseShape>,
 *   helpKeywords?: string|null,
 *   helpMessage?: string|null,
 *   messageFlow?: string|null,
 *   optinKeywords?: string|null,
 *   optinMessage?: string|null,
 *   optoutKeywords?: string|null,
 *   optoutMessage?: string|null,
 *   privacyPolicyLink?: string|null,
 *   termsAndConditionsLink?: string|null,
 * }
 */
final class Campaign implements BaseModel
{
    /** @use SdkModel<CampaignShape> */
    use SdkModel;

    /**
     * Campaign description.
     */
    #[Required]
    public string $description;

    /**
     * Campaign name.
     */
    #[Required]
    public string $name;

    /**
     * Campaign type (e.g., "KYC", "App").
     */
    #[Required]
    public string $type;

    /**
     * List of use cases with sample messages.
     *
     * @var list<UseCase> $useCases
     */
    #[Required(list: UseCase::class)]
    public array $useCases;

    /**
     * Comma-separated keywords that trigger help message (e.g., "HELP, INFO, SUPPORT").
     */
    #[Optional(nullable: true)]
    public ?string $helpKeywords;

    /**
     * Message sent when user requests help.
     */
    #[Optional(nullable: true)]
    public ?string $helpMessage;

    /**
     * Description of how messages flow in the campaign.
     */
    #[Optional(nullable: true)]
    public ?string $messageFlow;

    /**
     * Comma-separated keywords that trigger opt-in (e.g., "YES, START, SUBSCRIBE").
     */
    #[Optional(nullable: true)]
    public ?string $optinKeywords;

    /**
     * Message sent when user opts in.
     */
    #[Optional(nullable: true)]
    public ?string $optinMessage;

    /**
     * Comma-separated keywords that trigger opt-out (e.g., "STOP, UNSUBSCRIBE, END").
     */
    #[Optional(nullable: true)]
    public ?string $optoutKeywords;

    /**
     * Message sent when user opts out.
     */
    #[Optional(nullable: true)]
    public ?string $optoutMessage;

    /**
     * URL to privacy policy.
     */
    #[Optional(nullable: true)]
    public ?string $privacyPolicyLink;

    /**
     * URL to terms and conditions.
     */
    #[Optional(nullable: true)]
    public ?string $termsAndConditionsLink;

    /**
     * `new Campaign()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Campaign::with(description: ..., name: ..., type: ..., useCases: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Campaign)
     *   ->withDescription(...)
     *   ->withName(...)
     *   ->withType(...)
     *   ->withUseCases(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<UseCase|UseCaseShape> $useCases
     */
    public static function with(
        string $description,
        string $name,
        string $type,
        array $useCases,
        ?string $helpKeywords = null,
        ?string $helpMessage = null,
        ?string $messageFlow = null,
        ?string $optinKeywords = null,
        ?string $optinMessage = null,
        ?string $optoutKeywords = null,
        ?string $optoutMessage = null,
        ?string $privacyPolicyLink = null,
        ?string $termsAndConditionsLink = null,
    ): self {
        $self = new self;

        $self['description'] = $description;
        $self['name'] = $name;
        $self['type'] = $type;
        $self['useCases'] = $useCases;

        null !== $helpKeywords && $self['helpKeywords'] = $helpKeywords;
        null !== $helpMessage && $self['helpMessage'] = $helpMessage;
        null !== $messageFlow && $self['messageFlow'] = $messageFlow;
        null !== $optinKeywords && $self['optinKeywords'] = $optinKeywords;
        null !== $optinMessage && $self['optinMessage'] = $optinMessage;
        null !== $optoutKeywords && $self['optoutKeywords'] = $optoutKeywords;
        null !== $optoutMessage && $self['optoutMessage'] = $optoutMessage;
        null !== $privacyPolicyLink && $self['privacyPolicyLink'] = $privacyPolicyLink;
        null !== $termsAndConditionsLink && $self['termsAndConditionsLink'] = $termsAndConditionsLink;

        return $self;
    }

    /**
     * Campaign description.
     */
    public function withDescription(string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * Campaign name.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Campaign type (e.g., "KYC", "App").
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * List of use cases with sample messages.
     *
     * @param list<UseCase|UseCaseShape> $useCases
     */
    public function withUseCases(array $useCases): self
    {
        $self = clone $this;
        $self['useCases'] = $useCases;

        return $self;
    }

    /**
     * Comma-separated keywords that trigger help message (e.g., "HELP, INFO, SUPPORT").
     */
    public function withHelpKeywords(?string $helpKeywords): self
    {
        $self = clone $this;
        $self['helpKeywords'] = $helpKeywords;

        return $self;
    }

    /**
     * Message sent when user requests help.
     */
    public function withHelpMessage(?string $helpMessage): self
    {
        $self = clone $this;
        $self['helpMessage'] = $helpMessage;

        return $self;
    }

    /**
     * Description of how messages flow in the campaign.
     */
    public function withMessageFlow(?string $messageFlow): self
    {
        $self = clone $this;
        $self['messageFlow'] = $messageFlow;

        return $self;
    }

    /**
     * Comma-separated keywords that trigger opt-in (e.g., "YES, START, SUBSCRIBE").
     */
    public function withOptinKeywords(?string $optinKeywords): self
    {
        $self = clone $this;
        $self['optinKeywords'] = $optinKeywords;

        return $self;
    }

    /**
     * Message sent when user opts in.
     */
    public function withOptinMessage(?string $optinMessage): self
    {
        $self = clone $this;
        $self['optinMessage'] = $optinMessage;

        return $self;
    }

    /**
     * Comma-separated keywords that trigger opt-out (e.g., "STOP, UNSUBSCRIBE, END").
     */
    public function withOptoutKeywords(?string $optoutKeywords): self
    {
        $self = clone $this;
        $self['optoutKeywords'] = $optoutKeywords;

        return $self;
    }

    /**
     * Message sent when user opts out.
     */
    public function withOptoutMessage(?string $optoutMessage): self
    {
        $self = clone $this;
        $self['optoutMessage'] = $optoutMessage;

        return $self;
    }

    /**
     * URL to privacy policy.
     */
    public function withPrivacyPolicyLink(?string $privacyPolicyLink): self
    {
        $self = clone $this;
        $self['privacyPolicyLink'] = $privacyPolicyLink;

        return $self;
    }

    /**
     * URL to terms and conditions.
     */
    public function withTermsAndConditionsLink(
        ?string $termsAndConditionsLink
    ): self {
        $self = clone $this;
        $self['termsAndConditionsLink'] = $termsAndConditionsLink;

        return $self;
    }
}
