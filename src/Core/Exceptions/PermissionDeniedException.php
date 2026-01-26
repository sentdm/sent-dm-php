<?php

namespace SentDm\Core\Exceptions;

class PermissionDeniedException extends APIStatusException
{
    /** @var string */
    protected const DESC = 'SentDm Permission Denied Exception';
}
