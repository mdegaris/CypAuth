<?php

require_once($PATH->absPath("/lib/user.php"));
require_once($PATH->absPath("/lib/password.php"));

class LoginUser
{
    private static $HTML_ERROR_NOT_POPULATED = "Missing username or password";

    // ============================================================

    private $encryptedLoginPassword;
    public $user;
    public $isPopulated;

    // ============================================================

    public function feedbackError()
    {
        if (!$this->user->isUserEmpty) {
            return $this->user->feedbackError();
        }

        if (!$this->isPopulated) {
            return LoginUser::$HTML_ERROR_NOT_POPULATED;
        }
    }

    // ============================================================

    public function feedbackHelp()
    {
        return $this->user->feedbackHelp();
    }

    // ============================================================

    public function authenticate()
    {
        if ($this->user->encryptedSavedPassword and $this->encryptedLoginPassword) {
            return ($this->user->encryptedSavedPassword === $this->encryptedLoginPassword);
        }

        return false;
    }

    // ============================================================

    public function __construct($usr, $pwd)
    {
        $this->user = User::createFromDatabase($usr);
        $this->encryptedLoginPassword = Password::HashedPassword($pwd);

        $this->isPopulated = ($this->user->isUserEmpty or $this->encryptedLoginPassword == null) ? false : true;
    }
}
