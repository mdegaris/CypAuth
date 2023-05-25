<?php

// Top level setup
require_once("lib/common.php");

require_once($_PATH->absPath("/lib/forms_helper.php"));
require_once($_PATH->absPath("/lib/cookie.php"));

// ============================================================

$forceSetup = FormHelper::isParamPresent("setup");

if ($forceSetup and !Cookie::HasAuthCookie()) {
  Cookie::GetInstance()->saveHttpRefCookie($_PATH->currentUrl(true));
  header("Location: auth.php?reset");
  exit();
}


if (!Cookie::HasAuthCookie()) {
  header("Location: auth.php");
  exit();
}

if (Cookie::HasAuthCookie() and $forceSetup) {
  header("Location: " . $_PATH->currentUrl(true, true));
  exit();
}

// ============================================================

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="css/portal.css" />
</head>

<body>
  <div class="outer-container">
    <header class="header">
      <div class="title-container">Labsys Portal</div>
    </header>
    <div class="separator"></div>
    <main class="main-content">
      <div class="section-container">
        <div class="section-header-container">
          <div class="section-header">Order System</div>
        </div>
        <div class="section-content">
          <ul>
            <li>
              <a href="http://atropos.cyprotex.com:8080/ords/dblive/f?p=103">Study Coordination</a>
              &nbsp;(<a href="/data/HowToUseStudyCoordinator.pdf">help doc</a>)
            </li>
            <li>
              <a href="http://applive.cyprotex.com/php_apps/service_definitions/index.php">Service Definitions</a>
            </li>
            <li>
              <a href="http://applive.cyprotex.com:8008/study_management">Study Management</a>
            </li>
            <li>
              <a href="http://atropos.cyprotex.com:8080/ords/dblive/f?p=121">CYP0694 Study Management</a>
            </li>
            <li>
              <a href="http://atropos.cyprotex.com:8080/ords/dblive/labsys_public/r/cyp1367-study-management">CYP1367 Study Management</a>
            </li>
            <li>
              <a href="http://atropos.cyprotex.com:8080/ords/dblive/labsys_public/r/cyp1676-next-status">CYP1676 NEXT Status</a>
            </li>
          </ul>
        </div>
      </div>

      <div class="section-container">
        <div class="section-header-container">
          <div class="section-header">Laboratory System</div>
        </div>
        <div class="section-content">
          <ul>
            <li>
              <a href="<?php echo (getenv('live_labsys_url')) ?>">Labsys Login</a>
            </li>
            <li>
              <a href="http://atropos.cyprotex.com:8080/ords/dblive/f?p=109:1">Decertification Centre</a>
            </li>
            <li>
              <a href="http://atropos.cyprotex.com:8080/ords/dblive/f?p=106:1:">Labsys Result Browser</a>
            </li>
            <li>
              <a href="http://atropos.cyprotex.com:8080/ords/dblive/f?p=111:1:">Labsys Pick Lists</a>
            </li>
            <li>
              <a href="http://atropos.cyprotex.com:8080/ords/dblive/f?p=110:4">Labsys Batch Manager {Microsomes, S9, etc.}</a>
            </li>
          </ul>
        </div>
      </div>
      <div class="section-container">3</div>
    </main>
  </div>
</body>

</html>