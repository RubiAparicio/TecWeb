<?php
// 1. Uso del namespace y la inclusión de la clase
namespace MyBackEnd;
require_once 'myapi/Products.php';

// 2. Creación del objeto
$products = new \MyApi\Products('marketzone'); 

if( isset($_POST['id']) ) {
    // Obtener y transformar el POST a un objeto
    $jsonOBJ = json_decode( json_encode($_POST) );
    
    // 3. Invoca el método correcto (edit($object))
    $products->edit($jsonOBJ);
} else {
    $products->data = ['status' => 'error', 'message' => 'No se recibió el ID para editar'];
}

// 4. Echo de la respuesta JSON
echo $products->getData();
?>