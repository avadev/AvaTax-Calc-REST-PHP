<?php
/**
 * CancelTaxRequest.class.php
 */

 /**
 * Data to pass to CancelTax indicating
 * the document that should be cancelled and the reason for the operation.
 * <p>
 * A document can be indicated solely by the DocId if it is known.
 * Otherwise the request must specify all of CompanyCode,
 * DocCode, and
 * DocType in order to uniquely identify the document.
 * </p>
 *
 * @see CancelTaxResult, DocumentType
 *
 * @author    Avalara
 * @copyright © 2004 - 2011 Avalara, Inc.  All rights reserved.
 * @package   Tax
 */

class CancelTaxRequest 
{
    public $CancelCode;   //Unspecified or PostFailed or DocDeleted or DocVoided or AdjustmentCancelled
	public $DocCode;
	public $DocType;
	public $CompanyCode;
	public $DocId;
	
	
	public function __construct()
	{
		$this->DocType = DocumentType::$SalesInvoice;  // this is right Document
		$this->CancelCode = CancelCode::$Unspecified;
	}


    /**
     *   A code indicating the reason the document is getting canceled.
     *
     * @return string
     * @see CancelCode
     */

    public function getCancelCode() { return $this->CancelCode; }
	public function getDocCode() { return $this->DocCode; }
	public function getDocType() { return $this->DocType; }
	public function getCompanyCode() { return $this->CompanyCode; }
	public function getDocId() { return $this->DocId; }
    /**
     *   A code indicating the reason the document is getting canceled.
     *
     * @var string
     * @see CancelCode
     */

    public function setCancelCode($value) { CancelCode::Validate($value); $this->CancelCode = $value; return $this; }
	public function setDocCode($value) { $this->DocCode = $value; }
	public function setDocType($value) { $this->DocType = $value; }
	public function setCompanyCode($value) { $this->CompanyCode = $value; }
	public function setDocId($value) { $this->DocId = $value; }
}


 


?>