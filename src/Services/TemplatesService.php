<?php

declare(strict_types=1);

namespace SentDm\Services;

use SentDm\Client;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Util;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\TemplatesContract;
use SentDm\Templates\APIResponseTemplate;
use SentDm\Templates\TemplateDefinition;
use SentDm\Templates\TemplateListResponse;

/**
 * Manage message templates with variable substitution.
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
     * Creates a new message template with header, body, footer, and buttons. The template can be submitted for review immediately or saved as draft for later submission.
     *
     * @param string|null $category Body param: Template category: MARKETING, UTILITY, AUTHENTICATION (optional, auto-detected if not provided)
     * @param string|null $creationSource Body param: Source of template creation (default: from-api)
     * @param TemplateDefinition|TemplateDefinitionShape $definition Body param: Template definition including header, body, footer, and buttons
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
     * Updates an existing template's name, category, language, definition, or submits it for review.
     *
     * @param string $id Path param: Template ID from route parameter
     * @param string|null $category Body param: Template category: MARKETING, UTILITY, AUTHENTICATION
     * @param TemplateDefinition|TemplateDefinitionShape|null $definition Body param: Template definition including header, body, footer, and buttons
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
     * @param int $page Query param: Page number (1-indexed)
     * @param int $pageSize Query param: Number of items per page
     * @param string|null $category Query param: Optional category filter: MARKETING, UTILITY, AUTHENTICATION
     * @param bool|null $isWelcomePlayground Query param: Optional filter by welcome playground flag
     * @param string|null $search Query param: Optional search term for filtering templates
     * @param string|null $status Query param: Optional status filter: APPROVED, PENDING, REJECTED
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        int $page,
        int $pageSize,
        ?string $category = null,
        ?bool $isWelcomePlayground = null,
        ?string $search = null,
        ?string $status = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): TemplateListResponse {
        $params = Util::removeNulls(
            [
                'page' => $page,
                'pageSize' => $pageSize,
                'category' => $category,
                'isWelcomePlayground' => $isWelcomePlayground,
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
