<?php
require_once "common.php";
require_once "googleloginfunc.php";
require_once __DIR__ . "/lib/Facebook/autoload.php";
require_once __DIR__."/lib/google-api-php-client/src/Google/Service/Drive.php";

//fb details for photo fetching from album
$fb = new Facebook\Facebook([
  'app_id' => '452345461790574',
  'app_secret' => '1be44d0b8951900c03a9e67b57d8174e',
  'default_graph_version' => 'v2.9',
  ]);

$session = $_SESSION['fb_access_token'];

// Init the variables
$driveInfo = "";
$folderName = "";
$folderDesc = "";
$files = "";
$parentId = "";

// Get the client Google credentials
$credentials = $_COOKIE["credentials"];

// Get your app info from JSON downloaded from google dev console
$json = json_decode(file_get_contents(__DIR__."/google-api-php-client/client_secret.json"), true);
$CLIENT_ID = $json['web']['client_id'];
$CLIENT_SECRET = $json['web']['client_secret'];
$REDIRECT_URI = $json['web']['redirect_uris'][3];

// Create a new Client
$client = new Google_Client();
$client->setClientId($CLIENT_ID);
$client->setClientSecret($CLIENT_SECRET);
$client->setRedirectUri($REDIRECT_URI);
$client->addScope(
	"https://www.googleapis.com/auth/drive", 
	"https://www.googleapis.com/auth/drive.appfolder");

// Refresh the user token and grand the privileges
$client->setAccessToken($credentials);
$service = new Google_Service_Drive($client);

//move single album to google drive
if(isset($_POST['albumid'])){
	$folderName = "Facebook_".$_POST['username']."_Album";
	$folderDesc = "Facebook_".$_POST['username']."_Album";

	//creating or fetching parentid of the folder
	$parentId = getFolderExistsCreate($service,$folderName,$folderDesc);

	//fetches all photos of a particular album
	$files = $fb->get('/'.$_POST['albumid'].'/photos?fields=images',$session)->getGraphEdge()->asArray();
	$title = $_POST['albumname'];
	$description = $_POST['albumname'];
	$mimeType = "application/vnd.google-apps.photo";

	//moving single album
	insert($service,$title,$description,$mimeType,$files,$title,$parentId);
}	

//moving all albums
if(isset($_POST['getall'])){
	$folderName = "Facebook_".$_POST['username']."_Album";
	$folderDesc = "Facebook_".$_POST['username']."_Album";

	//creating or fetching parentid of the folder
	$parentId = getFolderExistsCreate($service,$folderName,$folderDesc);

	//fetch all the albums of user
	$albums = $fb->get('/me/albums',$session)->getGraphEdge()->asArray();

	foreach ($albums as $album) {
		$album = (object)$album;
		$albumid = $album->id;
		$albumname = $album->name;
		
		//fetches all photos of a particular album
		$files = $fb->get('/'.$albumid.'/photos?fields=images',$session)->getGraphEdge()->asArray();
		$title = $albumname;
		$description = $albumname;
		$mimeType = "application/vnd.google-apps.photo";

		//moving each album one by one
		insert($service,$title,$description,$mimeType,$files,$title,$parentId);
	}
}

//moving selected album
if(isset($_POST['albumids']) && isset($_POST['albumnames'])){
	$albumid = $_POST['albumids'];
	$albumname = $_POST['albumnames'];

	for ($i=0; $i < count($albumid) ; $i++) { 
		$folderName = "Facebook_".$_POST['username']."_Album";
		$folderDesc = "Facebook_".$_POST['username']."_Album";

		//creating or fetching parentid of the folder
		$parentId = getFolderExistsCreate($service,$folderName,$folderDesc);

		//fetches all photos of a particular album
		$files = $fb->get('/'.$albumid[$i].'/photos?fields=images',$session)->getGraphEdge()->asArray();
		$title = $albumname[$i];
		$description = $albumname[$i];
		$mimeType = "application/vnd.google-apps.photo";

		//move selected albums to google drive
		insert($service,$title,$description,$mimeType,$files,$title,$parentId);
	}
}

//creates folder if it doesnot exists
function getFolderExistsCreate($service, $folderName, $folderDesc,$parentId="") {
	$files = $service->files->listFiles();
	$found = false;
	foreach ($files['items'] as $item) {
		if ($item['title'] == $folderName) {
			$found = true;
			return $item['id'];
			break;
		}
	}

	// If not found, create one
	if ($found == false) {
		$folder = new Google_Service_Drive_DriveFile();

		$folder->setTitle($folderName);

		if(!empty($folderDesc))
			$folder->setDescription($folderDesc);

		$folder->setMimeType('application/vnd.google-apps.folder');
		if($parentId != ""){
			var_dump($parentId);
			$parent = new Google_Service_Drive_ParentReference();
			$parent->setId($parentId);
			$folder->setParents(array($parent));
		}

		try {
			$createdFile = $service->files->insert($folder, array(
				'mimeType' => 'application/vnd.google-apps.folder',
				));
			echo $createdFile->id;
			return $createdFile->id;
		} catch (Exception $e) {
			print "An error occurred: " . $e->getMessage();
		}
	}
}

//moving album to google drive
function insert($service,$title,$description,$mimeType,$files,$folderName,$parentId){
	$i=0;
	var_dump($files);
	foreach ($files as $movefile) {
		$file = new Google_Service_Drive_DriveFile();
		$i++;

		// Set the metadata
		$file->setTitle($title.$i);
		$file->setDescription($description);

		// creates or gets the folder and its id
		if(isset($folderName)) {
			if(!empty($folderName)) {
				$parent = new Google_Service_Drive_ParentReference();
				$parent->setId($parentId);
				$file->setParents(array($parent));
				$parent = new Google_Service_Drive_ParentReference();
				$parent->setId(getFolderExistsCreate($service, $folderName, $folderName,$parentId));
				// print_r($parent);
				$file->setParents(array($parent));
			}
		}
		try {
			$data = file_get_contents($movefile['images'][1]['source']);

			$createdFile = $service->files->insert($file, array(
				'data' => $data,
				'uploadType'=> 'multipart'
				));
		} catch (Exception $e) {
			print "An error occurred: " . $e->getMessage();
		}
	}

}
?>