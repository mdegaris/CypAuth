<?php

// ============================================================

class FormHelper
{
    const USERNAME_LOGIN = "_lgn_usr";
    const PASSWORD_LOGIN = "_lgn_pwd";

    const USERNAME_RESET = "_rst_usr";
    const NEW_PASSWORD_RESET = "_rst_npwd";
    const CONFIRM_PASSWORD_RESET = "_rst_cpwd";

    const SUBMIT_LOGIN_AUTH = '_sub_lgn';
    const SUBMIT_USER = '_sub_usr';
    const SUBMIT_PASSWORD_RESET = '_sub_rpw';

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
        return trim($v . "");
    }
}

// ============================================================
