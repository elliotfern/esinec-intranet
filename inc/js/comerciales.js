$(document).ready(function () {
  tablaComerciales();
  tablaComercialesEquipos();
});

// TABLA COMERCIALES/RECLUTADORES
function tablaComerciales() {
  var server = window.location.hostname;
  var urlAjax =
    "https://" + server + "/controller/comerciales.php?type=comerciales";
  var table = $("#comerciales").dataTable({
    pageLength: 50,
    ajax: {
      url: urlAjax,
      type: "POST",
      dataSrc: "",
    },

    order: [[0, "asc"]],

    columnDefs: [
      {
        // # NOMBRE COMERCIAL
        //
        targets: [0],
        type: "text",
        visible: true,
        render: function (data, type, row, meta) {
          if (row.comercial === null) {
            return row.comercial;
          } else {
            return row.comercial;
          }
        },
      },

      {
        // # MODIFICAR
        //
        targets: [1],
        type: "text",
        visible: true,
        render: function (data, type, row, meta) {
          return (
            '<button type="button" id="btnModificaInscripcion' +
            row.id +
            '" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalModificaComercial" onclick="updateComercial(' +
            row.id +
            ')" value="' +
            row.id +
            '" data-title="' +
            row.id +
            '" data-slug="' +
            row.id +
            '" data-text="' +
            row.id +
            '">Modificar comercial</button>'
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

// TABLA COMERCIALES/EQUIPOS
function tablaComercialesEquipos() {
  var server = window.location.hostname;
  var urlAjax =
    "https://" +
    server +
    "/controller/comerciales.php?type=comerciales-equipos";
  var table = $("#comercialesEquipos").dataTable({
    pageLength: 50,
    ajax: {
      url: urlAjax,
      type: "POST",
      dataSrc: "",
    },

    order: [[0, "asc"]],

    columnDefs: [
      {
        // # NOMBRE COMERCIAL
        //
        targets: [0],
        type: "text",
        visible: true,
        render: function (data, type, row, meta) {
          if (row.equipo === null) {
            return row.equipo;
          } else {
            return row.equipo;
          }
        },
      },

      {
        // # MODIFICAR
        //
        targets: [1],
        type: "text",
        visible: true,
        render: function (data, type, row, meta) {
          return (
            '<button type="button" id="btnModificaInscripcion' +
            row.id +
            '" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalModificaComercial" onclick="updateComercial(' +
            row.id +
            ')" value="' +
            row.id +
            '" data-title="' +
            row.id +
            '" data-slug="' +
            row.id +
            '" data-text="' +
            row.id +
            '">Modificar comercial</button>'
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

// INPUT OPEN MODAL FORM - MODIFICAR COMERCIAL
function updateComercial(idComercial) {
  var idComercial = idComercial;
  var server = window.location.hostname;
  var urlAjax =
    "https://" +
    server +
    "/php-forms/comerciales/modal-modificar-comercial.php";
  $.ajax({
    url: urlAjax, //the page containing php script
    type: "post", //request type,
    data: {
      idComercial: idComercial,
      registration: "yes",
    },
    success: function (response) {
      // Add response in Modal body
      $("#bodyModalModificarComercial").html(response);
      $("#bodyModalModificarComercial").show();
    },
  });
}

// AJAX PROCESS > PHP -
// MODAL FORM - MODIFICAR COMERCIAL
$(function () {
  $("#btnModificarComercial").click(function () {
    // check values
    $("#modificarComercialMessageOk").hide();
    $("#modificarComercialMessageErr").hide();

    // Stop form from submitting normally
    event.preventDefault();
    var server = window.location.hostname;
    var urlAjax =
      "https://" +
      server +
      "/php-process/comerciales/php-modificar-comercial.php";
    $.ajax({
      type: "POST",
      url: urlAjax,
      data: {
        id: $("#id").val(),
        equipo: $("#equipo").val(),
      },
      success: function (response) {
        if (response.status == "success") {
          // Add response in Modal body
          $("#modificarComercialMessageOk").show();
          $("#modificarComercialMessageErr").hide();

          // Clear form fields
          $("#id").val("");
          $("#comercial").val("");
        } else {
          $("#modificarComercialMessageErr").show();
          $("#modificarComercialMessageOk").hide();
        }
      },
    });
  });
});

// AJAX PROCESS > PHP -
// MODAL FORM - INSERTAR NUEVO COMERCIAL
$(function () {
  $("#btnCrearComercial").click(function () {
    // check values
    $("#crearComercialMessageOk").hide();
    $("#crearComercialMessageErr").hide();

    // Stop form from submitting normally
    event.preventDefault();
    var server = window.location.hostname;
    var urlAjax =
      "https://" + server + "/php-process/comerciales/php-crear-comercial.php";
    $.ajax({
      type: "POST",
      url: urlAjax,
      data: {
        comercial2: $("#comercial2").val(),
      },
      success: function (response) {
        if (response.status == "success") {
          // Add response in Modal body
          $("#crearComercialMessageOk").show();
          $("#crearComercialMessageErr").hide();
        } else {
          $("#crearComercialMessageErr").show();
          $("#crearComercialMessageOk").hide();
        }
      },
    });
  });
});
