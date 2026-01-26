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
        string $xAPIKey,
        string $xSenderID,
        RequestOptions|array|null $requestOptions = null,
    ): MessageGetResponse;

    /**
     * @api
     *
     * @param string $customMessage Body param: The custom message content to include in the template
     * @param string $phoneNumber Body param: The phone number to send the message to, in international format (e.g., +1234567890)
     * @param string $xAPIKey Header param
     * @param string $xSenderID Header param
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function sendQuickMessage(
        string $customMessage,
        string $phoneNumber,
        string $xAPIKey,
        string $xSenderID,
        RequestOptions|array|null $requestOptions = null,
    ): mixed;

    /**
     * @api
     *
     * @param string $contactID Body param: The unique identifier of the contact to send the message to
     * @param string $templateID Body param: The unique identifier of the template to use for the message
     * @param string $xAPIKey Header param
     * @param string $xSenderID Header param
     * @param array<string,string>|null $templateVariables Body param: Optional key-value pairs of template variables to replace in the template body. For example, if your template contains "Hello {{name}}", you would provide { "name": "John Doe" }
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function sendToContact(
        string $contactID,
        string $templateID,
        string $xAPIKey,
        string $xSenderID,
        ?array $templateVariables = null,
        RequestOptions|array|null $requestOptions = null,
    ): mixed;

    /**
     * @api
     *
     * @param string $phoneNumber Body param: The phone number to send the message to, in international format (e.g., +1234567890)
     * @param string $templateID Body param: The unique identifier of the template to use for the message
     * @param string $xAPIKey Header param
     * @param string $xSenderID Header param
     * @param array<string,string>|null $templateVariables Body param: Optional key-value pairs of template variables to replace in the template body. For example, if your template contains "Hello {{name}}", you would provide { "name": "John Doe" }
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function sendToPhone(
        string $phoneNumber,
        string $templateID,
        string $xAPIKey,
        string $xSenderID,
        ?array $templateVariables = null,
        RequestOptions|array|null $requestOptions = null,
    ): mixed;
}
