<?php
// 1. Uso del namespace y la inclusión de la clase
namespace MyBackEnd;
require_once 'myapi/Products.php';

// 2. Creación del objeto
$products = new \MyApi\Products('marketzone'); 

if (isset($_POST['nombre'])) {
    $nombre = $_POST['nombre'];
    // Si estamos editando, recibimos un ID. Si no, es 0.
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    
    // 3. Invoca el método correcto (singleByName($name, $id))
    // La lógica de verificación (si existe o no) está dentro del método de la clase.
    $products->singleByName($nombre, $id);
} else {
    $products->data = [
        'status' => 'error',
        'existe' => false,
        'message' => 'No se proporcionó un nombre'
    ];
}

// 4. Echo de la respuesta JSON
echo $products->getData();
?>