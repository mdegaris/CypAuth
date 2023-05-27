<?php

require_once($_PATH->absPath("/lib/user.php"));
require_once($_PATH->absPath("/lib/password.php"));

class LoginUser
{
    public static $HTML_ERROR_NOT_POPULATED = "Missing username or password";
    public static $HTML_ERROR_FAILED_AUTH = "Invalid username or password";

    // ============================================================

    private $encryptedLoginPassword;

    // ============================================================

    public $user;
    public $isPopulated;

    // ============================================================

    public function feedbackError()
    {
        if ($this->user->exists) {
            if (!$this->user->accountEnabled) {
                return User::$HTML_ERROR_ACC_DISABLED;
            }

            if (!$this->user->locallyAuthenticated) {
                return User::$HTML_ERROR_NOT_LOCAL;
            }
        }

        if (!$this->isPopulated) {
            return LoginUser::$HTML_ERROR_NOT_POPULATED;
        }
    }

    // ============================================================

    public function feedbackHelp()
    {
        return null;
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
