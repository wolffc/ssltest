<?php
namespace wolffc\ssltest;
require 'vendor/autoload.php';

$options = getopt('',array('minimum-rating:','domain:','report-file:'));
if (!array_key_exists('domain',$options)){
	printUsage();
	die(1);
}

function printUsage(){
	echo 'USAGE: php ssltest-cli.php --domain=www.example.com [--minimum-rating=B] [--report-file=report.html]';
};

$testDomain = $options['domain'];
$reportDir = dirname(__FILE__) . '/reports/' .$testDomain;
$reportFile = $reportDir .'/'.time() .'.html';

$testClient = new SSLTestClient();
$testClient->setDomain($testDomain);
echo 'run test: ';
do {
	$testResult = $testClient->run();
	echo '.';
} while ($testResult->isDone() === false);

if (array_key_exists('report-file',$options)){
	file_put_contents($options['report-file'], $testResult->getBody());
}

echo 'Rating: ' . $testResult->getRating() . PHP_EOL;

if (array_key_exists('minimum-rating',$options)){
	if($testResult->ratingIsHigherOrEqual($options['minimum-rating'])){
		exit(0);
	}else{
		exit(1);
	}
}
exit(0);

?>