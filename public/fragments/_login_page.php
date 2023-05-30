<?php

/**
 * Login PHP fragment that renders a login form
 * Also handles the validation, authentication logic
 * and cookie creation upon a login submit.
 */

require_once($_PATH->absPath("/lib/forms_helper.php"));
require_once($_PATH->absPath("/lib/fragments.php"));
require_once($_PATH->absPath("/lib/login_user.php"));
require_once($_PATH->absPath("/lib/cookie.php"));


// Check if the login button was clicked.
if (FormHelper::isParamPresent(FormHelper::SUBMIT_LOGIN)) {

    // Retrieve submitted login and password form field vaules.
    $username = FormHelper::getPostParam(FormHelper::USERNAME_LOGIN);
    $password = FormHelper::getPostParam(FormHelper::PASSWORD_LOGIN);

    // Create LoginUser object, and check for any validation feedback.
    $loginUser = new LoginUser($username, $password);
    $feedbackErr = $loginUser->feedbackError();
    $feedbackHelp = $loginUser->feedbackHelp();

    // If no validation feedback, then proceed with authentication.
    if (!$feedbackErr) {

        // If password reset has been flagged,
        // user will redirect to the "set new password".
        if ($loginUser->user->resetPassword) {
            // Build URL that triggers the "set new password" page render.
            $url = sprintf(
                '%s?%s',
                $_PATH->currentUrl(true),
                http_build_query(
                    array(
                        FormHelper::RESET_FLAG => true,
                        FormHelper::SUBMIT_USERNAME_RESET => true,
                        FormHelper::USERNAME_RESET => $loginUser->user->username
                    )
                )
            );
            header("Location: $url");
            exit();
        }

        if ($loginUser->authenticate()) {
            Cookie::GetInstance()->saveAuthCookie($loginUser->user->username);
            $urlReferrer = Cookie::GetInstance()->readOnceHttpRefCookie();
            if ($urlReferrer) {
                header(sprintf("Location: %s", $urlReferrer));
            } else {
                header(sprintf("Location: %s", $_PATH->rootUrl()));
            }
            exit();
        } else {
            $feedbackErr = LoginUser::$HTML_ERROR_FAILED_AUTH;
        }
    }
}
?>

<?php if (!empty($feedbackErr)) : ?>
    <div class="feedback-primary">
        <?= $feedbackErr ?>
    </div>
<?php endif; ?>

<?php include(Fragments::GetInstance()->loginForm); ?>

<?php if (!empty($feedbackHelp)) : ?>
    <div class="feedback-extra">
        <?= $feedbackHelp ?>
    </div>
<?php endif; ?>