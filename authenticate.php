<?php

require_once("lib/forms_helper.php");

// $db_user = getenv("CS_DB_RO_USER");
// $db_pass = getenv("CS_DB_RO_PASSWORD");
// $db_instance = getenv("CS_DB_INSTANCE");


function doInitialSetup()
{
    return getGetParam("setup") !== null;
}

function hasAuthCookie()
{
    return getCookieParam("auth_cookie") !== null;
}

function hasUser()
{
    return getPostParam("reset_pw_user") !== null;
}



if (doInitialSetup() and !hasAuthCookie()) {
    // var_dump($_REQUEST);
    // var_dump($_COOKIE);
    $includeFragment = "fragments/_reset.php";
} else {
    $includeFragment = "fragments/_login.php";
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