<?php
// headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: *");
header("Content-Type: text/html; charset=utf-8");

// Record prints
ob_start();

// Run nav
require_once(__DIR__ . '/nav.php');
// Get Page
require_once(__DIR__ . '/page.php');


?>


