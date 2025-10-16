<?php
    $conexion = @mysqli_connect(
        'localhost',
        'root',
        'aarr2004',
        'marketzone'
    );
    
    if(!$conexion) {
        die('¡Base de datos NO conectada!');
    }
?>
