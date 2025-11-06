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

    // --- INSTRUCCIONES 3.1 y 4: VALIDACIÓN DE CAMPOS (al salir del foco) ---
    $('#product-form input').blur(function() {
        validarCampo(this);
    });

    // --- FUNCIÓN DE SUBMIT DEL FORMULARIO (Instrucciones 2, 3.2) ---
    $('#product-form').submit(e => {
        e.preventDefault();

        // INSTRUCCIÓN 3.2: Validar campos requeridos antes de enviar
        let formularioValido = true;
        
        // Validamos solo los 'required' del HTML
        $('#product-form input[required]').each(function() {
            if (!validarCampo(this)) {
                formularioValido = false;
            }
        });

        if (!formularioValido) {
            $('#estado_global').text('Por favor, corrige los campos requeridos.');
            return; // Detiene el envío
        } else {
            $('#estado_global').text('');
        }
        
        // Construir el objeto postData desde los campos del formulario
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

        // Decidir si es agregar o editar
        const url = edit === false ? './backend/product-add.php' : './backend/product-edit.php';

        $.post(url, postData, (response) => {
            let respuesta = JSON.parse(response);

            // Mostrar mensaje de éxito/error en la barra global
            $('#estado_global').text(respuesta.message);

            if (respuesta.status === 'success') {
                // Reiniciar el formulario
                $('#product-form').trigger('reset');
                // Limpiar todos los mensajes de estado
                $('#product-form small').text('');
                // Volver a listar productos
                listarProductos();
                // Regresar a modo "Agregar"
                reiniciarFormulario(); // Llama a la función corregida
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

            // Rellenar cada campo del formulario con los datos
            $('#productId').val(product.id);
            $('#nombre').val(product.nombre);
            $('#marca').val(product.marca);
            $('#modelo').val(product.modelo);
            $('#precio').val(product.precio);
            $('#unidades').val(product.unidades);
            $('#detalles').val(product.detalles);
            $('#imagen').val(product.imagen);

            // Poner la bandera de edición en true
            edit = true;
            $('#btn-submit').text('Actualizar Producto'); // Cambia el texto del botón
        });
    });

    // --- FUNCIONES AUXILIARES ---

    /**
     * Valida un campo individual (Instrucción 3.1 y 4)
     * @param {HTMLElement} campo - El input a validar
     * @returns {boolean} - true si es válido, false si no
     */
    function validarCampo(campo) {
        let esRequerido = $(campo).prop('required');
        let valor = $(campo).val();
        let $estado = $(campo).next('small'); // El <small> asociado

        if (esRequerido && valor.trim() === '') {
            $estado.text('Este campo es requerido.'); // Muestra el mensaje
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
        // Se elimina la línea que borraba el estado global
        $('#product-form small').text('');
    }

});