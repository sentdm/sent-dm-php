<?php

declare(strict_types=1);

namespace SentDm\Services;

use SentDm\Client;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Util;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\TemplatesContract;
use SentDm\Templates\TemplateDefinition;
use SentDm\Templates\TemplateListResponse;
use SentDm\Templates\TemplateResponse;

/**
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
     * Creates a new message template for the authenticated customer with comprehensive template definitions including headers, body, footer, and interactive buttons. Supports automatic metadata generation using AI (display name, language, category). Optionally submits the template for WhatsApp review. The customer ID is extracted from the authentication token.
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
    ): TemplateResponse {
        $params = Util::removeNulls(
            [
                'definition' => $definition,
                'xAPIKey' => $xAPIKey,
                'xSenderID' => $xSenderID,
                'category' => $category,
                'language' => $language,
                'submitForReview' => $submitForReview,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Retrieves a specific message template by its unique identifier for the authenticated customer with comprehensive template definitions including headers, body, footer, and interactive buttons. The customer ID is extracted from the authentication token.
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
    ): TemplateResponse {
        $params = Util::removeNulls(
            ['xAPIKey' => $xAPIKey, 'xSenderID' => $xSenderID]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Retrieves all message templates available for the authenticated customer with comprehensive template definitions including headers, body, footer, and interactive buttons. Supports advanced filtering by search term, status, and category, plus pagination. The customer ID is extracted from the authentication token.
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
    ): TemplateListResponse {
        $params = Util::removeNulls(
            [
                'page' => $page,
                'pageSize' => $pageSize,
                'xAPIKey' => $xAPIKey,
                'xSenderID' => $xSenderID,
                'category' => $category,
                'search' => $search,
                'status' => $status,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Deletes a specific message template by its unique identifier for the authenticated customer with smart deletion strategy. Deletion behavior: - If template has NO messages: Permanently deleted from database (hard delete). - If template has messages: Marked as deleted but preserved for message history (soft delete with snapshot). The template must exist and belong to the authenticated customer to be deleted successfully. The customer ID is extracted from the authentication token.
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
    ): mixed {
        $params = Util::removeNulls(
            ['xAPIKey' => $xAPIKey, 'xSenderID' => $xSenderID]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
