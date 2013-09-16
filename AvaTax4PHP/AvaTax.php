<?php
/**
 * AvaTax.php
 *
 * @package Base
 */
 
/**
 * Defines class loading search path.
 */
 
spl_autoload_register('avataxAutoloader');

function avataxAutoloader($class_name) 
{ 	
	
	$path=dirname(__FILE__).'/classes/'.$class_name . '.class.php';
	
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