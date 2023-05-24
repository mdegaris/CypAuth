<?php

require_once("path_finder.php");

// Setup Globals
$PATH = Path::GetInstance("/var/www/html/labsys_portal");

$app_configs = parse_ini_file($PATH->absPath("/conf/labsys_portal.conf"));
$db_creds_file = realpath(sprintf("%s" . DIRECTORY_SEPARATOR . "%s", $app_configs['CS_ROOT'], $app_configs['DB_CREDENTIALS_FILE']));

if (!$db_creds_file) {
    throw new Exception('Could not find database credentials.');
}

$db_credentials = parse_ini_file($db_creds_file);
$db_user = $db_credentials['CS_DB_RO_USER'];
$db_pass = $db_credentials['CS_DB_RO_PASSWORD'];
$db_instance = $db_credentials['CS_DB_INSTANCE'];


$gLogFile = "/home/cloe_screen/log/labsys_portal.log";
function log_message($message, $log_level = LOG_INFO)
{
    global $gLogFile;

    $level = "UNKNOWN";
    if ($log_level === LOG_INFO) {
        $level = "INFO";
    } elseif ($log_level === LOG_ERR) {
        $level = "ERROR";
    }

    $ts = date('Y-m-d H:i:s');
    $lm = sprintf("%s : %s - %s%s", $level, $ts, $message, PHP_EOL);
    error_log($lm, 3, $gLogFile);
}
