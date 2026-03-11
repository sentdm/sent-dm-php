# Sent Dm PHP API library

The Sent Dm PHP library provides convenient access to the Sent Dm REST API from any PHP 8.1.0+ application.

It is generated with [Stainless](https://www.stainless.com/).

## Documentation

The REST API documentation can be found on [docs.sent.dm](https://docs.sent.dm).

## Installation

<!-- x-release-please-start-version -->

```
composer require "sentdm/sent-dm-php 0.7.0"
```

<!-- x-release-please-end -->

## Usage

This library uses named parameters to specify optional arguments.
Parameters with a default value must be set by name.

```php
<?php

use SentDm\Client;

$client = new Client(apiKey: getenv('SENT_DM_API_KEY') ?: 'My API Key');

$response = $client->messages->send(
  channel: ['sms', 'whatsapp'],
  template: [
    'id' => '7ba7b820-9dad-11d1-80b4-00c04fd430c8',
    'name' => 'order_confirmation',
    'parameters' => ['name' => 'John Doe', 'order_id' => '12345'],
  ],
  to: ['+14155551234', '+14155555678'],
);

var_dump($response->data);
```

### Value Objects

It is recommended to use the static `with` constructor `TemplateDefinition::with(body: (object)[], ...)`
and named parameters to initialize value objects.

However, builders are also provided `(new TemplateDefinition)->withBody((object)[])`.

### Handling errors

When the library is unable to connect to the API, or if the API returns a non-success status code (i.e., 4xx or 5xx response), a subclass of `SentDm\Core\Exceptions\APIException` will be thrown:

```php
<?php

use SentDm\Core\Exceptions\APIConnectionException;
use SentDm\Core\Exceptions\RateLimitException;
use SentDm\Core\Exceptions\APIStatusException;

try {
  $response = $client->messages->send();
} catch (APIConnectionException $e) {
  echo "The server could not be reached", PHP_EOL;
  var_dump($e->getPrevious());
} catch (RateLimitException $e) {
  echo "A 429 status code was received; we should back off a bit.", PHP_EOL;
} catch (APIStatusException $e) {
  echo "Another non-200-range status code was received", PHP_EOL;
  echo $e->getMessage();
}
```

Error codes are as follows:

| Cause            | Error Type                     |
| ---------------- | ------------------------------ |
| HTTP 400         | `BadRequestException`          |
| HTTP 401         | `AuthenticationException`      |
| HTTP 403         | `PermissionDeniedException`    |
| HTTP 404         | `NotFoundException`            |
| HTTP 409         | `ConflictException`            |
| HTTP 422         | `UnprocessableEntityException` |
| HTTP 429         | `RateLimitException`           |
| HTTP >= 500      | `InternalServerException`      |
| Other HTTP error | `APIStatusException`           |
| Timeout          | `APITimeoutException`          |
| Network error    | `APIConnectionException`       |

### Retries

Certain errors will be automatically retried 2 times by default, with a short exponential backoff.

Connection errors (for example, due to a network connectivity problem), 408 Request Timeout, 409 Conflict, 429 Rate Limit, >=500 Internal errors, and timeouts will all be retried by default.

You can use the `maxRetries` option to configure or disable this:

```php
<?php

use SentDm\Client;

// Configure the default for all requests:
$client = new Client(requestOptions: ['maxRetries' => 0]);

// Or, configure per-request:
$result = $client->messages->send(
  channel: ['sms'],
  template: [
    'id' => '7ba7b820-9dad-11d1-80b4-00c04fd430c8',
    'name' => 'order_confirmation',
    'parameters' => ['name' => 'John Doe', 'order_id' => '12345'],
  ],
  to: ['+14155551234'],
  requestOptions: ['maxRetries' => 5],
);
```

## Advanced concepts

### Making custom or undocumented requests

#### Undocumented properties

You can send undocumented parameters to any endpoint, and read undocumented response properties, like so:

Note: the `extra*` parameters of the same name overrides the documented parameters.

```php
<?php

$response = $client->messages->send(
  channel: ['sms'],
  template: [
    'id' => '7ba7b820-9dad-11d1-80b4-00c04fd430c8',
    'name' => 'order_confirmation',
    'parameters' => ['name' => 'John Doe', 'order_id' => '12345'],
  ],
  to: ['+14155551234'],
  requestOptions: [
    'extraQueryParams' => ['my_query_parameter' => 'value'],
    'extraBodyParams' => ['my_body_parameter' => 'value'],
    'extraHeaders' => ['my-header' => 'value'],
  ],
);
```

#### Undocumented request params

If you want to explicitly send an extra param, you can do so with the `extra_query`, `extra_body`, and `extra_headers` under the `request_options:` parameter when making a request, as seen in the examples above.

#### Undocumented endpoints

To make requests to undocumented endpoints while retaining the benefit of auth, retries, and so on, you can make requests using `client.request`, like so:

```php
<?php

$response = $client->request(
  method: "post",
  path: '/undocumented/endpoint',
  query: ['dog' => 'woof'],
  headers: ['useful-header' => 'interesting-value'],
  body: ['hello' => 'world']
);
```

## Versioning

This package follows [SemVer](https://semver.org/spec/v2.0.0.html) conventions. As the library is in initial development and has a major version of `0`, APIs may change at any time.

This package considers improvements to the (non-runtime) PHPDoc type definitions to be non-breaking changes.

## Requirements

PHP 8.1.0 or higher.

## Contributing

See [the contributing documentation](https://github.com/sentdm/sent-dm-php/tree/main/CONTRIBUTING.md).
