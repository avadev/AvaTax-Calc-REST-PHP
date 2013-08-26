<?php
/**
 * EstimateTaxRequest.class.php
 */



class EstimateTaxRequest
{
    private $Latitude;
    private $Longitude;
    private $SaleAmount;
    
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
