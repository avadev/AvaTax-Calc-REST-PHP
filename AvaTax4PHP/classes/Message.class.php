<?php
/**
 * Message.class.php
 */

/**
 * Message class used in results and exceptions.
 * Contains status detail about call results.
 * Note that the REST API does not make use of all of these properties for all methods.
 *
 * @package   Address
 * @author    Avalara
 * @copyright © 2004 - 2011 Avalara, Inc.  All rights reserved.
 */

class Message
{
    private $Summary;
    private $Details;
    private $RefersTo;
    private $Severity;
    private $Source;
    
    public function __construct($summary = null, $details = null, $refersto = null, $severity = null, $source = null)
    {
		$this->Summary = $summary;
		$this->Details = $details;
		$this->RefersTo = $refersto;
		$this->Severity = $severity;
		$this->Source = $source;
    }
    
    //Helper function to decode result objects from Json responses to specific objects.
    public function parseMessages($jsonString)
    {
		$object = json_decode($jsonString);
		$messageArray = array();
		foreach($object->Messages as $message)
		{

			$messageArray[] =  new self(
				$message->Summary,
				$message->Details,
				$message->RefersTo,
				$message->Severity,
				$message->Source);
		}

		return $messageArray;
    	

    }
    
    
    
    /**
     * Gets the concise summary of the message. 
     *
     * @return string
     */    
    public function getSummary() { return $this->Summary; }
    
    /**
     * Gets the details of the message. 
     *
     * @return string
     */
    public function getDetails() { return $this->Details; }
    
    /**
     * Gets the item the message refers to, if applicable. Used to indicate a missing or incorrect value. 
     *
     * @return unknown
     */
    public function getRefersTo() { return $this->RefersTo; }
    
    /**
     * Gets the Severity Level of the message. 
     *
     * @return unknown
     */
    public function getSeverity() { return $this->Severity; }
    
    /**
     * Gets the source of the message.
     *
     * @return unknown
     */
    public function getSource() { return $this->Source; }
    
    // mutators
    public function setSummary($value) { $this->Summary = $value; return $this; }
    public function setDetails($value) { $this->Details = $value; return $this; }
    public function setRefersTo($value) { $this->RefersTo = $value; return $this; }
    public function setSeverity($value) { SeverityLevel::Validate($value); $this->Severity = $value; return $this; }
    public function setSource($value) { $this->Source = $value; return $this; }
    
}

?>