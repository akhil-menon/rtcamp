<?php
	require_once "common.php";
	require_once "googleloginfunc.php";
	
	$user = $response->getGraphUser();

	header('Content-Type: text/html; charset=utf-8');

	global $CLIENT_ID, $CLIENT_SECRET, $REDIRECT_URI;
	$client = new Google_Client();
	$client->setClientId($CLIENT_ID);
	$client->setClientSecret($CLIENT_SECRET);
	$client->setRedirectUri($REDIRECT_URI);
	$client->setScopes('email');

	if(!isset($_COOKIE['credentials']) && isset($_GET['code'])){
		$authUrl = $client->createAuthUrl();	
		getCredentials($_GET['code'], $authUrl);
		$userName = $_SESSION["userInfo"]["name"];
		$userEmail = $_SESSION["userInfo"]["email"];
		header('Location: http://local.rtcampproj.com/index.php?code='.$_GET['code']);
	}


?>
<!DOCTYPE html>
<html class="no-js">
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $user['name'];?></title>

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
    <style>
    	#overlay {
		    position: fixed; /* Sit on top of the page content */
		    display: none; /* Hidden by default */
		    width: 100%; /* Full width (cover the whole page) */
		    height: 100%; /* Full height (cover the whole page) */
		    top: 0; 
		    left: 0;
		    right: 0;
		    bottom: 0;
		    background-color: rgba(0,0,0,0.5); /* Black background with opacity */
		    z-index: 100; /* Specify a stack order in case you're using a different order for other elements */
		}

    	.loader {
    		position:absolute;
    		top:50%;
    		left:50%;
			border: 16px solid #f3f3f3; /* Light grey */
			border-top: 16px solid blue;
 			border-bottom: 16px solid blue;
			border-radius: 50%;
			width: 120px;
			height: 120px;
			animation: spin 2s linear infinite;
		}

		@keyframes spin {
			0% { transform: rotate(0deg); }
			100% { transform: rotate(360deg); }
		}
    </style>
	<script>

		$(document).ready(function() {

			$('.downloadall').click(function() {
				var getall=1;
				$.ajax({
					type: "POST",
					url: "download.php",
					data: { getall: getall },
					beforeSend:function(){
					  	$("#overlay").show();
					  },
					  complete:function(){
					  	$("#overlay").hide();
					  }
				}).done(function(msg) {
					alert("Data Saved");
					$("#down").html(msg);
					$('html,body').animate({
				    scrollTop: $('#down').offset().top - 80
					}, 1000);
				})
			});

			$('.download').click(function() {
				var albumid = $(this).attr('id').split('/');
				//alert(albumid[1]);
				$.ajax({
				  type: "POST",
				  url: "download.php",
				  data: { albumid: albumid[0], albumname: albumid[1] },
				  beforeSend:function(){
				  	$("#overlay").show();
				  },
				  complete:function(){
				  	$("#overlay").hide();
				  }
				}).done(function( msg ) {
				  alert( "Data Saved");
				  $("#down").html(msg);
				  $('html,body').animate({
				    scrollTop: $('#down').offset().top - 80
					}, 1000);
				});    
		    });

	    	$(".downloadselected").click(function() {
	    		var albumids = [];
	    		var albumnames = [];
				$("input[name='chkbx[]']:checked").each(function ()
				{
					var albumid = $(this).attr('id').split('/');
				    albumids.push(albumid[0]);
				    albumnames.push(albumid[1]);
				});
	    		alert(albumids+"/"+albumnames);
	    		
	    		$.ajax({
				  type: "POST",
				  url: "download.php",
				  data: { albumids: albumids, albumnames: albumnames },
				  beforeSend:function(){
				  	$("#overlay").show();
				  },
				  complete:function(){
				  	$("#overlay").hide();
				  }
				}).done(function( msg ) {
				  alert( "Data Saved");
				  $("#down").html(msg);
				  $('html,body').animate({
				    scrollTop: $('#down').offset().top - 80
					}, 1000);
				});
	    	});

			$('.moveall').click(function() {
				var username = $(".username").html();
				var getall=1;
				$.ajax({
					type: "POST",
					url: "move.php",
					data: { getall: getall, username: username },
					beforeSend:function(){
					  	$("#overlay").show();
					  },
					  complete:function(){
					  	$("#overlay").hide();
					  }
				}).done(function(msg) {
					alert("Data Moved");
				})
			});

	    	$('.move').click(function() {
	    		var username = $(".username").html();
				var albumid = $(this).attr('id').split('/');
				$.ajax({
				  type: "POST",
				  url: "move.php",
				  data: { albumid: albumid[0], albumname: albumid[1], username: username },
				  beforeSend:function(){
				  	$("#overlay").show();
				  },
				  complete:function(){
				  	$("#overlay").hide();
				  }
				}).done(function( msg ) {
				  alert( "Data Moved");
				});    
		    });

		    $(".moveselected").click(function() {
		    	var username = $(".username").html();
	    		var albumids = [];
	    		var albumnames = [];
				$("input[name='chkbx[]']:checked").each(function ()
				{
					var albumid = $(this).attr('id').split('/');
				    albumids.push(albumid[0]);
				    albumnames.push(albumid[1]);
				});
	    		alert(albumids+"/"+albumnames);
	    		
	    		$.ajax({
				  type: "POST",
				  url: "move.php",
				  data: { albumids: albumids, albumnames: albumnames, username:username },
				  beforeSend:function(){
				  	$("#overlay").show();
				  },
				  complete:function(){
				  	$("#overlay").hide();
				  }
				}).done(function( msg ) {
				  alert( "Data Moved");
				});
	    	});

		    $("#logout").click(function() {
		    	$.ajax({
		    		type: "POST",
		    		url: "logout.php",
		    		data: { logout: 1 }
		    	}).done(function(msg) {
		    		window.location="http://local.rtcampproj.com/login.php";
	    		});
	    	});
		});
	</script>

	</head>
	<body>
	<header role="banner" id="fh5co-header">
			<div class="container">
				<!-- <div class="row"> -->
			    <nav class="navbar navbar-default">
		        <div class="navbar-header">
		        	<!-- Mobile Toggle Menu Button -->
					<a href="#" class="js-fh5co-nav-toggle fh5co-nav-toggle" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"><i></i></a>
		         <a class="username navbar-brand" href="index.php"><?php echo $user['name'];?></a> 
		        </div>
		        <div id="navbar" class="navbar-collapse collapse">
		          <ul class="nav navbar-nav navbar-right">
		            <li class="active"><a href="#" data-nav-section="albums"><span>Albums</span></a></li>
		            <li><a href="#" class="downloadall"><span>Download All</span></a></li>
		            <li><a href="#" class="downloadselected"><span>Download Selected</span></a></li>
		            <li><a href="#" class="moveall"><span>Move All</span></a></li>
		            <li><a href="#" class="moveselected"><span>Move Selected</span></a></li>
		            <li><a id="logout" href="#"><span>Logout</span></a></li>
		          </ul>
		        </div>
			    </nav>
			  <!-- </div> -->
		  </div>
	</header>
	<section id="fh5co-home" data-section="home" style="background-image: url(resources/images/full_image_2.jpg);" data-stellar-background-ratio="0.5">
		<div class="gradient"></div>
		<div class="container">
			<div class="text-wrap">
				<div class="text-inner">
					<div class="row">
						<div class="col-md-8 col-md-offset-2">
							<h1 class="to-animate">Download and Take Backup of Everything You Love.</h1>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="slant"></div>
	</section>

	<section id="fh5co-intro" data-section="albums">
		<div class="container">
		<div id="down">Click on download to download that album</div>
			<div class="row row-bottom-padded-lg">
				<?php 
					$albums = $fb->get('/me/albums',$_SESSION['fb_access_token'])->getGraphEdge()->asArray();
					foreach ($albums as $album) {
				?>
				<div class="fh5co-block to-animate" style="background-image: url(resources/images/img_7.jpg);">
					<div class="overlay-darker"></div>
					<div class="overlay"></div>
					<div class="fh5co-text">
						<input type="checkbox" name="chkbx[]" id="<?php echo $album['id']."/".$album['name'];?>"/>
						<i class="fh5co-intro-icon icon-bulb"></i>
						<h2><a id="<?php echo $album['id'];?>" href="slider.php?id=<?php echo $album['id'];?>" class="slider"><?php echo $album['name'];?></a></h2>
						<div id="progress"></div>
						<br/>
						<p>
							<a id="<?php echo $album['id']."/".$album['name'];?>" href="#" class="download btn btn-primary">Download</a>
							<?php
								if(isset($_COOKIE['credentials'])){
							?>
							<a id="<?php echo $album['id']."/".$album['name'];?>" class="move btn btn-primary">Move</a>
							<?php
								}
								else{
							?>
							<p>
								<a href="<?php echo getAuthorizationUrl("", "");?>">Login </a>with google for moving your albums to your drive.
							</p>
							<?php
								}
							?>
						</p>
					</div>
				</div>
				<?php
					}
				?>
			</div>
		</div>
		<div id="overlay" style="display: none;">
			<div class="loader"></div>
		</div>
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

