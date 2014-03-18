<?php
require('AvaTaxClasses/AvaTax.php');

// Header Level Elements
// Required Header Level Elements
$serviceURL = "https://development.avalara.net";
$accountNumber = "1234567890";
$licenseKey = "A1B2C3D4E5F6G7H8";
	
$taxSvc = new TaxServiceRest($serviceURL, $accountNumber, $licenseKey);
$getTaxRequest = new GetTaxRequest();

// Document Level Elements
// Required Request Parameters
$getTaxRequest->setCustomerCode("ABC4335");
$getTaxRequest->setDocDate("2014-01-01");

// Best Practice Request Parameters
$getTaxRequest->setCompanyCode("APITrialCompany");
$getTaxRequest->setClient("AvaTaxSample");
$getTaxRequest->setDocCode("INV001");
$getTaxRequest->setDetailLevel(DetailLevel::$Tax);
$getTaxRequest->setCommit(FALSE);
$getTaxRequest->setDocType(DocumentType::$SalesInvoice);

// Situational Request Parameters
// $getTaxRequest->setCustomerUsageType("G");
// $getTaxRequest->setExemptionNo("12345");
// $getTaxRequest->setDiscount(50);
// $taxOverride = new TaxOverride();
// $taxOverride.TaxOverrideType("TaxDate");
// $taxOverride.Reason("Adjustment for return");
// $taxOverride.TaxDate("2013-07-01");
// $taxOverride.TaxAmount("0");
// $getTaxRequest->setTaxOverride($taxOverride);

// Optional Request Parameters
$getTaxRequest->setPurchaseOrderNo("PO123456");
$getTaxRequest->setReferenceCode("ref123456");
$getTaxRequest->setPosLaneCode("09");
$getTaxRequest->setCurrencyCode("USD");

// Address Data
$addresses = array();

$address1 = new Address();
$address1->setAddressCode("01");
$address1->setLine1("45 Fremont Street");
$address1->setCity("San Francisco");
$address1->setRegion("CA");

$addresses[] = $address1;

$address2 = new Address();
$address2->setAddressCode("02");
$address2->setLine1("118 N Clark St");
$address2->setLine2("Suite 100");
$address2->setLine3("ATTN Accounts Payable");
$address2->setCity("Chicago");
$address2->setRegion("IL");
$address2->setCountry("US");
$address2->setPostalCode("60602");

$addresses[] = $address2;

$address3 = new Address();
$address3->setAddressCode("03");
$address3->setLatitude(47.627935);
$address3->setLongitude(-122.51702);

$addresses[] = $address3;
$getTaxRequest->setAddresses($addresses);

// Line Data
// Required Parameters
$lines = array();

$line1 = new Line();
$line1->setLineNo("01");
$line1->setItemCode("N543");
$line1->setQty(1);
$line1->setAmount(10);
$line1->setOriginCode("01");
$line1->setDestinationCode("02");

// Best Practice Request Parameters
$line1->setDescription("Red Size 7 Widget");
$line1->setTaxCode("NT");

// Situational Request Parameters
// $line1->setCustomerUsageType("L");
// $line1->setDiscounted(TRUE);
// $line1->setTaxIncluded(TRUE);
// $lineTaxOverride = new TaxOverride();
// $lineTaxOverride.TaxOverrideType("TaxDate");
// $lineTaxOverride.Reason("Adjustment for return");
// $lineTaxOverride.TaxDate("2013-07-01");
// $lineTaxOverride.TaxAmount("0");
// $line1->setTaxOverride($lineTaxOverride);

// Optional Request Parameters
$line1->setRef1("ref123");
$line1->setRef2("ref456");

$lines[] = $line1;

$line2 = new Line();
$line2->setLineNo("02");
$line2->setItemCode("T345");
$line2->setQty(3);
$line2->setAmount(150);
$line2->setOriginCode("01");
$line2->setDestinationCode("03");
$line2->setDescription("Size 10 Green Running Shoe");
$line2->setTaxCode("PC030147");

$lines[] = $line2;

$line3 = new Line();
$line3->setLineNo("02-FR");
$line3->setItemCode("FREIGHT");
$line3->setQty(1);
$line3->setAmount(15);
$line3->setOriginCode("01");
$line3->setDestinationCode("03");
$line3->setDescription("Shipping Charge");
$line3->setTaxCode("FR");

$lines[] = $line3;
$getTaxRequest->setLines($lines);

$getTaxResult = $taxSvc->getTax($getTaxRequest);

//Print Results
echo 'GetTaxTest Result: ' . $getTaxResult->getResultCode() . "\n";
if($getTaxResult->getResultCode() != SeverityLevel::$Success)	// call failed
{	
	foreach($getTaxResult->getMessages() as $message)
	{
		echo $message->getSeverity() . ": ".$message->getSummary() . "\n";
	}
}
else
{
	echo "Document Code: " . $getTaxResult->getDocCode() . " Total Tax: " . $getTaxResult->getTotalTax() . "\n";
	foreach($getTaxResult->getTaxLines() as $taxLine)
	{
		echo "    " . "Line Number: " . $taxLine->getLineNo() . " Line Tax: " . $taxLine->getTax() . "\n";
		foreach($taxLine->getTaxDetails() as $taxDetail)
		{
			echo "        " . "Jurisdiction: " . $taxDetail->getJurisName() . " Tax: " . $taxDetail->getTax() . "\n";
		}
	}
}	
?>