<?php
/**
 * EstimateTaxRequest.class.php
 */
/**
 * Data to pass to {@link TaxServiceSoap#estimateTax}.
 *
 * @Calculates a composite tax for a given latitude/longitude and sale amount. Currently supported for US only.
 * 
 * @author    Avalara
 * @copyright © 2004 - 2011 Avalara, Inc.  All rights reserved.
 * @package   Tax
 */


class EstimateTaxRequest
{
    private $Latitude; //decimal
    private $Longitude; //decimal
    private $SaleAmount; //decimal
    
    public function __construct($latitude, $longitude, $saleAmt)
    {
        $this->setLatitude($latitude);
        $this->setLongitude($longitude);
        $this->setSaleAmount($saleAmt);
    }
    
    
    public function setLatitude($value) { $this->Latitude = $value;}
    public function setLongitude($value) { $this->Longitude = $value;}    
    public function setSaleAmount($value) { $this->SaleAmount = $value;}   
    public function getLatitude() { return $this->Latitude; }
    public function getLongitude() { return $this->Longitude; }    
    public function getSaleAmount() { return $this->SaleAmount; }	
}

?>
