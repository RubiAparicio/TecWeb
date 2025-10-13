<?php
$link = mysqli_connect("localhost", "root", "aarr2004", "marketzone");

if ($link === false) {
    die("ERROR: No se pudo conectar a la BD. " . mysqli_connect_error());
}

$id       = $_POST['id'];
$nombre   = $_POST['nombre_producto'];
$marca    = $_POST['marca_producto'];
$modelo   = $_POST['modelo_producto'];
$precio   = $_POST['precio_producto'];
$unidades = $_POST['unidades_producto'];
$detalles = $_POST['detalles_producto'];
$imagen   = $_POST['imagen_producto'];

$sql = "UPDATE productos SET 
            nombre='$nombre',
            marca='$marca',
            modelo='$modelo',
            precio=$precio,
            unidades=$unidades,
            detalles='$detalles',
            imagen='$imagen'
        WHERE id=$id";

if (mysqli_query($link, $sql)) {
    echo "Producto actualizado correctamente.";
} else {
    echo "ERROR: No se pudo ejecutar $sql. " . mysqli_error($link);
}

mysqli_close($link);
?>