$(document).ready(function() {
    // Variable para saber si estamos editando o agregando
    let edit = false;

    // Ocultar la barra de estado al inicio
    $('#product-result').hide();
    
    // Cargar productos al iniciar
    listarProductos();

    // --- FUNCIÓN PARA LISTAR PRODUCTOS ---
    function listarProductos() {
        $.ajax({
            url: './backend/product-list.php',
            type: 'GET',
            success: function(response) {
                const productos = JSON.parse(response);
                if (Object.keys(productos).length > 0) {
                    let template = '';
                    productos.forEach(producto => {
                        // Usamos los nombres correctos de la BD
                        let descripcion = '';
                        descripcion += '<li>precio: ' + producto.precio + '</li>';
                        descripcion += '<li>unidades: ' + producto.unidades + '</li>';
                        descripcion += '<li>modelo: ' + producto.modelo + '</li>';
                        descripcion += '<li>marca: ' + producto.marca + '</li>';
                        descripcion += '<li>detalles: ' + producto.detalles + '</li>';

                        template += `
                            <tr productId="${producto.id}">
                                <td>${producto.id}</td>
                                <td><a href="#" class="product-item">${producto.nombre}</a></td>
                                <td><ul>${descripcion}</ul></td>
                                <td>
                                    <button class="product-delete btn btn-danger">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                    $('#products').html(template);
                }
            }
        });
    }

    // --- BÚSQUEDA (Tu lógica original) ---
    $('#search').keyup(function() {
        if ($('#search').val()) {
            let search = $('#search').val();
            $.ajax({
                url: './backend/product-search.php?search=' + search,
                data: { search },
                type: 'GET',
                success: function (response) {
                    if(!response.error) {
                        const productos = JSON.parse(response);
                        if(Object.keys(productos).length > 0) {
                            let template = '';
                            let template_bar = '';

                            productos.forEach(producto => {
                                let descripcion = '';
                                descripcion += '<li>precio: '+producto.precio+'</li>';
                                descripcion += '<li>unidades: '+producto.unidades+'</li>';
                                descripcion += '<li>modelo: '+producto.modelo+'</li>';
                                descripcion += '<li>marca: '+producto.marca+'</li>';
                                descripcion += '<li>detalles: '+producto.detalles+'</li>';
                            
                                template += `
                                    <tr productId="${producto.id}">
                                        <td>${producto.id}</td>
                                        <td><a href="#" class="product-item">${producto.nombre}</a></td>
                                        <td><ul>${descripcion}</ul></td>
                                        <td>
                                            <button class="product-delete btn btn-danger">
                                                Eliminar
                                            </button>
                                        </td>
                                    </tr>
                                `;

                                template_bar += `
                                    <li>${producto.nombre}</il>
                                `;
                            });
                            $('#product-result').show();
                            $('#container').html(template_bar);
                            $('#products').html(template);    
                        }
                    }
                }
            });
        } else {
            $('#product-result').hide();
            listarProductos(); // Recarga la lista si la búsqueda está vacía
        }
    });

    // --- ¡NUEVO! INSTRUCCIÓN 5: VALIDACIÓN ASÍNCRONA DE NOMBRE ---
    $('#nombre').keyup(function() {
        if ($('#nombre').val()) {
            let nombre = $('#nombre').val();
            // Obtenemos el ID del producto (0 si es nuevo, o un valor si se edita)
            let id = $('#productId').val() || 0; 

            // Llamada AJAX al nuevo script 'product-check-name.php'
            $.post('./backend/product-check-name.php', { nombre: nombre, id: id }, (response) => {
                let respuesta = JSON.parse(response);

                // Mostramos el mensaje de estado debajo del campo 'nombre'
                if (respuesta.existe) {
                    $('#estado_nombre').text('Este nombre de producto ya existe.');
                    // Cambiamos el color a rojo (peligro)
                    $('#estado_nombre').removeClass('text-success text-warning').addClass('text-danger');
                } else {
                    $('#estado_nombre').text('Nombre disponible.');
                    // Cambiamos el color a verde (éxito)
                    $('#estado_nombre').removeClass('text-danger text-warning').addClass('text-success');
                }
            });
        } else {
            // Si el campo está vacío, limpiamos el mensaje
            $('#estado_nombre').text('');
            $('#estado_nombre').removeClass('text-success text-danger').addClass('text-warning');
        }
    });
    // --- FIN DE LA SECCIÓN NUEVA ---


    // --- INSTRUCCIONES 3.1 y 4: VALIDACIÓN DE CAMPOS (al salir del foco) ---
    $('#product-form input').blur(function() {
        // Validamos el campo usando la función
        validarCampo(this);
    });

    // --- FUNCIÓN DE SUBMIT DEL FORMULARIO (Instrucciones 2, 3.2) ---
    $('#product-form').submit(e => {
        e.preventDefault();

        let formularioValido = true;
        // Validamos solo los 'required' del HTML
        $('#product-form input[required]').each(function() {
            if (!validarCampo(this)) {
                formularioValido = false;
            }
        });

        // Revisamos también que el nombre no esté marcado como 'ya existe'
        if ($('#estado_nombre').hasClass('text-danger')) {
            formularioValido = false;
            $('#estado_global').text('El nombre del producto ya existe, por favor cámbialo.');
            return;
        }

        if (!formularioValido) {
            $('#estado_global').text('Por favor, corrige los campos requeridos.');
            return; // Detiene el envío
        } else {
            $('#estado_global').text('');
        }
        
        const postData = {
            id: $('#productId').val(),
            nombre: $('#nombre').val(),
            marca: $('#marca').val(),
            modelo: $('#modelo').val(),
            precio: $('#precio').val(),
            unidades: $('#unidades').val(),
            detalles: $('#detalles').val(),
            imagen: $('#imagen').val()
        };

        const url = edit === false ? './backend/product-add.php' : './backend/product-edit.php';

        $.post(url, postData, (response) => {
            let respuesta = JSON.parse(response);

            // Mostrar mensaje de éxito/error en la barra global
            $('#estado_global').text(respuesta.message);

            if (respuesta.status === 'success') {
                listarProductos();
                reiniciarFormulario();
            }
        });
    });

    // --- ELIMINAR PRODUCTO ---
    $(document).on('click', '.product-delete', (e) => {
        if (confirm('¿Realmente deseas eliminar el producto?')) {
            const element = $(e.target).closest('tr');
            const id = $(element).attr('productId');
            $.post('./backend/product-delete.php', { id }, (response) => {
                listarProductos();
            });
        }
    });

    // --- CARGAR PRODUCTO EN FORMULARIO (Actualizado para campos) ---
    $(document).on('click', '.product-item', (e) => {
        e.preventDefault(); 
        const element = $(e.target).closest('tr');
        const id = $(element).attr('productId');

        $.post('./backend/product-single.php', { id }, (response) => {
            let product = JSON.parse(response);

            $('#productId').val(product.id);
            $('#nombre').val(product.nombre);
            $('#marca').val(product.marca);
            $('#modelo').val(product.modelo);
            $('#precio').val(product.precio);
            $('#unidades').val(product.unidades);
            $('#detalles').val(product.detalles);
            $('#imagen').val(product.imagen);

            edit = true;
            $('#btn-submit').text('Actualizar Producto');
            // Limpiamos todos los mensajes de estado al cargar un producto
            $('#product-form small').text('');
            $('#estado_global').text('');
        });
    });

    // --- FUNCIONES AUXILIARES ---

    /**
     * Valida un campo individual
     */
    function validarCampo(campo) {
        let esRequerido = $(campo).prop('required');
        let valor = $(campo).val();
        let $estado = $(campo).next('small'); // El <small> asociado

        // Si el campo es 'nombre' y ya tiene un mensaje de 'keyup', no hacemos nada
        if ($(campo).attr('id') === 'nombre' && $estado.text() !== '') {
             // A menos que esté vacío, en ese caso sí mostramos "requerido"
             if (valor.trim() === '') {
                $estado.text('Este campo es requerido.');
                $estado.removeClass('text-success text-danger').addClass('text-warning');
                return false;
             }
             // Si no está vacío, confiamos en el mensaje de 'keyup'
             return !$estado.hasClass('text-danger');
        }

        // Validación normal para los demás campos
        if (esRequerido && valor.trim() === '') {
            $estado.text('Este campo es requerido.');
            $estado.removeClass('text-success text-danger').addClass('text-warning');
            return false;
        }

        $estado.text(''); // Limpiar estado si es válido
        return true;
    }

    /**
     * Reinicia el formulario al estado original (VERSIÓN CORREGIDA)
     */
    function reiniciarFormulario() {
        edit = false;
        $('#product-form').trigger('reset');
        $('#productId').val('');
        $('#btn-submit').text('Agregar Producto');
        // Limpiamos todos los mensajes de estado
        $('#product-form small').text('');
        // Restauramos los colores por defecto
        $('#product-form small').removeClass('text-success text-danger').addClass('text-warning');
    }

});