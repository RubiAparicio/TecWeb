
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

function ejemplo4() {
    var valor1 = prompt("Introducir primer número: ", "");
    var valor2 = prompt("Introducir segundo número: ", "");
    var suma = parseInt(valor1) + parseInt(valor2);
    var producto = parseInt(valor1)*parseInt(valor2);
    document.getElementById("resultado4").innerHTML = "La suma es " + suma + "<br>El producto es " + producto;
}

function ejemplo5() {
    var nombre = prompt("Ingresa tu nombre: ", "");
    var nota = prompt("Ingresa tu nota: ", "");
    if (nota>=4) {
        document.getElementById("resultado5").innerHTML = nombre + " esta aprobado con un " + nota;
    }
}

function ejemplo6() {
    var num1 = prompt("Ingresa el primer número: ", "");
    var num2 = prompt("Ingresa el segundo número: ", "");
    num1 = parseInt(num1);
    num2 = parseInt(num2);
    if (num1>num2) {
        document.getElementById("resultado6").innerHTML = "El mayor es " + num1;
    } else {
        document.getElementById("resultado6").innerHTML = "El mayor es " + num2;
    }
}

function ejemplo7() {
    var nota1 = prompt("Ingresa 1ra. nota: ", "");
    var nota2 = prompt("Ingresa 2da. nota: ", "");
    var nota3 = prompt("Ingresa 3ra. nota: ", "");
    nota1 = parseInt(nota1);
    nota2 = parseInt(nota2);
    nota3 = parseInt(nota3);
    var pro;
    pro = (nota1+nota2+nota3)/3;
    if (pro>=7) {
        document.getElementById("resultado7").innerHTML = "Aprobado";
    } else {
        if (pro>=4) {
            document.getElementById("resultado7").innerHTML = "Regular";
        } else {
            document.getElementById("resultado7").innerHTML = "Reprobado";
        }
    }
}

function ejemplo8() {
    var valor = prompt("Ingresar un valor comprendido entre 1 y 5: ", "");
    valor = parseInt(valor);
    switch(valor) {
        case 1: document.getElementById("resultado8").innerHTML = "Uno";
            break;
        case 2: document.getElementById("resultado8").innerHTML = "Dos";
            break;
        case 3: document.getElementById("resultado8").innerHTML = "Tres";
            break;
        case 4: document.getElementById("resultado8").innerHTML = "Cuatro";
            break;
        case 5: document.getElementById("resultado8").innerHTML = "Cinco";
            break;
        default: document.getElementById("resultado8").innerHTML = "Debe ingresar un valor comprendido entre 1 y 5";
            break;
    }
}

function ejemplo9() {
    var col = prompt("Ingresa el color con que quiera pintar el fondo de la ventana(rojo, verde, azul): ", "");
    switch(col) {
        case "rojo":
            document.bgColor = "#ff0000";
            break;
        case "verde":
            document.bgColor = "#00ff00";
            break;
        case "azul":
            document.bgColor = "#0000ff";
            break;
        default: document.getElementById("resultado9").innerHTML = "Debe ingresar un color valido";
            break;
    }
}