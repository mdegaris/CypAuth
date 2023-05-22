<?php

function check_password_strength($password)
{
    $pw_strength_regex = "^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[!@#$%^&*-]).{8,}$";

    if (preg_match($pw_strength_regex, $password)) {
        return true;
    }

    return false;
}

function check_login_form($request)
{
}
