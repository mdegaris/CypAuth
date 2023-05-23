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


    static function Trimmer($v)
    {
        return trim($v . "");
    }
}

// ============================================================

function _getParam($scopeMap, $name)
{
    return isset($scopeMap[$name]) ? $scopeMap[$name] : null;
}


function getRequestParam($name)
{
    return _getParam($_REQUEST, $name);
}

function getPostParam($name)
{
    return _getParam($_POST, $name);
}

function getGetParam($name)
{
    return _getParam($_GET, $name);
}

function getCookieValue($name)
{
    return _getParam($_COOKIE, $name);
}

function isParamPresent($name)
{
    return isset($_REQUEST[$name]);
}

// ============================================================
