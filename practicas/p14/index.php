<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();

// Ajusta esta ruta si el nombre de tus carpetas es diferente
$app->setBasePath('/TecWeb/practicas/p14');
$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Hola Mundo Slim!");
    return $response;
});

// Ruta que recibe un nombre por la URL (ej: localhost/p14/saludo/Juan)
$app->get('/saludo/{nombre}', function (Request $request, Response $response, $args) {
    $nombre = $args['nombre'];
    $response->getBody()->write("Hola, " . $nombre);
    return $response;
});

$app->post('/probarpost', function ($request, $response, $args) {

    $reqPost = $request->getParsedBody();
    $nombre = $reqPost['nombre'] ?? null;
    $edad = $reqPost['edad'] ?? null;

    // Armamos un arreglo con los datos a regresar
    $respuesta = [
        'status' => 'ok',
        'mensaje' => 'Datos recibidos correctamente',
        'datos' => [
            'nombre' => $nombre,
            'edad' => $edad
        ]
    ];

    // Convertimos el array a JSON
    $payload = json_encode($respuesta, JSON_PRETTY_PRINT);

    // Escribimos el JSON en el cuerpo de la respuesta
    $response->getBody()->write($payload);

    // Indicamos que la salida es JSON
    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/testjson', function ($request, $response, $args) {

    $data = [
        [
            "nombre"   => "Rubi",
            "apellido" => "Aparicio"
        ],
        [
            "nombre"   => "Eduardo",
            "apellido" => "Carmona"
        ]
    ];

    // Convertimos a JSON
    $payload = json_encode($data, JSON_PRETTY_PRINT);

    // Escribimos el JSON en la respuesta
    $response->getBody()->write($payload);

    // Indicamos que es JSON
    return $response->withHeader('Content-Type', 'application/json');
});


$app->run();
?>