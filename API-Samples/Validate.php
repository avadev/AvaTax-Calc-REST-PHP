<?php

require('../AvaTax4PHP/AvaTax.php');            // location of the AvaTax.PHP Classes - Required

$client = new AddressServiceRest(
	"", // TODO: Enter service URL
	"", //TODO: Enter Username or Account Number
	""); //TODO: Enter Password or License Key
	

//address variables are assigned to address objects
try
{
	$address = new Address();
	$address->setLine1("PO Box 123");		//R: An address line is required for validation.
	$address->setCity("Bainbridge Island");		//R: Two of the three: city, region, postal code are required.
	$address->setRegion("WA");
	$address->setPostalCode("98110");


// Build Address object into an array
        
	$request = new ValidateRequest($address);
	$result = $client->Validate($request);

// Output to console the result (Success or Not Success)
// If not Success return Error Message results
// If Success - retune Normalized address
// If corrdinates = 1 return latitude and longitude
	echo "\n".'Validate ResultCode is: '. $result->getResultCode()."\n";
	if($result->getResultCode() != SeverityLevel::$Success)
	{
		foreach($result->getMessages() as $msg)
		{
			echo $msg->getSeverity().": ".$msg->getSummary()."\n";
		}
	}
	else
	{
		echo "Normalized Address:\n";
	   	$valid = $result->getvalidAddress();

		echo "Line 1: ".$valid->getline1()."\n";
		echo "Line 2: ".$valid->getline2()."\n";
		echo "Line 3: ".$valid->getline3()."\n";
		echo "City: ".$valid->getcity()."\n";
		echo "Region: ".$valid->getregion()."\n";
		echo "Postal Code: ".$valid->getpostalCode()."\n";
		echo "Country: ".$valid->getcountry()."\n";
		echo "County: ".$valid->getcounty()."\n";
		echo "FIPS Code: ".$valid->getfipsCode()."\n";
		echo "PostNet: ".$valid->getpostNet()."\n";
		echo "Carrier Route: ".$valid->getcarrierRoute()."\n";
		echo "Address Type: ".$valid->getaddressType()."\n";

	}
   
}


catch(Exception $exception)
{
	echo $msg = "Exception: " . $exception->getMessage()."\n";
}  

?>
