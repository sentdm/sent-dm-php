<?php

namespace SentDm\Core\Exceptions;

class UnprocessableEntityException extends APIStatusException
{
    /** @var string */
    protected const DESC = 'SentDm Unprocessable Entity Exception';
}
