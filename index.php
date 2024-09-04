<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

use Slim\Routing\RouteContext;
use Slim\Exception\HttpNotFoundException;

require __DIR__ . '\vendor\autoload.php';

$app = AppFactory::create();

$app->add(function (Request $request, Response $response, callable $next) {
    $routeContext = RouteContext::fromRequest($request);
    $route = $routeContext->getRoute();

    // Se a rota não foi encontrada, lança uma exceção 404
    if (null === $route) {
        throw new HttpNotFoundException($request);
    }

    return $next($request, $response);
});

$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Hello world!");
    return $response;
});

$app->run();