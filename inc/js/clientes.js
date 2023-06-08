$(document).ready(function () {
  tablaClientesFactura();
});

function tablaClientesFactura() {
  var server = window.location.hostname;
  var urlAjax = "https://" + server + "/controller/clientes.php?type=clientes";
  var table = $("#clientesFactura").dataTable({
    pageLength: 50,
    ajax: {
      url: urlAjax,
      type: "POST",
      dataSrc: "",
    },

    order: [[2, "asc"]],

    columnDefs: [
      {
        // # INFO CLIENTE
        //
        targets: [0],
        type: "text",
        visible: true,
        render: function (data, type, row, meta) {
          return (
            '<a href="https://gestion.esinec.com/clientes/' +
            row.ID +
            '"><img src="https://gestion.esinec.com/inc/img/info.png" alt="Cliente" width="25" height="15"></a>'
          );
        },
      },

      {
        // # NOMBRE
        //
        targets: [1],
        type: "text",
        visible: true,
        render: function (data, type, row, meta) {
          if (row.first_name === null) {
            return row.first_name;
          } else {
            return row.first_name;
          }
        },
      },

      {
        // # APELLIDOS
        //
        targets: [2],
        type: "text",
        visible: true,
        render: function (data, type, row, meta) {
          if (row.last_name === null) {
            return row.last_name;
          } else {
            return row.last_name;
          }
        },
      },

      {
        // # EMAIL
        //
        targets: [3],
        type: "text",
        visible: true,
        render: function (data, type, row, meta) {
          if (row.user_email === null) {
            return row.user_email;
          } else {
            return row.user_email;
          }
        },
      },

      {
        // # CIUDAD
        //
        targets: [4],
        type: "text",
        visible: true,
        render: function (data, type, row, meta) {
          if (row.billing_city === null) {
            return row.billing_city;
          } else {
            return row.billing_city;
          }
        },
      },

      {
        // # TELEFONO
        //
        targets: [5],
        type: "text",
        visible: true,
        render: function (data, type, row, meta) {
          if (row.telephone === null) {
            return row.telephone;
          } else {
            return row.telephone;
          }
        },
      },

      {
        // # STATUS
        // https://datatables.net/examples/advanced_init/column_render.html
        //
        targets: [6],
        visible: true,
        render: function (data, type, row, meta) {
          return (
            '<a href="https://esinec.com/wp-admin/user-edit.php?user_id=' +
            row.ID +
            '" class="btn btn-primary btn-sm" role="button" aria-pressed="true" target="_blank">Actualizar</a>'
          );
        },
      },
      {
        targets: [7],
        visible: true,
        render: function (data, type, row, meta) {
          return (
            '<a href="' +
            row.ID +
            '/facturacion" class="btn btn-success btn-sm" role="button" aria-pressed="true">Facturas</a>'
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

// AJAX PROCESS > PHP -
// MODAL FORM - CREAR NUEVO COBRO PROGRAMADO
$(function () {
  $("#btnCrearCobro").click(function () {
    // check values
    $("#crearCobroMessageOk").hide();
    $("#crearCobroMessageErr").hide();

    // Stop form from submitting normally
    event.preventDefault();
    var server = window.location.hostname;
    var urlAjax =
      "https://" + server + "/php-process/clientes/php-insert-cobro.php";
    $.ajax({
      type: "POST",
      url: urlAjax,
      data: {
        cliente: $("#cliente").val(),
        producto: $("#producto").val(),
        importe: $("#importe").val(),
        tipoPago: $("#tipoPago").val(),
        fecha: $("#fecha").val(),
        estado: $("#estado").val(),
        numPago: $("#numPago").val(),
      },
      success: function (response) {
        if (response.status == "success") {
          // Add response in Modal body
          $("#crearCobroMessageOk").show();
          $("#crearCobroMessageErr").hide();
        } else {
          $("#crearCobroMessageErr").show();
          $("#crearCobroMessageOk").hide();
        }
      },
    });
  });
});

// INPUT OPEN MODAL FORM - MODIFICAR INSCRIPCION
function updateInscripcion(idInscripcion) {
  var idInscripcion2 = idInscripcion;
  var server = window.location.hostname;
  var urlAjax =
    "https://" + server + "/php-forms/clientes/modal-modificar-inscripcion.php";
  $.ajax({
    url: urlAjax, //the page containing php script
    type: "post", //request type,
    data: {
      idInscripcion2: idInscripcion2,
      registration: "yes",
    },
    success: function (response) {
      // Add response in Modal body
      $("#bodyModalModificarInscripcion").html(response);
      $("#bodyModalModificarInscripcion").show();
    },
  });
}

// AJAX PROCESS > PHP -
// MODAL FORM - CREAR NUEVA INSCRIPCIÓN
$(function () {
  $("#btnNuevaInscripcion").click(function () {
    // check values
    $("#nuevaInscripcionMessageOk").hide();
    $("#nuevaInscripcionMessageErr").hide();

    // Stop form from submitting normally
    event.preventDefault();
    var server = window.location.hostname;
    var urlAjax =
      "https://" + server + "/php-process/clientes/php-insert-inscripcion.php";
    $.ajax({
      type: "POST",
      url: urlAjax,
      data: {
        cliente: $("#cliente").val(),
        importeTotal: $("#importeTotal").val(),
        codigo: $("#codigo").val(),
        edicion: $("#edicion").val(),
        asistencia: $("#asistencia").val(),
        captacionComercial: $("#captacionComercial").val(),
        comercialCierre: $("#comercialCierre").val(),
        notas: $("#notas").val(),
      },
      success: function (response) {
        if (response.status == "success") {
          // Add response in Modal body
          $("#nuevaInscripcionMessageOk").show();
          $("#nuevaInscripcionMessageErr").hide();
        } else {
          $("#nuevaInscripcionMessageErr").show();
          $("#nuevaInscripcionMessageOk").hide();
        }
      },
    });
  });
});

// AJAX PROCESS > PHP -
// MODAL FORM - MODIFICAR INSCRIPCIÓN
$(function () {
  $("#btnModificarInscripcion").click(function () {
    // check values
    $("#modificarInscripcionMessageOk").hide();
    $("#modificarInscripcionMessageErr").hide();

    // Stop form from submitting normally
    event.preventDefault();
    var server = window.location.hostname;
    var urlAjax =
      "https://" +
      server +
      "/php-process/clientes/php-modificar-inscripcion.php";
    $.ajax({
      type: "POST",
      url: urlAjax,
      data: {
        id: $("#id2").val(),
        cliente: $("#cliente2").val(),
        importeTotal: $("#importeTotal2").val(),
        codigo: $("#codigo2").val(),
        edicion: $("#edicion2").val(),
        asistencia: $("#asistencia2").val(),
        captacionComercial: $("#captacionComercial2").val(),
        comercialCierre: $("#comercialCierre2").val(),
        notas: $("#notas2").val(),
      },
      success: function (response) {
        if (response.status == "success") {
          // Add response in Modal body
          $("#modificarInscripcionMessageOk").show();
          $("#modificarInscripcionMessageErr").hide();
        } else {
          $("#modificarInscripcionMessageErr").show();
          $("#modificarInscripcionMessageOk").hide();
        }
      },
    });
  });
});

// INPUT OPEN MODAL FORM - MODIFICAR PAGO
function updateModalPagos(idPago) {
  var idPago2 = idPago;
  var server = window.location.hostname;
  var urlAjax =
    "https://" + server + "/php-forms/clientes/modal-modificar-pago.php";
  $.ajax({
    url: urlAjax, //the page containing php script
    type: "post", //request type,
    data: {
      idPago2: idPago2,
      registration: "yes",
    },
    success: function (response) {
      // Add response in Modal body
      $("#bodyModalModificarPago").html(response);
      $("#bodyModalModificarPago").show();
    },
  });
}

// AJAX PROCESS > PHP -
// MODAL FORM - MODIFICAR COBRO PROGRAMADO
$(function () {
  $("#btnModificarPago").click(function () {
    // check values
    $("#modificarCobroMessageOk").hide();
    $("#modificarCobroMessageErr").hide();

    // Stop form from submitting normally
    event.preventDefault();
    var server = window.location.hostname;
    var urlAjax =
      "https://" + server + "/php-process/clientes/php-modificar-cobro.php";
    $.ajax({
      type: "POST",
      url: urlAjax,
      data: {
        id2: $("#id2").val(),
        cliente2: $("#cliente2").val(),
        producto2: $("#producto2").val(),
        importe2: $("#importe2").val(),
        tipoPago2: $("#tipoPago2").val(),
        fecha2: $("#fecha2").val(),
        estado2: $("#estado2").val(),
        numPago2: $("#numPago2").val(),
      },
      success: function (response) {
        if (response.status == "success") {
          // Add response in Modal body
          $("#modificarCobroMessageOk").show();
          $("#modificarCobroMessageErr").hide();
        } else {
          $("#modificarCobroMessageErr").show();
          $("#modificarCobroMessageOk").hide();
        }
      },
    });
  });
});

// AJAX PROCESS > PHP -
// BOTON PAGO PROGRAMADO - ¿COBRADO? AL CLICAR CAMBIA ESTADO A "PAGADO"
function btnCobrado(idPago) {
  var idPago3 = idPago;
  var server = window.location.hostname;
  var urlAjax =
    "https://" +
    server +
    "/php-process/clientes/php-modificar-boton-cobrado.php";
  $.ajax({
    url: urlAjax, //the page containing php script
    type: "post", //request type,
    data: {
      idPago3: idPago3,
      estado2: 2,
    },
    success: function (response) {
      // Open the modal
      $("#actualizarPago").modal("show");

      // Close the modal after 4 seconds
      setTimeout(function () {
        $("#actualizarPago").modal("hide");
      }, 2000);
    },
    error: function (xhr, status, error) {
      // Handle any error that occurred during the AJAX request
      console.error(error);
    },
  });
}

// AJAX CREATE PDF INVOICE
/**
 * Sends an AJAX request to the server-side script with the invoice ID and opens the resulting PDF in a new tab or window.
 * @param {string} id - The ID of the invoice to retrieve as a PDF.
 */
function facturasWebGenerarPDF(id) {
  // Get the hostname of the current URL
  var server = window.location.hostname;

  // Create a new XMLHttpRequest object
  var xhr = new XMLHttpRequest();

  // Set the request URL to the server-side script that retrieves the PDF
  xhr.open(
    "GET",
    "https://" +
      server +
      "/php-forms/clientes/generar-factura-web.php?id=" +
      id,
    true
  );

  // Set the expected response type to a blob
  xhr.responseType = "blob";

  // Define what should happen when the request finishes loading
  xhr.onload = function (e) {
    if (this.status === 200) {
      // Create a blob URL from the received blob data
      var blob = new Blob([this.response], { type: "application/pdf" });
      var url = URL.createObjectURL(blob);

      // Open the PDF in a new tab or window
      window.open(url);
    }
  };

  // Send the request to the server
  xhr.send();
}
