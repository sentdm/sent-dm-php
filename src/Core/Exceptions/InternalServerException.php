<?php

namespace SentDm\Core\Exceptions;

class InternalServerException extends APIStatusException
{
    /** @var string */
    protected const DESC = 'SentDm Internal Server Exception';
}
