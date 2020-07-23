<?php

// cryptes login and register passwords
function hashPassword($password){
        
    $salt = '$2y$11$'.substr(bin2hex(openssl_random_pseudo_bytes(32)), 0, 22);

    return crypt($password, $salt);
}

// compares encrypted database passeword to login passeword
function verifyPassword($password, $hashedPassword){
        
		return crypt($password, $hashedPassword) == $hashedPassword;
}


?>