<?php
require_once('config.php');
require_once 'php-github-api/vendor/autoload.php';

$client = new Github\Client();
if (defined('AUTH_TOKEN') && AUTH_TOKEN != 'your_token') {
	$client->authenticate(AUTH_TOKEN, '', Github\Client::AUTH_HTTP_TOKEN);
}

$sevendaysago = date('Y-m-d', strtotime('-7 days')) . 'T00:00:00+00:00';

$graph['graph']['title'] = "Issues per Repository";
$graph['graph']['type'] = REPOSITORY_ISSUE_GRAPH;

foreach ($repositories as $repository) {
	list($username, $repo, $branch) = explode('/', $repository['repo']);
	$name = $repository['name'];
	$repo = $client->api('repo')->show($username, $repo);
	if ($repo['open_issues'] > 0) {
		$datapoints = array("value"=>$repo['open_issues'], "title"=>$name);
		$graph['graph']['datasequences'][] = array("title"=>$name, "datapoints"=>array($datapoints));	
	}	
}

print json_encode($graph) . "\n";

?>