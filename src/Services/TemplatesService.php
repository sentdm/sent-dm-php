<?php

declare(strict_types=1);

namespace SentDm\Services;

use SentDm\Client;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Util;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\TemplatesContract;
use SentDm\Templates\APIResponseTemplate;
use SentDm\Templates\Template;
use SentDm\Templates\TemplateDefinition;
use SentDm\TemplatesPage;

/**
 * Reusable message bodies with named variables.
 *
 * A template is substituted at send time from the values you pass, so the copy lives here rather than in your application. WhatsApp templates additionally need Meta's approval before they can be sent, and a template's channel status reports where that stands — an approved SMS template and an unapproved WhatsApp one are the same template in two states.
 *
 * @phpstan-import-type TemplateDefinitionShape from \SentDm\Templates\TemplateDefinition
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
final class TemplatesService implements TemplatesContract
{
    /**
     * @api
     */
    public TemplatesRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new TemplatesRawService($client);
    }

    /**
     * @api
     *
     * Creates a new message template with header, body, footer, and buttons. The template can be submitted for review immediately or saved as draft for later submission. There is no `name` field on create — the display name is derived from the template's content and can be changed afterwards with `PUT /v3/templates/{id}`.
     *
     * @param string|null $category Body param: Template category: MARKETING, UTILITY, AUTHENTICATION (optional, auto-detected if not provided)
     * @param string|null $creationSource Body param: Source of template creation (default: from-api)
     * @param TemplateDefinition|TemplateDefinitionShape $definition Body param: Complete definition of a message template including header, body, footer, and buttons
     * @param string|null $language Body param: Template language code (e.g., en_US) (optional, auto-detected if not provided)
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param bool $submitForReview Body param: Whether to submit the template for review after creation (default: false)
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        ?string $category = null,
        ?string $creationSource = null,
        TemplateDefinition|array|null $definition = null,
        ?string $language = null,
        ?bool $sandbox = null,
        ?bool $submitForReview = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseTemplate {
        $params = Util::removeNulls(
            [
                'category' => $category,
                'creationSource' => $creationSource,
                'definition' => $definition,
                'language' => $language,
                'sandbox' => $sandbox,
                'submitForReview' => $submitForReview,
                'idempotencyKey' => $idempotencyKey,
                'xProfileID' => $xProfileID,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Retrieves a specific template by its ID. Returns template details including name, category, language, status, and definition.
     *
     * @param string $id Template ID from route parameter
     * @param string $xProfileID Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseTemplate {
        $params = Util::removeNulls(['xProfileID' => $xProfileID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Updates an existing template's name, category, language, definition, or submits it for review. While the template is in review (status PENDING, or any channel awaiting a verdict) its definition, category and language are frozen and a resubmission is refused — those requests answer 409 CONFLICT_006. The display name stays editable throughout.
     *
     * `definition`, `category` and `language` are editable only from status DRAFT, REJECTED or APPROVED. An edit to any of them on a template in another state (PAUSED, DISABLED or REVOKED) is refused with 400 VALIDATION_001 and the detail "Template (except display name) cannot be updated unless it is in draft or rejected status"; `name` stays editable in every state. `submit_for_review` on a PAUSED, DISABLED or REVOKED template is accepted and answers 200, but opens no review and does not move the status — only the reviewer can reinstate it.
     *
     * Editing an APPROVED template is a live edit: the new content is stored immediately, and sending `submit_for_review: true` re-opens review, which returns the affected channels to PENDING so they stop sending until they are approved again. The previously approved content is never sent during re-review. Watch the per-channel `templates` webhook events rather than assuming the template-level status.
     *
     * Templates provisioned by Sent (light-onboarding templates, whose names carry the reserved `sent_` prefix) are read-only: every field is refused with 400 VALIDATION_001 and the detail "This template is read-only. Only 'submit for review' is allowed.", and only `submit_for_review` is accepted. A `name` starting with `sent_` is refused for the same reason — the prefix is reserved.
     *
     * @param string $id Path param: Template ID from route parameter
     * @param string|null $category Body param: Template category: MARKETING, UTILITY, AUTHENTICATION
     * @param TemplateDefinition|TemplateDefinitionShape|null $definition Body param: Complete definition of a message template including header, body, footer, and buttons
     * @param string|null $language Body param: Template language code (e.g., en_US)
     * @param string|null $name Body param: Template display name
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param bool $submitForReview Body param: Whether to submit the template for review after updating (default: false)
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $id,
        ?string $category = null,
        TemplateDefinition|array|null $definition = null,
        ?string $language = null,
        ?string $name = null,
        ?bool $sandbox = null,
        ?bool $submitForReview = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseTemplate {
        $params = Util::removeNulls(
            [
                'category' => $category,
                'definition' => $definition,
                'language' => $language,
                'name' => $name,
                'sandbox' => $sandbox,
                'submitForReview' => $submitForReview,
                'idempotencyKey' => $idempotencyKey,
                'xProfileID' => $xProfileID,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Retrieves a paginated list of message templates for the authenticated customer. Supports filtering by status, category, and search term.
     *
     * @param string|null $category Query param: Optional category filter: MARKETING, UTILITY, AUTHENTICATION
     * @param bool|null $isWelcomePlayground Query param: Accepted and ignored. It used to filter on the welcome-playground marker inside a template's LOB
     * details; that filter is gone and nothing reads this value, so sending it neither narrows nor
     * widens the result. Retained only so a client still passing is_welcome_playground keeps
     * binding instead of the request shape changing under it.
     * @param int $page Query param: Page number (1-indexed)
     * @param int $pageSize Query param: Number of items per page
     * @param string|null $search Query param: Optional search term for filtering templates
     * @param string|null $status Query param: Optional status filter: APPROVED, PENDING, REJECTED
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @return TemplatesPage<Template>
     *
     * @throws APIException
     */
    public function list(
        ?string $category = null,
        ?bool $isWelcomePlayground = null,
        ?int $page = null,
        ?int $pageSize = null,
        ?string $search = null,
        ?string $status = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): TemplatesPage {
        $params = Util::removeNulls(
            [
                'category' => $category,
                'isWelcomePlayground' => $isWelcomePlayground,
                'page' => $page,
                'pageSize' => $pageSize,
                'search' => $search,
                'status' => $status,
                'xProfileID' => $xProfileID,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Deletes a template by ID. Optionally, you can also delete the template from WhatsApp/Meta by setting delete_from_meta=true.
     *
     * @param string $id Path param: Template ID from route parameter
     * @param bool|null $deleteFromMeta Body param: Whether to also delete the template from WhatsApp/Meta (optional, defaults to false)
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $id,
        ?bool $deleteFromMeta = null,
        ?bool $sandbox = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): mixed {
        $params = Util::removeNulls(
            [
                'deleteFromMeta' => $deleteFromMeta,
                'sandbox' => $sandbox,
                'xProfileID' => $xProfileID,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
