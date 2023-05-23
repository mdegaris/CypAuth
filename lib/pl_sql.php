<?php

require("database.php");

$SET_PASSWORD_SQL = <<<SQL
SELECT cyp_lib.authenticate.set_local_password(:account_uid, :encrypted_password)
FROM DUAL
SQL;

/*
    Ascertains if a given username needs their password resetting.
*/
function setNewPasswordInDB($username, $encryptedPassword)
{
    global $SET_PASSWORD_SQL;

    dbQuery(
        $SET_PASSWORD_SQL,
        array("account_uid" => $username, "encrypted_password" => $encryptedPassword)
    );
}