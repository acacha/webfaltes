<?php 
include_once("config.inc.php");

$file = $_GET['file'];
$file = '/tmp/' . $file;
//file_exists( $file ) or die( "No such file: " . htmlspecialchars( $file ) );

//echo $file."</br>";

// little security measure here (prevents users from accessing
// files, like /etc/passwd for example)
if (file_exists($file)){
	
	$file = basename( $file );
	
	//echo $file."</br>"; 
	
	$file = addcslashes( $file, '/\\' );
	
	//echo $file."</br>";
	//echo "file: "."/tmp/".$file;
	
	$f = fopen( "/tmp/".$file, 'r' );
	$photo = fread( $f, filesize( "/tmp/".$file) );
	fclose( $f );
}else{
	$f = fopen(_BASE_PATH."/imatges/default_small.jpg", 'r' );
	$photo = fread( $f, filesize(_BASE_PATH."/imatges/default_small.jpg"));
	fclose( $f );
}

Header( "Content-type: image/png" );
Header( "Content-disposition: inline; filename=photo.png" );

echo $photo;
?>