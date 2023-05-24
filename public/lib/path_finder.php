<?php

class Path
{
    public static $instance = null;

    public static function GetInstance($docRoot = null)
    {
        if (self::$instance === null) {
            self::$instance = new Path($docRoot);
        }

        return self::$instance;
    }

    // ============================================================

    private $docRoot;

    public function absPath($urlPath)
    {
        $strPath = sprintf("%s%s%s", $this->docRoot, DIRECTORY_SEPARATOR, $urlPath);
        $rlPath = realpath($strPath);

        if (!$rlPath) {
            throw new Exception("Error building absolute file path. $strPath does not exist.");
        }

        return $rlPath;
    }

    // ============================================================

    public function urlPath($stripExtra = false)
    {
        $url = (sprintf("%s://%s%s", (empty($_SERVER['HTTPS']) ? 'http' : 'https'), $_SERVER['HTTP_HOST'], $_SERVER['REQUEST_URI']));

        if ($stripExtra) {
            $pos = strripos($url, $_SERVER['PHP_SELF']);
            $url_stripped = sprintf("%s%s", substr($url, 0, $pos), $_SERVER['PHP_SELF']);
            return $url_stripped;
        } else {
            return $url;
        }
    }

    // ============================================================

    private function __construct($forceDocRoot)
    {
        if ($forceDocRoot == null) {
            $this->docRoot = $_SERVER['DOCUMENT_ROOT'];
        } else {
            $docRoot = $forceDocRoot;
        }
    }
}

// ============================================================
