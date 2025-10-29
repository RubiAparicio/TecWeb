<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>05-Colaboración de clases</title>
</head>
<body>
    <?php
    require_once __DIR__.'/Pagina.php';

    $par1 = new Pagina('El ático del Programador', 'El sótano del Programador');
    for($i=0;$i<15;$i++) {
        $par1->insertar_cuerpo('Línea No. '.($i+1).' en el cuerpo de la página');
    }

    $par1->graficar();
    ?>
</body>
</html>