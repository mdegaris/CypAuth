<?php

require_once("path_helper.php");

// ============================================================

function setupGlobalDefnitions($config)
{

    $dbCredsFileStr = sprintf(
        "%s%s%s",
        $config['CS_ROOT'],
        DIRECTORY_SEPARATOR,
        $config['DB_CREDENTIALS_FILE']
    );

    $dbCredsFile = realpath($dbCredsFileStr);
    if (!$dbCredsFile) {
        throw new Exception("Could not find database credentials file: $dbCredsFileStr");
    }

    $dbCredentials = parse_ini_file($dbCredsFile);
    define("CS_ROOT", $config['CS_ROOT']);
    define("DB_USER", $dbCredentials['CS_DB_RO_USER']);
    define("DB_PASS", $dbCredentials['CS_DB_RO_PASSWORD']);
    define("DB_INSTANCE", $dbCredentials['CS_DB_INSTANCE']);
    define("COOKIE_DOMAIN", $config['COOKIE_DOMAIN']);
    define('LOG_FILE', sprintf(
        $config['CS_ROOT'],
        DIRECTORY_SEPARATOR,
        $config['LOG_FILE']
    ));
}

// ============================================================

// Set default timezone
date_default_timezone_set('Europe/London');

// Setup Globals
$doc_root = substr(__DIR__, 0, stripos(__DIR__, "/lib"));
$_PATH = Path::GetInstance($doc_root);

// Read configs
$appConfigs = parse_ini_file($_PATH->absPath("/conf/labsys_portal.conf"));

// Setup global defines
setupGlobalDefnitions($appConfigs);


// ============================================================

function logMessage($message, $logLevel = LOG_INFO)
{
    $logRealPath = realpath(LOG_FILE);
    if (!$logRealPath) {
        $file = fopen($logRealPath, 'w');
        fclose($file);
    }

    $level = "UNKNOWN";
    if ($logLevel === LOG_INFO) {
        $level = "INFO";
    } elseif ($logLevel === LOG_ERR) {
        $level = "ERROR";
    }

    $ts = date('Y-m-d H:i:s');
    $lm = sprintf("%s : %s - %s%s", $level, $ts, $message, PHP_EOL);
    // 3 for appending to log file.
    error_log($lm, 3, $logRealPath);
}

// ============================================================