<?php
require_once("lib/forms_helper.php");
require_once("lib/user_class.php");

$resetIncludeFrag = "fragments/_user.php";

if (isParamPresent(FormHelper::SUBMIT_USER)) {
    $username = getPostParam(FormHelper::USERNAME_RESET);
    $feedbackErr = null;
    $feedbackHelp = null;

    if ($username) {
        $userObj = User::createFromDatabase($username);
        $feedbackErr = $userObj->feedbackError();
        // $feedbackHelp = $userObj->feedbackHelp();

        if (!$feedbackErr) {
            $resetIncludeFrag = "fragments/_new_password.php";
        }
    }
}
?>

<?php if ($feedbackErr): ?>
    <div class="feedback-primary">
        <?= $feedbackErr ?>
    </div>
<?php endif; ?>

<?php
require($resetIncludeFrag);
?>

<?php if ($feedbackHelp): ?>
    <div class="feedback-extra">
        <?= $feedbackHelp ?>
    </div>
<?php endif; ?>