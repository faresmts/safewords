<?php

namespace Faresmts\SafeWords\Exceptions;

use Exception;

class InvalidMethodCall extends Exception
{
    public static function thisMethodCallIsNotValid(): self
    {
        return new static('you cannot call these two methods at the same time');
    }
}
