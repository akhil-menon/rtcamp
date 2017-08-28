<?php
	session_start();
	if(isset($_POST['logout'])){
		if(isset($_SESSION['fb_access_token'])){
			session_unset('fb_access_token');
		}
		if (isset($_COOKIE['credentials'])) {
		    unset($_COOKIE['credentials']);
		    setcookie('credentials', '', time() - 3600, '/');
		}
	}
	header('Location: http://local.rtcampproj.com/login.php');
?>