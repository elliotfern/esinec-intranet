<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo '<div class="container">';
echo '<h1>Facturación</h1>';
echo '<h2>Mostrando todas las facturase emitidas</h2>';

echo "<hr>";

echo '<div class="'.TABLE_DIV_CLASS.'">';
echo '<table class="table table-striped datatable" id="orders-table">
    <thead class="'.TABLE_THREAD.'">
    <tr>
        <th>Número factura</th>
        <th>Cliente</th>
        <th>Fecha</th>
        <th>Producto</th>
        <th>Neto</th>
        <th>IVA</th>
        <th>Total</th>
        <th>Método de pago</th>
        <th>Estado</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <tr>
   
    </tr>
    </tbody>
    </table>
    </div>';

?>

<script>

$(document).ready(function () {
    tablaFacturasAll();
});


function tablaFacturasAll() {
  var server = window.location.hostname;
  var urlAjax = "https://" + server + "/controller/facturacion.php?type=facturas";
  var table = $("#orders-table").dataTable({
    pageLength: 50,
    ajax: {
      url: urlAjax,
      type: "POST",
      dataSrc: "",
    },

    order: [[2, "DESC"]],
    columns: [
      { data: "invoice_number" },
      { data: "_billing_first_name" },
      { data: "user_email" },
      { data: "billing_city" },
      { data: "telephone" },
    ],

    columnDefs: [
      {
        // # NUMERO FACTURA
        //
        targets: [0],
        type: "text",
        visible: true,
        render: function (data, type, row, meta) {
          if (row.invoice_number === null) {
            return row.order_id;
          } else {
            return row.invoice_number;
          }
        },
      },

      {
        // # NOMBRE Y APELLIDOS
        //
        targets: [1],
        type: "text",
        visible: true,
        render: function (data, type, row, meta) {
          if (row._billing_first_name === null) {
            return row._billing_last_name;
          } else {
            return row._billing_first_name + ' ' + row._billing_last_name;
          }
        },
      },

      {
        // # FECHA FACTURA
        //
        targets: [2],
        type: "date",
        visible: true,
        render: function (data, type, row, meta) {
          if (row.post_date === null) {
            return 'Sin fecha';
          } else {
            const date = new Date(row.post_date);
            const formattedDate = date.toISOString().slice(0, 10);
            return formattedDate;
          }
        },
      },

      {
        // # PRODUCTO
        //
        targets: [3],
        type: "text",
        visible: true,
        render: function (data, type, row, meta) {
          if (row.order_items === null) {
            return row.order_items;
          } else {
            const str = row.order_items;
            const newStr = str.replace(/\|ES-IVA 21%-1/g, "");
            return '<strong>' + newStr + '</strong>';
          }
        },
      },

      {
        // # NETO
        //
        targets: [4],
        type: "text",
        visible: true,
        render: function (data, type, row, meta) {
          if (row.order_total === null) {
            return row.order_total;
          } else {
            let tax = Number(row.order_tax);
            let total = Number(row.order_total);
            let subtotal = total - tax;
            let subtotal_format = subtotal.toLocaleString('de-DE', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            return subtotal_format + '€';
          }
        },
      },

      {
        // # IVA
        //
        targets: [5],
        type: "number",
        visible: true,
        render: function (data, type, row, meta) {
          if (row.order_tax === null) {
            return '';
          } else {
            let tax2 = Number(row.order_tax);
            let tax_format = tax2.toLocaleString('de-DE', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            return tax_format + '€';
          }
        },
      },

      {
        // # TOTAL
        //
        targets: [6],
        type: "number",
        visible: true,
        render: function (data, type, row, meta) {
          if (row.order_total === null) {
            return '';
          } else {
            let total = row.order_total;
            let total2 = Number(total);
            let total_format = total2.toLocaleString('de-DE', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            return '<strong>' + total_format + '€</strong>';
          }
        },
      },

      {
        // # METODO PAGO
        //
        targets: [7],
        type: "text",
        visible: true,
        render: function (data, type, row, meta) {
          if (row.payment_type === null) {
            return '';
          } else {
            return row.payment_type;
          }
        },
      },

      {
        // # ESTADO
        //
        targets: [8],
        type: "text",
        visible: true,
        render: function (data, type, row, meta) {
          if (row.post_status === "wc-completed") {
            return 'Pago completado';
          } else {
            return row.post_status;
          }
        },
      },

      {
        // # STATUS
        // https://datatables.net/examples/advanced_init/column_render.html
        //
        targets: [9],
        visible: true,
        render: function (data, type, row, meta) {
          return (
            '<a href="https://esinec.com/wp-admin/user-edit.php?user_id=' +
            row.ID +
            '" class="btn btn-primary btn-sm" role="button" aria-pressed="true" target="_blank">Ver detalles</a>'
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
          columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
        },
      },
      {
        extend: "excelHtml5",
        text: "Excel",
        filename: "table_data",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
        },
      },
    ],
  });
  setInterval(function () {
    table.api().ajax.reload(null, false); // user paging is not reset on reload
  }, 15000);
}
</script>

<?php
echo "</div>";


//include_once('modals-clientes.php');

# footer
include_once(APP_ROOT. '/inc/footer.php');