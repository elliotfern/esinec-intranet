$(document).ready(function () {
  tablaInscripcionCursos();
  tablaClientesInscripcionCurso();
});

function tablaInscripcionCursos() {
  var server = window.location.hostname;
  var urlAjax =
    "https://" + server + "/controller/cursos.php?type=inscripcion-cursos";
  var table = $("#inscripcionCursos").dataTable({
    pageLength: 50,
    ajax: {
      url: urlAjax,
      type: "POST",
      dataSrc: "",
    },

    order: [[0, "asc"]],

    columnDefs: [
      {
        // # NOMBRE CURSO
        //
        targets: [0],
        type: "text",
        visible: true,
        render: function (data, type, row, meta) {
          return "<strong>" + row.codigo + " / " + row.edicion + "</strong>";
        },
      },

      {
        // # TOTAL INSCRITOS AL CURSO
        //
        targets: [1],
        type: "text",
        visible: true,
        render: function (data, type, row, meta) {
          return +row.total;
        },
      },

      {
        // # LINK A LISTADO DE INSCRITOS EN EL CURSO
        //
        targets: [2],
        type: "text",
        visible: true,
        render: function (data, type, row, meta) {
          return (
            '<a href="https://gestion.esinec.com/cursos/' +
            row.id +
            '" class="btn btn-primary btn-sm" role="button" aria-pressed="true">Ver inscritos</a>'
          );
        },
      },

      {
        // # MODIFICAR EDICION
        //
        targets: [3],
        type: "text",
        visible: true,
        render: function (data, type, row, meta) {
          return (
            '<button type="button" id="btnModificaInscripcion' +
            row.id +
            '" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalModificaEdicion" onclick="updateEdicion(' +
            row.id +
            ')" value="' +
            row.id +
            '" data-title="' +
            row.id +
            '" data-slug="' +
            row.id +
            '" data-text="' +
            row.id +
            '">Modificar edición</button>'
          );
        },
      },
    ],

    dom: "Bfrtip",
    buttons: [
      {
        extend: "pdfHtml5",
        orientation: "landscape",
        pageSize: "LEGAL",
        titleAttr: "PDF clientes",
        exportOptions: {
          columns: [1, 2, 3, 4, 5],
        },
      },
      {
        extend: "excelHtml5",
        text: "Excel",
        filename: "table_data",
        exportOptions: {
          columns: [1, 2, 3, 4, 5],
        },
      },
    ],
  });
  setInterval(function () {
    table.api().ajax.reload(null, false); // user paging is not reset on reload
  }, 15000);
}

// FUNCION PARA MOSTRAR TABLA CON LOS CLIENTES INSCRITOS EN UN DETERMINADO CURSO
function tablaClientesInscripcionCurso() {
  var idCurso = $("#idCurso").val();
  var server = window.location.hostname;
  var urlAjax =
    "https://" +
    server +
    "/controller/cursos.php?type=inscripcion-curso&id=" +
    idCurso;
  var table = $("#tablaClientesInscripcionCurso").dataTable({
    pageLength: 50,
    ajax: {
      url: urlAjax,
      type: "POST",
      dataSrc: "",
    },

    order: [[1, "asc"]],

    columnDefs: [
      {
        // # NOMBRE CLIENTE
        //
        targets: [0],
        type: "text",
        visible: true,
        render: function (data, type, row, meta) {
          return "<strong>" + row.first_name + "</strong>";
        },
      },

      {
        // # APELLIDOS CLIENTE
        //
        targets: [1],
        type: "text",
        visible: true,
        render: function (data, type, row, meta) {
          return "<strong>" + row.last_name + "</strong>";
        },
      },

      {
        // # LINK FICHA CLIENTE
        //
        targets: [2],
        type: "text",
        visible: true,
        render: function (data, type, row, meta) {
          return (
            '<a href="https://gestion.esinec.com/clientes/' +
            row.idCliente +
            '/facturacion" class="btn btn-primary btn-sm" role="button" aria-pressed="true">Ver cliente</a>'
          );
        },
      },
    ],

    dom: "Bfrtip",
    buttons: [
      {
        extend: "pdfHtml5",
        orientation: "landscape",
        pageSize: "LEGAL",
        titleAttr: "PDF clientes",
        exportOptions: {
          columns: [0, 1],
        },
      },
      {
        extend: "excelHtml5",
        text: "Excel",
        filename: "table_data",
        exportOptions: {
          columns: [0, 1],
        },
      },
    ],
  });
  setInterval(function () {
    table.api().ajax.reload(null, false); // user paging is not reset on reload
  }, 15000);
}

// INPUT OPEN MODAL FORM - MODIFICAR EDICIÓN CURSO
function updateEdicion(idEdicion) {
  var idEdicion = idEdicion;
  var server = window.location.hostname;
  var urlAjax =
    "https://" + server + "/php-forms/cursos/modal-modificar-edicion.php";
  $.ajax({
    url: urlAjax, //the page containing php script
    type: "post", //request type,
    data: {
      idEdicion: idEdicion,
      registration: "yes",
    },
    success: function (response) {
      // Add response in Modal body
      $("#bodyModalModificarEdicion").html(response);
      $("#bodyModalModificarEdicion").show();
    },
  });
}

// AJAX PROCESS > PHP -
// MODAL FORM - MODIFICAR EDICION
$(function () {
  $("#btnModificarEdicion").click(function () {
    // check values
    $("#modificarEdicionMessageOk").hide();
    $("#modificarEdicionMessageErr").hide();

    // Stop form from submitting normally
    event.preventDefault();
    var server = window.location.hostname;
    var urlAjax =
      "https://" + server + "/php-process/cursos/php-modificar-edicion.php";
    $.ajax({
      type: "POST",
      url: urlAjax,
      data: {
        id: $("#id").val(),
        edicion: $("#edicion").val(),
        curso: $("#curso").val(),
      },
      success: function (response) {
        if (response.status == "success") {
          // Add response in Modal body
          $("#modificarEdicionMessageOk").show();
          $("#modificarEdicionMessageErr").hide();
        } else {
          $("#modificarEdicionMessageErr").show();
          $("#modificarEdicionMessageOk").hide();
        }
      },
    });
  });
});

// AJAX PROCESS > PHP -
// MODAL FORM - CREAR CODIGO CURSO
$(function () {
  $("#btnCrearCodigo").click(function () {
    // check values
    $("#crearCodigoMessageOk").hide();
    $("#crearCodigoMessageErr").hide();

    // Stop form from submitting normally
    event.preventDefault();
    var server = window.location.hostname;
    var urlAjax =
      "https://" + server + "/php-process/cursos/php-insert-curso.php";
    $.ajax({
      type: "POST",
      url: urlAjax,
      data: {
        codigo: $("#codigo").val(),
      },
      success: function (response) {
        if (response.status == "success") {
          // Add response in Modal body
          $("#crearCodigoMessageOk").show();
          $("#crearCodigoMessageErr").hide();
        } else {
          $("#crearCodigoMessageErr").show();
          $("#crearCodigoMessageOk").hide();
        }
      },
    });
  });
});

// AJAX PROCESS > PHP -
// MODAL FORM - CREAR EDICION CURSO
$(function () {
  $("#btnCrearEdicion").click(function () {
    // check values
    $("#crearEdicionMessageOk").hide();
    $("#crearEdicionMessageErr").hide();

    // Stop form from submitting normally
    event.preventDefault();
    var server = window.location.hostname;
    var urlAjax =
      "https://" + server + "/php-process/cursos/php-insert-edicion.php";
    $.ajax({
      type: "POST",
      url: urlAjax,
      data: {
        curso: $("#curso").val(),
        edicion: $("#edicion").val(),
      },
      success: function (response) {
        if (response.status == "success") {
          // Add response in Modal body
          $("#crearEdicionMessageOk").show();
          $("#crearEdicionMessageErr").hide();
        } else {
          $("#crearEdicionMessageErr").show();
          $("#crearEdicionMessageOk").hide();
        }
      },
    });
  });
});

// ELIMINAR INSCRIPCION CURSO
function eliminarInscripcion(idInscripcion) {
  var idInscripcion = idInscripcion;
  var server = window.location.hostname;
  var urlAjax =
    "https://" + server + "/php-process/cursos/eliminar-inscripcion.php";
  $.ajax({
    url: urlAjax, //the page containing php script
    type: "post", //request type,
    data: {
      idInscripcion: idInscripcion,
      registration: "yes",
    },
    success: function (response) {
      // La solicitud AJAX fue exitosa
      // Cambiar la clase del boton
      $("#btnEliminarInscripcion-" + idInscripcion)
        .removeClass("btn btn-sm btn-danger")
        .addClass("btn btn-sm btn-primary");

      // Cambiar el texto del boton
      $("#btnEliminarInscripcion-" + idInscripcion).text("Eliminando...");
    },
  });
}
