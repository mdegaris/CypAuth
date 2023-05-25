<?php

// Top level setup
require_once("lib/common.php");

// ============================================================

require_once($_PATH->absPath("/lib/fragments.php"));
require_once($_PATH->absPath("/lib/forms_helper.php"));
require_once($_PATH->absPath("/lib/cookie.php"));

// ============================================================

// Checks if the reset flag in the URL is set.
function doPasswordReset()
{
    return FormHelper::getGetParam("reset") !== null;
}

// If we're (re)setting the password, then start the reset password flow.
// Else start the login flow.
if (doPasswordReset() and !Cookie::HasAuthCookie()) {
    $includeFragment = Fragments::GetInstance()->reset;
} else {
    $includeFragment = Fragments::GetInstance()->login;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="/images/logo-brand.svg" type="image/svg+xml">
    <link rel="stylesheet" href="css/auth.css" />
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