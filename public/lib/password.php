<?php

require_once($_PATH->absPath("/lib/forms_helper.php"));

// ============================================================

class Password
{
    private static $SET_PASSWORD_PLSQL = <<<SQL
    BEGIN
        labsys_app.user_management_pkg.change_encrypted_password(:account_uid, :encrypted_password, :modified_by_uid);
    END;
SQL;

    // ============================================================

    private static $HASHING_ALGORITHM = "sha512";
    private static $STRENGTH_REGEX = '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$/';
    private static $HTML_ERROR_NOT_POPULATE = "Populate both password fields";
    private static $HTML_ERROR_NO_MATCH = "Password fields don't match";
    private static $HTML_ERROR_WEAK = "Password is too weak";

    // ============================================================

    public static $HTML_PASSWORD_REQ = <<<HTML
    <div>
        Passwords musts be at least:
    </div>
    <ul>
        <li>8 characters in length</li>
        <li>Contain 1 uppercase letter</li>
        <li>Contain 1 lowercase letter</li>
        <li>Contain 1 number</li>
    </ul>
HTML;

    // ============================================================

    public static function HashedPassword($password)
    {
        if ($password) {
            return hash(self::$HASHING_ALGORITHM, $password);
        }

        return null;
    }

    // ============================================================

    public $user;
    public $newPassword;
    public $confirmPassword;

    // ============================================================

    private function isPopulatedCheck()
    {
        return ($this->newPassword and $this->confirmPassword);
    }

    private function areMatchingCheck()
    {
        return ($this->newPassword === $this->confirmPassword);
    }

    private function isWeak()
    {
        return (preg_match(self::$STRENGTH_REGEX, $this->newPassword) == false);
    }

    // ============================================================

    public function feedbackError()
    {
        if (!$this->isPopulatedCheck()) {
            return self::$HTML_ERROR_NOT_POPULATE;
        }

        if (!$this->areMatchingCheck()) {
            return self::$HTML_ERROR_NO_MATCH;
        }

        if ($this->isWeak()) {
            return self::$HTML_ERROR_WEAK;
        }
    }

    // ============================================================

    public function setNewPasswordInDB()
    {
        $binds = array(
            "account_uid" => $this->user->username,
            "encrypted_password" => self::HashedPassword($this->newPassword),
            "modified_by_uid" => $this->user->username
        );

        $error = dbExecute(self::$SET_PASSWORD_PLSQL, $binds);

        if ($error) {
            dbRollback();
            $errMes = sprintf(
                "Database error when setting local password: %s. Code=%d. Offset=%d. SQL=%s",
                $error['message'],
                $error['code'],
                $error['offset'],
                $error['sqltext']
            );
            throw new Exception($errMes, $error['code']);
        } else {
            dbCommit();
        }
    }

    // ============================================================

    function __construct($usrObj, $newPwd, $confirmPwd)
    {
        $this->user = $usrObj;
        $this->newPassword = FormHelper::Trimmer($newPwd);
        $this->confirmPassword = FormHelper::Trimmer($confirmPwd);
    }
}
