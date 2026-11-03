<?php

namespace SentDm;

use Psr\Http\Message\ResponseInterface;
use SentDm\CallsPage\Data;
use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkPage;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Core\Contracts\BasePage;
use SentDm\Core\Conversion;
use SentDm\Core\Conversion\Contracts\Converter;
use SentDm\Core\Conversion\Contracts\ConverterSource;
use SentDm\Core\Conversion\ListOf;

/**
 * @phpstan-type CallsPageShape = array{data?: Data|null}
 *
 * @template TItem
 *
 * @implements BasePage<TItem>
 */
final class CallsPage implements BaseModel, BasePage
{
    /** @use SdkModel<CallsPageShape> */
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

        // Translate wire names before __unserialize, which expects PHP property names.
        $parsed = Conversion::coerce(self::class, value: $this->parsedBody);
        // @phpstan-ignore-next-line argument.type
        self::__unserialize($parsed instanceof self ? $parsed->toProperties() : $this->parsedBody);

        if (is_array($items = $this->data?->offsetGet('calls'))) {
            $parsed = Conversion::coerce(new ListOf($convert), value: $items);
            // @phpstan-ignore-next-line
            $this->data->offsetSet('calls', value: $parsed);
        }
    }

    /** @return list<TItem> */
    public function getItems(): array
    {
        // @phpstan-ignore-next-line return.type
        return $this->data?->offsetGet('calls') ?? [];
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
        $curr = ((array) $this->requestInfo['query'])['page'] ?? 1;
        if (!($this
            ->data->pagination->hasMore ?? null) || !count($this->getItems())) {
            return null;
        }

        $nextRequest = $this->requestInfo;
        // The resolved path already contains the old query; buildRequest merges it again.
        $nextRequest['path'] = explode('?', $nextRequest['path'], 2)[0];
        $nextRequest['query']['page'] = $curr + 1;

        // @phpstan-ignore-next-line return.type
        return [$nextRequest, $this->options];
    }
}
