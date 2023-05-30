<?php

class Path
{
    // Singleton setup
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
    private $appUrlRoot;

    // Build the full absolute path from a relative path.
    public function absPath($relPath)
    {
        $sPath = sprintf("%s%s%s", $this->docRoot, DIRECTORY_SEPARATOR, $relPath);
        $rPath = realpath($sPath);

        if (!$rPath) {
            throw new Exception("Error building absolute file path. $sPath does not exist.");
        }

        return $rPath;
    }

    // ============================================================

    // Build the full absolute path from a relative path.
    public function rootUrl()
    {
        return $this->appUrlRoot;
    }

    // ============================================================

    // Build the full absolute path from a relative path.
    public function resetPasswordForward($formHelper)
    {



        return sprintf('%s?reset=&%s', $this->currentUrl(true), http_build_query($_REQUEST));
    }

    // ============================================================

    // Get the current URL path
    public function currentUrl($remvoeQuery = false, $removeScript = false)
    {
        $url = (sprintf(
                "%s://%s%s",
                empty($_SERVER['HTTPS']) ? 'http' : 'https',
                $_SERVER['HTTP_HOST'],
                $_SERVER['REQUEST_URI']
            )
        );

        if ($remvoeQuery or $removeScript) {

            $parsedUrl = parse_url($url);

            if ($remvoeQuery) {
                $baseFile = basename($_SERVER['SCRIPT_NAME']);
                $url = str_replace('/' . $baseFile, '', $url);
            }

            if ($removeScript) {
                $url = str_replace('?' . $parsedUrl['query'], '', $url);
            }
        }

        return $url;
    }

    // ============================================================

    private function __construct($forceDocRoot)
    {
        if ($forceDocRoot == null) {
            $this->docRoot = $_SERVER['DOCUMENT_ROOT'];
        } else {
            $this->docRoot = $forceDocRoot;
        }

        $this->appUrlRoot = sprintf('/%s', basename($this->docRoot));
    }
}

// ============================================================