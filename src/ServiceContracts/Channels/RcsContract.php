<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts\Channels;

use SentDm\Channels\Rcs\APIResponseOfRcsAgent;
use SentDm\Channels\Rcs\RcCreateParams\AgentUseCase;
use SentDm\Channels\Rcs\RcsAddress;
use SentDm\Core\Exceptions\APIException;
use SentDm\RequestOptions;

/**
 * @phpstan-import-type RcsAddressShape from \SentDm\Channels\Rcs\RcsAddress
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface RcsContract
{
    /**
     * @api
     *
     * @param AgentUseCase|value-of<AgentUseCase> $agentUseCase Body param: Which kind of traffic the agent carries. One of the accepted use cases; the error names the set.
     * @param string $bannerURL Body param
     * @param string $brandColor Body param: Primary brand colour, as #RRGGBB. Three-digit shorthand is refused: the value is submitted
     * verbatim, so two spellings of one colour is only a way for the stored value to disagree with the form.
     * @param string $brandEmail Body param
     * @param string $brandName Body param: The brand this agent presents over RCS.
     *
     * Not taken from your compliance.brand: a business may present a different brand on RCS than
     * the one its 10DLC registration is filed against, and the carriers vet this one.
     * @param string $brandPhoneNumber Body param: The brand's own number. Also becomes the agent's canonical sending number for routing, which is why it
     * is normalised to E.164 rather than stored as sent.
     * @param string $briefCompanyDescription Body param
     * @param string $companyEin Body param
     * @param string $contactNameAndTitle Body param
     * @param string $customerSupportEmail Body param
     * @param string $customerSupportPhoneNumber Body param
     * @param string $description Body param: What the agent is for, shown to recipients. Capped by the carriers, not by us.
     * @param string $displayName body param: The name the agent shows in the messaging client
     * @param string $entityType Body param
     * @param string $helpMessage Body param
     * @param string $logoURL Body param: Publicly reachable logo. It has to be fetchable without authentication at review time, so a URL behind
     * a login passes this call and fails the review.
     * @param RcsAddress|RcsAddressShape $officialAddress body param: The registered address of the company behind the agent
     * @param string $optInProcessDescription Body param: How recipients opt in, in prose. The carriers read this one.
     * @param string|null $optInScreenshotURL body param: A screenshot of the opt-in, as a publicly fetchable URL
     * @param string $privacyPolicyURL Body param: Required by US carriers. Must be an absolute http(s) URL they can fetch.
     * @param list<string> $sampleMessages body param: Examples of what the agent will send, for the review
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string $startMessage Body param
     * @param string $stopMessage Body param
     * @param string $termsAndConditionsURL Body param
     * @param string $websiteURL body param: The brand's own site
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        AgentUseCase|string|null $agentUseCase = null,
        ?string $bannerURL = null,
        ?string $brandColor = null,
        ?string $brandEmail = null,
        ?string $brandName = null,
        ?string $brandPhoneNumber = null,
        ?string $briefCompanyDescription = null,
        ?string $companyEin = null,
        ?string $contactNameAndTitle = null,
        ?string $customerSupportEmail = null,
        ?string $customerSupportPhoneNumber = null,
        ?string $description = null,
        ?string $displayName = null,
        ?string $entityType = null,
        ?string $helpMessage = null,
        ?string $logoURL = null,
        RcsAddress|array|null $officialAddress = null,
        ?string $optInProcessDescription = null,
        ?string $optInScreenshotURL = null,
        ?string $privacyPolicyURL = null,
        ?array $sampleMessages = null,
        ?bool $sandbox = null,
        ?string $startMessage = null,
        ?string $stopMessage = null,
        ?string $termsAndConditionsURL = null,
        ?string $websiteURL = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfRcsAgent;
}
