<?php

require_once("path_helper.php");


// Setup Globals

$doc_root = substr(__DIR__, 0, stripos(__DIR__, "/lib"));
$_PATH = Path::GetInstance($doc_root);

// Read configs
$app_configs = parse_ini_file($_PATH->absPath("/conf/labsys_portal.conf"));
$db_creds_file_str = sprintf(
    "%s" . DIRECTORY_SEPARATOR . "%s",
    $app_configs['CS_ROOT'],
    $app_configs['DB_CREDENTIALS_FILE']
);

$db_creds_file = realpath($db_creds_file_str);

if (!$db_creds_file) {
    throw new Exception("Could not find database credentials file: $db_creds_file_str");
}

// Setup global defines
$db_credentials = parse_ini_file($db_creds_file);
define("DB_USER", $db_credentials['CS_DB_RO_USER']);
define("DB_PASS", $db_credentials['CS_DB_RO_PASSWORD']);
define("DB_INSTANCE", $db_credentials['CS_DB_RO_USER']);
define("COOKIE_DOMAIN", $db_credentials['COOKIE_DOMAIN']);



$gLogFile = "/home/cloe_screen/log/labsys_portal.log";
function logMessage($message, $logLevel = LOG_INFO)
{
    global $gLogFile;

    $level = "UNKNOWN";
    if ($logLevel === LOG_INFO) {
        $level = "INFO";
    } elseif ($logLevel === LOG_ERR) {
        $level = "ERROR";
    }

    $ts = date('Y-m-d H:i:s');
    $lm = sprintf("%s : %s - %s%s", $level, $ts, $message, PHP_EOL);
    error_log($lm, 3, $gLogFile);
}