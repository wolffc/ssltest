<?php
namespace wolffc\ssltest;

interface SSLTestClientInterface{
	/**
	 * set The Logger to Log Progress to
	 * @param \Psr\Log\Logger\Interface $logger the logger
	 */
	public function setLogger(\Psr\Log\LoggerInterface $logger);

	/**
	 * the Domain Name to Test
	 * @param string $domain the domainname (eg. www.yourdomain.com)
	 */
	public function setDomain($domain);

	/**
	 * run the Testing Process and Returns a Status object. 
	 * IMPORTANT while the status returns 0 it has to be run and run again.
	 * @return \wolffc\ssltest\TestResponse the Response Status
	 */
	public function run();
}
?>