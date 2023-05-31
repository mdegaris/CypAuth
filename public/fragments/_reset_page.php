<?php

require_once($_PATH->absPath("/lib/forms_helper.php"));
require_once($_PATH->absPath("/lib/fragments.php"));
require_once($_PATH->absPath("/lib/user.php"));
require_once($_PATH->absPath("/lib/password.php"));
require_once($_PATH->absPath("/lib/cookie.php"));


$includeFrag = Fragments::GetInstance()->usernameForm;

// ============================================================

if (FormHelper::isParamPresent(FormHelper::SUBMIT_USERNAME_RESET)) {
    $username = FormHelper::getRequestParam(FormHelper::USERNAME_RESET);
    $userObj = User::createFromDatabase($username);
    $feedbackErr = $userObj->feedbackError();
    $feedbackHelp = $userObj->feedbackHelp();

    if (!$feedbackErr) {
        $includeFrag = Fragments::GetInstance()->newPasswordForm;
        $feedbackHelp = Password::$HTML_PASSWORD_REQ;
    }
}

// ============================================================

if (FormHelper::isParamPresent(FormHelper::SUBMIT_PASSWORD_RESET)) {
    $username = FormHelper::getRequestParam(FormHelper::USERNAME_RESET);
    $newPwd = FormHelper::getPostParam(FormHelper::NEW_PASSWORD_RESET);
    $confirmPwd = FormHelper::getPostParam(FormHelper::CONFIRM_PASSWORD_RESET);

    $userObj = User::createFromDatabase($username);
    $passwordObj = new Password($userObj, $newPwd, $confirmPwd);
    $feedbackErr = $passwordObj->feedbackError();
    $feedbackHelp = Password::$HTML_PASSWORD_REQ;

    if (!$feedbackErr) {
        $passwordObj->setNewPasswordInDB();
        Cookie::GetInstance()->saveAuthCookie($userObj->username);

        $referrer_url = Cookie::GetInstance()->readOnceHttpRefCookie();
        $return_url = empty($referrer_url) ? $_PATH->rootUrl() : $referrer_url;

        header("Location: $return_url");
        exit();
    } else {
        $includeFrag = Fragments::GetInstance()->newPasswordForm;
    }

    // ============================================================
}

?>

<?php if (!empty($feedbackErr)) : ?>
    <div class="feedback-primary">
        <?= $feedbackErr ?>
    </div>
<?php endif; ?>

<?php
require($includeFrag);
?>

<?php if (!empty($feedbackHelp)) : ?>
    <div class="feedback-extra">
        <?= $feedbackHelp ?>
    </div>
<?php endif; ?>

<div class="form-footer"><a href="auth.php">Login</a></div>