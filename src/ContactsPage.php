<?php

namespace SentDm;

use Psr\Http\Message\ResponseInterface;
use SentDm\ContactsPage\Data;
use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkPage;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Core\Contracts\BasePage;
use SentDm\Core\Conversion;
use SentDm\Core\Conversion\Contracts\Converter;
use SentDm\Core\Conversion\Contracts\ConverterSource;
use SentDm\Core\Conversion\ListOf;
use SentDm\Core\Util;

/**
 * @phpstan-type ContactsPageShape = array{data?: Data|null}
 *
 * @template TItem
 *
 * @implements BasePage<TItem>
 */
final class ContactsPage implements BaseModel, BasePage
{
    /** @use SdkModel<ContactsPageShape> */
    use SdkModel;

    /** @use SdkPage<TItem> */
    use SdkPage;

    #[Optional]
    public ?Data $data;

    /**
     * @internal
     *
     * @param array{
     *   method: string,
     *   path: string,
     *   query: array<string,mixed>,
     *   headers: array<string,string|list<string>|null>,
     *   body: mixed,
     * } $requestInfo
     */
    public function __construct(
        private string|Converter|ConverterSource $convert,
        private Client $client,
        private array $requestInfo,
        private RequestOptions $options,
        private ResponseInterface $response,
        private mixed $parsedBody,
    ) {
        $this->initialize();

        if (!is_array($this->parsedBody)) {
            return;
        }

        // @phpstan-ignore-next-line argument.type
        self::__unserialize($this->parsedBody);

        if (is_array($items = $this->data?->offsetGet('contacts'))) {
            $parsed = Conversion::coerce(new ListOf($convert), value: $items);
            // @phpstan-ignore-next-line
            $this->data->offsetSet('contacts', value: $parsed);
        }
    }

    /** @return list<TItem> */
    public function getItems(): array
    {
        // @phpstan-ignore-next-line return.type
        return $this->data?->offsetGet('contacts') ?? [];
    }

    /**
     * @internal
     *
     * @return array{
     *   array{
     *     method: string,
     *     path: string,
     *     query: array<string,mixed>,
     *     headers: array<string,string|list<string>|null>,
     *     body: mixed,
     *   },
     *   RequestOptions,
     * }|null
     */
    public function nextRequest(): ?array
    {
        /** @var int */
        $curr = Util::dig($this->requestInfo, ['query', 'page']) ?? 1;
        if (!($this
            ->data->pagination->hasMore ?? null) || !count($this->getItems())) {
            return null;
        }

        $nextRequest = array_merge_recursive(
            $this->requestInfo,
            ['query' => $curr + 1]
        );

        // @phpstan-ignore-next-line return.type
        return [$nextRequest, $this->options];
    }
}
