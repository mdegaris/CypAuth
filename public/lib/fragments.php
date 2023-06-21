<?php

class Fragments
{
    // Setup singleton.
    private static $instance = null;
    public static function GetInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Fragments();
        }

        return self::$instance;
    }

    // ============================================================

    const FRAGMENT_SUB_FOLDER = 'fragments';

    public $usernameForm;
    public $newPasswordForm;
    public $loginPage;
    public $resetPage;
    public $loginForm;

    // ============================================================

    private function buildPath($fn) {

        global $_PATH;

        $sp = sprintf("%s%s%s%s", 
            DIRECTORY_SEPARATOR,
            Fragments::FRAGMENT_SUB_FOLDER, 
            DIRECTORY_SEPARATOR, 
            $fn);

        return $_PATH->absPath($sp);
    }

    // ============================================================

    public function __construct()
    {        
        // All possible PHP page fragments.
        $this->usernameForm = $this->buildPath("_username_form.php");
        $this->newPasswordForm = $this->buildPath("_new_password_form.php");
        $this->loginPage = $this->buildPath("_login_page.php");
        $this->loginForm = $this->buildPath("_login_form.php");
        $this->resetPage = $this->buildPath("_reset_page.php");
    }
}
