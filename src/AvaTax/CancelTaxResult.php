<?php
namespace AvaTax;
/**
 * CancelTaxResult.class.php
 */

/**
 * Result data returned from {@link TaxSvcRest#cancelTax}
 * @see CancelTaxRequest
 *  
 * @author    Avalara
 * @copyright � 2004 - 2011 Avalara, Inc.  All rights reserved.
 * @package   Tax
 * 
 */

class CancelTaxResult extends AvaResult implements JsonSerializable
{
    /** @var string Internal Avalara reference to document - may not be returned for some accounts */
	private $DocId;

	public function __construct($docId, $transactionId, $resultCode, $messages)
	{
		$this->DocId = $docId;
		$this->TransactionId = $transactionId;
		$this->ResultCode = $resultCode;
		$this->Messages = $messages;
	}

    /**
     * Helper function to decode result objects from Json responses to specific objects.
     *
     * @param $jsonString
     * @return CancelTaxResult
     */
	public static function parseResult($jsonString)
	{
        $object = self::jsonDecode($jsonString);

		if(property_exists($object,"CancelTaxResult")) {
		    $object = $object->CancelTaxResult;
        }

		$messages = array();
		$docid = null;
		$transactionid = null;
		$resultcode = null;

		if(property_exists($object, "Messages")) {
		    $messages = Message::parseMessages("{\"Messages\": ".json_encode($object->Messages)."}");
        }

		if(property_exists($object, "DocId")) {
		    $docid = $object->DocId;
        }

		if(property_exists($object, "TransactionId")) {
		    $transactionid = $object->TransactionId;
        }

		if(property_exists($object, "ResultCode")) {
		    $resultcode = $object->ResultCode;
        }

		return new self($docid, $transactionid, $resultcode, $messages);
	}

	public function jsonSerialize(){
		return array(
			'DocId' => $this->getDocId(),
			'TransactionId' => $this->getTransactionId(),
			'ResultCode' => $this->getResultCode(),
			'Messages' => $this->getMessages()
		);
	}

	public function getDocId() { return $this->DocId; }
}

?>