<?php
// 1. Uso del namespace y la inclusión de la clase
namespace MyBackEnd;
require_once 'myapi/Products.php';

// 2. Creación del objeto
$products = new \MyApi\Products('marketzone'); 

if( isset($_POST['id']) ) {
    $id = $_POST['id'];
    // 3. Invoca el método correcto (single($id))
    $products->single($id);
} else {
    // Si no hay ID, asigna un array vacío para getData()
    $products->data = []; 
}

// 4. Echo de la respuesta JSON
echo $products->getData();
?>