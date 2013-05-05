<?php
require_once('config.php');
require_once 'php-github-api/vendor/autoload.php';

$client = new Github\Client();
if (defined('AUTH_TOKEN') && AUTH_TOKEN != 'your_token') {
	$client->authenticate(AUTH_TOKEN, '', Github\Client::AUTH_HTTP_TOKEN);
}

$sevendaysago = date('Y-m-d', strtotime('-6 days')) . 'T00:00:00+00:00';

$graph['graph']['title'] = "Repository Commits";
$graph['graph']['type'] = REPOSITORY_COMMIT_GRAPH;

foreach ($repositories as $repository) {
	unset($commitdate);
	$commitdate = array();
	list($username, $repo, $branch) = explode('/', $repository['repo']);
	$name = $repository['name'];
	$commits = $client->api('repo')->commits()->all($username, $repo, array('sha' => $branch, 'since' => $sevendaysago));
	foreach ($commits as $commit) {
		if (isset($commit['commit']['author']['date'])) {
			$date = date('l', strtotime($commit['commit']['author']['date']));
			if (isset($commitdate[$date])) {
				$commitdate[$date]++;
			} else {
				$commitdate[$date] = 1;
			}
		}
	}
	
	unset($datapoint);
	if (!empty($commitdate)) {
		$x = 0;
		while ($x < 7) {
			$d = date('l', strtotime("-$x days"));
			if (!isset($commitdate[$d])) {
				$commitdate[$d] = 0;
			}
			$datapoint[$x] = array(
				"title" => $d,
				"value" => $commitdate[$d]
			);
			$x++;
		}
		$graph['graph']['datasequences'][] = array('title' => $name, 'datapoints' => $datapoint);
	}
}
print json_encode($graph) . "\n";
?>