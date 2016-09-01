<?php

namespace AvaTax;

class AvaException extends \Exception
{
    const INVALID_API_RESPONSE = 'invalid_response';
    const CURL_ERROR = 'curl_error';
    const MISSING_INFO = 'missing_info';
}