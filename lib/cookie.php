<?php

$COOKIE_NAME = "auth_cookie";
$COOKIE_LIFE = time() + 60 * 60 * 24 * 365;  // One year
$DOMAIN = "cyprotex.com";
$HASH_SALT = "ziggy";
$TIME_NOW = time();


function _build_hash($username, $location)
{
  global $TIME_NOW, $HASH_SALT;

  if ($username and $location) {
    return md5("${username}|${location}|${TIME_NOW}|${HASH_SALT}");
  }
}


function _cookie_value($username, $location, $login_hash)
{
  global $TIME_NOW;

  if ($username and $location and $login_hash) {
    return "${username}|${location}|${TIME_NOW}|${login_hash}";
  }
}


function save_cookie($username, $location)
{
  global $COOKIE_NAME, $COOKIE_LIFE, $DOMAIN;

  $login_hash = _build_hash($username, $location);
  $cookie_value = _cookie_value($username, $location, $login_hash);

  setcookie($COOKIE_NAME, $cookie_value, $COOKIE_LIFE, '/', $DOMAIN);
}
