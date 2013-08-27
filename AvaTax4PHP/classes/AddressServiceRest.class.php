<?php
/**
 * AddressServiceRest.class.php
 */
 
/**
 * Proxy interface for the Avalara Address Web Service. 
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
 * @copyright © 2004 - 2011 Avalara, Inc.  All rights reserved.
 * @package   Address
 * 
 */

class AddressServiceRest 
{
    static protected $classmap = array(
        							'Validate' => 'Validate',
                                    'BaseRequest' => 'BaseRequest',
                                    'ValidateRequest' => 'ValidateRequest',
                                    'BaseAddress' => 'BaseAddress',
                                    'ValidAddress' => 'ValidAddress',                                    
                                    'ValidateResult' => 'ValidateResult',                                    
                                    'BaseResult' => 'BaseResult',
                                    'SeverityLevel' => 'SeverityLevel',
                                    'Message' => 'Message',
                                    'Profile' => 'Profile',);
        
    protected $config = array();

    public function __construct($url, $account, $license)
    {
        $this->config = array(
    		'url' => $url,
            'account' => $account,         
            'license' => $license);   
    		                            
    }    
    	
	 public function validate($validateRequest)
    {
		
    	$url =  $this->config['url'].'/1.0/address/validate?'. http_build_query($validateRequest->getAddress());
    	$curl = curl_init();
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($curl, CURLOPT_USERPWD, $this->config['account'].":".$this->config['license']);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		
		$result = curl_exec($curl);

		return ValidateResult::parseResult($result);
		
    }     
}
?>
