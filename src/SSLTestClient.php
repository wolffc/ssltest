<?php
namespace wolffc\ssltest;

class SSLTestClient implements SSLTestClientInterface{

	protected $logger = NULL;

	protected $domain ='';

	protected $httpClient;

	protected $httpResponse;

	protected $delay = 0;




	/**
	 * set The Logger to Log Progress to
	 * @param \Psr\Log\Logger\Interface $logger the logger
	 */
	public function setLogger(\Psr\Log\LoggerInterface $logger = NULL){
		if(is_null($logger)){
			return;
		}
		$this->logger = $logger;
	}

	/**
	 * the Domain Name to Test
	 * @param string $domain the domainname (eg. www.yourdomain.com)
	 */
	public function setDomain($domain){
		$this->domain = $domain;
	}

	protected function initHttpClient(){
		$clientOoptions = array(
			'adapter' => 'Zend\Http\Client\Adapter\Curl'
			);
		$this->httpClient = new \Zend\Http\Client($this->getTestServiceURL(), $clientOoptions);
		$this->httpClient->setParameterGet($this->getGetParamerters());
	}

	/**
	 * run the Testing Process and Returns a Status object.
	 * IMPORTANT while the status returns 0 it has to be run and run again.
	 * @return \wolffc\ssltest\TestResponse the Response Status
	 */
	public function run(){
		$this->initHttpClient();

		$this->httpResponse = $this->httpClient->send();
		if($this->httpResponse->getStatusCode() !== 200){
			return $this->getTestResponse(TestResponse::STATUS_FAIL);
		}
		if($this->isSSLTestDoneYet()){
			return $this->getTestResponse(TestResponse::STATUS_SUCCESS);
		}
		return $this->getTestResponse(TestResponse::STATUS_IN_PROGRESS);
	}


	public function getTestResponse($testStatus){
		$testResponse = new TestResponse();
		$testResponse->setTestStatus($testStatus);
		$testResponse->setHttpResponseObject($this->httpResponse);
		return  $testResponse;
	}

	public function getHttpResponse(){
		return $this->httpResponse;
	}

	/**
	 * returuns true if the ssl test is completed jet
	 * @return boolean if the test is completed
	 */
	protected function isSSLTestDoneYet(){
		$body = $this->httpResponse->getBody();
		return (strstr($body, 'http-equiv="refresh"') ===FALSE);
	}


	protected function getTestServiceURL(){
		return 'https://www.ssllabs.com/ssltest/analyze.html';
	}

	protected function getGetParamerters()	{
		return array(
			'd' => $this->domain,
			'hideResults'=>1
		);
	}

}
?>