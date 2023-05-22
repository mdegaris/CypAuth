<?php

$is_first_time = isset($_REQUEST['firsttime']);
$has_auth_cookie = isset($_COOKIE['auth_cookie']);

if ($is_first_time and !$has_auth_cookie) {
    header("Location: authenticate.php?reset");
}

if (!$has_auth_cookie) {
    header("Location: authenticate.php");
}
