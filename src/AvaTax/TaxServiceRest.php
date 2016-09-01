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

class TaxServiceRest
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
	protected $config = array();

	/**
	 * TaxServiceRest constructor.
	 *
	 * @param $url string - domain for API endpoint
	 * @param $account string - API account
	 * @param $license string - API license
	 * @param bool $ssl - whether to use SSL connecting to the API (Windows users read below)
	 * Some Windows users have had trouble with our SSL Certificates. Uncomment the following line to NOT use SSL.
	 * This is not recommended, see below ($ssl_ca_path) for better alternative*
	 * @param null $ssl_ca_path - Manually set an SSL path to a cert (Windows users read below)
	 * $ssl_ca_path: Other Windows users may prefer to download the certificate from our site (detail here: http://developer.avalara.com/api-docs/designing-your-integration/errors-and-outages/ssl-certificates) and manually set the cert path.
	 * To set the path manually, uncomment the following two lines and ensure you are telling curl where it can find the root certificate. If you choose to manually set the path, make sure you have reenabled cURL by commenting out the line above
	 * that tells curl to NOT use SSL.
	 * ex: $ssl_ca_path = "C:/curl/curl-ca-bundle.crt";
	 *
	 */
	public function __construct($url, $account, $license, $ssl = true, $ssl_ca_path = null)
	{
		$this->config = array(
			'url' => $url,
			'account' => $account,
			'license' => $license,
			'ssl' => $ssl,
			'ssl_ca_path' => $ssl_ca_path
		);
	}

	/**
	 * Process a request to the API
	 *
	 * @param $path
	 * @param null $data
	 * @return mixed
	 * @throws AvaException
	 */
	private function processRequest($path, $data = null)
	{
		if(!$this->config['url'] || !(filter_var($this->config['url'], FILTER_VALIDATE_URL))) {
			throw new AvaException("A valid service URL is required.", AvaException::MISSING_INFO);
		}

		if(empty($this->config['account'])) {
			throw new AvaException("Account number or username is required.", AvaException::MISSING_INFO);
		}

		if(empty($this->config['license'])) {
			throw new AvaException("License key or password is required.", AvaException::MISSING_INFO);
		}

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($curl, CURLOPT_USERPWD, $this->config['account'].":".$this->config['license']);
		curl_setopt($curl, CURLOPT_URL, $this->config['url'].$path);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, $this->config['ssl']);

		if($this->config['ssl_ca_path']) {
			curl_setopt($curl, CURLOPT_CAINFO, $this->config['ssl_ca_path']);
		}

		if($data) {
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
		}

		$response = curl_exec($curl);

		if($error_number = curl_errno($curl)) {
			$error_msg = curl_strerror($error_number);
			throw new AvaException("AddressServiceRest cURL error ({$error_number}): {$error_msg}", AvaException::CURL_ERROR);
		}

		if(!$response) {
			throw new AvaException('AddressServiceRest received empty result from API', AvaException::INVALID_API_RESPONSE);
		}

		curl_close($curl);

		return $response;
	}

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
	 * @param string $msg
	 * @return EstimateTaxResult
	 */
	public function ping($msg = "")
	{
		$request = new EstimateTaxRequest("47.627935","-122.51702","10");
		return $this->estimateTax($request);
	}
}

?>
