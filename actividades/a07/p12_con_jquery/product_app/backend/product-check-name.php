<?php
    include_once __DIR__.'/database.php';

    // Arreglo de respuesta por defecto
    $data = array(
        'status'  => 'error',
        'existe' => false,
        'message' => 'No se proporcionó un nombre'
    );

    if (isset($_POST['nombre'])) {
        // Usar real_escape_string es una buena práctica de seguridad
        $nombre = $conexion->real_escape_string($_POST['nombre']);
        
        // Si estamos editando, recibimos un ID. Si no, es 0.
        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

        // La consulta busca un nombre que coincida Y que NO sea el del ID actual
        $sql = "SELECT * FROM productos WHERE nombre = '{$nombre}' AND eliminado = 0 AND id != {$id}";
        
        if ($result = $conexion->query($sql)) {
            if ($result->num_rows > 0) {
                // El nombre YA existe en otro producto
                $data['existe'] = true; 
            } else {
                // El nombre está disponible
                $data['existe'] = false; 
            }
            $data['status'] = 'success';
            $data['message'] = 'Verificación completa';
            $result->free();
        } else {
            $data['message'] = 'Error en la consulta: ' . $conexion->error;
        }
        
        $conexion->close();
    }
    
    // Devolvemos un JSON con la respuesta
    echo json_encode($data, JSON_PRETTY_PRINT);
?>