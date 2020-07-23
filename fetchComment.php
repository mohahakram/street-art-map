<?php
session_start();



include "application/bdd.php";

$query = $pdo->prepare(
    'SELECT * 
        FROM 
            comments 
        INNER JOIN
            images
        ON 
            comments.ImageId = images.Id
        WHERE 
            images.Id = ?
        ORDER BY 
            CreationDate DESC
        '
);

$query->execute( [ $_POST ['imageId'] ] );
$data = $query->fetch(PDO::FETCH_ASSOC);

$comments = array(
    "id"            =>  $data['Id'],
    "pseudo"        =>  $data['Pseudo'],
    "comment"       =>  $data['Comment'],
    "creationDate"  =>  $data['CreationDate'],
    "imageId"       =>  $data['ImageId']
);
echo json_encode($comments);






?>