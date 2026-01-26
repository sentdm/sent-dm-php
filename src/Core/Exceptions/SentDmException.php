<?php

namespace SentDm\Core\Exceptions;

class SentDmException extends \Exception
{
    /** @var string */
    protected const DESC = 'SentDm Error';

    public function __construct(string $message, int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($this::DESC.PHP_EOL.$message, $code, $previous);
    }
}
