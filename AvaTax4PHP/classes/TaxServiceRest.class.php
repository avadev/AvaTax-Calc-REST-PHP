<?php
/**
 * TaxServiceSoap.class.php
 */

/**
 * Proxy interface for the Avalara Tax Web Service.  It contains methods that perform remote calls
 * to the Avalara Tax Service. 
 *
 * TaxServiceSoap reads its configuration values from static variables defined
 * in ATConfig.class.php. This file must be properly configured with your security credentials.
 *
 * <p>
 * <b>Example:</b>
 * <pre>
 *  $taxService = new TaxServiceSoap();
 *  $result = $taxService->ping();
 * </pre>
 *
 * @author    Avalara
 * @copyright © 2004 - 2011 Avalara, Inc.  All rights reserved.
 * @package   Tax
 */


class TaxServiceRest
{
    static protected $classmap = array(
        'BaseAddress' => 'Address',
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
        
    public function __construct($url, $account, $license)
    {
        $this->config = array(
    		'url' => $url,
            'account' => $account,         
            'license' => $license);   
    		                            
    } 

    public function cancelTax(&$cancelTaxRequest)
    {
		$url = $this->config['url']."/1.0/tax/cancel";
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($curl, CURLOPT_USERPWD, $this->config['account'].":".$this->config['license']);

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($cancelTaxRequest)); 
        $curl_response = curl_exec($curl);
        curl_close($curl);
        
        return CancelTaxResult::parseResult($curl_response);
    }

	public function getTax(&$getTaxRequest)
    {
    	
		$url = $this->config['url']."/1.0/tax/get";
		
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($curl, CURLOPT_USERPWD, $this->config['account'].":".$this->config['license']);

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($getTaxRequest)); 
        $curl_response = curl_exec($curl);
        
        curl_close($curl);
        
        return GetTaxResult::parseResult($curl_response);
		
		
    }

	public function estimateTax(&$estimateTaxRequest)
	{
		$url =  $this->config['url'].'/1.0/tax/'. $estimateTaxRequest->getLatitude().",".$estimateTaxRequest->getLongitude().'/get?saleamount='.$estimateTaxRequest->getSaleAmount();
    	$curl = curl_init();
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($curl, CURLOPT_USERPWD, $this->config['account'].":".$this->config['license']);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		
		$curl_response = curl_exec($curl);

		return EstimateTaxResult::parseResult($curl_response);
		
	}
	/*
	There is no explicit ping function in the REST API, so here's an imitation.*/
	public function ping($msg = "")
	{
		$request = new EstimateTaxRequest("47.627935","-122.51702","10");
		return $this->estimateTax($request);
		
	}
}

?>
