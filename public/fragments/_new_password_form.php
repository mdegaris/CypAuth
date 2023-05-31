<?php
require_once($_PATH->absPath("/lib/forms_helper.php"));
?>

<form method="post">
    <div class="field-container">
        <input autocapitalize="off"
               autocomplete="password"
               type="password"
               name="<?= FormHelper::NEW_PASSWORD_RESET ?>"
               placeholder="New password"
               value="" />

        <input autocapitalize="off"
               autocomplete="off"
               type="password"
               name="<?= FormHelper::CONFIRM_PASSWORD_RESET ?>"
               placeholder="Confirm password"
               value="" />
    </div>

    <div class="button-container">
        <button type="submit"
                name="<?= FormHelper::SUBMIT_PASSWORD_RESET ?>">SET PASSWORD</button>
    </div>

    <input autocapitalize="off"
           autocomplete="username"
           class="invisbible"
           type="text"
           name="<?= FormHelper::USERNAME_RESET ?>"
           value=<?= FormHelper::getRequestParam(FormHelper::USERNAME_RESET) ?> />
</form>