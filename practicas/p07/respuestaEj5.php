<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Respuesta Ejercicio 5</title>
</head>
<body>
    <h2>Resultado Ejercicio 5</h2>
    <?php
        include_once("src/funciones.php");
        if (isset($_POST['edad']) && isset($_POST['sexo'])) {
            $edad = (int)$_POST['edad'];
            $sexo = $_POST['sexo'];
            ejercicio5($edad, $sexo);
        }
    ?>
</body>