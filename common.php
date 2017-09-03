<?php
	if(!session_id()){
		session_start();
	}
	if(!isset($_SESSION['fb_access_token'])){
		header('Location: http://local.rtcampproj.com/login.php');
	}
	require_once __DIR__ . "/Facebook/autoload.php";
	
	$fb = new Facebook\Facebook([
	  'app_id' => '452345461790574',
	  'app_secret' => '1be44d0b8951900c03a9e67b57d8174e',
	  'default_graph_version' => 'v2.8',
	  ]);

	try {
	  // Returns a `Facebook\FacebookResponse` object
	  $response = $fb->get('/me?fields=id,name,gender,birthday,picture,cover,albums', $_SESSION['fb_access_token']);
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
	  echo 'Graph returned an error: ' . $e->getMessage();
	  exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
	  echo 'Facebook SDK returned an error: ' . $e->getMessage();
	  exit;
	}
?>