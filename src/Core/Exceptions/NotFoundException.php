<?php

namespace SentDm\Core\Exceptions;

class NotFoundException extends APIStatusException
{
    /** @var string */
    protected const DESC = 'SentDm Not Found Exception';
}
