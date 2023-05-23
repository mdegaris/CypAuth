<?php

require_once("lib/forms_helper.php");




class ResetForm
{
    public static function FromHTTP()
    {
        return new ResetForm(
            getPostParam(FormHelper::USERNAME_LOGIN),
            getPostParam(FormHelper::NEW_PASSWORD_RESET),
            getPostParam(FormHelper::CONFIRM_PASSWORD_RESET)
        );
    }

    public $username;
    public $newPassword;
    public $confirmPassword;

    function __construct($usr, $nPw, $cPw)
    {
        $this->username = FormHelper::Trimmer($usr);
        $this->newPassword = FormHelper::Trimmer($nPw);
        $this->confirmPassword = FormHelper::Trimmer($cPw);
    }
}

function validateUser($username)
{

}


function strongPasswordCheck($password)
{
    $pw_strength_regex = "^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[!@#$%^&*-]).{8,}$";

    return false;
}

function matchingPasswords($form)
{
    if (getPostParam($form->newPassword) === getPostParam($form->confirmPassword)) {
        return true;
    }

    return false;
}


function fieldsPopulated($form)
{
    if (getPostParam($form->newPassword) and getPostParam($form->confirmPassword)) {
        return true;
    }

    return false;
}

function getFormFeedback()
{
    $resetForm = ResetForm::FromHTTP();

    if (!fieldsPopulated($resetForm)) {
        return "Both fields must be populated.";
    }

    if (!matchingPasswords($resetForm)) {
        return "Confirmation password does not match.";
    }

    if (!strongPasswordCheck($resetForm->newPassword)) {
        return <<<TXT
The passowrd must be at least 8 characters, and contain:
<ul>
    <li>At least one upper case letter</li>
    <li>At least one lower case letter</li>
    <li>At least one number</li>
    <li>At least one special character (!@#$%^&*-)</li>
</ul>
TXT;
    }

    return false;
}


function handleFormSubmit()
{
    $feedback_message = getFormFeedback();

    if ($feedback_message === false) {

    }
}

?>


<form method="post">
    <div class="field-container">
        <input type="password" name="<?= FormHelper::NEW_PASSWORD_RESET ?>" placeholder="New password" />
        <input type="password" name="<? FormHelper::CONFIRM_PASSWORD_RESET ?>" placeholder="Confirm password" />
    </div>
    <div class="button-container">
        <button>SET PASSWORD</button>
    </div>
    <input type="hidden" name="<?= FormHelper::SUBMIT_PASSWORD_RESET ?>" />

</form>
<div class="feedback-container">
    <?= $feedback_message ?>
</div>