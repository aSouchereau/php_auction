<?php
// (A) ADD CODE TO REQUIRE THE BOOTSTRAP FILE BELOW
require_once (__DIR__ . "/../app/bootstrap.php");


//Run the session logout method to logout the current user
// (B) USE THE CORRECT SESSION CLASS METHOD TO LOGOUT THE USER
/**
 * @var App\Lib\Session $session
 */
$session->logout();


// (C) REDIRECT THE USER TO THE index.php PAGE
header("Location: " . CONFIG_URL);


die();