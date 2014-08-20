<?php
/**
 * AvaTax.php
 *
 * @package Base
 */
 
/**
 * Defines class loading search path.
 */
 

//This will automatically register all classes you will need. If you have a special case that does not permit you to use the spl_autoload_register, the commented code block below will manually register all required classes.
spl_autoload_register('avataxAutoloader');



/*
$arrayofclasses = array(
	"Enum",
	"Address",
	"AddressServiceRest",
	"AddressType",
	"BaseResult",
	"CancelCode",
	"CancelTaxRequest",
	"CancelTaxResult",
	"DetailLevel",
	"DocumentType",

	"EstimateTaxRequest",
	"EstimateTaxResult",
	"GetTaxRequest",
	"GetTaxResult",
	"JurisdictionType",
	"Line",
	"Message",
	"SeverityLevel",
	"TaxDetail",
	"TaxLine",
	"TaxOverride",
	"TaxOverrideType",
	"TaxServiceRest",
	"ValidAddress",
	"ValidateRequest",
	"ValidateResult"	
);

foreach($arrayofclasses as $value)
{
	avataxAutoloader($value);	
}

*/

function avataxAutoloader($class_name) 
{
	$path=dirname(__FILE__).'/classes/'.$class_name.'.class.php';
	require_once $path;
}


function EnsureIsArray( $obj ) 
{
	if( is_object($obj))
	{
		$item[0] = $obj;
	}
	else
	{
		$item = (array)$obj;
	}
	return $item;
}

function getDefaultDate()
{
	$dateTime=new DateTime();
	$dateTime->setDate(1900,01,01);
	return $dateTime->format("Y-m-d");
}

function getCurrentDate()
{
	$dateTime=new DateTime();
	return $dateTime->format("Y-m-d");
} 




?>