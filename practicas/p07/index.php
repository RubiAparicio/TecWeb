<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 7</title>
</head>
<body>
    <h2>Ejercicio 1</h2>
    <p>Escribir programa para comprobar si un número es un múltiplo de 5 y 7</p>
    <?php
        include_once("src/funciones.php");
        if (isset($_GET['num'])) {
            ejercicio1($_GET['num']);
        }
    ?>

    <h2>Ejemplo de POST</h2>
    <form action="http://localhost/TecWeb/practicas/p07/index.php" method="post">
        Name: <input type="text" name="name"><br>
        E-mail: <input type="text" name="email"><br>
        <input type="submit">
    </form>
    <br>
    <?php
        if(isset($_POST["name"]) && isset($_POST["email"]))
        {
            echo $_POST["name"];
            echo '<br>';
            echo $_POST["email"];
        }
    ?>

    <h2>Ejercicio 2</h2>
    <p>Crea un programa para la generación repetitiva de 3 números aleatorios hasta obtener una
    secuencia compuesta por: impar, par, impar.</p>
    <?php
        ejercicio2();
    ?>

    <h2>Ejercicio 3</h2>
    <p>Utiliza un ciclo while para encontrar el primer número entero obtenido aleatoriamente,
    pero que además sea múltiplo de un número dado.</p>
    <?php
        echo "Utilizando While <br>";
        if (isset($_GET['multiplo'])) {
            ejercicio3While($_GET['multiplo']);
        }
        echo "<br><br>Utilizando Do-While<br>";
        if (isset($_GET['multiplo'])) {
            ejercicio3DoWhile($_GET['multiplo']);
        }
    ?>

    <h2>Ejercicio 4</h2>
    <p>Crear un arreglo cuyos índices van de 97 a 122 y cuyos valores son las letras de la ‘a’
    a la ‘z’. Usa la función chr(n) que devuelve el caracter cuyo código ASCII es n para poner
    el valor en cada índice.</p>
    <?php
        ejercicio4();
    ?>

    <h2>Ejercicio 5</h2>
    <p>Usar las variables $edad y $sexo en una instrucción if para identificar una persona de
    sexo “femenino”, cuya edad oscile entre los 18 y 35 años y mostrar un mensaje de
    bienvenida apropiado.</p>
    <form action = "respuestaEj5.php" method = "post">
        <fieldset>
            <legend><p>Formulario</p></legend>
            Edad: <input type="number" name="edad"><br>
            Sexo: <input type="radio" name="sexo" value="Femenino"> Femenino
            <input type="radio" name="sexo" value="Masculino"> Masculino
            <p><input type="submit" value="Enviar">
            <input type="reset" value="Restablecer"></p>
        </fieldset>
    </form>

    <h2>Ejercicio 6</h2>
    <p>Crea en código duro un arreglo asociativo que sirva para registrar el parque vehicular de
    una ciudad.</p>
    <form action = "respuestaEj6.php" method = "post">
        <fieldset>
            <legend><p>Formulario del Carro</p></legend>
            Matrícula de Auto: <input type="text" name="matricula"><br>
            <p><input type="submit" name = "buscar" value="Buscar">
            <input type="reset" value="Restablecer">
            <input type="submit" name = "todos" value="Mostrar Todos"></p>
        </fieldset>
    </form>
</body>
</html>