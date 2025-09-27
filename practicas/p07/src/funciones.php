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

    function autos () {
        $autos = array(
            "UBN6338" => array( //Primer auto
                "Auto" => array(
                    "marca" => "HONDA",
                    "modelo" => 2020,
                    "tipo" => "camioneta"
                ),
                    "Propietario" => array(
                    "nombre" => "Alfonzo Esparza",
                    "ciudad" => "Puebla, Pue.",
                    "direccion" => "C.U., Jardines de San Manuel"
                )
            ),
            "UBN6339" => array( //Segundo auto
                "Auto" => array(
                    "marca" => "MAZDA",
                    "modelo" => 2019,
                    "tipo" => "sedan"
                ),
                    "Propietario" => array(
                    "nombre" => "Ma. del Consuelo Molina",
                    "ciudad" => "Puebla, Pue.",
                    "direccion" => "97 Oriente"
                )
            ),
            "RAR2004" => array( //Tercer auto
                "Auto" => array(
                    "marca" => "MERCEDES",
                    "modelo" => 2021,
                    "tipo" => "sedan"
                ),
                    "Propietario" => array(
                    "nombre" => "Rubi Aparicio",
                    "ciudad" => "Oaxaca, Oax.",
                    "direccion" => "Privada 63 F Ote. 1207"
                )
            ),
            "RSR2527" => array( //Cuarto auto
                "Auto" => array(
                    "marca" => "AUDI",
                    "modelo" => 2022,
                    "tipo" => "hatchback"
                ),
                    "Propietario" => array(
                    "nombre" => "Ricardo Santos",
                    "ciudad" => "Oaxaca, Oax.",
                    "direccion" => "Villas Orion 2"
                )
            ),
            "AXY3953" => array( //Quinto auto
                "Auto" => array(
                    "marca" => "CHEVROLET",
                    "modelo" => 2015,
                    "tipo" => "camioneta"
                ),
                    "Propietario" => array(
                    "nombre" => "Luis Alfonso",
                    "ciudad" => "Orizaba, Ver.",
                    "direccion" => "Col. Alta Vista de Juárez"
                )
            ),
            "FGT5839" => array( //Sexto auto
                "Auto" => array(
                    "marca" => "KIA",
                    "modelo" => 2020,
                    "tipo" => "sedan"
                ),
                    "Propietario" => array(
                    "nombre" => "Alejandro Montes",
                    "ciudad" => "Monterrey, NL.",
                    "direccion" => "Buena Vista 1"
                )
            ),
            "TJW3852" => array( //Septimo auto
                "Auto" => array(
                    "marca" => "BMW",
                    "modelo" => 2018,
                    "tipo" => "hatchback"
                ),
                    "Propietario" => array(
                    "nombre" => "Ana Ramirez",
                    "ciudad" => "Acatlán, Pue.",
                    "direccion" => "23 Sur"
                )
            ),
            "DHI4501" => array( //Octavo auto
                "Auto" => array(
                    "marca" => "NISSAN",
                    "modelo" => 2021,
                    "tipo" => "hatchback"
                ),
                    "Propietario" => array(
                    "nombre" => "Carlos Hernández",
                    "ciudad" => "CDMX",
                    "direccion" => "Col. Roma"
                )
            ),
            "MVN9670" => array( //Noveno auto
                "Auto" => array(
                    "marca" => "TOYOTA",
                    "modelo" => 2018,
                    "tipo" => "sedan"
                ),
                    "Propietario" => array(
                    "nombre" => "Laura Gómez",
                    "ciudad" => "Guadalajara, Jal.",
                    "direccion" => "Av. Patria 123"
                )
            ),
            "SDL6850" => array( //Decimo auto
                "Auto" => array(
                    "marca" => "FORD",
                    "modelo" => 2022,
                    "tipo" => "camioneta"
                ),
                    "Propietario" => array(
                    "nombre" => "Miguel Torres",
                    "ciudad" => "Monterrey, NL.",
                    "direccion" => "San Pedro 45"
                )
            ),
            "LMR6854" => array( //Onceavo auto
                "Auto" => array(
                    "marca" => "VOLKSWAGEN",
                    "modelo" => 2021,
                    "tipo" => "camioneta"
                ),
                    "Propietario" => array(
                    "nombre" => "Sofia Martínez",
                    "ciudad" => "Toluca, Méx.",
                    "direccion" => "Col. Centro"
                )
            ),
            "STC6978" => array( //Doceavo carro
                "Auto" => array(
                    "marca" => "TESLA",
                    "modelo" => 2023,
                    "tipo" => "sedan"
                ),
                    "Propietario" => array(
                    "nombre" => "Claudia Méndez",
                    "ciudad" => "CDMX",
                    "direccion" => "Santa Fe"
                )
            ),
            "RTO6849" => array( //Treceavo carro
                "Auto" => array(
                    "marca" => "HYUNDAI",
                    "modelo" => 2020,
                    "tipo" => "hatchback"
                ),
                    "Propietario" => array(
                    "nombre" => "Jorge Navarro",
                    "ciudad" => "Puebla, Pue.",
                    "direccion" => "Lomas de Angelópolis"
                )
            ),
            "GTI5930" => array( //Catorceavo carro
                "Auto" => array(
                    "marca" => "SUBARU",
                    "modelo" => 2021,
                    "tipo" => "sedan"
                ),
                    "Propietario" => array(
                    "nombre" => "Ricardo Sánchez",
                    "ciudad" => "Oaxaca, Oax.",
                    "direccion" => "Col. Reforma"
                )
            ),
            "KRR7986" => array( //Quinceavo carro
                "Auto" => array(
                    "marca" => "KIA",
                    "modelo" => 2019,
                    "tipo" => "sedan"
                ),
                    "Propietario" => array(
                    "nombre" => "David López",
                    "ciudad" => "Querétaro, Qro.",
                    "direccion" => "Av. Constituyentes"
                )
            ),
        );
        return $autos;
    }

    function buscarMatricula ($matricula) {
        $autos = autos();
        if (isset($autos[$matricula])) {
            echo "<pre>";
            echo "[$matricula] => <br>";
            foreach ($autos[$matricula] as $key => $value) {
                echo "  [$key] => <br>";
                foreach ($value as $key2 => $value2) {
                    echo "    [$key2] => $value2<br>"; 
                }  
            }
            echo "</pre>";
        } else {
            echo "<p>No se encontró un auto con la matrícula $matricula.</p>";
        }
    }

    function mostrarTodos (){
        $autos = autos();
        echo "<pre>";
        foreach ($autos as $key => $value) {
            echo "[$key] => <br>";
            foreach ($value as $key2 => $value2) {
                echo "  [$key2] => <br>";
                foreach ($value2 as $key3 => $value3) {
                echo "    [$key3] => $value3<br>";
                }  
            }  
        }
        echo "</pre>";
    }
?>