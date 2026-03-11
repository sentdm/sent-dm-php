<?php

declare(strict_types=1);

namespace SentDm\Me;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Returns the account associated with the provided API key. The response includes account identity, contact information, messaging channel configuration, and — depending on the account type — either a list of child profiles or the profile's own settings.
 *
 * **Account types:**
 * - `organization` — Has child profiles. The `profiles` array is populated.
 * - `user` — Standalone account with no profiles.
 * - `profile` — Child of an organization. Includes `organization_id`, `short_name`, `status`, and `settings`.
 *
 * **Channels:**
 * The `channels` object always includes `sms`, `whatsapp`, and `rcs`. Each channel has a `configured` boolean. Configured channels expose additional details such as `phone_number`.
 *
 * @see SentDm\Services\MeService::retrieve()
 *
 * @phpstan-type MeRetrieveParamsShape = array{xProfileID?: string|null}
 */
final class MeRetrieveParams implements BaseModel
{
    /** @use SdkModel<MeRetrieveParamsShape> */
    use SdkModel;
    use SdkParams;

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
    public static function with(?string $xProfileID = null): self
    {
        $self = new self;

        null !== $xProfileID && $self['xProfileID'] = $xProfileID;

        return $self;
    }

    public function withXProfileID(string $xProfileID): self
    {
        $self = clone $this;
        $self['xProfileID'] = $xProfileID;

        return $self;
    }
}
