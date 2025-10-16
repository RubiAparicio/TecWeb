// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
  };

// FUNCIÓN CALLBACK DE BOTÓN "Buscar"
function buscarID(e) {
    /**
     * Revisar la siguiente información para entender porqué usar event.preventDefault();
     * http://qbit.com.mx/blog/2013/01/07/la-diferencia-entre-return-false-preventdefault-y-stoppropagation-en-jquery/#:~:text=PreventDefault()%20se%20utiliza%20para,escuche%20a%20trav%C3%A9s%20del%20DOM
     * https://www.geeksforgeeks.org/when-to-use-preventdefault-vs-return-false-in-javascript/
     */
    e.preventDefault();

    // SE OBTIENE EL ID A BUSCAR
    var id = document.getElementById('search').value;

    // SE CREA EL OBJETO DE CONEXIÓN ASÍNCRONA AL SERVIDOR
    var client = getXMLHttpRequest();
    client.open('POST', './backend/read.php', true);
    client.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    client.onreadystatechange = function () {
        // SE VERIFICA SI LA RESPUESTA ESTÁ LISTA Y FUE SATISFACTORIA
        if (client.readyState == 4 && client.status == 200) {
            console.log('[CLIENTE]\n'+client.responseText);
            
            // SE OBTIENE EL OBJETO DE DATOS A PARTIR DE UN STRING JSON
            let productos = JSON.parse(client.responseText);    // similar a eval('('+client.responseText+')');
            
            // SE VERIFICA SI EL OBJETO JSON TIENE DATOS
            if(Object.keys(productos).length > 0) {
                // SE CREA UNA LISTA HTML CON LA DESCRIPCIÓN DEL PRODUCTO
                let descripcion = '';
                    descripcion += '<li>precio: '+productos.precio+'</li>';
                    descripcion += '<li>unidades: '+productos.unidades+'</li>';
                    descripcion += '<li>modelo: '+productos.modelo+'</li>';
                    descripcion += '<li>marca: '+productos.marca+'</li>';
                    descripcion += '<li>detalles: '+productos.detalles+'</li>';
                
                // SE CREA UNA PLANTILLA PARA CREAR LA(S) FILA(S) A INSERTAR EN EL DOCUMENTO HTML
                let template = '';
                    template += `
                        <tr>
                            <td>${productos.id}</td>
                            <td>${productos.nombre}</td>
                            <td><ul>${descripcion}</ul></td>
                        </tr>
                    `;

                // SE INSERTA LA PLANTILLA EN EL ELEMENTO CON ID "productos"
                document.getElementById("productos").innerHTML = template;
            }
        }
    };
    client.send("id="+id);
}

function buscarProducto(e) {
    e.preventDefault();

    // SE OBTIENE EL TÉRMINO DE BÚSQUEDA
    var query = document.getElementById('search').value;
    
    if (query.trim() === '') {
        document.getElementById('productos').innerHTML = '<tr><td colspan="3">Ingrese un término de búsqueda.</td></tr>';
        return;
    }

    // SE CREA EL OBJETO DE CONEXIÓN ASÍNCRONA AL SERVIDOR
    var client = getXMLHttpRequest();
    client.open('POST', './backend/read.php', true);
    client.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
    client.onreadystatechange = function () {
        // SE VERIFICA SI LA RESPUESTA ESTÁ LISTA Y FUE SATISFACTORIA
        if (client.readyState == 4 && client.status == 200) {
            console.log('[CLIENTE]\n'+client.responseText);
            
            var productos;
            var template = '';
            
            // SE OBTIENE EL OBJETO DE DATOS A PARTIR DE UN STRING JSON
            productos = JSON.parse(client.responseText);

            // SE VERIFICA SI EL ARRAY JSON TIENE DATOS
            if (!Array.isArray(productos) || productos.length === 0 || productos.error) {
                // Muestra un mensaje si no hay resultados o si hubo un error de consulta.
                template += '<tr><td colspan="3">No se encontraron productos o hubo un error: ' + (productos.error || 'Lista vacía') + '</td></tr>';
            } else {
                // SE ITERA SOBRE EL ARRAY DE PRODUCTOS Y SE CONSTRUYE LA PLANTILLA DE LA TABLA
                productos.forEach(producto => {
                    
                    // SE CREA UNA LISTA HTML CON LA DESCRIPCIÓN DEL PRODUCTO
                    let descripcion = '';
                    descripcion += '<li>precio: '+producto.precio+'</li>';
                    descripcion += '<li>unidades: '+producto.unidades+'</li>';
                    descripcion += '<li>modelo: '+producto.modelo+'</li>';
                    descripcion += '<li>marca: '+producto.marca+'</li>';
                    descripcion += '<li>detalles: '+producto.detalles+'</li>';
                    descripcion += '<li>imagen: '+producto.imagen+'</li>';
                    
                    // SE CREA UNA PLANTILLA PARA CREAR LA FILA
                    template += `
                        <tr>
                            <td>${producto.id}</td>
                            <td>${producto.nombre}</td>
                            <td><ul>${descripcion}</ul></td>
                        </tr>
                    `;
                });
            }
            
            // SE INSERTA LA PLANTILLA EN EL ELEMENTO CON ID "productos"
            document.getElementById("productos").innerHTML = template;
        }
    };
    // Se envía el parámetro 'busqueda'
    client.send("busqueda="+encodeURIComponent(query));
}

function validarProductos() {
    const nombre = document.getElementById('name').value.trim();
    let productoJSON;

    try {
        productoJSON = JSON.parse(document.getElementById('description').value);
    } catch (error) {
        alert("Error: el JSON no es válido.");
        return false;
    }

    const { precio, unidades, modelo, marca, detalles, imagen } = productoJSON;

    if (nombre === "" || nombre.length > 100) {
        alert('El nombre es requerido y debe tener máximo 100 caracteres!');
        return false;
    }
    if (!marca || marca === "") {
        alert('Debes seleccionar una marca!');
        return false;
    }
    const regexModelo = /^[a-zA-Z0-9]+$/;
    if (!modelo || !regexModelo.test(modelo) || modelo.length > 25) {
        alert('El modelo es requerido, alfanumérico y máximo 25 caracteres!');
        return false;
    }
    if (isNaN(precio) || precio <= 99.99) {
        alert('El precio es requerido y debe ser mayor a $99.99!');
        return false;
    }
    if (detalles && detalles.length > 250) {
        alert('Los detalles no pueden tener más de 250 caracteres!');
        return false;
    }
    if (isNaN(unidades) || unidades < 0) {
        alert('Las unidades son requeridas y deben ser mayor o igual a 0!');
        return false;
    }
    if (!imagen || imagen === "") {
        productoJSON.imagen = "img/default.png";
        document.getElementById('description').value = JSON.stringify(productoJSON, null, 2);
    }

    return true;
}

// FUNCIÓN CALLBACK DE BOTÓN "Agregar Producto"
function agregarProducto(e) {
    e.preventDefault();

    if (!validarProductos()) {
        return; 
    }

    // SE OBTIENE DESDE EL FORMULARIO EL JSON A ENVIAR
    var productoJsonString = document.getElementById('description').value;

    let finalJSON;
    try {
        // SE CONVIERTE EL JSON DE STRING A OBJETO
        finalJSON = JSON.parse(productoJsonString);
    } catch (err) {
        alert("Error: el contenido del JSON no es válido.");
        return;
    }

    // SE AGREGA AL JSON EL NOMBRE DEL PRODUCTO
    finalJSON['nombre'] = document.getElementById('name').value.trim();

    // Si no tiene imagen, se pone la por defecto
    if (!finalJSON.imagen || finalJSON.imagen.trim() === "") {
        finalJSON.imagen = "img/default.png";
    }

    // SE OBTIENE EL STRING DEL JSON FINAL
    productoJsonString = JSON.stringify(finalJSON, null, 2);

    // SE CREA EL OBJETO DE CONEXIÓN ASÍNCRONA AL SERVIDOR
    var client = getXMLHttpRequest();
    client.open('POST', './backend/create.php', true);
    client.setRequestHeader('Content-Type', "application/json;charset=UTF-8");
    client.onreadystatechange = function () {
        if (client.readyState == 4) {
            if (client.status == 200) {
                console.log('[CLIENTE]\n' + client.responseText);
                window.alert(client.responseText);
            } else {
                window.alert('Error al comunicarse con el servidor: ' + client.status);
            }
        }
    };
    client.send(productoJsonString);
}


// SE CREA EL OBJETO DE CONEXIÓN COMPATIBLE CON EL NAVEGADOR
function getXMLHttpRequest() {
    var objetoAjax;

    try{
        objetoAjax = new XMLHttpRequest();
    }catch(err1){
        /**
         * NOTA: Las siguientes formas de crear el objeto ya son obsoletas
         *       pero se comparten por motivos historico-académicos.
         */
        try{
            // IE7 y IE8
            objetoAjax = new ActiveXObject("Msxml2.XMLHTTP");
        }catch(err2){
            try{
                // IE5 y IE6
                objetoAjax = new ActiveXObject("Microsoft.XMLHTTP");
            }catch(err3){
                objetoAjax = false;
            }
        }
    }
    return objetoAjax;
}

function init() {
    /**
     * Convierte el JSON a string para poder mostrarlo
     * ver: https://developer.mozilla.org/es/docs/Web/JavaScript/Reference/Global_Objects/JSON
     */
    var JsonString = JSON.stringify(baseJSON,null,2);
    document.getElementById("description").value = JsonString;
}