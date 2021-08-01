<?php

header('Content-Type: application/json');

$r = new stdClass;

$r->cookie  = $_COOKIE;
$r->get     = $_GET;
$r->post    = $_POST;
$r->request = $_REQUEST;
$r->server  = $_SERVER;

echo json_encode($r);

exit;
