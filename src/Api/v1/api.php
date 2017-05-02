<?php
// Requests from the same server don't have a HTTP_ORIGIN header

use Api\V1\BoardingCardApi;

$loader = require __DIR__.'/../../autoload.php';

if (!array_key_exists('HTTP_ORIGIN', $_SERVER)) {
    $_SERVER['HTTP_ORIGIN'] = $_SERVER['SERVER_NAME'];
}

try {
    $api = new BoardingCardApi($_REQUEST['request'], $_SERVER['HTTP_ORIGIN'], $_GET);
    echo $api->processAPI();
} catch (Exception $e) {
    echo json_encode(Array('error' => $e->getMessage()));
}

