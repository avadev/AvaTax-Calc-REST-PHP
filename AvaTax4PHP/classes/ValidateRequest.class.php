<?php
/**
 * ValidateRequest.class.php
 */

/**
 * Data wrapper used internally to pass arguments within {@link AddressServiceSoap#validate}. End users should not need to use this class.
 * 
 * <pre>
 * <b>Example:</b>
 * $svc = new AddressServiceSoap();
 *
 * $address = new Address();
 * $address->setLine1("900 Winslow Way");
 * $address->setCity("Bainbridge Island");
 * $address->setRegion("WA");
 * $address->setPostalCode("98110");
 *
 * ValidateRequest validateRequest = new ValidateRequest();
 * validateRequest.setAddress(address);
 * validateRequest.setTextCase(TextCase.Upper);
 *
 * ValidateResult result = svc.validate(validateRequest);
 * ArrayOfValidAddress arrValids = result.getValidAddresses();
 * int numAddresses = (arrValids == null ||
 *         arrValids.getValidAddress() == null ? 0 :
 *         arrValids.getValidAddress().length);
 * System.out.println("Number of Addresses is " + numAddresses);
 * </pre>
 *
 * @author    Avalara
 * @copyright © 2004 - 2011 Avalara, Inc.  All rights reserved.
 * @package   Address
 */
 
 //public function validate($address, $textCase = 'Default', $coordinates = false)
    //{
       // $request = new ValidateRequest($address, ($textCase ? $textCase : TextCase::$Default), $coordinates);
       // return $this->client->Validate(array('ValidateRequest' => $request))->ValidateResult;
    //}


class ValidateRequest
{
    private $Address;
    
    public function __construct($address = null)
    {
        $this->setAddress($address);
    }
    
    // mutators
    /**
     * The address to Validate.
     * <pre>
     * <b>Example:</b>
     * $address = new Address();
     * $address->setLine1("900 Winslow Way");
     * $address->setCity("Bainbridge Island");
     * $address->setRegion("WA");
     * $address->setPostalCode("98110");
     *
     * $validateRequest = new ValidateRequest();
     * $validateRequest->setAddress(address);
     * $validateRequest->setTextCase(TextCase::$Upper);
     *
     * $result = svc->validate(validateRequest);
     * </pre>
     *
     * @var Address
     */
    
    public function setAddress(&$value) { $this->Address = $value; return $this; }
   
    public function getAddress() { return $this->Address; }
    
    /**
     * The casing to apply to the validated address(es).
     * <pre>
     * <b>Example:</b>
     * <b>Example:</b>
     * $address = new Address();
     * $address->setLine1("900 Winslow Way");
     * $address->setCity("Bainbridge Island");
     * $address->setRegion("WA");
     * $address->setPostalCode("98110");
     *
     * $validateRequest = new ValidateRequest();
     * $validateRequest->setAddress(address);
     * $validateRequest->setTextCase(TextCase::$Upper);
     *
     * $result = svc->validate(validateRequest);
     * </pre>
     *
     * @return string
     * @see TextCase
     */
	
}

?>
