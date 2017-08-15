<?php
	require "common.php";
	
	$user = $response->getGraphUser();
	//var_dump($user);
	echo '<br/>Name: '.$user['name'].'<br/>';
	echo 'Gender: '.$user['gender'].'<br/>';
	echo 'DOB: '.$user['birthday']->format('d/m/Y').'<br/>';
	echo '<img src="'.$user['picture']['url'].'"/><br/>';
	echo '<img src="'.$user['cover']['source'].'"/><br/>';
	echo '<br/><br/>';

	$albums = $fb->get('/me/albums',$_SESSION['fb_access_token'])->getGraphEdge()->asArray();

	foreach ($albums as $album) {
		echo '<input type="hidden" id="hdnalbumid" value="'.$album['id'].'"/>';
		echo '<a id="slider" href="#">'.$album['name'].'</a>&nbsp;<input type="button" id="download" value="Download">&nbsp;|&nbsp;';
	}

	echo '<div id="slid"></div>';
	
?>
<script src='assets/js/jquery-3.1.1.min.js' type="text/javascript"></script>
<script type="text/javascript">
	$('#download').click(function() {

		$.ajax({
		  type: "POST",
		  url: "download.php",
		  data: { albumid: $('#hdnalbumid').val() }
		}).done(function( msg ) {
		  alert( "Data Saved: " + msg.d );
		});    

    });

    $("#slider").click(function() {
    	$.ajax({
    		type: "POST",
    		url: "slider.php",
    		data: { albumid: $('#hdnalbumid').val() }
    	}).done(function(msg) {
    		$("#slid").empty();
    		$("#slid").html(msg);
    	});
    });
</script>