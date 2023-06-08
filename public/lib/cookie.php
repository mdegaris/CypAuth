<?php

class Cookie
{
  // Setup Singleton
  private static $instance = null;
  public static function GetInstance()
  {
    if (self::$instance === null) {
      self::$instance = new Cookie();
    }

    return self::$instance;
  }

  // ============================================================

  private static $DOMAIN = COOKIE_DOMAIN;
  private static $HTTP_REF_COOKIE_NAME = "http_referrer";
  private static $AUTH_COOKIE_NAME = "auth_cookie";
  private static $DEFAULT_LOCATION = 'Macclesfield';
  private static $HASH_SALT = "ziggy";

  // ============================================================

  // Return a cookie's value, if it exists.
  public static function GetCookie($name)
  {
    return !empty($_COOKIE[$name]) ? $_COOKIE[$name] : null;
  }

  // ============================================================

  // Check if the Auth cookie has been created.
  public static function HasAuthCookie()
  {
    return self::GetCookie(self::$AUTH_COOKIE_NAME) !== null;
  }

  // ============================================================

  private $cookieLife = null;
  private $timeNow = null;

  // ============================================================

  // Destroy a given coookie.
  private function destroyCookie($cookieName)
  {
    if (isset($_COOKIE[$cookieName])) {
      setcookie($cookieName, '', time() - 3600);
      unset($_COOKIE[$cookieName]);      
    }
  }

  // ============================================================

  # Build the MD5 validation hash for the Auth cookie.
  private function buildHash($username, $location)
  {
    if ($username and $location) {
      return md5(sprintf(
        "%s|%s|%s|%s",
        $username,
        $location,
        $this->timeNow,
        self::$HASH_SALT
      ));
    }
  }

  // ============================================================

  // Build the Auth cookie's value.
  private function buildCookieValue($username, $location, $loginHash)
  {
    if ($username and $location and $loginHash) {
      return sprintf(
        "%s|%s|%s|%s",
        $username,
        $location,
        $this->timeNow,
        $loginHash
      );
    }
  }

  // ============================================================

  // Get the Auth cookie value, if it exists.
  private function getAuthCookieValue()
  {
    return self::GetCookie(self::$AUTH_COOKIE_NAME);
  }

  // ============================================================

  // Get a cookie's value and then remove/invalidate it.
  private function getAndDestroyCookie($cookieName)
  {
    $cookieValue = self::GetCookie($cookieName);
    $this->destroyCookie($cookieName);
    return $cookieValue;
  }

  // ============================================================

  // Save/set the Auth cookie to the cookie domain.
  public function saveAuthCookie($username, $loc = null)
  {
    $location = $loc == null ? self::$DEFAULT_LOCATION : $loc;

    $cookieValue = self::buildCookieValue(
      $username,
      $location,
      $this->buildHash($username, $location)
    );

    setcookie(
      self::$AUTH_COOKIE_NAME,
      $cookieValue,
      $this->cookieLife,
      '/',
      self::$DOMAIN
    );
  }

  // ============================================================

  // Save/set the HTTP referrer (return URL) cookie.
  public function saveHttpRefCookie($url)
  {
    setcookie(self::$HTTP_REF_COOKIE_NAME, $url);
  }

  // ============================================================

  // Return and destroy the HTTP referrer cookie.
  public function readOnceHttpRefCookie()
  {
    return $this->getAndDestroyCookie(self::$HTTP_REF_COOKIE_NAME);
  }

  // ============================================================

  // Get the username (accoutn uid) from the Auth cookie value, 
  // if it exists.
  public function getUsername()
  {
    $authValue = $this->getAuthCookieValue();
    if (!empty($authValue)) {
      $cvSplit = explode('|', html_entity_decode($authValue), 2);
      return $cvSplit[0];
    }
  }

  // ============================================================

  private function __construct()
  {
    $this->timeNow = time();
    $this->cookieLife = ($this->timeNow + 60 * 60 * 24 * 365); // One year
  }
}
