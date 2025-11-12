<?php
// 1. Uso del namespace y la inclusión de la clase
namespace MyBackEnd;
require_once 'myapi/Products.php';

// 2. Creación del objeto
$products = new \MyApi\Products('marketzone'); 

if( isset($_GET['search']) ) {
    $search = $_GET['search'];
    // 3. Invoca el método correcto (search($query))
    $products->search($search);
} else {
    // Si no hay parámetro de búsqueda, devuelve un array vacío
    $products->data = []; 
}

// 4. Echo de la respuesta JSON
echo $products->getData();
?>