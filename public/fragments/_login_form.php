<?php
require_once($_PATH->absPath("/lib/forms_helper.php"));
?>


<form method="post">
    <div class="field-container">
        <input autocapitalize="off"
               autocomplete="username"
               type="text"
               name="<?= FormHelper::USERNAME_LOGIN ?>"
               placeholder="Username" />

        <input autocapitalize="off"
               autocomplete="password"
               type="password"
               name="<?= FormHelper::PASSWORD_LOGIN ?>"
               placeholder="Password" />
    </div>

    <div class="button-container">
        <button type="submit"
                name="<?= FormHelper::SUBMIT_LOGIN ?>"">LOGIN</button>
    </div>
</form>