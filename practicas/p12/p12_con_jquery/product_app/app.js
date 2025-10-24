// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
  };

function init() {
    /**
     * Convierte el JSON a string para poder mostrarlo
     * ver: https://developer.mozilla.org/es/docs/Web/JavaScript/Reference/Global_Objects/JSON
     */
    var JsonString = JSON.stringify(baseJSON,null,2);
    document.getElementById("description").value = JsonString;

    // SE LISTAN TODOS LOS PRODUCTOS
    listarProductos();
}

var edit = false;
var productId = null;

// LISTAR PRODUCTOS
function listarProductos() {
  $.ajax({
    url: "./backend/product-list.php",
    type: "GET",
    dataType: "json",
    success: function (productos) {
      let template = "";
      productos.forEach((producto) => {
        let descripcion = `
          <li>precio: ${producto.precio}</li>
          <li>unidades: ${producto.unidades}</li>
          <li>modelo: ${producto.modelo}</li>
          <li>marca: ${producto.marca}</li>
          <li>detalles: ${producto.detalles}</li>
        `;
        template += `
          <tr productId="${producto.id}">
            <td>${producto.id}</td>
            <td>${producto.nombre}</td>
            <td><ul>${descripcion}</ul></td>
            <td>
              <button class="btn btn-warning btn-sm product-edit">Editar</button>
              <button class="btn btn-danger btn-sm product-delete">Eliminar</button>
            </td>
          </tr>
        `;
      });
      $("#products").html(template);
    },
  });
}

// BUSCAR PRODUCTO 
$(document).on("keyup", "#search", function () {
  let search = $(this).val();
  if (search) {
    $.ajax({
      url: "./backend/product-search.php",
      type: "GET",
      data: { search: search },
      dataType: "json",
      success: function (productos) {
        let template = "";
        let template_bar = "";
        productos.forEach((producto) => {
          let descripcion = `
            <li>precio: ${producto.precio}</li>
            <li>unidades: ${producto.unidades}</li>
            <li>modelo: ${producto.modelo}</li>
            <li>marca: ${producto.marca}</li>
            <li>detalles: ${producto.detalles}</li>
          `;
          template += `
            <tr productId="${producto.id}">
              <td>${producto.id}</td>
              <td>${producto.nombre}</td>
              <td><ul>${descripcion}</ul></td>
              <td>
                <button class="btn btn-warning btn-sm product-edit">Editar</button>
                <button class="btn btn-danger btn-sm product-delete">Eliminar</button>
              </td>
            </tr>
          `;
          template_bar += `<li>${producto.nombre}</li>`;
        });
        $("#product-result").removeClass("d-none").addClass("d-block");
        $("#container").html(template_bar);
        $("#products").html(template);
      },
    });
  } else {
    listarProductos();
  }
});

// AGREGAR PRODUCTO
$("#product-form").submit(function (e) {
    e.preventDefault();

    let url = edit ? "./backend/product-edit.php" : "./backend/product-add.php";

    let finalJSON = JSON.parse($("#description").val());
    finalJSON["nombre"] = $("#name").val();

    if (edit) {
        finalJSON["id"] = productId;
    }

    $.ajax({
        url: url,
        type: "POST",
        data: JSON.stringify(finalJSON),
        contentType: "application/json; charset=UTF-8",
        success: function (response) {
            let res = JSON.parse(response);
            let template_bar = `
                <li style="list-style:none;">status: ${res.status}</li>
                <li style="list-style:none;">message: ${res.message}</li>
            `;
            $("#product-result").removeClass("d-none").addClass("d-block");
            $("#container").html(template_bar);

            listarProductos();

            $("#product-form").trigger("reset");
            $("#description").val(JSON.stringify(baseJSON, null, 2));

            edit = false;
            productId = null;
            $("#product-form").find("button[type=submit]").text("Agregar Producto");
        }
    });
});

// ELIMINAR PRODUCTO
$(document).on("click", ".product-delete", function () {
  if (confirm("¿Deseas eliminar el producto?")) {
    let element = $(this)[0].parentElement.parentElement;
    let id = $(element).attr("productId");
    $.ajax({
      url: "./backend/product-delete.php",
      type: "GET",
      data: { id: id },
      success: function (response) {
        let res = JSON.parse(response);
        let template_bar = `
          <li style="list-style:none;">status: ${res.status}</li>
          <li style="list-style:none;">message: ${res.message}</li>
        `;
        $("#product-result").removeClass("d-none").addClass("d-block");
        $("#container").html(template_bar);
        listarProductos();
      },
    });
  }
});

// EDITAR PRODUCTO
$(document).on("click", ".product-edit", function () {
    let element = $(this)[0].parentElement.parentElement;
    let id = $(element).attr("productId");

    edit = true; 
    productId = id;

    $.ajax({
        url: "./backend/product-search.php",
        type: "GET",
        data: { search: id },
        dataType: "json",
        success: function (producto) {
            producto = producto[0];
            $("#name").val(producto.nombre);

            let productoFormateado = {
                precio: parseFloat(producto.precio),
                unidades: parseInt(producto.unidades, 10),
                modelo: producto.modelo,
                marca: producto.marca,
                detalles: producto.detalles,
                imagen: producto.imagen
            };

            $("#description").val(JSON.stringify(productoFormateado, null, 2));
            $("#productId").val(producto.id);

            $("#product-form").find("button[type=submit]").text("Actualizar Producto");
        },
    });
});