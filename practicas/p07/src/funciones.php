<?php
    function ejercicio1 ($num) {
        //if(isset($_GET['numero']))
        //$num = $_GET['num'];
        if ($num%5==0 && $num%7==0)
        {
            echo '<h3>R= El número '.$num.' SÍ es múltiplo de 5 y 7.</h3>';
        }
        else
        {
            echo '<h3>R= El número '.$num.' NO es múltiplo de 5 y 7.</h3>';
        }
    }

    function ejercicio2 () {
        $matriz = [];
        $iteraciones = 0;

        do {
            $num1 = rand(1, 1000);
            $num2 = rand(1, 1000);
            $num3 = rand(1, 1000);
            $iteraciones++;
            
            $matriz = [$num1, $num2, $num3];
        } while (!(($num1 % 2 != 0) && ($num2 % 2 == 0) && ($num3 % 2 != 0)));

        foreach ($matriz as $num) {
            echo "$num ";
        }

        $totalNumeros = $iteraciones * 3;
        echo "<br>$totalNumeros números obtenidos en $iteraciones iteraciones.";
    }

    function ejercicio3While ($multiplo) {
        $numero = rand(1, 100);
        while ($numero % $multiplo != 0) {
            $numero = rand(1, 100);
        }
        echo "El número $numero es múltiplo de: $multiplo";
    }

    function ejercicio3DoWhile ($multiplo) {
        do {
            $numero = rand(1, 100);
        } while ($numero % $multiplo != 0);
        echo "El número $numero es múltiplo de: $multiplo";
    }

    function ejercicio4 () {
        $array = [];
        for ($i=97;$i<=122;$i++) {
            $array[$i] = chr($i);
        }
        foreach ($array as $key => $value) {
            echo "[$key] => $value<br>";
        }
    }

    function ejercicio5 ($edad, $sexo) {
        if (($sexo == "Femenino") && ($edad >= 18) && ($edad <= 35)) {
            echo "<p>Bienvenida, usted está en el rango de edad permitido.</p>";
        } else {
            echo "<p>Lo sentimos, no cumple con los criterios.</p>";
        }
    }
?>