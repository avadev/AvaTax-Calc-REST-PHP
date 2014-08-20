<?php
require('../AvaTaxClasses/AvaTax.php');
include 'configuration.php';

// Header Level Elements
// Required Header Level Elements
$serviceURL = $configuration['serviceURL'];
$accountNumber = $configuration['accountNumber'];
$licenseKey = $configuration['licenseKey'];
	
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