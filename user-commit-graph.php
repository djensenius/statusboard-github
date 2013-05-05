<?php
require_once('config.php');
require_once 'php-github-api/vendor/autoload.php';

$client = new Github\Client();
if (defined('AUTH_TOKEN') && AUTH_TOKEN != 'your_token') {
	$client->authenticate(AUTH_TOKEN, '', Github\Client::AUTH_HTTP_TOKEN);
}

$sevendaysago = date('Y-m-d', strtotime('-6 days')) . 'T00:00:00+00:00';

$graph['graph']['title'] = "User Commits";
$graph['graph']['type'] = USER_COMMIT_GRAPH;

foreach ($repositories as $repository) {
	list($username, $repo, $branch) = explode('/', $repository['repo']);
	$name = $repository['name'];
	error_log("Looping through $name");
	$commits = $client->api('repo')->commits()->all($username, $repo, array('sha' => $branch, 'since' => $sevendaysago));
	foreach ($commits as $commit) {
		if (isset($commit['commit']['author']['name'])) {
			$username = $commit['commit']['author']['name'];
			if (isset($commitname[$username])) {
				$commitname[$username]++;
				
			} else {
				$commitname[$username] = 1;
			}
		}
	}	
}

foreach ($commitname as $name=>$commits) {
	$datapoints = array("value"=>$commits, "title"=>$name);
	$graph['graph']['datasequences'][] = array("title"=>$name, "datapoints"=>array($datapoints));
}

print json_encode($graph) . "\n";
?>