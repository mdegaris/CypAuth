<?php

$cookieName = 'auth_cookie';
if (isset($_COOKIE[$cookieName])) {
    unset($_COOKIE[$cookieName]);
    setcookie($cookieName, '', time() - 3600);
}
