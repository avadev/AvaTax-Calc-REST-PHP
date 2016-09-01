<?php

namespace AvaTax;


class AvaResult extends BaseResult
{
    /**
     * Shortcut to decode and validate json
     *
     * @param $jsonString
     * @return mixed
     * @throws AvaException
     */
    public static function jsonDecode($jsonString)
    {
        $object = json_decode($jsonString);

        if(json_last_error() !== JSON_ERROR_NONE) {
            throw new AvaException('AvaResult: Error decoding JSON', AvaException::INVALID_API_RESPONSE);
        }

        if(!is_object($object)) {
            throw new AvaException('AvaResult: Expected object from json_decode', AvaException::INVALID_API_RESPONSE);
        }

        return $object;
    }
}