<?php

// Top level setup
require_once("lib/common.php");

require_once($_PATH->absPath("/lib/forms_helper.php"));
require_once($_PATH->absPath("/lib/cookie.php"));

// ============================================================

// Redirect to password resetting if 'setup' request parameter is set
// and Auth cookie is not set.
$forceSetup = FormHelper::isParamPresent(FormHelper::SETUP_FLAG);
if ($forceSetup and !Cookie::HasAuthCookie()) {

    logMessage("No cookie and we're forcing a password setup.");

    Cookie::GetInstance()->saveHttpRefCookie($_PATH->currentUrl(true));
    header(sprintf("Location: auth.php?%s", FormHelper::RESET_FLAG));
    exit();
}

// If Auth cookie is not set, redirect to auth login.
if (!Cookie::HasAuthCookie()) {

    logMessage("No cookie so redirect to login.");

    header("Location: auth.php");
    exit();
}

// If we have an auth cookie and trying to force a setup,
// strip query string and script.php, and redirect to home portal page.
if (Cookie::HasAuthCookie() and $forceSetup) {

    logMessage(sprintf("Cookie found for \"%s\", so clean-up URL and redirect to main index page.", Cookie::GetInstance()->getUsername()));

    header("Location: " . $_PATH->currentUrl(true, true));
    exit();
}

// ============================================================

logMessage(sprintf("Cookie found for \"%s\". Display main index page.", Cookie::GetInstance()->getUsername()));

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible"
              content="IE=edge" />
        <meta name="viewport"
              content="width=device-width, initial-scale=1.0" />
        <link rel="icon"
              href="images/logo-brand.svg"
              type="image/svg+xml">
        <link rel="stylesheet"
              href="css/portal.css?1" />

        <title>Labsys Portal</title>
    </head>

    <body>
        <div class="outer-container">
            <header class="header">
                <div class="logo-container">
                    <img class="logo-image"
                         src="images/logo-brand.svg" />
                </div>
                <div class="title-container">Labsys Portal</div>
                <div class="profile-container">
                    <div class="username"><?= Cookie::GetInstance()->getUsername() ?></div>
                    <div class="date"><?= date('d M Y') ?></div>
                </div>
            </header>
            <div class="separator"></div>
            <main class="main-content">
                <section class="section-column">
                    <div class="card">
                        <div class="card-title">Order Systems</div>
                        <div class="card-content">
                            <ul>
                                <li>
                                    <a href="http://atropos.cyprotex.com:8080/ords/dblive/f?p=103">Study
                                        Coordination</a>
                                </li>
                                <li>
                                    <a href="http://applive.cyprotex.com:8008/study_management">Study
                                        Management</a>
                                </li>
                                <li>
                                    <a href="http://atropos.cyprotex.com:8080/ords/dblive/f?p=107">RSI
                                        Tracker V2</a>
                                </li>
                                <li>
                                    <a
                                       href="http://applive.cyprotex.com/wip/order_sys_order_list.php">Work
                                        in
                                        Progress</a>
                                </li>
                                <li>
                                    <a
                                       href="http://applive.cyprotex.com/wip/order_sys_order_list.php?mode=complete">Completed
                                        Orders</a>
                                </li>
                                <li>
                                    <a href="http://atropos.cyprotex.com:8080/ords/dblive/f?p=142">Labsys
                                        Registered
                                        Compounds &amp; Services</a>
                                </li>
                                <li>
                                    <a
                                       href="http://applive.cyprotex.com/php_apps/result_extraction/">Report
                                        Extraction</a>
                                </li>
                                <li>
                                    <a
                                       href="http://applive.cyprotex.com/php_apps/service_definitions/">Service
                                        Definitions</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-title">Client Specific Tools</div>
                        <div class="card-content">
                            <ul>
                                <li>
                                    <a href="http://atropos.cyprotex.com:8080/ords/dblive/f?p=121">CYP0694
                                        Study
                                        Management</a>
                                </li>
                                <li>
                                    <a
                                       href="http://atropos.cyprotex.com:8080/ords/dblive/labsys_public/r/cyp1367-study-management">CYP1367
                                        Study Management</a>
                                </li>
                                <li class="inactive">
                                    <a
                                       href="http://atropos.cyprotex.com:8080/ords/dblive/labsys_public/r/cyp1676-next-status">CYP1676
                                        NEXT Status</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-title">Reports</div>
                        <div class="card-content">
                            <ul>
                                <li>
                                    <a
                                       href="http://applive.cyprotex.com:8008/reports/Order_System_Metrics">Order
                                        System
                                        Metrics</a>
                                </li>
                                <li>
                                    <a
                                       href="http://applive.cyprotex.com:8008/reports/Mass_Spec/Compounds_Received_During_The_Last_14_Days_That_Require_Optimisation/?format=xls&location=Macclesfield">Optimisation
                                        Status (Macclesfield)</a>
                                </li>
                                <li>
                                    <a
                                       href="http://atropos.cyprotex.com:8080/ords/dblive/labsys_public/r/cyprotex-workflow-statistics/optimisation-turnaround-study">Optimisation
                                        Statistics (Macclesfield)</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                </section>
                <section class="section-column">
                    <div class="card">
                        <div class="card-title">Laboratory Systems</div>
                        <div class="card-content">
                            <ul>
                                <li>
                                    <a href="http://applive.cyprotex.com:8080/labsys">Labsys</a>
                                </li>
                                <li>
                                    <a
                                       href="http://atropos.cyprotex.com:8080/ords/dblive/f?p=109:1">Decertification
                                        Centre</a>
                                </li>
                                <li>
                                    <a
                                       href="http://atropos.cyprotex.com:8080/ords/dblive/f?p=106:1:">Labsys
                                        Result
                                        Browser</a>
                                </li>
                                <li>
                                    <a
                                       href="http://atropos.cyprotex.com:8080/ords/dblive/f?p=111:1:">Labsys
                                        Pick
                                        Lists</a>
                                </li>
                                <li>
                                    <a
                                       href="http://atropos.cyprotex.com:8080/ords/dblive/f?p=110:4">Labsys
                                        Batch
                                        Manager
                                        {Microsomes, S9, etc.}</a>
                                </li>
                                <li>
                                    <a href="http://applive.cyprotex.com:8008/iplate_design">Cocktails
                                        and I-Plate
                                        Design</a>
                                </li>
                                <li class="inactive">
                                    <a href="http://co-mac-sapd02.cyprotex.com:8084/applive/">Auto
                                        Tox Task Wizard</a>
                                </li>
                                <li>
                                    <a href="http://applive.cyprotex.com:8008/hcs">HCS Fitting</a>
                                </li>
                                <li>
                                    <a href="http://applive.cyprotex.com:8008/tox_upload">Tox
                                        Instrument Data Upload</a>
                                </li>
                                <li>
                                    <a href="http://applive.cyprotex.com:8080/reinjection/">Reinjection
                                        Site</a>
                                </li>
                                <li>
                                    <a href="http://atropos.labs.cyprotex.com/monitor/">Waters
                                        Monitor</a>
                                </li>
                                <li>
                                    <a
                                       href="http://atropos.labs.cyprotex.com/monitor/tecan_view.html">Tecan
                                        Monitor</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-title">Mass Spec Data</div>
                        <div class="card-content">
                            <ul>
                                <li class="inactive">
                                    <a href="http://msrawdata.cyprotex.com/msrawdata.php">Xevo Mass
                                        Spec Raw Data
                                        Fetcher</a>
                                </li>
                                <li>
                                    <a href="http://applive.cyprotex.com:8008/qtrapdata">QTRAP Data
                                        (for MultiQuant
                                        work)</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-title">Upload Utilities</div>
                        <div class="card-content">
                            <ul>
                                <li>
                                    <a href="http://applive.cyprotex.com/cgi-bin/upload_to_ms.pl">Sample list upload to all Xevos</a>
                                </li>
                                <li class="inactive">
                                    <a href="http://applive/cgi-bin/upload_to_qtrap.pl">Sample list
                                        upload to all
                                        QTRAPS</a>
                                </li>
                                <li class="inactive">
                                    <a href="http://applive/cgi-bin/upload_to_tecan_genesis.pl">Gemini
                                        script upload to
                                        Tecan Genesis</a>
                                </li>
                                <li class="inactive">
                                    <a href="http://applive/cgi-bin/convert_qtrap_to_ms.pl">Sample
                                        list convert QTRAP
                                        (upload to Xevos)</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                </section>
                <section class="section-column">
                    <div class="card">
                        <div class="card-title">Quality</div>
                        <div class="card-content">
                            <ul>
                                <li>
                                    <a href="http://atropos.cyprotex.com:8080/ords/dblive/f?p=102">Change
                                        Book</a>
                                </li>
                                <li>
                                    <a href="http://applive.cyprotex.com:8008/reports">Reports</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-title">Infrastructure</div>
                        <div class="card-content">
                            <ul>
                                <li>
                                    <a href="http://sb.cyprotex.com/bus/dblive.srvbus/ui">Service
                                        Bus</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </section>
            </main>
        </div>
    </body>

</html>