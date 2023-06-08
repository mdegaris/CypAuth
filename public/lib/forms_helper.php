<?php

class FormHelper
{
    // App flags
    const SETUP_FLAG = 'setup';
    const RESET_FLAG = 'reset';

    // Login inputs
    const USERNAME_LOGIN = "username-login";
    const PASSWORD_LOGIN = "current-password";
    const SUBMIT_LOGIN = 'login-submit';

    // Reset password inputs
    const USERNAME_RESET = "username-reset";
    const NEW_PASSWORD_RESET = "new-password";
    const CONFIRM_PASSWORD_RESET = "confirm-password";
    const SUBMIT_USERNAME_RESET = 'username-submit';
    const SUBMIT_PASSWORD_RESET = 'reset-submit';

    // ============================================================

    // Generic parameter map getter.
    private static function getParam($scopeMap, $name)
    {
        return isset($scopeMap[$name]) ? $scopeMap[$name] : null;
    }

    // ============================================================

    // Get request parameter (GET or POST).
    public static function getRequestParam($name)
    {
        return self::getParam($_REQUEST, $name);
    }

    // POST only.
    public static function getPostParam($name)
    {
        return self::getParam($_POST, $name);
    }

    // GET only
    public static function getGetParam($name)
    {
        return self::getParam($_GET, $name);
    }

    // Check if a request parameter exists.
    public static function isParamPresent($name)
    {
        return isset($_REQUEST[$name]);
    }

    // ============================================================

    // Simple value trimmer.
    public static function Trimmer($v)
    {
        return empty($v) ? $v : trim($v . "");
    }
}

// ============================================================