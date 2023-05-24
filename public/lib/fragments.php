<?php

class Fragments
{
    private static $instance = null;

    public static function GetInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Fragments();
        }

        return self::$instance;
    }

    // ============================================================

    public $username;
    public $new_password;
    public $login;
    public $reset;

    public function __construct()
    {
        global $_PATH;

        $this->username = $_PATH->absPath("/fragments/_username.php");
        $this->new_password = $_PATH->absPath("/fragments/_new_password.php");
        $this->login = $_PATH->absPath("/fragments/_login.php");
        $this->reset = $_PATH->absPath("/fragments/_reset.php");
    }
}