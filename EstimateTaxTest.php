<?php

require('../AvaTax4PHP/AvaTax.php');            // location of the AvaTax.PHP Classes - Required

$client = new TaxServiceRest(
	"", // TODO: Enter service URL
	"", //TODO: Enter Username or Account Number
	""); //TODO: Enter Password or License Key
	
	$latitude = "47.627935";			// R: Latitude of location
	$longitude = "-122.51702";			// R: Longitude of location
	$saleAmount = "10";					// R: Total sale amount
	$request = new EstimateTaxRequest($latitude, $longitude, $saleAmount);

try
{
	$result = $client->estimateTax($request);
	echo 'Estimate ResultCode is: '. $result->getResultCode()."\n";
	
	//If the call failed, display error messages.
	if($result->getResultCode() != SeverityLevel::$Success)	// call failed
	{	
		foreach($result->getMessages() as $msg)
		{
			echo $msg->getSeverity().": ".$msg->getSummary()."\n";
		}

	}
	//If the call succeeded, display the tax calculation details.
	else
	{
		print_r($result->getTaxDetails());
	}
}
catch(Exception $exception)
{
	echo $msg = "Exception: " . $exception->getMessage()."\n";
}
	
?>