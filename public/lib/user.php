<?php

require_once($_PATH->absPath("/lib/database.php"));

// ============================================================

class User
{
    private static $USER_CREDS_SQL = <<<SQL
    SELECT account_uid, encrypted_local_password, locally_authenticated, password_reset, account_enabled
    FROM cyprotex.cy_user
    WHERE cy_user.account_uid = :username
SQL;

    // ============================================================

    public static $HTML_ERROR_EMPTY = "Please enter a username";
    public static $HTML_ERROR_ACC_DISABLED = "This account has been disabled";
    public static $HTML_ERROR_NOT_LOCAL = "Account not locally authenticated";
    public static $HTML_ERROR_NOT_RESET = "Account not flagged for resetting";
    public static $HTML_ERROR_USER_NOT_FOUND = "User could not be found";

    // ============================================================

    private static $HTML_ERROR_USER_FIND_HELP = <<<HTML
    <div>
        Usernames usually take one of following forms:
    </div>
    <div>
        E.g. <span class="blue">John</span> <span class="orange">Robinson</span>
    </div>
    <ol>
        <li><span class="blue">j</span><span class="orange">robinson</span></li>
        <li><span class="blue">joh</span><span class="orange">robin</span></li>
    </ol>
HTML;


    public $username;
    public $encryptedSavedPassword;
    public $locallyAuthenticated;
    public $resetPassword;
    public $accountEnabled;
    public $exists;
    public $isUserEmpty;

    public static function createFromDatabase($username)
    {
        $rows = dbQuery(User::$USER_CREDS_SQL, array("username" => $username));
        $row = $rows and count($rows) == 1 ? $rows[0] : null;

        if ($row) {
            $row = $rows[0];
            return new User(
                $row['ACCOUNT_UID'],
                $row['ENCRYPTED_LOCAL_PASSWORD'],
                $row['PASSWORD_RESET'],
                $row['LOCALLY_AUTHENTICATED'],
                $row['ACCOUNT_ENABLED']
            );
        } else {
            return new User($username);
        }
    }

    // ============================================================

    public function feedbackError()
    {
        if ($this->isUserEmpty) {
            return User::$HTML_ERROR_EMPTY;
        }

        if (!$this->exists) {
            return User::$HTML_ERROR_USER_NOT_FOUND;
        }

        if (!$this->accountEnabled) {
            return User::$HTML_ERROR_ACC_DISABLED;
        }

        if (!$this->locallyAuthenticated) {
            return User::$HTML_ERROR_NOT_LOCAL;
        }

        if (!$this->resetPassword) {
            return User::$HTML_ERROR_NOT_RESET;
        }
    }

    // ============================================================

    public function feedbackHelp()
    {
        if (!$this->isUserEmpty and !$this->exists) {
            return User::$HTML_ERROR_USER_FIND_HELP;
        }
    }

    // =============================================================

    function __construct($usr, $encryptedPwd = null, $resetPwd = null, $localPwd = null, $accEnabled = null)
    {
        $this->username = FormHelper::Trimmer($usr);

        $this->isUserEmpty = empty($this->username) ? true : false;
        $this->exists = ($resetPwd or $localPwd or $accEnabled);

        if ($this->exists) {
            $this->encryptedSavedPassword = $encryptedPwd;
            $this->resetPassword = $resetPwd === 'Y' ? true : false;
            $this->locallyAuthenticated = $localPwd === 'Y' ? true : false;
            $this->accountEnabled = $accEnabled === 'Y' ? true : false;
        }
    }
}
