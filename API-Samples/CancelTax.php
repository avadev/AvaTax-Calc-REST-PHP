<?php

require('../AvaTax4PHP/AvaTax.php');            // location of the AvaTax.PHP Classes - Required

$client = new TaxServiceRest(
	"", // TODO: Enter service URL
	"", //TODO: Enter Username or Account Number
	""); //TODO: Enter Password or License Key
	
	//First, we need to create a document to void. This is an abbreviated version of the sample 
	// in CalcTax.php. For a full sample of tax calculation, please see that file.
	$request = new GetTaxRequest();

    $dateTime = new DateTime();                                  
    $request->setCompanyCode("SDK");                    
    $request->setDocType(DocumentType::$SalesInvoice);    //This will need to be an invoice type to record a document for us to void.                       
    $request->setDocCode("INV123123" . date_format($dateTime, "Y-m-d"));                         
    $request->setDocDate(date_format($dateTime, "Y-m-d"));  
    $request->setCustomerCode("CUST123123");             

    $origin = new Address();                      
    $origin->setLine1("PO Box 123");              
    $origin->setRegion("WA");          
    $origin->setPostalCode("98101");      
    $origin->setAddressCode("01");          	
	$request->setAddresses(array($origin));

    $line1 = new Line();                                 
    $line1->setLineNo("01");                            
    $line1->setItemCode("SKU123");                  
    $line1->setQty(3);                          
    $line1->setAmount(500);                   /
	$line1->setOriginCode("01");
	$line1->setDestinationCode("01");
    $request->setLines(array($line1));              



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
	}
	
	
	//Cancel the document we just created:
	$cancelRequest = new CancelTaxRequest();				//Instantiate a new request object
	$cancelRequest->setCancelCode(CancelCode::$DocVoided);	//R: CancelCode controls the final document state after the CancelTax
	$cancelRequest->setDocCode($request->getDocCode());		//R: DocumentCode of the transaction we want to void
	$cancelRequest->setDocType($request->getDocType());		//R: DocumentType of the transaction we want to void
	$cancelRequest->setCompanyCode($request->getCompanyCode());		//R: CompanyCode of the transaction we want to void
	
	
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
	}
	
?>