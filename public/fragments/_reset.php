<?php

require_once($PATH->absPath("/lib/forms_helper.php"));
require_once($PATH->absPath("/lib/user.php"));
require_once($PATH->absPath("/lib/password.php"));
require_once($PATH->absPath("/lib/pl_sql.php"));
require_once($PATH->absPath("/lib/cookie.php"));


$resetIncludeFrag = $PATH->absPath("/fragments/_username.php");

if (isParamPresent(FormHelper::SUBMIT_USER)) {

    $username = getPostParam(FormHelper::USERNAME_RESET);

    $user = User::createFromDatabase($username);
    $feedbackErr = $user->feedbackError();
    $feedbackHelp = $user->feedbackHelp();

    if (!$feedbackErr) {
        $resetIncludeFrag = $PATH->absPath("/fragments/_new_password.php");
    }
}

if (isParamPresent(FormHelper::SUBMIT_PASSWORD_RESET)) {
    $username = getPostParam(FormHelper::USERNAME_RESET);
    $newPwd = getPostParam(FormHelper::NEW_PASSWORD_RESET);
    $confirmPwd = getPostParam(FormHelper::CONFIRM_PASSWORD_RESET);

    $user = User::createFromDatabase($username);
    $passwordObj = new Password($user, $newPwd, $confirmPwd);
    $feedbackErr = $passwordObj->feedbackError();
    $feedbackHelp = $passwordObj->feedbackHelp();

    if (!$feedbackErr) {
        // $passwordObj->setNewPasswordInDB();
        Cookie::GetInstance()->saveAuthCookie($user->username);
        $referrer_url = Cookie::GetInstance()->readOnceHttpRefCookie();
        echo ($referrer_url);
        header("Location: $referrer_url");
        exit();
    } else {
        $resetIncludeFrag = $PATH->absPath("/fragments/_new_password.php");
    }
}

?>

<?php if (isset($feedbackErr) and $feedbackErr): ?>
    <div class="feedback-primary">
        <?= $feedbackErr ?>
    </div>
<?php endif; ?>

<?php
require($resetIncludeFrag);
?>

<?php if (isset($feedbackHelp) and $feedbackHelp): ?>
    <div class="feedback-extra">
        <?= $feedbackHelp ?>
    </div>
<?php endif; ?>