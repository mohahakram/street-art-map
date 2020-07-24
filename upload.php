<?php
// creates a session or resumes the current one.
// allows to use $_SESSION variables
session_start();
// var_dump($_SESSION);

include 'application/bdd.php';

// verifies if user is connected by checking
// if the 'role' key exists in a $_SESSION variable
if(array_key_exists('role', $_SESSION) == false ) {
    // if not redirect to login page
    header('Location: login.php');
    exit();
}

$img = $_FILES['imageUpload']['name'];
// var_dump($img);
function getExtension($str)
{   
    // finds the last dot in a given string
     $i = strrpos($str,".");
     if (!$i) { return ""; } 
    // finds the length of a string minus th eposition of $i 
     $l = strlen($str) - $i;
    //  substracts and returns string after dot (dot included)
     $ext = substr($str,$i+1,$l);
     return $ext;
}

// calls getExtension and gives it a string as a parameter
$extension =  getExtension($img);
// generate a unique id as new name
$id = uniqid();
// final name and extension to be stored 
$newimg = $id.'.'.$extension;

function getGps($exifCoord, $hemi) {

    $degrees = count($exifCoord) > 0 ? gps2Num($exifCoord[0]) : 0;
    $minutes = count($exifCoord) > 1 ? gps2Num($exifCoord[1]) : 0;
    $seconds = count($exifCoord) > 2 ? gps2Num($exifCoord[2]) : 0;

    $flip = ($hemi == 'W' or $hemi == 'S') ? -1 : 1;

    return $flip * ($degrees + $minutes / 60 + $seconds / 3600);

}

function gps2Num($coordPart) {

    $parts = explode('/', $coordPart);

    if (count($parts) <= 0)
        return 0;

    if (count($parts) == 1)
        return $parts[0];

    return floatval($parts[0]) / floatval($parts[1]);
}

// checks if $_FILE is declared and no error is encountered during iuplozd
if ((isset($_FILES['imageUpload']['tmp_name']) && ($_FILES['imageUpload']['error'] == UPLOAD_ERR_OK))) {
    // sets the directory to save images
    $chemin_destination = 'img/upload/';
    // checks if image was moved to right destination 
    if (move_uploaded_file($_FILES['imageUpload']['tmp_name'], $chemin_destination . $newimg) == true) {
        // exif reads information about an image like exposure, shutter speed, gps
        $exif = exif_read_data($chemin_destination . $newimg);
        // in this case exif returns the gps data for longitude and latitude
        $lon = getGps($exif["GPSLongitude"], $exif['GPSLongitudeRef']);
        $lat = getGps($exif["GPSLatitude"], $exif['GPSLatitudeRef']);
        // var_dump($lat, $lon);

        // writes data into database
        $query = $pdo->prepare(
            'INSERT INTO
                images (Path, UserId, Lon, Lat)
	        VALUES 
                (?,?,?,?)'
        );

        // data is passed trough execute array to avoid attacks
        $query->execute([$newimg, $_SESSION['id'], $lon, $lat]);
        // var_dump($_FILES);
        header('Location: index.php');
        exit();
    }
}     


$template = 'www/upload';
include 'layout.phtml';
?>