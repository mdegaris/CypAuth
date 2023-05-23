<?php

class Path
{

    public static $_instance = null;

    public static function GetInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new Path();
        }

        return self::$_instance;
    }

    private $docRoot;

    public function absPath($urlPath)
    {
        return realpath(sprintf("%s%s%s", $this->docRoot, DIRECTORY_SEPARATOR, $urlPath));
    }

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

    private function __construct()
    {
        $this->docRoot = $_SERVER['DOCUMENT_ROOT'];
    }
}


$PATH = Path::GetInstance();

?>