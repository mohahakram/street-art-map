<?php
session_start();
// var_dump($_POST);

include 'application/bdd.php';
if (array_key_exists('role', $_SESSION) && !empty($_POST['comment'])) {
    $query = $pdo->prepare(
        'INSERT INTO
            comments (Pseudo, Comment, ImageId)
        VALUES
            (?, ?, ?)'
    );

    $query->execute([ $_POST['pseudo'], $_POST['comment'], $_POST['imageId'] ]);
}

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
        -- ORDER BY 
            -- CreationDate DESC
        '
);

$query->execute([$_POST['imageId']]);
$data = $query->fetch(PDO::FETCH_ASSOC);
//  var_dump($data);
$comments = array(
    "commentId"     =>  $data['CommentId'],
    "pseudo"        =>  $data['Pseudo'],
    "comment"       =>  $data['Comment'],
    "creationDate"  =>  $data['CreationDate'],
    "imageId"       =>  $data['ImageId']
);
echo json_encode($comments);




// $json = json_decode($_POST)


// var_dump($result);

?>