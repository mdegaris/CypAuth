<?php
require_once($PATH->absPath("/lib/forms_helper.php"));
?>

<form method="post">
    <div class="field-container">
        <input autocomplete="off" type="password" name="<?= FormHelper::NEW_PASSWORD_RESET ?>"
            placeholder="New password" value="" />
        <input autocomplete="off" type="password" name="<?= FormHelper::CONFIRM_PASSWORD_RESET ?>"
            placeholder="Confirm password" value="" />
    </div>
    <div class="button-container">
        <button>SET PASSWORD</button>
    </div>
    <input type="hidden" name="<?= FormHelper::USERNAME_RESET ?>" value=<?= getPostParam(FormHelper::USERNAME_RESET) ?> />
    <input type="hidden" name="<?= FormHelper::SUBMIT_PASSWORD_RESET ?>" />
</form>