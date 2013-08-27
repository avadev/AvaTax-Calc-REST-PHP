<?php

require('../AvaTax4PHP/AvaTax.php');            // location of the AvaTax.PHP Classes - Required

$client = new TaxServiceRest(
	"", // TODO: Enter service URL
	"", //TODO: Enter Username or Account Number
	""); //TODO: Enter Password or License Key
	
	//First, we need to create a document to void.
	$request = new GetTaxRequest();

//Document Level Setup  
//     R: indicates Required Element
//     O: Indicates Optional Element
//
    $dateTime = new DateTime();                                  // R: Sets dateTime format 
    $request->setCompanyCode("SDK");                    // R: Company Code from the accounts Admin Console
    $request->setDocType(DocumentType::$SalesInvoice);                           // R: Typically SalesOrder,SalesInvoice, ReturnInvoice
    $request->setDocCode("INV123123");                          // R: Invoice or document tracking number - Must be unique
    $request->setDocDate(date_format($dateTime, "Y-m-d"));  // R: Date the document is processed and Taxed - See TaxDate
    $request->setCustomerCode("CUST123123");             // R: String - Customer Tracking number or Exemption Customer Code

	$addresses = array();
//Add Address
    $origin = new Address();                      // R: New instance of an origin address
    $origin->setLine1("PO Box 123");              // O: It is not required to pass a valid street address however the 
    $origin->setCity("Seattle");                  // R: City
    $origin->setRegion("WA");              // R: State or Province
    $origin->setPostalCode("98101");      // R: String (Expects to be NNNNN or NNNNN-NNNN or LLN-LLN)
    $origin->setAddressCode("01");            // O: String Country, Country Code, etc.
	$addresses[] = $origin;

	
	$request->setAddresses($addresses);
//
// Line level processing
    
    $lines = array();                                     // array of lines for the invoice
    //$i = 0;                                            // sets counter to 0 (multiple lines)
    $line1 = new Line();                                // New instance of a line  
    $line1->setLineNo("01");                            // R: string - line Number of invoice - must be unique.
    $line1->setItemCode("SKU123");                   // R: string - SKU or short name of Item
    $line1->setQty(3);                          // R: decimal - The number of items 
    $line1->setAmount(500);                   // R: decimal - the "NET" amount of items 
	$line1->setOriginCode("01");
	$line1->setDestinationCode("01");

    $request->setLines(array($line1));             // sets line items to $lineX array    



// GetTaxRequest and Results
    
    try {
        $getTaxResult = $client->getTax($request);
        echo 'GetTax is: ' . $getTaxResult->getResultCode() . "\n";

// Error Trapping

        if ($getTaxResult->getResultCode() == SeverityLevel::$Success) 
        {
// Success - Display GetTaxResults to console            
            //Document Level Results
            echo "DocCode: " . $request->getDocCode() . "\n";
            echo "TotalAmount: " . $getTaxResult->getTotalAmount() . "\n";
            echo "TotalTax: " . $getTaxResult->getTotalTax() . "\n";
         }            
// If NOT success - display error messages to console
// it is important to itterate through the entire message class                              
         else {
            foreach ($getTaxResult->getMessages() as $msg) 
            {
                echo $msg->getName() . ": " . $msg->getSummary() . "\n";
            }
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
	//Then we can void it!
	$cancelRequest = new CancelTaxRequest();
	$cancelRequest->setCancelCode(CancelCode::$DocVoided);
	$cancelRequest->setDocCode($request->getDocCode());
	$cancelRequest->setDocType($request->getDocType());	
	$cancelRequest->setCompanyCode($request->getCompanyCode());	
	
	
	try 
	{
		$cancelTaxResult = $client->cancelTax($cancelRequest);
		echo 'CancelTax is: ' . $cancelTaxResult->getResultCode() . "\n";

// Error Trapping

		if ($cancelTaxResult->getResultCode() == SeverityLevel::$Success) 
		{
			echo "DocCode: " . $cancelRequest->getDocCode() . "\n";
		 }            
// If NOT success - display error messages to console
// it is important to itterate through the entire message class                              
		else {
			foreach ($cancelTaxResult->getMessages() as $msg) {
				echo $msg->getName() . ": " . $msg->getSummary() . "\n";
			}
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