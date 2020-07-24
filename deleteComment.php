<?php
// creates a session or resumes the current one.
// allows to use $_SESSION variables
session_start();

// checks for 'id' key in $_GET variable and 
// if its an integer, if not redirects to admin page
if (!array_key_exists('id', $_GET) OR !ctype_digit($_GET['id'])) {
    header('Location: artwork.php');
    exit();
} else {
    include 'application/bdd.php';

    // deletes from table with right id
    $query = $pdo->prepare(
	'DELETE FROM 
        comments 
    WHERE 
        Id= ?'
);

// finishs task with the id passed through url
$query->execute( [$_GET['id']] );

// header('Location: artwork.php?id='.$_GET['imageId']);
exit();
}

