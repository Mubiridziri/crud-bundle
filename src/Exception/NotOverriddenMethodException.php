<?php

namespace Mubiridziri\Crud\Exception;

class NotOverriddenMethodException extends \Exception
{
    public function __construct($message = "Required method not overridden", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}