<?php
/**
 * AddressServiceRest.class.php
 */

/**
 * Interface for the Avalara Address Web Service.
 *
 * AddressServiceRest reads its configuration values from parameters in the constructor
 *
 * <p>
 * <b>Example:</b>
 * <pre>
 *  $addressService = new AddressServiceRest("https://development.avalara.net","1100012345","1A2B3C4D5E6F7G8");
 * </pre>
 *
 * @author    Avalara
 * @copyright � 2004 - 2011 Avalara, Inc.  All rights reserved.
 * @package   Address
 *
 */

namespace AvaTax;

class AddressServiceRest extends RestService
{
	static protected $classmap = array(
		'Validate' => 'Validate',
		'ValidateRequest' => 'ValidateRequest',
		'Address' => 'Address',
		'ValidAddress' => 'ValidAddress',
		'ValidateResult' => 'ValidateResult',
		'BaseResult' => 'BaseResult',
		'SeverityLevel' => 'SeverityLevel',
		'Message' => 'Message');

	/**
	 * Validates/normalizes a single provided address. Will either return a single, non-ambiguous validated address match or an error.
	 *
	 * @param ValidateRequest $validateRequest
	 * @return ValidateResult
	 * @throws AvaException
	 */
	public function validate(ValidateRequest $validateRequest)
	{
		$result = $this->processRequest('/1.0/address/validate?'. http_build_query($validateRequest->getAddress()));
		return ValidateResult::parseResult($result);
	}
}
?>
