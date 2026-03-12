<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts;

use SentDm\Core\Exceptions\APIException;
use SentDm\RequestOptions;
use SentDm\Templates\APIResponseTemplate;
use SentDm\Templates\TemplateDefinition;
use SentDm\Templates\TemplateListResponse;

/**
 * @phpstan-import-type TemplateDefinitionShape from \SentDm\Templates\TemplateDefinition
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface TemplatesContract
{
    /**
     * @api
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
    ): APIResponseTemplate;

    /**
     * @api
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
    ): APIResponseTemplate;

    /**
     * @api
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
    ): APIResponseTemplate;

    /**
     * @api
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
    ): TemplateListResponse;

    /**
     * @api
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
    ): mixed;
}
