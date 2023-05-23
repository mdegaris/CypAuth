<?php
require_once($PATH->absPath("/lib/forms_helper.php"));
?>

<form method="post" action="">
    <div class="field-container">
        <input type="text" name="<?= FormHelper::USERNAME_RESET ?>" placeholder="Username" value="" />
    </div>
    <div class="button-container">
        <button>CONTINUE</button>
    </div>
    <input type="hidden" name="<?= FormHelper::SUBMIT_USER ?>" />
</form>