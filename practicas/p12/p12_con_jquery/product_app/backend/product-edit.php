<?php
include('database.php'); 
include('product-validation.php'); 

$inputJSON = file_get_contents('php://input');
$producto = json_decode($inputJSON, true);

$id = $producto['id'] ?? null;
if (empty($id)) {
    echo json_encode(["status" => "validation_error", "message" => "Error de edición: ID de producto no recibido."]);
    exit;
}

$errors = validateProductData($producto);

if (!empty($errors)) {
    echo json_encode([
        "status" => "validation_error",
        "message" => "Errores de validación encontrados.",
        "details" => $errors
    ]);
    exit;
}

$nombre = $producto['nombre'] ?? '';
$marca = $producto['marca'] ?? '';
$modelo = $producto['modelo'] ?? '';
$precio = $producto['precio'] ?? 0.0;
$unidades = $producto['unidades'] ?? 0;
$detalles = $producto['detalles'] ?? '';
$imagen = $producto['imagen'] ?? ''; 

$DEFAULT_IMAGE = 'img/default.png';

if (empty($imagen)) {
    $imagen = $DEFAULT_IMAGE;
}

$id_sql = mysqli_real_escape_string($conexion, $id);
$nombre_sql = mysqli_real_escape_string($conexion, $nombre);
$marca_sql = mysqli_real_escape_string($conexion, $marca);
$modelo_sql = mysqli_real_escape_string($conexion, $modelo);
$detalles_sql = mysqli_real_escape_string($conexion, $detalles);
$imagen_sql = mysqli_real_escape_string($conexion, $imagen);
$precio_float = floatval($precio);
$unidades_int = intval($unidades);

$query = "UPDATE productos SET
            nombre = '$nombre_sql',
            marca = '$marca_sql',
            modelo = '$modelo_sql',
            precio = $precio_float,
            unidades = $unidades_int,
            detalles = '$detalles_sql',
            imagen = '$imagen_sql'
          WHERE id = '$id_sql'";

$result = mysqli_query($conexion, $query);

if ($result) {
    if (mysqli_affected_rows($conexion) > 0) {
        echo json_encode(["status" => "success", "message" => "Producto actualizado correctamente."]);
    } else {
        echo json_encode(["status" => "info", "message" => "Error no se realizaron cambios."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Error al actualizar en BD " . mysqli_error($conexion)]);
}

mysqli_close($conexion);
?>