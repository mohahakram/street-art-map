<?php
// creates a session or resumes the current one.
// allows to use $_SESSION variables
session_start();
// var_dump($_SESSION);

$template = 'www/index';
include 'layout.phtml';

?>