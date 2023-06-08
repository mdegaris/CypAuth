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

    public $usernameForm;
    public $newPasswordForm;
    public $loginPage;
    public $resetPage;
    public $loginForm;

    public function __construct()
    {
        global $_PATH;

        // All possible PHP page fragments.
        $this->usernameForm = $_PATH->absPath("/fragments/_username_form.php");
        $this->newPasswordForm = $_PATH->absPath("/fragments/_new_password_form.php");
        $this->loginPage = $_PATH->absPath("/fragments/_login_page.php");
        $this->loginForm = $_PATH->absPath("/fragments/_login_form.php");
        $this->resetPage = $_PATH->absPath("/fragments/_reset_page.php");
    }
}
