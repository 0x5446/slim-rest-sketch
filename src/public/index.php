<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require __DIR__ . '/../../vendor/autoload.php';

$containers['settings'] = include __DIR__ . '/../Conf/_settings.php';
$containers['config'] = function($c) {
    return new \App\Conf\Config();
};
$containers['cookies'] = function($c) {
    $request = $c->get('request');
    return new \Slim\Http\Cookies($request->getCookieParams());
};

$app = new \Slim\App($containers);

$app->map(['GET', 'POST', 'PUT', 'DELETE'], '[/{controller:.*}]', function($request, $response, $attrs) {
    try {
        $controller = empty($attrs['controller']) ? 'Index' : join('\\', array_map('ucfirst', explode('/', $attrs['controller'])));
        $controller = '\\App\\Controller\\' . $controller;
        $obj = new $controller($request, $response);
        $body = call_user_func_array([$obj, strtolower($request->getMethod())], []);
        return $response->withAddedHeader('Code', 0)->withAddedHeader('Msg', '')->withJson($body);
    } catch (Exception $e) {
        return $response->withAddedHeader('Code', $e->getCode())->withAddedHeader('Msg', $e->getMessage())->withJson(null);
    }
});

$app->run();
