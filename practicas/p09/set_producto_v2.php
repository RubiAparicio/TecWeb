<?php
    $nombre = $_POST['nombre_producto'];
    $marca  = $_POST['marca_producto'];
    $modelo = $_POST['modelo_producto'];
    $precio = floatval($_POST['precio_producto']);
    $detalles = $_POST['detalles_producto'];
    $unidades = intval($_POST['unidades_producto']);
    
    // Subir imagen
    $directorio = "img/";
    if (!is_dir($directorio)) {
        mkdir($directorio, 0777, true);
    }

    $nombreArchivo = basename($_FILES["imagen_producto"]["name"]);
    $rutaDestino = $directorio . $nombreArchivo;

    $ext_permitidas = ['jpg', 'jpeg', 'png', 'gif'];
    $ext = strtolower(pathinfo($rutaDestino, PATHINFO_EXTENSION));

    if (!in_array($ext, $ext_permitidas)) {
        die('<h3>Formato de imagen no permitido. Solo JPG, PNG o GIF.</h3>');
    }

    if (move_uploaded_file($_FILES["imagen_producto"]["tmp_name"], $rutaDestino)) {
        $imagen = $rutaDestino;
    } else {
        die('<h3>Error al subir la imagen.</h3>');
    }

    /** SE CREA EL OBJETO DE CONEXION */
    @$link = new mysqli('localhost', 'root', 'aarr2004', 'marketzone');	

    /** comprobar la conexión */
    if ($link->connect_errno) 
    {
        die('Falló la conexión: '.$link->connect_error.'<br/>');
        /** NOTA: con @ se suprime el Warning para gestionar el error por medio de código */
    }

    $sql_check = "SELECT * FROM productos WHERE nombre = '{$nombre}' AND marca = '{$marca}' AND modelo = '{$modelo}'";
    $result = $link->query($sql_check);

    if ($result && $result->num_rows > 0)
    {
        echo 'Error: El producto ya existe en la base de datos.<br/>';
    }
    else
    {
        //$sql = "INSERT INTO productos (id, nombre, marca, modelo, precio, detalles, unidades, imagen, eliminado)
        //        VALUES (null, '{$nombre}', '{$marca}', '{$modelo}', {$precio}, '{$detalles}', {$unidades}, '{$imagen}', 0)";
        
        $sql = "INSERT INTO productos (nombre, marca, modelo, precio, detalles, unidades, imagen)
                VALUES ('{$nombre}', '{$marca}', '{$modelo}', {$precio}, '{$detalles}', {$unidades}, '{$imagen}')";
        
        if ( $link->query($sql) ) 
        {
            echo 'Producto insertado con ID: '.$link->insert_id;
        }
        else
        {
            echo 'El Producto no pudo ser insertado =(';
        }
    }

    $link->close();
?>