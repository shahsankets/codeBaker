<?php

session_start();
/**
 * @author RN Kushwaha
 * @email Rn.kushwaha022@gmail.com
 * @return db Objects to connect
 * @date 5th April 2014
 */
if ($_SERVER['HTTP_HOST'] == "localhost" || $_SERVER['HTTP_HOST'] == "127.0.0.1") {
    // Config setting for localhost.
    $DBServer = 'localhost'; // e.g 'localhost' or '192.168.1.100'
    $DBUser = 'root';
    $DBPass = 'admin';
    $DBName = 'rnmysqli';
    define('SITE_URL', "http://localhost/rnmysqli/");
} else {
    // Config setting for live server.
    $DBServer = 'localhost'; // e.g 'localhost' or '192.168.1.100'
    $DBUser = 'root';
    $DBPass = 'admin';
    $DBName = 'rnmysqli';
    define('SITE_URL', "http://cookandbake.co.in/");
}

// Database Connection Establishment String
$conn = new mysqli($DBServer, $DBUser, $DBPass, $DBName);
// check connection
if ($conn->connect_error) {
    trigger_error('Database connection failed: ' . $conn->connect_error, E_USER_ERROR);
}

function executeQuery($sql, $conn = '') {
    $result = $conn->query($sql);
    if ($result === false) {
        trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
    }
    return $result;
}

// Some common settings
define('SITE_TITLE', "RN New MySQLi Approach");
define('SITE_ADMIN_TITLE', "RN New MySQLi Approach - Secure Admin Area");
define('PAGING_SIZE', 50);
date_default_timezone_set('Asia/Kolkata');
$conn->query("SET time_zone = '+05:30';");

?>