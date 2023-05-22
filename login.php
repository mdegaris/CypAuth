<?php

$LOGIN_ATTEMPT = false;
$LOGIN_SUCCESS = false;


function process_login_attempt($username, $password)
{
}

function get_post_param($param)
{
  if (isset($_POST[$param])) {
    return $_POST[$param];
  } else {
    return false;
  }
}


if (isset($_POST['auth_login'])) {

  /*
    Validation check (username and password)
    Validation fail:
      Feedback message: Populate fields ;  END
    Check user existence
    User does not exist:
      Feedback message: Could not find user. Attempt the following format: John Robinson (jsmith or johrobin). ;  END
    User exists:
      User Creds from cy_user db table to create User object.
      Confirm user is local auth and enables:
        If not: Feedback message; END
      Query User obj for Reset Password required:
        Redirect to reset password page (POST param; user=username). ;  END
      Reset Password not required
        Attempt to authenticate
        Authenticate success:
          Return to HTTP_REDIRECT. ;  END
        Authenticate failure:
          Feeback message: Invalid login password;  END
      
  */

  $LOGIN_ATTEMPT = true;

  if (
    $username = get_post_param('username') and
    $password = get_post_param('password')
  ) {

    if (process_login_attempt($username, $password) === TRUE) {
      $fake_login($username, 'Macclesfield');
      $LOGIN_SUCCESS = true;
    } else {
      $LOGIN_SUCCESS = false;
    }
  }
}



// $COOKIE_LIFE = time() + 60 * 60 * 24 * 365;  // One year
// $DOMAIN = 'cyprotex.com';


// function fake_login($login_name, $login_location)
// {
//   global $COOKIE_LIFE, $DOMAIN;

//   $login_time = time();
//   $login_hash = md5("${login_name}|${login_location}|${login_time}|ziggy");
//   $cookie_value = "${login_name}|${login_location}|${login_time}|${login_hash}";

//   setcookie('auth_cookie', $cookie_value, $COOKIE_LIFE, '/', 'bull.lab.cyprotex.com');
// }


// function authenticate_user()
// {
//   return true;
// }


// function get_post_param($param)
// {
//   if (isset($_POST[$param])) {
//     return $_POST[$param];
//   } else {
//     return false;
//   }
// }

// if (isset($_POST['auth_login'])) {

//   $LOGIN_ATTEMPT = true;

//   if (
//     $username = get_post_param('username') and
//     $password = get_post_param('password')
//   ) {

//     if (authenticate_user($username, $password) === TRUE) {
//       $fake_login($username, 'MAcclesfield');
//       $LOGIN_SUCCESS = true;
//     } else {
//       $LOGIN_SUCCESS = false;
//     }
//   }
// }

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
          <div class="field-container">
            <input type="password" name="password_new" placeholder="New password" />
            <input type="password" name="password_confirm" placeholder="Confirm password" />
          </div>
          <input type="hidden" name="auth_login" />
        </form>
        <?php
        if ($LOGIN_ATTEMPT === true and $LOGIN_SUCCESS === false) {
        ?>
          <div class="feedback-container">Invalid username/password</div>
        <?php
        } elseif ($LOGIN_ATTEMPT === true and $LOGIN_SUCCESS === true) {
        ?>
          <div class="feedback-container">Fake login success</div>
        <?php
        }
        ?>
      </div>
    </div>
  </main>
</body>

</html>