<?php

require_once($PATH->absPath("/lib/forms_helper.php"));
require_once($PATH->absPath("/lib/loginUser.php"));
require_once($PATH->absPath("/lib/cookie.php"));


if (isParamPresent(FormHelper::SUBMIT_LOGIN_AUTH)) {

    $username = getPostParam(FormHelper::USERNAME_LOGIN);
    $password = getPostParam(FormHelper::PASSWORD_LOGIN);

    $loginUser = new LoginUser($username, $password);
    $feedbackErr = $loginUser->feedbackError();
    $feedbackHelp = $loginUser->feedbackHelp();

    if (!$feedbackErr) {
        if ($loginUser->authenticate()) {
            Cookie::GetInstance()->saveAuthCookie($loginUser->user->username);
            $url_referrer = Cookie::GetInstance()->readOnceHttpRefCookie();
            if ($url_referrer) {
                header("Location: $url_referrer");
            } else {
                header("Location: /");
            }
            exit();
        } else {
            $feedbackErr = "Incorrect username/password";
        }
    }
}
?>

<?php if (isset($feedbackErr) and $feedbackErr): ?>
    <div class="feedback-primary">
        <?= $feedbackErr ?>
    </div>
<?php endif; ?>

<form method="post">
    <div class="field-container">
        <input type="text" name="<?= FormHelper::USERNAME_LOGIN ?>" placeholder="Username" />
        <input type="password" name="<?= FormHelper::PASSWORD_LOGIN ?>" placeholder="Password" />
    </div>
    <div class="button-container">
        <button>LOGIN</button>
    </div>
    <input type="hidden" name="<?= FormHelper::SUBMIT_LOGIN_AUTH ?>" />
</form>

<?php if (isset($feedbackHelp) and $feedbackHelp): ?>
    <div class="feedback-extra">
        <?= $feedbackHelp ?>
    </div>
<?php endif; ?>