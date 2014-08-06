<?php
require('AvaTaxClasses/AvaTax.php');

// Header Level Elements
// Required Header Level Elements
$serviceURL = "https://development.avalara.net";
$accountNumber = "1234567890";
$licenseKey = "A1B2C3D4E5F6G7H8";

$taxSvc = new TaxServiceRest($serviceURL, $accountNumber, $licenseKey);
	
$geoTaxResult = $taxSvc->ping(""); 
echo 'PingTest Result: ' . $geoTaxResult->getResultCode()."\n";
if($geoTaxResult->getResultCode() != SeverityLevel::$Success)
{	
	foreach($geoTaxResult->getMessages() as $message)
	{
		echo $message->getSummary() . "\n";
	}
} 
?>