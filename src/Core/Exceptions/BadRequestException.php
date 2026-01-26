<?php

namespace SentDm\Core\Exceptions;

class BadRequestException extends APIStatusException
{
    /** @var string */
    protected const DESC = 'SentDm Bad Request Exception';
}
