
<?php
/**
 * EstimateTaxResult.class.php
 */


class EstimateTaxResult extends BaseResult
{
/**
 * Array of matching {@link ValidAddress}'s.
 * @var array
 */
    private $Rate;
    private $Tax;
    private $TaxDetails = array();
    
        
	public function __construct($resultCode , $rate , $tax, $taxdetails, $messages)
	{
		$this->ResultCode = $resultCode;
		$this->TaxDetails = $taxdetails;
		$this->Rate = $rate;
		$this->Tax = $tax;
		$this->Messages = $messages;
	}
	
	
	
	public static function parseResult($jsonString)
	{
		$object = json_decode($jsonString);
		if(property_exists($object, "TaxDetails"))
		{
		$taxdetails = TaxDetail::parseTaxDetails("{\"TaxDetails\": ".json_encode($object->TaxDetails)."}");		
		}
		if(property_exists($object, "Messages"))
		{
		$messages = Message::parseMessages("{\"Messages\": ".json_encode($object->Messages)."}");
		}
		print_r($messages);
		return new self( $object->ResultCode , $object->Rate, $object->Tax , $taxdetails, $messages );
	
	
	}

/**
 * Method returning array of matching {@link ValidAddress}'s.
 * @return array
 */
    public function getRate() { return $this->Rate; }
    public function getTax() { return $this->Tax; }	
    public function getTaxDetails() { return $this->TaxDetails; }	
	
	
	
	/**
 * @var string
 */
    //private $TransactionId;
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
    //public function getTransactionId() { return $this->TransactionId; }
/**
 * Accessor
 * @return string
 */
    public function getResultCode() { return $this->ResultCode; }
/**
 * Accessor
 * @return array
 */
    public function getMessages() { 
    return EnsureIsArray($this->Messages); }
    
    //@author:swetal
    

}

?>