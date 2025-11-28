<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();

$app->setBasePath('/TecWeb/practicas/p14');
$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Hola Mundo Slim!");
    return $response;
});

$app->get('/saludo/{nombre}', function (Request $request, Response $response, $args) {
    $nombre = $args['nombre'];
    $response->getBody()->write("Hola, " . $nombre);
    return $response;
});

$app->post('/probarpost', function (Request $request, Response $response, $args) {

    // Obtenemos los datos enviados por POST (Postman)
    $reqPost = $request->getParsedBody();

    // Procesamos los datos (pero NO devolvemos JSON aquí)
    $mensaje = "Datos recibidos: " . print_r($reqPost, true);

    $response->getBody()->write($mensaje);
    return $response;
});

$app->post('/testjson', function (Request $request, Response $response, $args) {

    // Obtenemos los datos enviados por POST
    $reqPost = $request->getParsedBody();

    // Armamos la respuesta en JSON
    $respuesta = [
        'status' => 'exito',
        'mensaje' => 'JSON generado correctamente',
        'recibido' => $reqPost
    ];

    // Convertimos a JSON
    $payload = json_encode($respuesta);

    // Escribimos la salida en JSON
    $response->getBody()->write($payload);

    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();
?>