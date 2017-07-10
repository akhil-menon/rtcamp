<?php
	if(!session_id()){
		session_start();
	}

	require_once __DIR__ . "/Facebook/autoload.php";
	
	$fb = new Facebook\Facebook([
	  'app_id' => '452345461790574',
	  'app_secret' => '1be44d0b8951900c03a9e67b57d8174e',
	  'default_graph_version' => 'v2.9',
	  ]);

	try {
	  // Returns a `Facebook\FacebookResponse` object
	  $response = $fb->get('/me?fields=id,name,gender,birthday,picture,cover', $_SESSION['fb_access_token']);
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
	  echo 'Graph returned an error: ' . $e->getMessage();
	  exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
	  echo 'Facebook SDK returned an error: ' . $e->getMessage();
	  exit;
	}

	$user = $response->getGraphUser();
	print_r($user);
	echo '<br/>Name: '.$user['name'].'<br/>';
	echo 'Gender: '.$user['gender'].'<br/>';
	echo 'DOB: '.$user['birthday'].'<br/>';
	echo '<img src="'.$user['picture']['url'].'"/><br/>';
	echo '<img src="'.$user['cover']['source'].'"/><br/>';
	// OR
	// echo 'Name: ' . $user->getName();
?>