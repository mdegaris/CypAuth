<?php

$cookieName = 'auth_cookie';
if (isset($_COOKIE[$cookieName])) {
    unset($_COOKIE[$cookieName]);
    // setcookie($cookieName, '', time() - 3600);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible"
          content="IE=edge" />
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0" />
</head>

<body>
    COOKIE DELETE!!!
</body>

</html>