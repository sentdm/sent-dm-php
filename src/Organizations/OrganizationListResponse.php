<?php

declare(strict_types=1);

namespace SentDm\Organizations;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Organizations\OrganizationListResponse\Organization;

/**
 * @phpstan-import-type OrganizationShape from \SentDm\Organizations\OrganizationListResponse\Organization
 *
 * @phpstan-type OrganizationListResponseShape = array{
 *   organizations?: list<Organization|OrganizationShape>|null
 * }
 */
final class OrganizationListResponse implements BaseModel
{
    /** @use SdkModel<OrganizationListResponseShape> */
    use SdkModel;

    /** @var list<Organization>|null $organizations */
    #[Optional(list: Organization::class)]
    public ?array $organizations;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<Organization|OrganizationShape>|null $organizations
     */
    public static function with(?array $organizations = null): self
    {
        $self = new self;

        null !== $organizations && $self['organizations'] = $organizations;

        return $self;
    }

    /**
     * @param list<Organization|OrganizationShape> $organizations
     */
    public function withOrganizations(array $organizations): self
    {
        $self = clone $this;
        $self['organizations'] = $organizations;

        return $self;
    }
}
