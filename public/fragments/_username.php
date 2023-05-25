<?php
require_once($_PATH->absPath("/lib/forms_helper.php"));
?>

<form method="post"
      action="">

    <div class="field-container">
        <input autocapitalize="off"
               autocomplete="username"
               type="text"
               name="<?= FormHelper::USERNAME_RESET ?>"
               placeholder="Username"
               value="" />
    </div>

    <div class="button-container">
        <button type="submit"
                name="<?= FormHelper::SUBMIT_USERNAME_RESET ?>">CONTINUE</button>
    </div>

</form>