<?php
// 1. Uso del namespace y la inclusión de la clase
namespace MyBackEnd;
require_once 'myapi/Products.php';

// 2. Creación del objeto (usa el nombre de tu BD)
$products = new \MyApi\Products('marketzone'); 

// 3. Invoca el método correcto (list())
$products->list();

// 4. Echo de la respuesta JSON
echo $products->getData();
?>