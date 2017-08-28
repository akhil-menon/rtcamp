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

	$helper = $fb->getRedirectLoginHelper();

	$permissions = ['email'];
	$loginUrl = $helper->getLoginUrl('http://local.rtcampproj.com/callback.php', $permissions);
?>
<!DOCTYPE html>
<html class="no-js">
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>

	<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
	<link rel="shortcut icon" href="favicon.ico">

	<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,600,400italic,700' rel='stylesheet' type='text/css'>
	
	<!-- Animate.css -->
	<link rel="stylesheet" href="resources/css/animate.css">
	<!-- Icomoon Icon Fonts-->
	<link rel="stylesheet" href="resources/css/icomoon.css">
	<!-- Simple Line Icons -->
	<link rel="stylesheet" href="resources/css/simple-line-icons.css">
	<!-- Magnific Popup -->
	<link rel="stylesheet" href="resources/css/magnific-popup.css">
	<!-- Bootstrap  -->
	<link rel="stylesheet" href="resources/css/bootstrap.css">
	<!-- owl carousal -->
	<link rel="stylesheet" href="resources/css/owl.carousel.css">
	<link rel="stylesheet" href="resources/css/owl.theme.css">
	<link rel="stylesheet" href="resources/css/owl.transitions.css">

	<link rel="stylesheet" href="resources/css/style.css">
	<link rel="stylesheet" href="resources/css/jquery-ui.min.css">

	<!-- Modernizr JS -->
	<script src="resources/js/modernizr-2.6.2.min.js"></script>
	<!-- jQuery -->
	<script src="resources/js/jquery.min.js"></script>
	<script type="text/javascript" src="resources/js/jquery-ui.min.js"></script>
	<!-- amazing slider -->
    <script src="resources/sliderengine/jquery.js"></script>
    <script src="resources/sliderengine/amazingslider.js"></script>
    <link rel="stylesheet" type="text/css" href="resources/sliderengine/amazingslider-1.css">
    <script src="resources/sliderengine/initslider-1.js"></script>
    
	</head>
	<body>
	<section id="fh5co-home" data-section="home" style="background-image: url(resources/images/full_image_2.jpg);" data-stellar-background-ratio="0.5">
		<div class="gradient"></div>
		<div class="container">
			<div class="text-wrap">
				<div class="text-inner">
					<div class="row">
						<div class="col-md-8 col-md-offset-2">
							<h1 class="to-animate">Download and Take Backup of Everything You Love.</h1><br/>
							<a href="<?php echo htmlspecialchars($loginUrl) ?>" class="btn btn-info">Log in with Facebook!</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="slant"></div>
	</section>

	<!-- jQuery Easing -->
	<script src="resources/js/jquery.easing.1.3.js"></script>
	<!-- Bootstrap -->
	<script src="resources/js/bootstrap.min.js"></script>
	<!-- Waypoints -->
	<script src="resources/js/jquery.waypoints.min.js"></script>
	<!-- Stellar Parallax -->
	<script src="resources/js/jquery.stellar.min.js"></script>
	<!-- Counter -->
	<script src="resources/js/jquery.countTo.js"></script>
	<!-- Magnific Popup -->
	<script src="resources/js/jquery.magnific-popup.min.js"></script>
	<script src="resources/js/magnific-popup-options.js"></script>

	<!-- Main JS (Do not remove) -->
	<script src="resources/js/main.js"></script>

	</body>
</html>