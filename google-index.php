<?php
	session_start();
	print_r($_SESSION['access_token']);

	require_once __DIR__.'/google/vendor/autoload.php';

	$oauth_credentials = __DIR__.'/google/client_secret.json';
	$client = new Google_Client();
	$client->setAuthConfig($oauth_credentials);
	$client->setAccessType("offline");        // offline access
	$client->setIncludeGrantedScopes(true);   // incremental auth
	$client->addScope(Google_Service_Drive::DRIVE_METADATA_READONLY);
	// Get the API client and construct the service object.
	//$client = getClient();
	$drive = new Google_Service_Drive($client_secret);

	$files = $drive->files->listFiles(array())->getItems();

	foreach ($files->files as $file) {
	    printf("Found file: %s (%s)", $file->name, $file->id);
	}
?>