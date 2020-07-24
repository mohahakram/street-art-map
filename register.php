<?php

include 'application/hash.php';

// checks if user filled inputs and form generated $_POST
if(empty($_POST) == false) {
    // var_dump($_POST);
    
    // crypts passeword before saving it in database
    $hashPassword = hashPassword($_POST['password']);
    $mail = $_POST['email'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $pseudo = $_POST['pseudo'];
    
    include 'application/bdd.php';

	$query = $pdo->prepare(
        'INSERT INTO
                user
                    (Mail, Password, FirstName, LastName, Pseudo, Role)
            VALUES
                (?, ?, ?, ?, ?, "user")
        '

	);

    // values are passed in execute array to avoid attacks
	$query->execute( [ $_POST['email'], $hashPassword, $_POST['firstName'], $_POST['lastName'], $_POST['pseudo']  ] );
	
    header('Location: login.php');
	exit();
}

    
    
$template = 'www/register';
include 'layout.phtml';
?>