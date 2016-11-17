<?php
require '../vendor/autoload.php';
include 'configuration.php';

// Header Level Elements
// Required Header Level Elements
$serviceURL = $configuration['serviceURL'];
$accountNumber = $configuration['accountNumber'];
$licenseKey = $configuration['licenseKey'];
$SSL = $configuration['SSL'];

$taxSvc = new AvaTax\TaxServiceRest($serviceURL, $accountNumber, $licenseKey, $SSL);
	
$geoTaxResult = $taxSvc->ping(""); 
echo 'PingTest Result: ' . $geoTaxResult->getResultCode()."\n";
if($geoTaxResult->getResultCode() != AvaTax\SeverityLevel::$Success)
{	
	foreach($geoTaxResult->getMessages() as $message)
	{
		echo $message->getSummary() . "\n";
	}
} 
?>
