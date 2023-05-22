<?php

require("database.php");

$AUTH_SQL = <<<SQL
SELECT cyp_lib.authenticate.local_auth(:username, :location, :password) AS :success
FROM DUAL
SQL;

$CHECK_RESET_PASSWORD_SQL = <<<SQL
SELECT cyp_lib.authenticate.reset_password_check(:username) AS :do_reset
FROM DUAL
SQL;

$CHECK_USERNAME_EXISTS_SQL = <<<SQL
SELECT 1 as user_exists
FROM DUAL
WHERE EXISTS
    (
        SELECT 1 
        FROM cyprotex.cy_user
        WHERE cy_user.account_uid = :username
    )
SQL;

$USER_LOGIN_CREDS_SQL = <<<SQL
SELECT account_uid, encrypted_local_password, local_password, reset_password
FROM cyprotex.cy_user
WHERE cy_user.account_uid = :username
SQL;


function _selectSingleValue($row, $name)
{
    if ($row and $name and isset($row[strtoupper($name)])) {
        return $row[strtoupper($name)];
    }

    return null;
}


/*
    Ascertains if a given username needs their password resetting.
*/
function reset_password_check($username)
{
    global $CHECK_RESET_PASSWORD_SQL;

    $row = dbQuery($CHECK_RESET_PASSWORD_SQL, array("username" => $username));

    if (_selectSingleValue($row, 'do_reset')) {
        return true;
    }

    return false;
}


function user_exist($username)
{
    global $CHECK_USERNAME_EXISTS_SQL;

    $row = dbQuery($CHECK_USERNAME_EXISTS_SQL, array("username" => $username));



    if (_selectSingleValue($row, 'user_exists')) {
        return true;
    }

    return false;
}
