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

	$session = $_SESSION['fb_access_token'];
	$dtype = 0;

	//uniqid() : to prevent the exception of folder already exists	
	$album_download_directory = 'resources/albums/'.uniqid().'/';
	mkdir($album_download_directory, 0777);

	if(isset($_POST['albumid'])){
		//download single album
		downloadalbum($dtype,$fb,$_POST['albumid'],$session,$_POST['albumname'],$album_download_directory);
		?>
		To Download <a href="<?php echo $album_download_directory."/".$_POST['albumname'].".zip";?>" download>Click Here</a>	
		<?php
	}

	if(isset($_POST['getall'])){
		$dtype = 2;
		//downloads all albums
		downloadall($dtype,$fb,$session,$album_download_directory);
		?>
		To Download <a href="<?php echo $album_download_directory."/facebook.zip";?>" download>Click Here</a>	
		<?php
	}

	if(isset($_POST['albumids']) && isset($_POST['albumnames'])){
		$dtype = 1;
		$dest = 'resources/albums/facebook';

		//download selected albums
		$albumid = $_POST['albumids'];
		$albumname = $_POST['albumnames'];
		for ($i=0; $i < count($albumid) ; $i++) { 
			downloadalbum($dtype,$fb,$albumid[$i],$session,$albumname[$i],$album_download_directory);
		}

		rcopy($album_download_directory,$dest);

		folderzip($dest);

		deleteDir($album_download_directory);

		rmdir_recursive("resources/albums/facebook");

		?>
		To Download <a href="<?php echo "resources/albums/facebook.zip";?>" download>Click Here</a>	
		<?php
	}

	function downloadall($dtype,$fb,$session,$album_download_directory){
		//fetch all the albums of user
		$albums = $fb->get('/me/albums',$session)->getGraphEdge()->asArray();

		foreach ($albums as $album) {
			$album = (object)$album;
			$albumid = $album->id;
			$albumname = $album->name;

			//downloads each album one by one
			downloadalbum($dtype,$fb,$albumid,$session,$albumname,$album_download_directory);

		}
		//zip the whole folder
		folderzip($album_download_directory);

		rename($album_download_directory.'/.zip',$album_download_directory.'/facebook.zip');
		//removes the folder
		//deleteDir($album_download_directory);
	}

	function downloadalbum($dtype,$fb,$albumid,$session,$albumname,$album_download_directory){
		$album_directory = $album_download_directory.$albumname;
		
		//checks whether the file already exists or not
		if ( !file_exists( $album_directory ) ) {
			mkdir($album_directory, 0777);
		}

		//fetches all photos of a particular album
		$photos = $fb->get('/'.$albumid.'/photos?fields=images',$session)->getGraphEdge()->asArray();

		$i=0;
		foreach ($photos as $photo) {
			$url = $photo['images'][1]['source'];
			file_put_contents($album_directory.'/'.$i.'.jpg', fopen($url,'r'));
			$i++;
		}
		
		if($dtype == 0 ){
			//folder is compressed to .zip
			folderzip($album_directory);

			//folder is removed after compression
			deleteDir($album_directory);
		}

	}

	function folderzip($album_directory){
		$dir = $album_directory;
		$zip_file = $album_directory.'.zip';

		// Get real path for our folder
		$rootPath = realpath($dir);

		// Initialize archive object
		$zip = new ZipArchive();
		$zip->open($zip_file, ZipArchive::CREATE | ZipArchive::OVERWRITE);

		// Create recursive directory iterator
		/** @var SplFileInfo[] $files */
		$files = new RecursiveIteratorIterator(
		    new RecursiveDirectoryIterator($rootPath),
		    RecursiveIteratorIterator::LEAVES_ONLY
		);

		foreach ($files as $name => $file)
		{
		    // Skip directories (they would be added automatically)
		    if (!$file->isDir())
		    {
		        // Get real and relative path for current file
		        $filePath = $file->getRealPath();
		        $relativePath = substr($filePath, strlen($rootPath) + 1);

		        // Add current file to archive
		        $zip->addFile($filePath, $relativePath);
		    }
		}

		// Zip archive will be created only after closing object
		$zip->close();
	}

	function deleteDir($path) {
	    if (empty($path)) { 
	        return false;
	    }
	    return is_file($path) ?
            @unlink($path) :
            array_map(__FUNCTION__, glob($path.'/*')) == @rmdir($path);
	}

	function rmdir_recursive($dir) {
	    $it = new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS);
	    $it = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
	    foreach($it as $file) {
	        if ($file->isDir()) rmdir($file->getPathname());
	        else unlink($file->getPathname());
	    }
	    rmdir($dir);
	}

	// Function to Copy folders and files       
    function rcopy($src, $dst) {
        if (file_exists ( $dst ))
            rmdir_recursive($dst);//rmdir ( $dst );
        if (is_dir ( $src )) {
            mkdir ( $dst );
            $files = scandir ( $src );
            foreach ( $files as $file )
                if ($file != "." && $file != "..")
                    rcopy ( "$src/$file", "$dst/$file" );
        } else if (file_exists ( $src ))
            copy ( $src, $dst );
    }
?>