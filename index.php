<?php

// require_once("lib/path_finder.php");
// $PATH = Path::GetInstance();

// // require_once(Path::$Instance->absFSPath("/lib/forms_helper.php"));

// echo ($PATH->absPath("/lib/forms_helper.php"));
echo (sprintf("%s://%s%s", (empty($_SERVER['HTTPS']) ? 'http' : 'https'), $_SERVER['HTTP_HOST'], $_SERVER['REQUEST_URI']));

phpinfo();