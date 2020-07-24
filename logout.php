<?php
// creates a session or resumes the current one.
// allows to use $_SESSION variables
session_start();

// erase session cookies 
if (ini_get("session.use_cookies")) {
    // fetch session cookies parameters 
    $params = session_get_cookie_params();
    // replace them
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// destroy session and redirection
session_destroy();
header('Location: index.php');
exit();

?>