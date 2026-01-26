<?php

declare(strict_types=1);

namespace SentDm\Organizations;

use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Retrieves all sender profiles within an organization that the authenticated user has access to. Returns filtered list based on user's permissions.
 *
 * @see SentDm\Services\OrganizationsService::retrieveProfiles()
 *
 * @phpstan-type OrganizationRetrieveProfilesParamsShape = array{
 *   xAPIKey: string, xSenderID: string
 * }
 */
final class OrganizationRetrieveProfilesParams implements BaseModel
{
    /** @use SdkModel<OrganizationRetrieveProfilesParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $xAPIKey;

    #[Required]
    public string $xSenderID;

    /**
     * `new OrganizationRetrieveProfilesParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * OrganizationRetrieveProfilesParams::with(xAPIKey: ..., xSenderID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new OrganizationRetrieveProfilesParams)->withXAPIKey(...)->withXSenderID(...)
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
     */
    public static function with(string $xAPIKey, string $xSenderID): self
    {
        $self = new self;

        $self['xAPIKey'] = $xAPIKey;
        $self['xSenderID'] = $xSenderID;

        return $self;
    }

    public function withXAPIKey(string $xAPIKey): self
    {
        $self = clone $this;
        $self['xAPIKey'] = $xAPIKey;

        return $self;
    }

    public function withXSenderID(string $xSenderID): self
    {
        $self = clone $this;
        $self['xSenderID'] = $xSenderID;

        return $self;
    }
}
