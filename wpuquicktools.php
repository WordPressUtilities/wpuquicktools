<?php

/**
 * WPU Quick Tools v 0.2.0
 */

/* ----------------------------------------------------------
  Define abspath to load our dumm wp-settings.php
---------------------------------------------------------- */

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
  Query
---------------------------------------------------------- */

function wpuquicktools_query($sql = '') {
    /* Init Mysql */
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $items = array();
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $items[] = array_map('wpuquicktools__force_utf8', $row);
    }
    $conn->close();
    return $items;
}

/* ----------------------------------------------------------
  JSON Query Helper
---------------------------------------------------------- */

function wpuquicktools_query_to_json($sql = '') {
    wpuquicktools_send_json(wpuquicktools_query($sql));
}

/* ----------------------------------------------------------
  Helpers
---------------------------------------------------------- */

/* Print JSON
-------------------------- */

function wpuquicktools_send_json($json){
    header('content-type:application/json');
    echo json_encode($json);
    die;
}


/* UTF-8 fixes
-------------------------- */

/* Thx http://php.net/manual/fr/function.mb-detect-encoding.php#50087 */
function wpuquicktools__is_utf8($string) {
    return preg_match('%^(?:
          [\x09\x0A\x0D\x20-\x7E]            # ASCII
        | [\xC2-\xDF][\x80-\xBF]             # non-overlong 2-byte
        |  \xE0[\xA0-\xBF][\x80-\xBF]        # excluding overlongs
        | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}  # straight 3-byte
        |  \xED[\x80-\x9F][\x80-\xBF]        # excluding surrogates
        |  \xF0[\x90-\xBF][\x80-\xBF]{2}     # planes 1-3
        | [\xF1-\xF3][\x80-\xBF]{3}          # planes 4-15
        |  \xF4[\x80-\x8F][\x80-\xBF]{2}     # plane 16
    )*$%xs', $string);
}

function wpuquicktools__force_utf8($string) {
    if (!wpuquicktools__is_utf8($string)) {
        $string = utf8_encode($string);
    }

    return $string;
}
