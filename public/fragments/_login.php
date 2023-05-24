<?php

require_once($_PATH->absPath("/lib/forms_helper.php"));
require_once($_PATH->absPath("/lib/fragments.php"));
require_once($_PATH->absPath("/lib/login_user.php"));
require_once($_PATH->absPath("/lib/cookie.php"));


if (FormHelper::isParamPresent(FormHelper::SUBMIT_LOGIN_AUTH)) {

    $username = FormHelper::getPostParam(FormHelper::USERNAME_LOGIN);
    $password = FormHelper::getPostParam(FormHelper::PASSWORD_LOGIN);

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
            $feedbackErr = Fragments::GetInstance()->login;
        }
    }
}
?>

<?php if (!empty($feedbackErr)): ?>
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

<?php if (!empty($feedbackHelp)): ?>
    <div class="feedback-extra">
        <?= $feedbackHelp ?>
    </div>
<?php endif; ?>