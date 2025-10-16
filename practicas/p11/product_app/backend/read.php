<?php
    include_once __DIR__.'/database.php';

    // SE CREA EL ARREGLO QUE SE VA A DEVOLVER EN FORMA DE JSON
    $data = array();
    // SE VERIFICA HABER RECIBIDO EL TÉRMINO DE BÚSQUEDA 'busqueda'
    if( isset($_POST['busqueda']) ) {
        $busqueda = $_POST['busqueda'];

        $sql = "SELECT * FROM productos WHERE eliminado = 0 AND (
                    id LIKE '%{$busqueda}%' OR 
                    nombre LIKE '%{$busqueda}%' OR 
                    marca LIKE '%{$busqueda}%' OR 
                    detalles LIKE '%{$busqueda}%'
                )";
        
        // SE REALIZA LA QUERY DE BÚSQUEDA
        if ( $result = $conexion->query($sql) ) {
            // SE OBTIENEN TODOS LOS RESULTADOS COMO UN ARRAY
            while ($row = $result->fetch_assoc()) {
                // SE CODIFICAN A UTF-8 LOS DATOS Y SE MAPEAN AL ARREGLO DE RESPUESTA
                $producto = array();
                foreach($row as $key => $value) {
                    $producto[$key] = utf8_encode($value);
                }
                $data[] = $producto;
            }
			$result->free();
		} else {
            // En caso de error de sintaxis en la consulta
            $data['error'] = 'Query Error: '.mysqli_error($conexion);
        }
		$conexion->close();
    }
    
    // SE HACE LA CONVERSIÓN DE ARRAY A JSON (siempre devuelve un array)
    echo json_encode($data, JSON_PRETTY_PRINT);
?>