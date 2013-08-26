<?php
/**
 * ValidateResult.class.php
 */
 
/**
 * Contains an array of {@link ValidAddress} objects returned by {@link AddressServiceSoap#validate} 
 *
 * <pre>
 *  $port = new AddressServiceSoap();
 *
 *  $address = new Address();
 *  $address->setLine1("900 Winslow Way");
 *  $address->setLine2("Suite 130");
 *  $address->setCity("Bainbridge Is");
 *  $address->setRegion("WA");
 *  $address->setPostalCode("98110-2450");
 *
 *  $result = $port->validate($address,TextCase::$Upper);
 *  $addresses = $result->ValidAddresses;
 *  print("Number of addresses returned is ". sizeoof($addresses));
 *
 * </pre>
 * 
 * @see ValidAddress
 * 
 * @author    Avalara
 * @copyright © 2004 - 2011 Avalara, Inc.  All rights reserved.
 * @package   Address
 */


class ValidateResult extends BaseResult
{
/**
 * Array of matching {@link ValidAddress}'s.
 * @var array
 */
    private $ValidAddress;
    
	public function __construct($resultCode , $validaddress , $messages)
	{
		$this->ResultCode = $resultCode;
		$this->ValidAddress = $validaddress;
		$this->Messages = $messages;
	}
	
	
	
	public static function parseResult($jsonString)
	{
		$object = json_decode($jsonString);
		$validaddress = new ValidAddress();
		$messages = array();
		
		if(property_exists($object, "Address"))
		{
			$address = ValidAddress::parseAddress(json_encode($object->Address));
		}	
		if(property_exists($object, "Messages"))
		{
			$messages = Message::parseMessages("{\"Messages\": ".json_encode($object->Messages)."}");
		}		
		return new self( $object->ResultCode , $address , $messages );	
	}

/**
 * Method returning array of matching {@link ValidAddress}'s.
 * @return array
 */
    public function getValidAddress() { return $this->ValidAddress; }
	
	
	
	
	
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
    
    //public function isTaxable()
    //{
    //    return $this->Taxable;
    //}

}

?>