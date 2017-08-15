<?php
require_once __DIR__.'/google/vendor/autoload.php';
$oauth_credentials = __DIR__.'/google/client_secret.json';

session_start();

$client = new Google_Client();
$client->setAuthConfig($oauth_credentials);
$client->setAccessType("offline");        // offline access
$client->setIncludeGrantedScopes(true);
$client->addScope(Google_Service_Drive::DRIVE_METADATA_READONLY);

//session_unset('access_token');

if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $client->setAccessToken($_SESSION['access_token']);
  $drive = new Google_Service_Drive($client);

  //checking whether folder exists or not
  $pageToken = null;
	do {
	  $response = $drive->files->listFiles(array(
	    // 'q' => "mimeType='image/jpeg'",
	    'spaces' => 'drive',
	    // 'q' => "name = 'My Drive'",
	    'pageToken' => $pageToken,
	    'fields' => 'nextPageToken, files(id, name)',
	    'pageSize' => 10
	  ));
	  foreach ($response->files as $file) {
	      printf("Found file: %s (%s)<br/>", $file->name, $file->id);
	  }
	} while ($pageToken != null);

	//response empty then create folder else redirect
	if(empty($response)){
		echo "af";
		// $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/google-index.php';
		// header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
	}
	else{
		$fileMetadata = new Google_Service_Drive_DriveFile(array(
		  'title' => 'Invoices',
		  'parents' => array('0B6dcBiaGljMURkxyN2JOZlFXbnM'),
		  'mimeType' => 'application/vnd.google-apps.folder'));
		$file = $drive->files->create($fileMetadata, array('fields' => 'id'));
		printf("Folder ID: %s\n", $file->id);
	}	
} else {
  $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/google-auth.php';
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}
?>