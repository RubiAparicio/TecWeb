
function getDatos()
{
    var nombre = prompt("Nombre: ", "");

    var edad = prompt("Edad: ", 0);

    var div1 = document.getElementById('nombre');
    div1.innerHTML = '<h3> Nombre: '+nombre+'</h3>';

    var div2 = document.getElementById('edad');
    div2.innerHTML = '<h3> Edad: '+edad+'</h3>';
}

function ejemplo1() {
    document.getElementById("resultado1").innerHTML = "Hola Mundo";
}

function ejemplo2() {
    var nombre = 'Rubi';
    var edad = 21;
    var altura = 1.50;
    var casado = false;

    document.getElementById("resultado2").innerHTML = nombre + "<br>" + edad + "<br>" + altura + "<br>" + casado;
}

function ejemplo3() {
    var nombre = prompt("Nombre: ", "");
    var edad = prompt("Edad: ", "");
    document.getElementById("resultado3").innerHTML = "Hola " + nombre + " así que tienes " + edad + " años";
}
