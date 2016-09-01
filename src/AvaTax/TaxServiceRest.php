<?php
/**
 * TaxServiceRest.class.php
 */

/**
 *
 * TaxServiceRest reads its configuration values from parameters in the constructor
 *
 * <p>
 * <b>Example:</b>
 * <pre>
 *  $taxService = new TaxServiceRest("https://development.avalara.net","1100012345","1A2B3C4D5E6F7G8");
 * </pre>
 *
 * @author    Avalara
 * @copyright � 2004 - 2011 Avalara, Inc.  All rights reserved.
 * @package   Tax
 *
 */

namespace AvaTax;

class TaxServiceRest extends RestService
{
	static protected $classmap = array(
		'Address' => 'Address',
		'ValidAddress' => 'ValidAddress',
		'Message' => 'Message',
		'ValidateRequest' => 'ValidateRequest',
		'ValidateResult' => 'ValidateResult',
		'Line'=>'Line',
		'CancelTaxRequest'=>'CancelTaxRequest',
		'CancelTaxResult'=>'CancelTaxResult',
		'GetTaxRequest'=>'GetTaxRequest',
		'GetTaxResult'=>'GetTaxResult',
		'TaxLine'=>'TaxLine',
		'TaxDetail' => 'TaxDetail',
		'BaseResult'=>'BaseResult',
		'TaxOverride'=>'TaxOverride'
	);

	/**
	 * Voids a document that has already been recorded on the Admin Console.
	 *
	 * @param $cancelTaxRequest
	 * @return CancelTaxResult
	 */
	public function cancelTax(CancelTaxRequest &$cancelTaxRequest)
	{
		return CancelTaxResult::parseResult($this->processRequest("/1.0/tax/cancel", $cancelTaxRequest));
	}

	/**
	 * Calculates tax on a document and/or records that document to the Admin Console.
	 *
	 * @param $getTaxRequest
	 * @return GetTaxResult
	 * @throws Exception
	 * @throws \Exception
	 */
	public function getTax(GetTaxRequest &$getTaxRequest)
	{
		return GetTaxResult::parseResult($this->processRequest("/1.0/tax/get", $getTaxRequest));
	}

	/**
	 * Estimates a composite tax based on latitude/longitude and total sale amount.
	 *
	 * @param $estimateTaxRequest EstimateTaxRequest
	 * @return EstimateTaxResult
	 * @throws AvaException
	 */
	public function estimateTax(EstimateTaxRequest &$estimateTaxRequest)
	{
		return EstimateTaxResult::parseResult($this->processRequest('/1.0/tax/'. $estimateTaxRequest->getLatitude().",".$estimateTaxRequest->getLongitude().'/get?saleamount='.$estimateTaxRequest->getSaleAmount()));
	}

	/**
	 * There is no explicit ping function in the REST API, so here's an imitation.
	 *
	 * @return EstimateTaxResult
	 */
	public function ping()
	{
		$request = new EstimateTaxRequest("47.627935","-122.51702","10");
		return $this->estimateTax($request);
	}
}

?>
