<?php

date_default_timezone_set("America/Toronto");

// Database connection
define("DB_HOST", "localhost");
define("DB_USER", "");
define("DB_PASSWORD", "");
define("DB_NAME", "");


// Admin's name
define("CONFIG_ADMIN", "Alex Souchereau");
// Admin's Email
define("CONFIG_ADMINEMAIL", "");
// Location of project
define("CONFIG_URL", "https://asouchereau.scweb.ca/web306/auction");
// Auction Site's Name
define("CONFIG_AUCTIONNAME", "Alex's Online Auction");
// Currency used on the auction site
define("CONFIG_CURRENCY", "$");


// Logs location
define("LOG_LOCATION", __DIR__ . "/../../logs/app.log");


// Uploaded file path
define("FILE_UPLOADLOC", "imgs/");



// Paypal Settings
define("CLIENT_ID", "");
define("CLIENT_SECRET", "");

define("PAYPAL_CURRENCY", "CAD");

define("PAYPAL_RETURNURL", CONFIG_URL . "/payment-successful.php");
define("PAYPAL_CANCELURL", CONFIG_URL . '/payment-cancelled.php');