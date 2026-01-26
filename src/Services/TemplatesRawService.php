<?php

declare(strict_types=1);

namespace SentDm\Services;

use SentDm\Client;
use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\TemplatesRawContract;
use SentDm\Templates\TemplateCreateParams;
use SentDm\Templates\TemplateDefinition;
use SentDm\Templates\TemplateListParams;
use SentDm\Templates\TemplateListResponse;
use SentDm\Templates\TemplateResponse;

/**
 * @phpstan-import-type TemplateDefinitionShape from \SentDm\Templates\TemplateDefinition
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
final class TemplatesRawService implements TemplatesRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Creates a new message template for the authenticated customer with comprehensive template definitions including headers, body, footer, and interactive buttons. Supports automatic metadata generation using AI (display name, language, category). Optionally submits the template for WhatsApp review. The customer ID is extracted from the authentication token.
     *
     * @param array{
     *   definition: TemplateDefinition|TemplateDefinitionShape,
     *   category?: string|null,
     *   language?: string|null,
     *   submitForReview?: bool,
     * }|TemplateCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TemplateResponse>
     *
     * @throws APIException
     */
    public function create(
        array|TemplateCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TemplateCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v2/templates',
            body: (object) $parsed,
            options: $options,
            convert: TemplateResponse::class,
        );
    }

    /**
     * @api
     *
     * Retrieves a specific message template by its unique identifier for the authenticated customer with comprehensive template definitions including headers, body, footer, and interactive buttons. The customer ID is extracted from the authentication token.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TemplateResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v2/templates/%1$s', $id],
            options: $requestOptions,
            convert: TemplateResponse::class,
        );
    }

    /**
     * @api
     *
     * Retrieves all message templates available for the authenticated customer with comprehensive template definitions including headers, body, footer, and interactive buttons. Supports advanced filtering by search term, status, and category, plus pagination. The customer ID is extracted from the authentication token.
     *
     * @param array{
     *   page: int,
     *   pageSize: int,
     *   category?: string|null,
     *   search?: string|null,
     *   status?: string|null,
     * }|TemplateListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TemplateListResponse>
     *
     * @throws APIException
     */
    public function list(
        array|TemplateListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TemplateListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v2/templates',
            query: $parsed,
            options: $options,
            convert: TemplateListResponse::class,
        );
    }

    /**
     * @api
     *
     * Deletes a specific message template by its unique identifier for the authenticated customer with smart deletion strategy. Deletion behavior: - If template has NO messages: Permanently deleted from database (hard delete). - If template has messages: Marked as deleted but preserved for message history (soft delete with snapshot). The template must exist and belong to the authenticated customer to be deleted successfully. The customer ID is extracted from the authentication token.
     *
     * @param string $id The unique identifier (GUID) of the resource to retrieve
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function delete(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v2/templates/%1$s', $id],
            options: $requestOptions,
            convert: null,
        );
    }
}
