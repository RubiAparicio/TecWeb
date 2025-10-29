<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>01-Definición</title>
</head>
<body>
    <?php
    require_once __DIR__.'/Persona.php';

    $per1 = new Persona;
    $per1->inicializar('Zacarias');
    $per1->mostrar();

    $per2 = new Persona;
    $per2->inicializar('Ibur');
    $per2->mostrar();

    $per3 = new Persona;
    $per3->inicializar('Carmona Torres gemelas blancas');
    $per3->mostrar();
    ?>
</body>
</html>