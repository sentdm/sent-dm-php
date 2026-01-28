<?php

namespace SentDm\Core\Exceptions;

class AuthenticationException extends APIStatusException
{
    /** @var string */
    protected const DESC = 'SentDm Authentication Exception';
}
