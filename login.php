<?php
	if(!session_id()){
		session_start();
	}
	require_once __DIR__ . "/Facebook/autoload.php";
	$fb = new Facebook\Facebook([
	  'app_id' => '452345461790574', // Replace {app-id} with your app id
	  'app_secret' => '1be44d0b8951900c03a9e67b57d8174e',
	  'default_graph_version' => 'v2.9',
	  ]);

	$helper = $fb->getRedirectLoginHelper();

	$permissions = ['email']; // Optional permissions
	$loginUrl = $helper->getLoginUrl('http://local.rtcampproj.com/callback.php', $permissions);

	echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';
?>