<?php
    if(!session_id()){
        session_start();
    }
    require_once __DIR__ . "/Facebook/autoload.php";

    $session = $_SESSION['fb_access_token'];
    
    $fb = new Facebook\Facebook([
      'app_id' => '452345461790574',
      'app_secret' => '1be44d0b8951900c03a9e67b57d8174e',
      'default_graph_version' => 'v2.9',
      ]);
        $photos = $fb->get('/'.$_GET['id'].'/photos?fields=images',$session)->getGraphEdge()->asArray();
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <title>Amazing Slider</title>
    
    <script src="resources/sliderengine/jquery.js"></script>
    <script src="resources/sliderengine/amazingslider.js"></script>
    <link rel="stylesheet" type="text/css" href="resources/sliderengine/amazingslider-1.css">
    <script src="resources/sliderengine/initslider-1.js"></script>
    
    <style type="text/css">
        body, html {
        height: 100%;
        margin: 0;
        padding: 0;
        overflow: hidden;
        }
    </style>
    
</head>
<body>
    
    <div id="amazingslider-wrapper-1" style="display:block;position:relative;max-width:100%;height:100%;margin:0 auto;">
        <div id="amazingslider-1" style="display:block;position:relative;margin:0 auto;">
            <ul class="amazingslider-slides" style="display:none;">
                <?php
                    foreach($photos as $photo)
                    {
                ?>
                <li><img src="<?php echo $photo['images'][1]['source']; ?>" />
                </li>
                <?php
                    }
                ?>
            </ul>
        </div>
    </div>
    
</body>
</html>