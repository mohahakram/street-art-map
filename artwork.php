<?php
// creates a session or resumes the current one.
// allows to use $_SESSION variables
session_start();

// connect to database
include 'application/bdd.php';
// select needed elements from tables
$query = $pdo->prepare(
    'SELECT 
            images.Id AS imageId,
            Path,
            uploadDate,
            Lon,
            Lat,
            UserId,
            Mail,
            FirstName,
            LastName,
            Pseudo,
            Role
        FROM 
            images 
        -- links two elements froms diffent tables with the same id
        INNER JOIN
            user
        ON 
            images.UserId = user.Id
        WHERE images.Id = ?'
);
// id returned via url
// returns elements and saves them in a variable
$query->execute([$_GET['id']]);
$file = $query->fetchAll(PDO::FETCH_ASSOC);
// echo '<pre>',var_dump($file),'</pre>';

$query = $pdo->prepare(
    'SELECT * 
        FROM 
            comments 
        INNER JOIN
            images
        ON 
            comments.ImageId = images.Id
        WHERE 
            images.Id = ?'
);

$query->execute([$_GET['id']]);
$comm = $query->fetchAll(PDO::FETCH_ASSOC);
// var_dump($comm);


$template = 'www/artwork';
include 'layout.phtml';
?>