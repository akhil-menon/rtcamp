<?php
	// if(!session_id()){
 //        session_start();
 //    }
 //    require_once __DIR__ . "/Facebook/autoload.php";

 //    $session = $_SESSION['fb_access_token'];
    
 //    $fb = new Facebook\Facebook([
 //      'app_id' => '452345461790574',
 //      'app_secret' => '1be44d0b8951900c03a9e67b57d8174e',
 //      'default_graph_version' => 'v2.9',
 //      ]);
 //        $photos = $fb->get('/'.$_GET['id'].'/photos?fields=images',$session)->getGraphEdge()->asArray();
?>

<html>
<head>
	<script type="text/javascript" src="resources/js/slider.js"></script>
	<link rel="stylesheet" type="text/css" href="resources/css/slider.css">
</head>
<body>
	<div id="slide-window">
  
    <ol id="slides" start="1">
    
      <li class="slide color-0 alive" style="background-image:url(http://stuckincustoms.smugmug.com/Portfolio/i-JSxf5Nm/0/X3/Burning-Man-Day-6%20%28202%20of%201606%29-X3.jpg);"></li>
      
      <li class="slide color-1" style="background-image:url(http://stuckincustoms.smugmug.com/Portfolio/i-KMjVHRd/0/X3/Andramada-X3.jpg);"></li>
      
      <li class="slide color-2" style="background-image:url(http://stuckincustoms.smugmug.com/Burning-Man/i-dd9xmfn/0/X3/The%20Steamy%20Car-X3.jpg);"></li>
      
      <li class="slide color-3" style="background-image:url(http://stuckincustoms.smugmug.com/Portfolio/i-KscS8CF/0/X3/Burning-Man-Day-1%20%281006%20of%201210%29-X3.jpg);"></li>
      
      <li class="slide color-4" style="background-image:url(http://stuckincustoms.smugmug.com/Portfolio/i-jQcPqJb/0/X3/Burning-Man-Last-Day-Night%20%28151%20of%201120%29-X3.jpg);"></li>
    
    </ol>
 
    <span class="nav fa fa-chevron-left fa-3x" id="left"></span>
    <span class="nav fa fa-chevron-right fa-3x" id="right"></span>
    
    <div id="credit">Photography by Trey Ratcliff<br>Slide No.<span id="count">1</span><br><span id="zoom">zoom</span></div>
    
</div>
</body>
</html>