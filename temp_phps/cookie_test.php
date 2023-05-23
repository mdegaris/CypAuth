<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COOKIE TEST</title>
</head>

<body>
    <?php
    
    $COOKIE_LIFE = time() + 60 * 60 * 24 * 365;  // One year

    if( ! isset($_COOKIE['count'])) {
        echo "Cookie not set";
        $count = 1;
    } else {
        echo "Cookie is set";
        $count = $_COOKIE['count'];
        $count++;
    }

    setcookie('count', "$count", $COOKIE_LIFE, "/", "172.21.5.30");

    ?>
    <h1>Created Cookie</h1>
</body>

</html>