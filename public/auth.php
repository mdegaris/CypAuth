<?php

// Top level setup
require_once("lib/common.php");

// ============================================================

require_once($PATH->absPath("/lib/forms_helper.php"));
require_once($PATH->absPath("/lib/cookie.php"));

// $db_user = getenv("CS_DB_RO_USER");
// $db_pass = getenv("CS_DB_RO_PASSWORD");
// $db_instance = getenv("CS_DB_INSTANCE");

// ============================================================

function doPasswordReset()
{
    return getGetParam("reset") !== null;
}


if (doPasswordReset() and !Cookie::HasAuthCookie()) {
    $includeFragment = $PATH->absPath("/fragments/_reset.php");
} else {
    $includeFragment = $PATH->absPath("/fragments/_login.php");
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="/images/logo-brand.svg" type="image/svg+xml">
    <link rel="stylesheet" href="css/login.css" />
</head>

<body>
    <main>
        <div class="main-container">
            <div class="title-container">
                <img class="title-logo" src="images/logo-brand.svg" />
                <div class="title-text">Labsys SSO</div>
            </div>
            <div class="form-container">
                <?php
                require($includeFragment);
                ?>
            </div>
        </div>
    </main>
</body>

</html>