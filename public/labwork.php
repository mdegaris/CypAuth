<?php

// Top level setup
require_once("lib/common.php");

require_once($PATH->absPath("/lib/forms_helper.php"));
require_once($PATH->absPath("/lib/cookie.php"));

// ============================================================

$force_setup = isParamPresent("setup");

if ($force_setup and !Cookie::HasAuthCookie()) {
    Cookie::GetInstance()->saveHttpRefCookie($PATH->urlPath(true));
    header("Location: authenticate.php?reset");
    exit();
}


if (!Cookie::HasAuthCookie()) {
    header("Location: authenticate.php");
    exit();
}

// ============================================================

phpinfo();
