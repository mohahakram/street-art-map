<?php

// creates a session or resumes the current one.
// allows to use $_SESSION variables
session_start();
include 'application/hash.php';

// declares and initialize variables in case of errors
$error = false;
$message = '';

// verify if user filled the inputs to log in
// by checking keys values
if ( isset ( $_POST['email'] ) && isset ( $_POST['password'] )) {
	// connects to database
	include 'application/bdd.php';
	// statement to be executed
	$query = $pdo->prepare(
		'SELECT
	        *
	    FROM 
		 	user 
		Where 
		 	Mail = ?'
	);
	// mail value is passed into array to protect the query
	// and avoid any attack
	$query->execute ( [ $_POST['email'] ] );
	$user = $query->fetch(PDO::FETCH_ASSOC);

	// checks if username exists and output 
	// an error message if not
	if ( $user == false ) {
		$error = true;
		$message = "Wrong Email...";
		// checks if input passeword matchs the database passeword
	} else if ( verifyPassword ( $_POST['password'], $user['Password'] ) == true) {
		// sets the values of user to the session variables
		$_SESSION['id'] = $user['Id'];
		$_SESSION['email'] = $user['Mail'];
		$_SESSION['firstName'] = $user['FirstName'];
		$_SESSION['lastName'] = $user['LastName'];
		$_SESSION['pseudo'] = $user['Pseudo'];
		$_SESSION['role'] = $user['Role'];

		// var_dump($_SESSION);
		header ( 'Location: index.php' );
		exit();
	} else {
		// outputs error message if passeword is wrong
		$error = true;
		$message = "Wrong password...";
	}
}

$template = 'www/login';
include 'layout.phtml';
