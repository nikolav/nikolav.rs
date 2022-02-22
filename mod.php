<?php


use Symfony\Component\VarDumper\VarDumper;

require __DIR__ . '/../vendor/autoload.php';


VarDumper::dump([
    "message" => "welcome",
    "payload" => [],
]);

