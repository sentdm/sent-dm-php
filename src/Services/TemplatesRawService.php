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
use SentDm\Templates\Template;
use SentDm\Templates\TemplateCreateParams;
use SentDm\Templates\TemplateDefinition;
use SentDm\Templates\TemplateDeleteParams;
use SentDm\Templates\TemplateListParams;
use SentDm\Templates\TemplateRetrieveParams;
use SentDm\Templates\TemplateUpdateParams;
use SentDm\TemplatesPage;

/**
 * Reusable message bodies with named variables.
 *
 * A template is substituted at send time from the values you pass, so the copy lives here rather than in your application. WhatsApp templates additionally need Meta's approval before they can be sent, and a template's channel status reports where that stands — an approved SMS template and an unapproved WhatsApp one are the same template in two states.
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
     * Creates a new message template with header, body, footer, and buttons. The template can be submitted for review immediately or saved as draft for later submission. There is no `name` field on create — the display name is derived from the template's content and can be changed afterwards with `PUT /v3/templates/{id}`.
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
     * Updates an existing template's name, category, language, definition, or submits it for review. While the template is in review (status PENDING, or any channel awaiting a verdict) its definition, category and language are frozen and a resubmission is refused — those requests answer 409 CONFLICT_006. The display name stays editable throughout.
     *
     * `definition`, `category` and `language` are editable only from status DRAFT, REJECTED or APPROVED. An edit to any of them on a template in another state (PAUSED, DISABLED or REVOKED) is refused with 400 VALIDATION_001 and the detail "Template (except display name) cannot be updated unless it is in draft or rejected status"; `name` stays editable in every state. `submit_for_review` on a PAUSED, DISABLED or REVOKED template is accepted and answers 200, but opens no review and does not move the status — only the reviewer can reinstate it.
     *
     * Editing an APPROVED template is a live edit: the new content is stored immediately, and sending `submit_for_review: true` re-opens review, which returns the affected channels to PENDING so they stop sending until they are approved again. The previously approved content is never sent during re-review. Watch the per-channel `templates` webhook events rather than assuming the template-level status.
     *
     * Templates provisioned by Sent (light-onboarding templates, whose names carry the reserved `sent_` prefix) are read-only: every field is refused with 400 VALIDATION_001 and the detail "This template is read-only. Only 'submit for review' is allowed.", and only `submit_for_review` is accepted. A `name` starting with `sent_` is refused for the same reason — the prefix is reserved.
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
     *   category?: string|null,
     *   isWelcomePlayground?: bool|null,
     *   page?: int,
     *   pageSize?: int,
     *   search?: string|null,
     *   status?: string|null,
     *   xProfileID?: string,
     * }|TemplateListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TemplatesPage<Template>>
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
                'category',
                'isWelcomePlayground',
                'page',
                'pageSize',
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
                    'isWelcomePlayground' => 'is_welcome_playground',
                    'pageSize' => 'page_size',
                ],
            ),
            headers: Util::array_transform_keys(
                $header_params,
                ['xProfileID' => 'x-profile-id']
            ),
            options: $options,
            convert: Template::class,
            page: TemplatesPage::class,
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
