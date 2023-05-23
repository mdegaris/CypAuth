<?php



function _selectSingleValue($row, $name)
{
    if ($row and $name and isset($row[strtoupper($name)])) {
        return $row[strtoupper($name)];
    }

    return null;
}


function reset_password_check($username)
{
    global $RESET_PASSWORD_CHECK_SQL;

    $row = dbQuery($RESET_PASSWORD_CHECK_SQL, array("username" => $username));

    if ($row and isset($row['DO_RESET'])) {
        $do_reset = $row['DO_RESET'];

        if ($do_reset) {
            return true;
        }
    }

    return false;
}



function local_authenticate($username, $location, $password)
{
    global $AUTH_SQL;

    $row = dbQuery($AUTH_SQL, array("username" => $username, "location" => $location, "password" => $password));

    if ($row and isset($row['SUCCESS'])) {
        $success = $row['SUCCESS'];

        if ($success) {
            return true;
        }
    }

    return false;
}
