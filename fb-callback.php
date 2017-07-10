<?php
	session_start();
	require_once __DIR__ . "/Facebook/autoload.php";
	$fb = new Facebook\Facebook([
  		'app_id' => '452345461790574',
    	'app_secret' => '1be44d0b8951900c03a9e67b57d8174e',
		'default_graph_version' => 'v2.9',
  	]);

	$helper = $fb->getRedirectLoginHelper();

	try {
	  $accessToken = $helper->getAccessToken();
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
	  // When Graph returns an error
	  echo 'Graph returned an error: ' . $e->getMessage();
	  exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
	  // When validation fails or other local issues
	  echo 'Facebook SDK returned an error: ' . $e->getMessage();
	  exit;
	}

	if ($accessToken !== null) {
	    $Response = $fb->get('me?fields=id,name,picture,cover,birthday,albums{picture}', $accessToken);
	    $user_data = $Response->getGraphUser();
	    print_r($user_data);
	}

	$_SESSION['fb_access_token'] = (string) $accessToken;
?>
	<div>
		<div>
			<img src="<?php echo $user_data['cover']['source']; ?>"/><br/>
			<?php echo $user_data['birthday']; ?>
		</div>
		<p><img src="<?php echo $user_data['picture']['url']; ?>"/>&nbsp;<?php echo $user_data['name']; ?></p><br/>
		<div>
			<img src="<?php echo $user_data['data']['picture']['data']['url'];?>"/>
		</div>
	</div>
<?php
	// // User is logged in with a long-lived access token.
	// // You can redirect them to a members-only page.
	// //header('Location: https://example.com/members.php');
?>