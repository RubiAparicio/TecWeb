<?php
    include_once __DIR__.'/database.php';

    // SE OBTIENE LA INFORMACIÓN DEL PRODUCTO ENVIADA POR EL CLIENTE
    $producto = file_get_contents('php://input');

    if(!empty($producto)) {
        // SE TRANSFORMA EL STRING DEL JSON A OBJETO
        $jsonOBJ = json_decode($producto);

        if (!isset($jsonOBJ->nombre) || !isset($jsonOBJ->precio) || !isset($jsonOBJ->marca) || !isset($jsonOBJ->modelo)) {
            echo "Error: Faltan datos obligatorios en el JSON.";
            exit;
        }

        $nombre   = mysqli_real_escape_string($conexion, $jsonOBJ->nombre);
        $precio   = mysqli_real_escape_string($conexion, $jsonOBJ->precio);
        $unidades = mysqli_real_escape_string($conexion, $jsonOBJ->unidades);
        $modelo   = mysqli_real_escape_string($conexion, $jsonOBJ->modelo);
        $marca    = mysqli_real_escape_string($conexion, $jsonOBJ->marca);
        $detalles = mysqli_real_escape_string($conexion, $jsonOBJ->detalles);
        $imagen   = mysqli_real_escape_string($conexion, $jsonOBJ->imagen);

        $query_check = "SELECT COUNT(*) as total FROM productos WHERE nombre='$nombre' AND eliminado=0";
        $result = mysqli_query($conexion, $query_check);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            if ($row['total'] > 0) {
                echo "Error: Ya existe un producto con ese nombre.";
                exit;
            }
        } else {
            echo "Error en la verificación: " . mysqli_error($conexion);
            exit;
        }

        $query_insert = "
            INSERT INTO productos (nombre, precio, unidades, modelo, marca, detalles, imagen, eliminado)
            VALUES ('$nombre', '$precio', '$unidades', '$modelo', '$marca', '$detalles', '$imagen', 0)
        ";

        if (mysqli_query($conexion, $query_insert)) {
            echo "Éxito: Producto insertado correctamente.";
        } else {
            echo "Error al insertar el producto: " . mysqli_error($conexion);
        }

    } else {
        echo "Error: No se recibió ningún dato JSON.";
    }
?>
