<?php
/**
 * CancelTaxResult.class.php
 */

/**
 * Result data returned from {@link TaxSvcSoap#cancelTax}
 * @see CancelTaxRequest
 *  
 * @author    Avalara
 * @copyright © 2004 - 2011 Avalara, Inc.  All rights reserved.
 * @package   Tax
 * 
 */

class CancelTaxResult // extends BaseResult
{
    

// BaseResult innards - workaround a bug in SoapClient
	private $DocId;
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
    
    
    public function __constructor($docId, $transactionId, $resultCode, $messages)
    {
    	$this->DocId = $docId;
    	$this->TransactionId = $transactionId;
    	$this->ResultCode = $resultCode;
    	$this->Messages = $messages;
    }
    
    public function parseResult($jsonString)
    {
		$object = json_decode($jsonString);
		$messages = array();	
		if(property_exists($object, "Messages"))
		{
			$messages = Message::parseMessages("{\"Messages\": ".json_encode($object->Messages)."}");
		}		
		return new self($object->DocId, $object->TransactionId, $object->ResultCode , $messages );	    
    
    
    }
    

    public function getDocId() { return $this->DocId; }
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