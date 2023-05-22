<?php

class User
{
    public $username;
    public $encryptedPassword;
    public $locallyAuthenticated;
    public $resetPassword;
    public $accountEnabled;

    public static function createFromDatabaseRow($databaseRow)
    {
    }

    public static function createFromHTTP($httpRequest)
    {
    }

    // =============================================================

    private function _getColumn($row, $name)
    {
        if ($row and $name and isset($row[strtoupper($name)])) {
            return $row[strtoupper($name)];
        }
    }

    // =============================================================

    public function authenticate($password)
    {
    }

    // =============================================================

    // public function toJson()
    // {
    //     return json_encode(
    //         array(
    //             "username" => $this->username,
    //             "resetPassword" => $this->resetPassword,
    //             "locallyAuthenticated" => $this->locallyAuthenticated,
    //             "accountEnabled" => $this->accountEnabled
    //         )
    //     );
    // }

    // =============================================================

    function __construct($username, $encPw = null, $resetPw = null, $locAuth = null, $accEnabled = null)
    {
        $this->username = $username;
        $this->encryptedPassword = $encPw;
        $this->resetPassword = $resetPw;
        $this->locallyAuthenticated = $locAuth;
        $this->accountEnabled  = $accEnabled;
    }
}
