<?php

declare(strict_types=1);

namespace SentDm\Services;

use SentDm\Client;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Util;
use SentDm\Messages\MessageGetResponse;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\MessagesContract;

/**
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
final class MessagesService implements MessagesContract
{
    /**
     * @api
     */
    public MessagesRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new MessagesRawService($client);
    }

    /**
     * @api
     *
     * Retrieves comprehensive details about a specific message using the message ID. Returns complete message data including delivery status, channel information, template details, contact information, and pricing. The customer ID is extracted from the authentication token to ensure the message belongs to the authenticated customer.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): MessageGetResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($id, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Sends a message to a phone number using the default template. This endpoint is rate limited to 5 messages per customer per day. The customer ID is extracted from the authentication token.
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
    ): mixed {
        $params = Util::removeNulls(
            ['customMessage' => $customMessage, 'phoneNumber' => $phoneNumber]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->sendQuickMessage(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Sends a message to a specific contact using a template. The message can be sent via SMS or WhatsApp depending on the contact's capabilities. Optionally specify a webhook URL to receive delivery status updates. The customer ID is extracted from the authentication token.
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
    ): mixed {
        $params = Util::removeNulls(
            [
                'contactID' => $contactID,
                'templateID' => $templateID,
                'templateVariables' => $templateVariables,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->sendToContact(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Sends a message to a phone number using a template. The phone number doesn't need to be a pre-existing contact. The message can be sent via SMS or WhatsApp. Optionally specify a webhook URL to receive delivery status updates. The customer ID is extracted from the authentication token.
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
    ): mixed {
        $params = Util::removeNulls(
            [
                'phoneNumber' => $phoneNumber,
                'templateID' => $templateID,
                'templateVariables' => $templateVariables,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->sendToPhone(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
