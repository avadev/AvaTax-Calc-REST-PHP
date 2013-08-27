<?php

require('../AvaTax4PHP/AvaTax.php');            // location of the AvaTax.PHP Classes - Required

$client = new TaxServiceRest(
	"", // TODO: Enter service URL
	"", //TODO: Enter Username or Account Number
	""); //TODO: Enter Password or License Key
	
try
{
	$result = $client->ping(""); //Note: any parameter content passed to the Ping method will be ignored.
	echo 'Ping ResultCode is: '. $result->getResultCode()."\n";
	if($result->getResultCode() != SeverityLevel::$Success)	// call failed
	{	
		foreach($result->getMessages() as $msg)
		{
			echo $msg->getSeverity().": ".$msg->getSummary()."\n";
		}

	} 
}
catch(Exception $exception)
{
	$msg = "Exception: ";
	if($exception)
		$msg .= $exception->faultstring;

	echo $msg."\n";
}

?>
