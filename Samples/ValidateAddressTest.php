<?php
require('AvaTaxClasses/AvaTax.php');

// Header Level Elements
// Required Header Level Elements
$serviceURL = "https://development.avalara.net";
$accountNumber = "1234567890";
$licenseKey = "A1B2C3D4E5F6G7H8";
	
$addressSvc = new AddressServiceRest($serviceURL, $accountNumber, $licenseKey);
$address = new Address();

// Required Request Parameters
$address->setLine1("118 N Clark St");
$address->setCity("Chicago");
$address->setRegion("IL");

// Optional Request Parameters
$address->setLine2("Suite 100");
$address->setLine3("ATTN Accounts Payable");
$address->setCountry("US");
$address->setPostalCode("60602");

$validateRequest = new ValidateRequest();
$validateRequest->setAddress($address);
$validateResult = $addressSvc->Validate($validateRequest);

//Print Results
echo 'ValidateAddressTest Result: ' . $validateResult->getResultCode() . "\n";
if($validateResult->getResultCode() != SeverityLevel::$Success)	// call failed
{	
	foreach($validateResult->getMessages() as $message)
	{
		echo $message->getSeverity() . ": " . $message->getSummary()."\n";
	}
}
else
{
	echo $validateResult->getValidAddress()->getLine1()
	                    . " " 
	                    . $validateResult->getValidAddress()->getCity()
	                    . ", "
	                    . $validateResult->getValidAddress()->getRegion()
	                    . " " 
	                    . $validateResult->getValidAddress()->getPostalCode() . "\n";
	
}
?>