<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../../src/.config.php';
require __DIR__ . '/../../vendor/autoload.php';


$app = AppFactory::create();

// Changes to base path handling
// Up to v3, Slim extracted the base path from the folder where the application was instantiated. This is no longer the case, and the base path must be explicitly declared in case your application is not executed from the root of your domain:
// https://www.slimframework.com/docs/v4/start/web-servers.html#run-from-a-sub-directory
$app->setBasePath('/api');


// cors-json@*
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

    return json_($response, [
        "message"     => "welcome",
        "version"     => "1.0.0",
        "admin.email" => "admin@nikolav.rs",
        "time"        => date(DATE_RFC2822),
    ]);
});

$app->get("/data", function ($req, $res, $args) {

    $fluent = new \Envms\FluentPDO\Query(
        new PDO(
            DATABASEMYSQLPDODSN_DB,
            DATABASEMYSQLPDODSN_USER,
            DATABASEMYSQLPDODSN_PASSWORD
        )
    );

    $data   = $fluent->from("main")->fetchAll();

    return json_($res, ["payload" => $data]);
});

$app->post("/data", function ($req, $res, $args) {

    $input = $req->getParsedBody();
    $data  = [
        "id"     => null,
        "status" => null,
    ];

    if (
        !empty($input["name"])
        && !empty($input["value"])
        && !empty($input["validation"])
        && (VALIDATION_ === $input["validation"])
    ) {

        try {

            $fluent = new \Envms\FluentPDO\Query(
                new PDO(
                    DATABASEMYSQLPDODSN_DB,
                    DATABASEMYSQLPDODSN_USER,
                    DATABASEMYSQLPDODSN_PASSWORD
                )
            );

            $query  = $fluent->insertInto("main", [
                "name"  => $input["name"],
                "value" => $input["value"],
            ]);

            $data["id"]     = $query->execute();
            $data["status"] = 0;

            $fluent->close();
        } catch (Exception $err) {
            $data["status"] = $err->getMessage();
        }
    } else {
        $data["status"] = -1;
    }

    return json_($res, $data);
});

$app->get("/admin", function ($req, $res, $args) {
    return json_($res, [
        "name"  => "nikolav",
        "email" => "admin@nikolav.rs",
        "url"   => "https://nikolav.rs/",
    ]);
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


//
function json_($response, $body)
{
    $response->getBody()
        ->write(json_encode($body));

    return $response;
}
