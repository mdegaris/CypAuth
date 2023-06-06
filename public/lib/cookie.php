<?php

class Cookie
{
  // Singleton Setup
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

  public static function GetCookie($name)
  {
    return !empty($_COOKIE[$name]) ? $_COOKIE[$name] : null;
  }

  // ============================================================

  public static function HasAuthCookie()
  {
    return self::GetCookie(self::$AUTH_COOKIE_NAME) !== null;
  }

  // ============================================================

  private $cookieLife = null;
  private $timeNow = null;
  private $cookieValue = null;

  // ============================================================

  private function destroyCookie($cookieName)
  {
    if (isset($_COOKIE[$cookieName])) {
      unset($_COOKIE[$cookieName]);
      setcookie($cookieName, '', time() - 3600);
    }
  }

  // ============================================================

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

  private function buildCookieValue($username, $location, $loginHash)
  {
    if ($username and $location and $loginHash) {
      return sprintf(
        "%s|%s|%s|%s",
        $username,
        $location,
        time(),
        $loginHash
      );
    }
  }

  // ============================================================

  private function getAndDestroyCookie($cookieName)
  {
    $cookieValue = self::GetCookie($cookieName);
    $this->destroyCookie($cookieName);
    return $cookieValue;
  }

  // ============================================================

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

  public function saveHttpRefCookie($url)
  {
    setcookie(self::$HTTP_REF_COOKIE_NAME, $url);
  }

  // ============================================================

  public function readOnceHttpRefCookie()
  {
    return $this->getAndDestroyCookie(self::$HTTP_REF_COOKIE_NAME);
  }

  // ============================================================

  public function getUsername()
  {
    // $cv = $this->
  }

  // ============================================================

  private function __construct()
  {
    $this->timeNow = time();
    $this->cookieLife = ($this->timeNow + 60 * 60 * 24 * 365); // One year
  }
}
