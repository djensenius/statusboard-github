<?php

// (Optional) Get your auth_token from GitHub following the instructions here:
// https://help.github.com/articles/creating-an-oauth-token-for-command-line-use
define('AUTH_TOKEN', 'your_token');

// Define the type of graph for repository commit's. Options are bar and line
define('REPOSITORY_COMMIT_GRAPH', 'line');

// Define the repositories you wish to track.
$repositories = array(
	0 => array(
		'repo' => 'djensenius/statusboard-github/master',
		'name' => 'GitHub Statusboard'
	),
);

?>
