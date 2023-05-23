<?php

// require("database.php");
require_once($PATH->absPath("/lib/password.php"));

class User
{
    private static $USER_CREDS_SQL = <<<SQL
    SELECT account_uid, encrypted_local_password, local_password, reset_password, account_enabled
    FROM cyprotex.cy_user
    WHERE cy_user.account_uid = :username
SQL;


    private static $HTML_ERROR_EMPTY = "Please enter a username";
    private static $HTML_ERROR_LOGIN_EMPTY = "Missing username or password";
    private static $HTML_ERROR_ACC_DISABLED = "This account has been disabled";
    private static $HTML_ERROR_NOT_LOCAL = "This account is not locally authenticated";
    private static $HTML_ERROR_NOT_RESET = "This account is not flagged for resetting";
    private static $HTML_ERROR_USER_NOT_FOUND = "User could not be found";

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
        // $row = dbQuery(User::$USER_CREDS_SQL, array("username" => $username));

        // if ($row) {
        //     return new User(
        //         $row['ACCOUNT_UID'],
        //         $row['ENCRYPTED_LOCAL_PASSOWRD'],
        //         $row['PASSWORD_RESET'],
        //         $row['LOCAL_PASSWORD'],
        //         $row['ACCOUNT_ENABLED']
        //     );
        // }

        if ($username == "mdegaris") {
            return new User(
                $username,
                Password::HashedPassword("test123"),
                "Y",
                // reset
                "Y",
                // local
                "Y"
                // enabled
            );
        } else {
            return new User($username);
        }

    }

    public function feedbackError($login = false)
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

        $this->isUserEmpty = $this->username ? false : true;
        $this->exists = ($resetPwd or $localPwd or $accEnabled);

        if ($this->exists) {
            $this->encryptedSavedPassword = $encryptedPwd;
            $this->resetPassword = $resetPwd === 'Y' ? true : false;
            $this->locallyAuthenticated = $localPwd === 'Y' ? true : false;
            $this->accountEnabled = $accEnabled === 'Y' ? true : false;
        }
    }
}