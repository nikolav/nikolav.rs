<?php


use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Symfony\Component\VarDumper\VarDumper;

require __DIR__ . '/../vendor/autoload.php';


$app = AppFactory::create();


VarDumper::dump([
    "message" => "welcome",
    "payload" => [
        "VarDumper"  => class_exists("Symfony\Component\VarDumper\VarDumper"),
        "AppFactory" => class_exists("Slim\Factory\AppFactory"),
        "IRequest"  => interface_exists("Psr\Http\Message\ServerRequestInterface"),
        "IResponse" => interface_exists("Psr\Http\Message\ResponseInterface"),
    ],
]);

exit;
