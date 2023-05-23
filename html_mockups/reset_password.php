<?php


/*
    Validation check (password and confirm password both populated, equal, and strong enough)
    Validation fail:
      Feedback message: ... ;  END
    Get user=username POST PARAM:
      If not exist:
        Feedback message: No user found ; END
      If exist:
        Build User object from DB.

    Sanity check for user exist, local and enabled:
      Feedback if not ; END
    
    Update database with password for user:
      encrpyt with sha512.
    
    Redirect to Login.
      
  */

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/login.css" />
</head>

<body>
    <main>
        <div class="main-container">
            <div class="form-container">
                <div class="title-container">
                    <img class="title-logo" src="images/logo-brand.svg" />
                    <div class="form-title">Cyprotex SSO</div>
                </div>
                <form class="login-form" method="post">
                    <div class="field-container">
                        <input class="input-field" type="text" name="username" placeholder="Username" />
                        <input class="input-field" type="password" name="password" placeholder="Password" />
                    </div>
                    <div class="button-container">
                        <button class="submit-button">LOGIN</button>
                    </div>
                    <input type="hidden" name="auth_login" />
                </form>
                <?php
        if ($LOGIN_ATTEMPT === true and $LOGIN_SUCCESS === false) {
        ?>
                <div class="feedback-container">Invalid username/password</div>
                <?php
        }
        ?>
            </div>
        </div>
    </main>
</body>

</html>