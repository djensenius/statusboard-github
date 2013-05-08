<?php

// (Optional) Get your auth_token from GitHub following the instructions here:
// https://help.github.com/articles/creating-an-oauth-token-for-command-line-use
define('AUTH_TOKEN', 'your_token');

// Define the type of graph for repository commit's. Options are bar and line.
define('REPOSITORY_COMMIT_GRAPH', 'line');

// Define the type of graph for user commit's. Options are bar and line.
// The user commits currently go through the repositories specified below.
define('USER_COMMIT_GRAPH', 'bar');

// Define type of graph for issues. Options are bar and line.
// Issues currently go through repositories specified below.
define('REPOSITORY_ISSUE_GRAPH', 'bar');

//Set timeout for the github refresh
define('GITHUB_REFRESH', 300);

// Define the repositories you wish to track.
$repositories = array(
	0 => array(
		'repo' => 'djensenius/statusboard-github/master',
		'name' => 'GitHub Statusboard'
	),
);

?>
