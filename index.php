<?php
  require_once __DIR__ . "/Facebook/autoload.php";
  $fb = new \Facebook\Facebook([
    'app_id' => '452345461790574',
    'app_secret' => '1be44d0b8951900c03a9e67b57d8174e',
    'default_graph_version' => 'v2.8',
    ]);
  $permissions = [];
  $helper = $fb->getRedirectLoginHelper();
  //$accessToken = $helper->getAccessToken();

  if(isset($accessToken)){
    $url = "https://graph.facebook.com/v2.9/me?fields=id%2Cname%2Cgender%2Cemail%2Ccover%2Cpicture%2Calbums&access_token=EAACEdEose0cBAMfi7ZBsOFzZAsfm2ECOFQwf7siGY17DXr80Msd8OLqOpKBmWoFoGaUAw5jlBZBYR0Pn3quOZCYWlwJG1RQt1dE7TTVJOQUBNyye55IPZA2LR4vZAptstEbSb3I1fWPA4PN2BmSZBdEdxW5j3F2MSciIIHfVe5dF60DOWxfboQHZA52WtuUoXSQZD";
    $headers = array("content-type: application/json");

    $ch = curl_init();
    curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_FOLLOWlOCATION,1);
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($ch,CURLOPT_COOKIEJAR,'cookie.txt');
    curl_setopt($ch,CURLOPT_COOKIEFILE,'cookie.txt');
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);

    $st = curl_exec($ch);
    $result = json_decode($st,true);
    echo "My Name:".$result['name'];
    echo "<img src='".$result['picture']['source']."'/>";


  }
  else{
    $loginurl = $helper->getLoginUrl('http://local.rtcampproj.com/index.php',$permissions);
    echo '<a href="'.$loginurl.'">Log in With Facebook</a>';
  }
?>
<html>
<head>
	<title>demo</title>
	<script src="./assets/js/jquery-3.1.0.js"></script>
</head>
<body>
<p>Hi....Facebook Demo.....</p>
<div id="test"></div>
<button id="fblogin" onclick="login()">FB Login</button>
<!-- <div
  class="fb-like"
  data-share="true"
  data-width="450"
  data-show-faces="true">
</div> -->
</body>
</html>