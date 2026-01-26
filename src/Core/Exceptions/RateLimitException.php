<?php

namespace SentDm\Core\Exceptions;

class RateLimitException extends APIStatusException
{
    /** @var string */
    protected const DESC = 'SentDm Rate Limit Exception';
}
