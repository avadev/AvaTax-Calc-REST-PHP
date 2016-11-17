<?php

namespace AvaTax;

class AvaException extends \Exception
{
    const UNKNOWN = 0;
    const INVALID_API_RESPONSE = 1;
    const CURL_ERROR = 2;
    const MISSING_INFO = 3;

    public function __construct($message = "", $code = self::UNKNOWN, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}