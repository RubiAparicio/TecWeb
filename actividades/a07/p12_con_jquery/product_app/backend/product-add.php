<?php
// 1. Uso del namespace y la inclusión de la clase
namespace MyBackEnd;
require_once 'myapi/Products.php';

// 2. Creación del objeto
$products = new \MyApi\Products('marketzone'); 

if(isset($_POST['nombre'])) {
    // Obtener y transformar el POST a un objeto, como en tu código original
    $jsonOBJ = json_decode( json_encode($_POST) );
    
    // 3. Invoca el método correcto (add($object))
    $products->add($jsonOBJ);
} else {
    // Mensaje por si falla la entrada
    $products->data = ['status' => 'error', 'message' => 'No se recibió la información completa para agregar'];
}

// 4. Echo de la respuesta JSON
echo $products->getData();
?>