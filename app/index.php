<?php
error_reporting(-1);
ini_set('display_errors', 1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/db/consultas.php';
require __DIR__ . '/Controlador/UsuarioControlador.php';
require __DIR__ . '/Entidades/Usuario.php';
require __DIR__ . '/Entidades/Suscripcion.php';
require __DIR__ . '/Controlador/SuscripcionControlador.php';
require __DIR__ . '/Entidades/Game.php';
require __DIR__ . '/Controlador/GameControlador.php';
require __DIR__ . '/Entidades/Puntaje.php';
require __DIR__ . '/Controlador/PuntajeControlador.php';

$app = AppFactory::create();

$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorHandler = $errorMiddleware->getDefaultErrorHandler();
$errorHandler->forceContentType('application/json');

//Middleware <<CORS - Por defecto de Slim>>
$app->add(function (Request $request, RequestHandlerInterface $handler): Response {
    $response = $handler->handle($request);
    $requestHeaders = $request->getHeaderLine('Access-Control-Request-Headers');
    $response = $response->withHeader('Access-Control-Allow-Origin', '*');
    $response = $response->withHeader('Access-Control-Allow-Methods', 'get,post,PUT,DELETE,options');
    $response = $response->withHeader('Access-Control-Allow-Headers', $requestHeaders);
    return $response;
});

$app->group('/usuarios', function (RouteCollectorProxy $group) {
    $group->post('/crear', \UsuarioControlador::class . ':retornarEstadoCreado');
    $group->get('/verTodos', \UsuarioControlador::class . ':retonarListaUsuarios');
    $group->post('/traerLogueado', \UsuarioControlador::class . ':retonarUsuarioLogueado');
    $group->put('/actualizarPass', \UsuarioControlador::class . ':retornarActualizacionPass');
    $group->delete('/eliminar', \UsuarioControlador::class . ':retornarEstadoEliminado');
    $group->post('/perfilUsuario', \UsuarioControlador::class . ':retonarUsuarioPerfil');
});

$app->group('/games', function (RouteCollectorProxy $group) {
    $group->post('/crear', \GameControlador::class . ':retornarEstadoCreado');
    $group->get('/verTodos', \GameControlador::class . ':retonarListaGames');
});

$app->group('/suscripcion', function (RouteCollectorProxy $group) {
    $group->post('/crear', \SuscripcionControlador::class . ':retornarEstadoCreada');
    $group->get('/verTodas', \SuscripcionControlador::class . ':retonarListaSuscripciones');
    $group->get('/buscarSuscripcionUsuario', \SuscripcionControlador::class . ':retonarSuscripcionUsuario');
    $group->delete('/eliminarSuscripcion', \SuscripcionControlador::class . ':retornarEliminarSuscripcion');
    $group->put('/actualizarSuscripcion', \SuscripcionControlador::class . ':retornarActualizarSuscripcion');
});

$app->group('/puntaje', function (RouteCollectorProxy $group) {
    $group->post('/crear', \PuntajeControlador::class . ':retornarEstadoCreado');
    $group->get('/verTodos', \PuntajeControlador::class . ':retonarListaPuntajes');
    $group->post('/BuscarPuntuajeUsuario', \PuntajeControlador::class . ':retonarPuntajesUsuario');
    $group->put('/actualizarPuntajes', \PuntajeControlador::class . ':retornarActualizacionPuntajes');
});

$app->run();
