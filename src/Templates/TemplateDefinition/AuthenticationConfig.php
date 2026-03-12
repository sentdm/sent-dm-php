<?php

declare(strict_types=1);

namespace SentDm\Templates\TemplateDefinition;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * Configuration for AUTHENTICATION category templates.
 *
 * @phpstan-type AuthenticationConfigShape = array{
 *   addSecurityRecommendation?: bool|null, codeExpirationMinutes?: int|null
 * }
 */
final class AuthenticationConfig implements BaseModel
{
    /** @use SdkModel<AuthenticationConfigShape> */
    use SdkModel;

    /**
     * Whether to add the security recommendation text: "For your security, do not share this code.".
     */
    #[Optional]
    public ?bool $addSecurityRecommendation;

    /**
     * Code expiration time in minutes (1-90). If set, adds footer: "This code expires in X minutes.".
     */
    #[Optional(nullable: true)]
    public ?int $codeExpirationMinutes;

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
        ?bool $addSecurityRecommendation = null,
        ?int $codeExpirationMinutes = null
    ): self {
        $self = new self;

        null !== $addSecurityRecommendation && $self['addSecurityRecommendation'] = $addSecurityRecommendation;
        null !== $codeExpirationMinutes && $self['codeExpirationMinutes'] = $codeExpirationMinutes;

        return $self;
    }

    /**
     * Whether to add the security recommendation text: "For your security, do not share this code.".
     */
    public function withAddSecurityRecommendation(
        bool $addSecurityRecommendation
    ): self {
        $self = clone $this;
        $self['addSecurityRecommendation'] = $addSecurityRecommendation;

        return $self;
    }

    /**
     * Code expiration time in minutes (1-90). If set, adds footer: "This code expires in X minutes.".
     */
    public function withCodeExpirationMinutes(?int $codeExpirationMinutes): self
    {
        $self = clone $this;
        $self['codeExpirationMinutes'] = $codeExpirationMinutes;

        return $self;
    }
}
