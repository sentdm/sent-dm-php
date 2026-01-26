<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts;

use SentDm\Core\Exceptions\APIException;
use SentDm\RequestOptions;
use SentDm\Templates\TemplateDefinition;
use SentDm\Templates\TemplateListResponse;
use SentDm\Templates\TemplateResponse;

/**
 * @phpstan-import-type TemplateDefinitionShape from \SentDm\Templates\TemplateDefinition
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface TemplatesContract
{
    /**
     * @api
     *
     * @param TemplateDefinition|TemplateDefinitionShape $definition Body param: Template definition containing header, body, footer, and buttons
     * @param string $xAPIKey Header param
     * @param string $xSenderID Header param
     * @param string|null $category Body param: The template category (e.g., MARKETING, UTILITY, AUTHENTICATION). Can only be set when creating a new template. If not provided, will be auto-generated using AI.
     * @param string|null $language Body param: The template language code (e.g., en_US, es_ES). Can only be set when creating a new template. If not provided, will be auto-detected using AI.
     * @param bool $submitForReview Body param: When false, the template will be saved as draft.
     * When true, the template will be submitted for review.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        TemplateDefinition|array $definition,
        string $xAPIKey,
        string $xSenderID,
        ?string $category = null,
        ?string $language = null,
        ?bool $submitForReview = null,
        RequestOptions|array|null $requestOptions = null,
    ): TemplateResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        string $xAPIKey,
        string $xSenderID,
        RequestOptions|array|null $requestOptions = null,
    ): TemplateResponse;

    /**
     * @api
     *
     * @param int $page Query param: The page number (zero-indexed). Default is 0.
     * @param int $pageSize Query param: The number of items per page (1-1000). Default is 100.
     * @param string $xAPIKey Header param
     * @param string $xSenderID Header param
     * @param string|null $category Query param: Optional filter by template category (e.g., MARKETING, UTILITY, AUTHENTICATION)
     * @param string|null $search Query param: Optional search term to filter templates by name or content
     * @param string|null $status Query param: Optional filter by template status (e.g., APPROVED, PENDING, REJECTED, DRAFT)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        int $page,
        int $pageSize,
        string $xAPIKey,
        string $xSenderID,
        ?string $category = null,
        ?string $search = null,
        ?string $status = null,
        RequestOptions|array|null $requestOptions = null,
    ): TemplateListResponse;

    /**
     * @api
     *
     * @param string $id The unique identifier (GUID) of the resource to retrieve
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $id,
        string $xAPIKey,
        string $xSenderID,
        RequestOptions|array|null $requestOptions = null,
    ): mixed;
}
