<?php

require('../AvaTax4PHP/AvaTax.php');            // location of the AvaTax.PHP Classes - Required

$client = new TaxServiceRest(
	"", // TODO: Enter service URL
	"", //TODO: Enter Username or Account Number
	""); //TODO: Enter Password or License Key
	
	$latitude = "47.627935";
	$longitude = "-122.51702";
	$saleAmount = "10";
	$request = new EstimateTaxRequest($latitude, $longitude, $saleAmount);

try
{
	$result = $client->estimateTax($request);
	echo 'Estimate ResultCode is: '. $result->getResultCode()."\n";
	if($result->getResultCode() != SeverityLevel::$Success)	// call failed
	{	
		foreach($result->getMessages() as $msg)
		{
			echo $msg->getSeverity().": ".$msg->getSummary()."\n";
		}

	} 
	else
	{
		print_r($result->getTaxDetails());
	}
}
catch(SoapFault $exception)
{
	$msg = "Exception: ";
	if($exception)
		$msg .= $exception->faultstring;

	echo $msg."\n";
	echo $client->__getLastRequest()."\n";
	echo $client->__getLastResponse()."\n";
}	
	
?>