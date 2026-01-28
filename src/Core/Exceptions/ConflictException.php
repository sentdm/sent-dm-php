<?php

namespace SentDm\Core\Exceptions;

class ConflictException extends APIStatusException
{
    /** @var string */
    protected const DESC = 'SentDm Conflict Exception';
}
