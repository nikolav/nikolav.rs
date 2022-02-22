<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';


$container = new \DI\Container();
AppFactory::setContainer($container);
$app = AppFactory::create();


// Changes to base path handling
// Up to v3, Slim extracted the base path from the folder where the application was instantiated. This is no longer the case, and the base path must be explicitly declared in case your application is not executed from the root of your domain:
// https://www.slimframework.com/docs/v4/start/web-servers.html#run-from-a-sub-directory
$app->setBasePath('/api');


$container->set("db", function () {
    return [
        "fluentpdo" => null,
    ];
});

// $container->set('view', function(\Psr\Container\ContainerInterface $container){
//     return new \Slim\Views\Twig('');
// });

// allow cors, json
$app->add(function ($req, $handler) {
    $res = $handler->handle($req);

    $res = $res->withHeader('Access-Control-Allow-Origin', '*');
    $res = $res->withHeader('Content-Type', 'application/json');

    return $res;
});

/**
 * The routing middleware should be added before the ErrorMiddleware
 * Otherwise exceptions thrown from it will not be handled
 */
$app->addRoutingMiddleware();

$app->get('/welcome', function (Request $request, Response $response, $args) {

    $body = [
        "message"     => "welcome",
        "version"     => "1.0.0",
        "payload"     => "",
        "time"        => "",
        "admin.email" => "admin@nikolav.rs",
    ];

    $response->getBody()
        ->write(json_encode($body));

    return $response;
});


/**
 * Add Error Handling Middleware
 *
 * @param bool $displayErrorDetails -> Should be set to false in production
 * @param bool $logErrors -> Parameter is passed to the default ErrorHandler
 * @param bool $logErrorDetails -> Display error details in error log
 * which can be replaced by a callable of your choice.
 
 * Note: This middleware should be added last. It will not handle any exceptions/errors
 * for middleware added after it.
 */
$app->addErrorMiddleware(false, true, true);

$app->run();
