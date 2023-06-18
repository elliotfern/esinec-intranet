$(document).ready(function () {
  tablaPagosPendientes();
  tablaPagosPendientesMensuales();
});

function tablaPagosPendientes() {
  var server = window.location.hostname;
  var urlAjax =
    "https://" + server + "/controller/facturacion.php?type=pagos-programados";
  var table = $("#pagosProgramadosClientes").dataTable({
    pageLength: 50,
    ajax: {
      url: urlAjax,
      type: "POST",
      dataSrc: "",
    },

    order: [[1, "asc"]],

    columnDefs: [
      {
        // # NOMBRE
        //
        targets: [0],
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
        targets: [1],
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
        // # TOTAL ENDEUDADO
        //
        targets: [2],
        type: "text",
        visible: true,
        render: function (data, type, row, meta) {
          if (row.importe === null) {
            return row.importe;
          } else {
            // Format the value in Spanish Euro format
            var formattedImporte = new Intl.NumberFormat("es-ES", {
              style: "currency",
              currency: "EUR",
              minimumFractionDigits: 2,
              maximumFractionDigits: 2,
              useGrouping: true,
            }).format(row.importe);

            // Wrap the formatted value in a <strong> element
            return "<strong>" + formattedImporte + "</strong>";
          }
        },
      },

      {
        // # VER DETALLES
        // https://datatables.net/examples/advanced_init/column_render.html
        //
        targets: [3],
        visible: true,
        render: function (data, type, row, meta) {
          return (
            '<a href="https://gestion.esinec.com/clientes/' +
            row.cliente +
            '/facturacion"><img src="https://gestion.esinec.com/inc/img/info.png" alt="Cliente" width="25" height="15"></a>'
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

function tablaPagosPendientesMensuales() {
  var server = window.location.hostname;
  var urlAjax =
    "https://" +
    server +
    "/controller/facturacion.php?type=pagos-programados-mensuales";
  var table = $("#pagosProgramadosClientesMensuales").dataTable({
    pageLength: 50,
    ajax: {
      url: urlAjax,
      type: "POST",
      dataSrc: "",
    },

    order: [[0, "asc"]],

    columnDefs: [
      {
        // # MES
        //
        targets: [0],
        type: "text",
        visible: true,
        render: function (data, type, row, meta) {
          if (row.mes_ano === null) {
            return "Sin determinar";
          } else {
            return row.mes_ano;
          }
        },
      },

      {
        // # TOTAL PAGOS
        //
        targets: [1],
        type: "text",
        visible: true,
        render: function (data, type, row, meta) {
          if (row.total_pagos === null) {
            return row.total_pagos;
          } else {
            return row.total_pagos;
          }
        },
      },

      {
        // # TOTAL ENDEUDADO
        //
        targets: [2],
        type: "text",
        visible: true,
        render: function (data, type, row, meta) {
          if (row.importe === null) {
            return row.importe;
          } else {
            // Format the value in Spanish Euro format
            var formattedImporte = new Intl.NumberFormat("es-ES", {
              style: "currency",
              currency: "EUR",
              minimumFractionDigits: 2,
              maximumFractionDigits: 2,
              useGrouping: true,
            }).format(row.importe);

            // Wrap the formatted value in a <strong> element
            return "<strong>" + formattedImporte + "</strong>";
          }
        },
      },

      {
        // # VER DETALLES
        // https://datatables.net/examples/advanced_init/column_render.html
        //
        targets: [3],
        visible: true,
        render: function (data, type, row, meta) {
          return (
            '<a href="https://gestion.esinec.com/clientes/' +
            row.cliente +
            '/facturacion"><img src="https://gestion.esinec.com/inc/img/info.png" alt="Cliente" width="25" height="15"></a>'
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
          columns: [1, 2, 3],
        },
      },
      {
        extend: "excelHtml5",
        text: "Excel",
        filename: "table_data",
        exportOptions: {
          columns: [1, 2, 3],
        },
      },
    ],
  });
  setInterval(function () {
    table.api().ajax.reload(null, false); // user paging is not reset on reload
  }, 15000);
}
