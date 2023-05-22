<?php

$HASHING_ALGORITHM = 'sha512';


/*
    Checks that a give password has:
    Length 8 characters long.
    Contains lower case letter.
    
*/
function check_password_strength($password)
{
    $pw_strength_regex = "^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[!@#$%^&*-]).{8,}$";

    if (preg_match($pw_strength_regex, $password)) {
        return true;
    }

    return false;
}


function hash_password($password)
{
    global $HASHING_ALGORITHM;

    if ($password) {
        return hash($HASHING_ALGORITHM, $password);
    }

    return null;
}
