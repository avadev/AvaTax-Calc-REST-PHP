<?php
namespace AvaTax;
/**
 * EstimateTaxResult.class.php
 */

/**
 * Returns composite rate and total tax for location, with an array of jurisdictional details.
 *
 * @class EstimateTaxResult
 */
class EstimateTaxResult extends AvaResult implements JsonSerializable
{
	private $Rate;
	private $Tax;
    /** @var array|TaxDetail[] */
	private $TaxDetails = array();

	public function __construct($resultCode, $rate, $tax, $taxdetails, $messages)
	{
		$this->ResultCode = $resultCode;
		$this->TaxDetails = $taxdetails;
		$this->Rate = $rate;
		$this->Tax = $tax;
		$this->Messages = $messages;
	}

    /**
     * Helper function to decode result objects from Json responses to specific objects.
     *
     * @param $jsonString
     * @return EstimateTaxResult
     */
	public static function parseResult($jsonString)
	{
        $object = self::jsonDecode($jsonString);

		$taxdetails = array();
		$messages = array();
		$resultcode = null;
		$rate = null;
		$tax = null;

		if( property_exists($object,"Rate")) {
		    $rate = $object->Rate;
        }

		if( property_exists($object,"Tax")) {
		    $tax = $object->Tax;
        }

		if( property_exists($object,"ResultCode")) {
		    $resultcode = $object->ResultCode;
        }

		if(property_exists($object, "TaxDetails")) {
		    $taxdetails = TaxDetail::parseTaxDetails("{\"TaxDetails\": ".json_encode($object->TaxDetails)."}");
        }

		if(property_exists($object, "Messages")) {
		    $messages = Message::parseMessages("{\"Messages\": ".json_encode($object->Messages)."}");
        }

		return new self($resultcode, $rate, $tax, $taxdetails, $messages);
	}

	public function jsonSerialize(){
		return array(
			'Rate' => $this->getRate(),
			'Tax' => $this->getTax(),
			'TaxDetails' => $this->getTaxDetails(),
			'ResultCode' => $this->getResultCode(),
			'Messages' => $this->getMessages()
		);
	}

    public function getRate() { return $this->Rate; }
    public function getTax() { return $this->Tax; }
    public function getTaxDetails() { return $this->TaxDetails; }
}

?>