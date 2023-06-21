<?php

require_once("path_helper.php");

// ============================================================

function setupGlobalDefnitions($config)
{
    // Check real path and check if exists.
    $dbCredsFile = realpath($config['DB_CREDENTIALS_FILE']);
    if (!$dbCredsFile) {
        throw new Exception(sprintf("Could not find database credentials file: %s",
                                    $config['DB_CREDENTIALS_FILE']));
    }

    $dbCredentials = parse_ini_file($dbCredsFile);
    define("DB_USER", $dbCredentials['CS_DB_RO_USER']);
    define("DB_PASS", $dbCredentials['CS_DB_RO_PASSWORD']);
    define("DB_INSTANCE", $dbCredentials['CS_DB_INSTANCE']);
    define("COOKIE_DOMAIN", $config['COOKIE_DOMAIN']);
    define('LOG_FILE', $config['LOG_FILE']);
}

// ============================================================

// Set default timezone
date_default_timezone_set('Europe/London');

// Setup Path singleton
$doc_root = substr(__DIR__, 0, stripos(__DIR__, "/lib"));
$_PATH = Path::GetInstance($doc_root);

// Read configs
$appConfigs = parse_ini_file($_PATH->absPath("/conf/labsys_portal.conf"));

// Setup global defines
setupGlobalDefnitions($appConfigs);


// ============================================================

function createFile($fn) {
    $fh = fopen($fn, 'w') or die (sprintf("Error creating log file: %s", LOG_FILE));
    fclose($fh);
}

// ============================================================

function logMessage($message, $logLevel = LOG_INFO) {

    global $_SERVER;

    $level = "UNKNOWN";
    if ($logLevel === LOG_INFO) {
        $level = "INFO";
    } elseif ($logLevel === LOG_ERR) {
        $level = "ERROR";
    }

    $ts = date('Y-m-d H:i:s');
    $lm = sprintf("%s : %s : %s - %s%s", $_SERVER['REMOTE_ADDR'], $level, $ts, $message, PHP_EOL);

    if (!file_exists(LOG_FILE)) {
        createFile(LOG_FILE);
    }

    // 3 for appending to log file.
    error_log($lm, 3, LOG_FILE);
}

// ============================================================