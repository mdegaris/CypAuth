<?php
require_once("lib/forms_helper.php");
?>


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