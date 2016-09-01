<?php
/**
 * Enum.class.php
 */

/**
 * Abstract class for enumerated types - provides validation.
 *
 * @author    Avalara
 * @copyright � 2004 - 2011 Avalara, Inc.  All rights reserved.
 * @package   Base
 */

namespace AvaTax;

class Enum
{
    /**
     * Basic implementation - check and throw
     * @param $value
     * @param $values
     * @param string $class
     * @return bool
     * @throws AvaException
     */
	protected static function __Validate($value, $values, $class = __CLASS__)
	{
        foreach($values as $valid)
        {
            if($value == $valid)
            {
                return true;
            }
        }

        throw new AvaException('Invalid '.$class.' "'.$value.'" - must be one of "'.implode('"|"',$values).'"');
	}
}

?>