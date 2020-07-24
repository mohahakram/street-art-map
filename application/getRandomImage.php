<?php

// returns only one random image from database
include 'bdd.php';
$query = $pdo->prepare(
	    'SELECT
	        *
       	FROM 
		    images
       	ORDER BY 
		   	RAND() LIMIT 1'
);

$query->execute();
$file = $query->fetch(PDO::FETCH_ASSOC);
// var_dump($file);

// encodes results to json to use with ajax
$selectedFile = array(
	"file"	=> 	$file['Path'], 
	"id" 	=> 	$file['Id']
);

echo json_encode($selectedFile);

?>