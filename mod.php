<?php


use Symfony\Component\VarDumper\VarDumper;
use Slim\Factory\AppFactory;

// use Psr\Http\Message\ResponseInterface as Response;
// use Psr\Http\Message\ServerRequestInterface as Request;


require __DIR__ . '/../vendor/autoload.php';

// $app = AppFactory::create();


VarDumper::dump([
    "message" => "welcome",
    "payload" => [
        "VarDumper"  => Symfony\Component\VarDumper\VarDumper::class,
        "AppFactory" => Slim\Factory\AppFactory::class,
        "IRequest"   => Psr\Http\Message\ServerRequestInterface::class,
        "IResponse"  => Psr\Http\Message\ResponseInterface::class,
    ],
]);

