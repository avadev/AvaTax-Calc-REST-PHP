<?php
require('AvaTaxClasses/AvaTax.php');

// Header Level Elements
// Required Header Level Elements
$serviceURL = "https://development.avalara.net";
$accountNumber = "1234567890";
$licenseKey = "A1B2C3D4E5F6G7H8";
	
$taxSvc = new TaxServiceRest($serviceURL, $accountNumber, $licenseKey);
$cancelTaxRequest = new CancelTaxRequest();

// Required Request Parameters
$cancelTaxRequest->setCompanyCode("APITrialCompany");
$cancelTaxRequest->setDocType(DocumentType::$SalesInvoice);		
$cancelTaxRequest->setDocCode("INV001");		
$cancelTaxRequest->setCancelCode(CancelCode::$DocVoided);	

$cancelTaxResult = $taxSvc->cancelTax($cancelTaxRequest);

//Print Results
echo 'CancelTaxTest Result: ' . $cancelTaxResult->getResultCode() . "\n";
if($cancelTaxResult->getResultCode() != SeverityLevel::$Success)	// call failed
{	
	foreach($cancelTaxResult->getMessages() as $message)
	{
		echo $message->getSeverity() . ": " . $message->getSummary()."\n";
	}
}
?>