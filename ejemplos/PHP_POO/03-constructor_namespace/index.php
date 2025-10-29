<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>03-Constructor y Namespace</title>
</head>
<body>
    <?php
    use EJEMPLOS\POO\Cabecera2 as Cabecera;
    require_once __DIR__.'/Cabecera.php';

    //$cab1 = new Cabecera('El rincón del Programador', 'center');
    //$cab1->graficar();

    $cab2 = new Cabecera('El rincón del Programador', 'center', 'https://www.cs.buap.mx');
    $cab2->graficar();
    ?>
</body>
</html>