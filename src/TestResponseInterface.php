<?php
namespace wolffc\ssltest;


interface TestResponseInterface {
	/**
	 * if the Test Is Already Done or if we need to do another Round
	 * @return boolean true if the test is done
	 */
	public function isDone();

	/**
	 * sets the status code of of the Current Response
	 * @param integer $TestStatus the Status number
	 */
	public function setTestStatus($testStatus);

	/**
	 * returns the Curent Status code
	 * @return integer teh TestStatus
	 */
	public function getTestStatus();

	/**
	 * gets a Descriptive message of the status code
	 * @return string the status message
	 */
	public function getStatusMessage();

	/**
	 * Allows to Set the Full HTTP Response Object to the Resoponse
	 * @param object $response the response object
	 */
	public function setHttpResponseObject($response);
	
	/**
	 * return the set response Object
	 * @return object the HTTP response object
	 */
	public function getHttpResponseObject();


	/**
	 * returns the rating als a Letter Code
	 * @return string the letters A+,A,B,C,D,F as Scored by SSL Labs
	 */
	public function getRating();

	/**
	 * convert a given Rating in letter form to a number (higer number means better rating)
	 * @param  string the letter of an Rating (A,B,C... F);
	 * @return integer -1 if illigle rating is found (F=0 ... A=5 A+=6)
	 */
	public function convertToNummericalRating($LetterRating);

	/**
	 * Returns true if rating is Higer or Eqal 
	 * @param  string $letterRating the rating letter A ... F
	 * @return boolean               if the rating is higher or eqal
	 */
	public function ratingIsHigherOrEqual($letterRating);
}