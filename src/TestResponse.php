<?php
namespace wolffc\ssltest;

class TestResponse implements TestResponseInterface {
	 const STATUS_FAIL = -1;
	 const STATUS_IN_PROGRESS = 0;
	 const STATUS_SUCCESS =1;

	 /**
	  * Current Status of
	  * @var integer
	  */
	 protected $testStatus=0;

	 protected $responseObject;

	 protected $simpleXMLBody;

	/**
	 * if the Test Is Already Done or if we need to do another Round
	 * @return boolean true if the test is done
	 */
	public function isDone(){
		if($this->testStatus == self::STATUS_IN_PROGRESS){
			return false;
		}
		return true;
	}

	/**
	 * sets the status code of of the Current Response
	 * @param integer $testStatus the Status number
	 */
	public function setTestStatus($testStatus){
		$this->testStatus = $testStatus;
	}

	/**
	 * returns the Curent Status code
	 * @return integer teh testStatus
	 */
	public function getTestStatus(){
		return $this->testStatus;
	}


	/**
	 * gets a Descriptive message of the status code
	 * @return string the status message
	 */
	public function getStatusMessage(){
		switch ($this->testStatus) {
			case self::STATUS_SUCCESS:
				return 'Sucessfull';

			case self::STATUS_IN_PROGRESS:
				return 'in Progress';

			case self::STATUS_FAIL:
				return 'Failed!';

			default:
				return 'Unknown Status';
		}
	}

	/**
	 * Allows to Set the Full HTTP Response Object to the Resoponse
	 * @param object $response the response object
	 */
	public function setHttpResponseObject($response){
		$this->responseObject = $response;
		$this->createSimpleXMLBody();
	}

	/**
	 * Creates as Simple XML Variant of the Body Text
	 */

	protected function createSimpleXMLBody(){
		$DomDoc = new \DOMDocument();
		// Silince ths Operation ass the Document Throws some Warnings
		@$DomDoc->loadHTML($this->responseObject->getBody());
		$this->simpleXMLBody = \simplexml_import_dom($DomDoc);
	}

	/**
	 * return the set response Object
	 * @return object the HTTP response object
	 */
	public function getHttpResponseObject(){
		return $this->responseObject;
	}

	public function getRating(){
		$result = $this->simpleXMLBody->xpath('//div[@id="rating"]/div[2]');
		if(count($result) ===1){
			return trim($result[0]);
		}else{
			return '- no Rating found';
		}

	}

	public function getBody(){
		return $this->responseObject->getBody();
	}

	public function convertToNummericalRating($letter){
		$letter = strtoupper($letter);
		$result = -1;
		$mapping = array(
				'A+' => 6,
				'A' => 5,
				'B' => 4,
				'C' => 3,
				'D' => 2,
				'E' => 1,
				'F' => 0
			);
		if(array_key_exists($letter, $mapping)){
			$result = $mapping[$letter];
		}
		return $result;
	}

	public function ratingIsHigherOrEqual($minimumRating){
		$rating = $this->convertToNummericalRating($this->getRating());
		$minimumRating = $this->convertToNummericalRating($minimumRating);
		if ($rating >= $minimumRating){
			return true;
		}
		return false;
	}



}

?>