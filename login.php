<?php

$LOGIN_ATTEMPT = false;
$LOGIN_SUCCESS = false;

$COOKIE_LIFE = time() + 60 * 60 * 24 * 365;  // One year
$DOMAIN = 'cyprotex.com';


function build_auth_cookie($login_name, $login_location)
{
  global $COOKIE_LIFE, $DOMAIN;

  $login_time = time();
  $login_hash = md5("${login_name}|${login_location}|${login_time}|ziggy");
  $cookie_value = "${login_name}|${login_location}|${login_time}|${login_hash}";

  $arr_cookie_options = array(
    'expires' => $COOKIE_LIFE,
    'path' => '/',
    'domain' => $DOMAIN,
    'secure' => false,
    'httponly' => true,
    'samesite' => 'Strict'
  );

  setcookie('auth_cookie', $cookie_value, $arr_cookie_options);
}


function login()
{
  return false;
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

  $LOGIN_ATTEMPT = true;

  if (
    $username = get_post_param('username') and
    $password = get_post_param('password')
  ) {

    if (login($username, $password) === TRUE) {
      $build_auth_cookie($username);
      $LOGIN_SUCCESS = true;
    } else {
      $LOGIN_SUCCESS = false;
    }
  }
}

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
    <div class="login-container">
      <div class="form-container">
        <div class="title-container">
          <img class="title-logo" src="images/logo-brand.svg" />
          <div class="login-title">Cyprotex SSO</div>
        </div>
        <form class="login-form" method="post">
          <div class="field-container">
            <input class="login-field" type="text" name="username" placeholder="Username" />
            <input class="login-field" type="password" name="password" placeholder="Password" />
          </div>
          <div class="button-container">
            <button class="login-button">LOGIN</button>
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