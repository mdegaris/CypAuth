<?php

// ============================================================

class FormHelper
{
    const USERNAME_LOGIN = "user_login";
    const PASSWORD_LOGIN = "password_login";

    const USERNAME_RESET = "user_reset";
    const NEW_PASSWORD_RESET = "new_password_reset";
    const CONFIRM_PASSWORD_RESET = "confirm_password_reset";

    const SUBMIT_LOGIN_AUTH = 'submit_login';
    const SUBMIT_USER = 'submit_user';
    const SUBMIT_PASSWORD_RESET = 'submit_reset';

    private static function getParam($scopeMap, $name)
    {
        return isset($scopeMap[$name]) ? $scopeMap[$name] : null;
    }

    public static function getRequestParam($name)
    {
        return self::getParam($_REQUEST, $name);
    }

    public static function getPostParam($name)
    {
        return self::getParam($_POST, $name);
    }

    public static function getGetParam($name)
    {
        return self::getParam($_GET, $name);
    }

    public static function getCookieValue($name)
    {
        return self::getParam($_COOKIE, $name);
    }

    public static function isParamPresent($name)
    {
        return isset($_REQUEST[$name]);
    }


    public static function Trimmer($v)
    {
        return empty($v) ? $v : trim($v . "");
    }
}

// ============================================================
