<?php

declare(strict_types=1);

namespace SentDm\Services;

use SentDm\Client;
use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Util;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\TemplatesRawContract;
use SentDm\Templates\APIResponseTemplate;
use SentDm\Templates\TemplateCreateParams;
use SentDm\Templates\TemplateDefinition;
use SentDm\Templates\TemplateDeleteParams;
use SentDm\Templates\TemplateListParams;
use SentDm\Templates\TemplateListResponse;
use SentDm\Templates\TemplateRetrieveParams;
use SentDm\Templates\TemplateUpdateParams;

/**
 * Manage message templates with variable substitution.
 *
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
     * Creates a new message template with header, body, footer, and buttons. The template can be submitted for review immediately or saved as draft for later submission.
     *
     * @param array{
     *   category?: string|null,
     *   creationSource?: string|null,
     *   definition?: TemplateDefinition|TemplateDefinitionShape,
     *   language?: string|null,
     *   sandbox?: bool,
     *   submitForReview?: bool,
     *   idempotencyKey?: string,
     *   xProfileID?: string,
     * }|TemplateCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseTemplate>
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
        $header_params = [
            'idempotencyKey' => 'Idempotency-Key', 'xProfileID' => 'x-profile-id',
        ];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v3/templates',
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: APIResponseTemplate::class,
        );
    }

    /**
     * @api
     *
     * Retrieves a specific template by its ID. Returns template details including name, category, language, status, and definition.
     *
     * @param string $id Template ID from route parameter
     * @param array{xProfileID?: string}|TemplateRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseTemplate>
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        array|TemplateRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TemplateRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v3/templates/%1$s', $id],
            headers: Util::array_transform_keys(
                $parsed,
                ['xProfileID' => 'x-profile-id']
            ),
            options: $options,
            convert: APIResponseTemplate::class,
        );
    }

    /**
     * @api
     *
     * Updates an existing template's name, category, language, definition, or submits it for review.
     *
     * @param string $id Path param: Template ID from route parameter
     * @param array{
     *   category?: string|null,
     *   definition?: TemplateDefinition|TemplateDefinitionShape|null,
     *   language?: string|null,
     *   name?: string|null,
     *   sandbox?: bool,
     *   submitForReview?: bool,
     *   idempotencyKey?: string,
     *   xProfileID?: string,
     * }|TemplateUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseTemplate>
     *
     * @throws APIException
     */
    public function update(
        string $id,
        array|TemplateUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TemplateUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = [
            'idempotencyKey' => 'Idempotency-Key', 'xProfileID' => 'x-profile-id',
        ];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'put',
            path: ['v3/templates/%1$s', $id],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: APIResponseTemplate::class,
        );
    }

    /**
     * @api
     *
     * Retrieves a paginated list of message templates for the authenticated customer. Supports filtering by status, category, and search term.
     *
     * @param array{
     *   page: int,
     *   pageSize: int,
     *   category?: string|null,
     *   isWelcomePlayground?: bool|null,
     *   search?: string|null,
     *   status?: string|null,
     *   xProfileID?: string,
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
        $query_params = array_flip(
            [
                'page',
                'pageSize',
                'category',
                'isWelcomePlayground',
                'search',
                'status',
            ],
        );

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v3/templates',
            query: Util::array_transform_keys(
                array_intersect_key($parsed, $query_params),
                [
                    'pageSize' => 'page_size',
                    'isWelcomePlayground' => 'is_welcome_playground',
                ],
            ),
            headers: Util::array_transform_keys(
                $header_params,
                ['xProfileID' => 'x-profile-id']
            ),
            options: $options,
            convert: TemplateListResponse::class,
        );
    }

    /**
     * @api
     *
     * Deletes a template by ID. Optionally, you can also delete the template from WhatsApp/Meta by setting delete_from_meta=true.
     *
     * @param string $id Path param: Template ID from route parameter
     * @param array{
     *   deleteFromMeta?: bool|null, sandbox?: bool, xProfileID?: string
     * }|TemplateDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function delete(
        string $id,
        array|TemplateDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TemplateDeleteParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['xProfileID' => 'x-profile-id'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v3/templates/%1$s', $id],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: null,
        );
    }
}
