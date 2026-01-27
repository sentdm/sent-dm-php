<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts;

use SentDm\Core\Exceptions\APIException;
use SentDm\Messages\MessageGetResponse;
use SentDm\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface MessagesContract
{
    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): MessageGetResponse;

    /**
     * @api
     *
     * @param string $customMessage The custom message content to include in the template
     * @param string $phoneNumber The phone number to send the message to, in international format (e.g., +1234567890)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function sendQuickMessage(
        string $customMessage,
        string $phoneNumber,
        RequestOptions|array|null $requestOptions = null,
    ): mixed;

    /**
     * @api
     *
     * @param string $contactID The unique identifier of the contact to send the message to
     * @param string $templateID The unique identifier of the template to use for the message
     * @param array<string,string>|null $templateVariables Optional key-value pairs of template variables to replace in the template body. For example, if your template contains "Hello {{name}}", you would provide { "name": "John Doe" }
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function sendToContact(
        string $contactID,
        string $templateID,
        ?array $templateVariables = null,
        RequestOptions|array|null $requestOptions = null,
    ): mixed;

    /**
     * @api
     *
     * @param string $phoneNumber The phone number to send the message to, in international format (e.g., +1234567890)
     * @param string $templateID The unique identifier of the template to use for the message
     * @param array<string,string>|null $templateVariables Optional key-value pairs of template variables to replace in the template body. For example, if your template contains "Hello {{name}}", you would provide { "name": "John Doe" }
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function sendToPhone(
        string $phoneNumber,
        string $templateID,
        ?array $templateVariables = null,
        RequestOptions|array|null $requestOptions = null,
    ): mixed;
}
