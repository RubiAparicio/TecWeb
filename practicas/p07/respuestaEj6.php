<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Respuesta Ejercicio 6</title>
</head>
<body>
    <h2>Resultado Ejercicio 6</h2>
    <?php
        include_once("src/funciones.php");
        if (isset($_POST['buscar']) && !empty($_POST['matricula'])) {
            $matricula = $_POST['matricula'];
            buscarMatricula($matricula);
        } elseif (isset($_POST['todos'])) {
            mostrarTodos();
        } else {
            echo "<p>No se recibieron datos válidos.</p>";
        }
    ?>
</body>