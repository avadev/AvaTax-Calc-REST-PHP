<?php
/**
 * GetTaxResult.class.php
 */

/**
 * Result data returned from {@link TaxServiceSoap#getTax}.
 *
 * @see GetTaxRequest
 * 
 * @author    Avalara
 * @copyright © 2004 - 2011 Avalara, Inc.  All rights reserved.
 * @package   Tax 
 */

class GetTaxResult // extends BaseResult
{
  	  
	private $DocCode;	//string  
	private $DocDate;			//date  		 	
	private $Timestamp;		//dateTime  	
	private $TotalAmount;		//decimal  
	private $TotalDiscount;	//decimal  
	private $TotalExemption;	//decimal  
	private $TotalTaxable;	//decimal  
	private $TotalTax;		//decimal  	
	private $TotalTaxCalculated;		//decimal  	 
	private $TaxDate;		//date 		
 	private $TaxLines;	//ArrayOfTaxLine
	private $TaxSummary;		//ArrayOfTaxDetail	
	private $TaxAddresses;
	
	public function __construct( $resultCode, $messages, $docCode, $docDate, $timestamp, $totalAmount, $totalDiscount, $totalExemption, $totalTaxable, $totalTax, $totalTaxCalculated, 
			$taxDate, $taxLines, $taxSummary, $taxAddresses)
	{
		$this->DocCode = $docCode ;	
		$this->DocDate = $docDate ;			 	
		$this->Timestamp = $timestamp ;		
		$this->TotalAmount = $totalAmount ;	  
		$this->TotalDiscount = $totalDiscount ;
		$this->TotalExemption = $totalExemption ;	  
		$this->TotalTaxable = $totalTaxable ;	
		$this->TotalTax = $totalTax ;		 	
		$this->TotalTaxCalculated = $totalTaxCalculated ;	 	 
		$this->TaxDate = $taxDate ;			
		$this->TaxLines = $taxLines ;
		$this->TaxSummary = $taxSummary ;		
		$this->TaxAddresses = $taxAddresses ;
	
	}
	
	public static function parseResult($jsonString)
	{
		$object = json_decode($jsonString);
		$taxlines = array();
		$taxsummary = array();
		$taxaddresses = array();
		$messages = array();
		
		if(property_exists($object, "TaxLines"))
		{
			$taxlines = TaxLine::parseTaxLines("{\"TaxLines\": ".json_encode($object->TaxLines)."}");
		}
		if(property_exists($object, "TaxSummary"))
		{
			$taxsummary = TaxDetail::parseTaxDetails("{\"TaxSummary\": ".json_encode($object->TaxSummary)."}");
		}
		if(property_exists($object, "TaxAddresses"))
		{
			$taxsaddresses = Address::parseAddress("{\"TaxAddresses\": ".json_encode($object->TaxAddresses)."}");
		}	
		if(property_exists($object, "Messages"))
		{
			$messages = Message::parseMessages("{\"Messages\": ".json_encode($object->Messages)."}");
		}		
		return new self( $object->ResultCode , $messages, $object->DocCode, $object->DocDate, $object->Timestamp, $object->TotalAmount, $object->TotalDiscount, $object->TotalExemption, $object->TotalTaxable, $object->TotalTax, $object->TotalTaxCalculated, 
			$object->TaxDate, $taxlines, $taxsummary, $taxaddresses );	
	}



	public function getDocCode() { return $this->DocCode; } 
	public function getDocDate() { return $this->DocDate; }			 				
	public function getTimestamp() { return $this->Timestamp; }			
	public function getTotalAmount() { return $this->TotalAmount; }		
	public function getTotalDiscount() { return $this->TotalDiscount; }	
	public function getTotalExemption() { return $this->TotalExemption; }	
	public function getTotalTaxable() { return $this->TotalTaxable; }	 
	public function getTotalTax() { return $this->TotalTax; }		  	
	public function getTotalTaxCalculated() { return $this->TotalTaxCalculated; }		 
	public function getTaxDate() { return $this->TaxDate; }		
 	public function getTaxLines() { return $this->TaxLines; }	
	public function getTaxSummary() { return $this->TaxSummary; }		
	public function getTaxAddresses() { return $this->TaxAddresses; }
	
	public function setDocCode($value) {  $this->DocCode= $value; } 
	public function setDocDate($value) {  $this->DocDate= $value; }			 				
	public function setTimestamp($value) {  $this->Timestamp= $value; }			
	public function setTotalAmount($value) {  $this->TotalAmount= $value; }		
	public function setTotalDiscount($value) {  $this->TotalDiscount= $value; }	
	public function setTotalExemption($value) {  $this->TotalExemption= $value; }	
	public function setTotalTaxable($value) {  $this->TotalTaxable= $value; }	 
	public function setTotalTax($value) {  $this->TotalTax= $value; }		  	
	public function setTotalTaxCalculated($value) {  $this->TotalTaxCalculated= $value; }		 
	public function setTaxDate($value) {  $this->TaxDate= $value; }		
 	public function setTaxLines($value) {  $this->TaxLines= $value; }	
	public function setTaxSummary($value) {  $this->TaxSummary= $value; }		
	public function setTaxAddresses($value) {  $this->TaxAddresses= $value; }
	

	public function getTaxLine($lineNo)
	{
		if($this->getTaxLines() != null)
		{
			foreach($this->getTaxLines() as $taxLine)
			{
				if($lineNo == $taxLine->getLineNo())
				{
					return $taxLine;
				}
				
			}
		}
	}
			
	
			
	/////////////////////////////////////////////PHP bug requires this copy from BaseResult ///////////
	/**
	* @var string
	*/
    private $TransactionId;
	/**
	* @var string must be one of the values defined in {@link SeverityLevel}.
	*/
    private $ResultCode = 'Success';
	/**
	* @var array of Message.
	*/
    private $Messages = array();

	/**
	* Accessor
	* @return string
	*/
    public function getTransactionId() { return $this->TransactionId; }
	/**
	* Accessor
	* @return string
	*/
    public function getResultCode() { return $this->ResultCode; }
	/**
	* Accessor
	* @return array
	*/
    public function getMessages() { return EnsureIsArray($this->Messages->Message); }
    
    




}

?>