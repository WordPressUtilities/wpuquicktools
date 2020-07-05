<?php

/**
 * WPU Quick Tools v 0.1.0
 */

define('ABSPATH', dirname(__FILE__) . '/');

/* ----------------------------------------------------------
  Load only the wp-config.php
---------------------------------------------------------- */

$wpconfig = 'wp-config.php';
while (!is_file($wpconfig)) {
    if (is_dir('..') && getcwd() != '/') {
        chdir('..');
    } else {
        die('EN: Could not find WordPress! FR : Impossible de trouver WordPress !');
    }
}
include $wpconfig;

/* ----------------------------------------------------------
  Query Helper
---------------------------------------------------------- */

function wpquicktools_query_to_json($sql = '') {

    /* Init Mysql */
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $json = array();
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $json[] = $row;
    }
    $conn->close();

    header('content-type:application/json');
    echo json_encode($json);
    die;
}
