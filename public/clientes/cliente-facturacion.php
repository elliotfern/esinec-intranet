<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// woocommerce restful api get customer all orders with meta key wcpdf_invoice_number

require_once(APP_ROOT. '/vendor/autoload.php');

use Automattic\WooCommerce\Client;

$activePage = "clientes";

if(isset($params['id'])) {
    $id = $params['id'];
}

function wc_price( $price ) {
    $currency_symbol = '€'; // replace with your currency symbol
    $decimal_separator = ','; // replace with your decimal separator
    $thousands_separator = '.'; // replace with your thousands separator
    
    $price = number_format( $price, 2, $decimal_separator, $thousands_separator );
    
    return $price . $currency_symbol;
}

echo '<div class="container">';
echo '<h1>Gestión de Clientes</h1>';
echo '<h2>Historial de facturación del cliente</h2>';

echo "<hr>";

// Authenticate with the API
$woocommerce = new Client(
    'https://esinec.com/',
    'ck_abc55b466d19218f2c24bf114c098d799a966f4b',
    'cs_2e386b874b0dc0feff1b6af2cfeb11b77b7dd1d0',
    [
        'version' => 'wc/v3',
    ]
);

// Get the customer ID
$customer_id = $id;

// Retrieve the customer information
$customer = $woocommerce->get("customers/$customer_id");

// Display the customer information
echo '<div class="customer-info">';
echo '<h4>Cliente:</h4>';
echo '<p><strong>Nombre y apellidos</strong> : <a href="https://gestion.esinec.com/clientes/'.$customer_id.'/">' . $customer->first_name . ' '  . $customer->last_name .'</a><p>';
echo '<p><strong>Email</strong> : ' . $customer->email . '<p>';
echo '<p><strong>Teléfono:</strong> ' . $customer->billing->phone . '</p>';
echo '</div>';

// Retrieve all orders of the customer
$orders = $woocommerce->get('orders', [
    'customer' => $customer_id,
    'meta_key' => '_wcpdf_invoice_number',
    'orderby' => 'date', // Order the orders by date
    'order' => 'desc', // Show the most recent orders first
]);


echo "<hr>";
echo '<h4>Histórico de facturas:</h4>';

echo '<a href="https://esinec.com/wp-admin/post-new.php?post_type=shop_order" class="btn btn-primary btn-sm" role="button" aria-pressed="true" target="_blank">Crear factura &rarr;</a>';

if (!empty($orders)) {
    echo "<div class='table-responsive' style='margin-top:20px;margin-bottom:25px'>";
    echo "<table class='table table-striped'>";
    echo "<thead class='".TABLE_THREAD."'>";
    echo '<tr>
        <th>Número factura</th>
        <th>Fecha</th>
        <th>Producto</th>
        <th>Neto</th>
        <th>IVA</th>
        <th>Total</th>
        <th>Método de pago</th>
        <th>Estado</th>
        <th>Num pago</th>
        <th></th>
        </tr>
        </thead>
        <tbody>';

    foreach ($orders as $order) {
        $items = $order->line_items;
        $product_names = array();

        $total_tax = 0;
        $net_total = 0;

        foreach ($items as $item) {
            $product_names[] = $item->name;
            $total_tax += $item->total_tax;
        }
        $net_total += $order->total - $total_tax;

        $date = $order->date_created;
        $createDate = new DateTime($date);
        $strip = $createDate->format('d-m-Y');

        $total = $order->total;
        $total_form = str_replace('.', ',', $total);

        $wcpdf_invoice_number = '';
        $numero_pago = '';

        // find the meta object with key _wcpdf_invoice_number
        foreach ($order->meta_data as $meta) {
            if ($meta->key === '_wcpdf_invoice_number') {
                $wcpdf_invoice_number = $meta->value;
                break;
            }
        }
        foreach ($order->meta_data as $meta) {
            if ($meta->key === 'numero_pago') {
                $numero_pago = $meta->value;
                break;
            }
        }

        echo '<tr>';
        echo '<td>';
        if ($wcpdf_invoice_number == "") {
            echo '<a href="/../facturacion/'.$order->id.'">'.$order->id.'</a>';
        } else {
            echo '<a href="/../facturacion/'.$order->id.'">'. $wcpdf_invoice_number . '</a>';
        }
        echo '</td>';
        echo '<td>'.$strip.'</td>';
        echo '<td>' . implode(", ", $product_names) . '</td>';
        echo '<td>' . wc_price($net_total) . '</td>';
        echo '<td>' . wc_price($total_tax) . '</td>';
        echo '<td>'.$total_form.'€</td>';
        echo '<td>'.$order->payment_method_title.'</td>';
        echo '<td>'.$order->status.'</td>';
        echo '<td>'.$numero_pago.'</td>';
        echo '<td><a href="https://esinec.com/wp-admin/post.php?post='.$order->id.'&action=edit" class="btn btn-success btn-sm" role="button" aria-pressed="true" target="_blank">Modificar</a></td>';
        echo '</tr>';
    }

    echo "</tbody>";
    echo "</table>";
    echo "</div>";
} else {
    echo '<div class="alert alert-danger" role="alert" style="margin-top:20px"><p>Este cliente no tiene ninguna factura en el sistema.</div></p>';
}


echo "<hr>";
echo '<h4>Cobros programados:</h4>';

echo '
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalCrearCobro" data-variable="'.$customer_id.'">
Añadir nuevo cobro &rarr;
</button>';

?>
<input type="hidden" id="customerId" name="customerId" value="<?php echo $customer_id?>">
<input type='hidden' id='url' value='<?php echo APP_SERVER;?>'/>

        <div class="table-responsive" style='margin-top:20px;margin-bottom:25px'>
            <table class="table table-striped" id="cobrosPendientes">
                <thead class="table-primary">
                <tr>
                <th>Producto</th>
                <th>Importe</th>
                <th>Tipo de pago</th>
                <th>Fecha</th>
                <th>Núm. pago</th>
                <th>Estado</th>
                <th></th>
                <th></th>
            </thead>
            <tbody>
            </tbody>
        </table>
        </div>

        <script>
            $(document).ready(function(){
                function fetch_data(){
                    var urlRoot = $("#url").val();
                    var idCustomer = $("#customerId").val();
                    var urlAjax = urlRoot + "/controller/clientes.php?type=pagos-pendientes&id="+idCustomer;
                    $.ajax({
                        url:urlAjax,
                        method:"POST",
                        dataType:"json",
                        success: function(data) {
                    if (data.length > 0) {
                        var html = '';
                        for (var i = 0; i < data.length; i++) {
                            html += '<tr>';
                                html += '<td>'+data[i].post_title + '</td>';
                                var number = parseFloat(data[i].importe);
                                    var importeForm = new Intl.NumberFormat('es-ES', {
                                        style: 'currency',
                                        currency: 'EUR',
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2,
                                        useGrouping: true
                                 }).format(number);
                                html += '<td>'+ importeForm +'</td>';
                                html += '<td>';
                                    if (data[i].tipoPago == 1) {
                                    html += 'Transferencia bancaria';
                                    } else if (data[i].tipoPago == 2) {
                                        html += 'Cash';
                                    } else if (data[i].tipoPago == 4) {
                                        html += 'PayPal';
                                    } else if (data[i].tipoPago == 3) {
                                        html += 'Tarjeta / Stripe';
                                    }
                                html += '</td>';
                                
                                if (data[i].fecha == null) {
                                    html += '<td>Sin determinar</td>';
                                } else  {
                                    html += '<td>'+new Date(data[i].fecha).toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit', year: 'numeric' }) + '</td>';
                                }

                                html += '<td>';
                                    if (data[i].numPago == null) {
                                    html += 'Pago ?';
                                    } else {
                                        html += 'Pago '+data[i].numPago;
                                    }
                                html += '</td>';

                                html += '<td>';
                                    if (data[i].estado == 1) {
                                    html += 'Pendiente pago';
                                    } else if (data[i].estado == 2) {
                                    html += 'Pagado';
                                    }
                                html += '</td>';
                               
                                html += '<td>';
                                
                                if (data[i].estado == 1) {
                                    html += '<button type="button" onclick="btnCobrado('+data[i].id+')" id="btnCobrado" class="btn btn-sm btn-danger">¿Cobrado?</button>';
                                    } else if (data[i].estado == 2) {
                                        html += '<button type="button" class="btn btn-sm btn-warning">Pagado</button>';
                                    }
                                
                                html += '</td>';
                                html += '<td><button type="button" id="btnModificaPagos' + data[i].id +'" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#btnModificaPagos" onclick="updateModalPagos(' + data[i].id +')" value="'+data[i].id+ '" data-title="'+data[i].id+ '" data-slug="'+data[i].id+ '" data-text="'+data[i].id+ '">Modificar datos</button></td>';
                                html += '</tr>';
                        }
                        $('#cobrosPendientes tbody').html(html);
                        $('#cobrosPendientes').show(); // Show the table if data is available
                    } else {
                        $('#cobrosPendientes').hide(); // Hide the table if data is empty
                    }
                }
            });
        }
                fetch_data();
                setInterval(function(){
                    fetch_data();
                }, 5000);
            });
       </script>

<hr>
<h4>Inscripción curso:</h4>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalCrearInscripcion" data-variable="<?php echo $customer_id;?>">
Añadir nueva inscripción &rarr;
</button>

<input type="hidden" id="customerId" name="customerId" value="<?php echo $customer_id?>">
<input type='hidden' id='url' value='<?php echo APP_SERVER;?>'/>

        <div class="table-responsive" style='margin-top:20px;margin-bottom:25px'>
            <table class="table table-striped" id="inscripcionCurso">
                <thead class="table-primary">
                <tr>
                <th>Código</th>
                <th>Edición</th>
                <th>Importe total</th>
                <th>Captación comercial</th>
                <th>Comercial cierre</th>
                <th>Notas</th>
                <th></th>
        </tr>
            </thead>
            <tbody></tbody>
        </table>
        </div>

        <script>
    $(document).ready(function() {
        function fetch_data() {
            var urlRoot = $("#url").val();
            var idCustomer = $("#customerId").val();
            var urlAjax = urlRoot + "/controller/clientes.php?type=pago-total-cliente&id=" + idCustomer;
            $.ajax({
                url: urlAjax,
                method: "POST",
                dataType: "json",
                success: function(data) {
                    if (data.length > 0) {
                        var html = '';
                        for (var i = 0; i < data.length; i++) {
                            html += '<tr>';
                                html += '<td>'+data[i].codigo +'</td>';
                                if (data[i].asistencia == null) {
                                        html += '<td><a href="https://gestion.esinec.com/cursos/'+data[i].idEdicion + '">'+data[i].edicion + '</a></td>';
                                } else {
                                    html += '<td><a href="https://gestion.esinec.com/cursos/'+data[i].idEdicion + '">'+data[i].edicion + ' - ' + data[i].asistencia+'</a></td>';
                                }
                                    var number = parseFloat(data[i].importeTotal);
                                    var importeTotalForm = new Intl.NumberFormat('es-ES', {
                                        style: 'currency',
                                        currency: 'EUR',
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2,
                                        useGrouping: true
                                 }).format(number);
                                html += '<td>'+ importeTotalForm +'</td>';
                                if (data[i].comercial == null) {
                                    html += '<td>-</td>';
                                } else  {
                                    html += '<td>'+data[i].comercial + '</td>';
                                }
                                if (data[i].comercialCierre == null) {
                                        html += '<td>-</td>';
                                } else {
                                        html += '<td>'+data[i].comercialCierre+'</td>';
                                }
                                if (data[i].notas == null) {
                                        html += '<td>-</td>';
                                } else {
                                        html += '<td>'+data[i].notas+'</td>';
                                }
                                html += '<td> <button type="button" id="btnModificaInscripcion' + data[i].id +'" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalModificaInscripcion" onclick="updateInscripcion(' + data[i].id +')" value="'+data[i].id+ '" data-title="'+data[i].id+ '" data-slug="'+data[i].id+ '" data-text="'+data[i].id+ '">Modificar datos</button></td>';
                                html += '</tr>';
                        }
                        $('#inscripcionCurso tbody').html(html);
                        $('#inscripcionCurso').show(); // Show the table if data is available
                    } else {
                        $('#inscripcionCurso').hide(); // Hide the table if data is empty
                    }
                }
            });
        }

        fetch_data();
        setInterval(function() {
            fetch_data();
        }, 5000);
    });
</script>


</div>
<?php

include_once('modals-cliente-facturacion.php');

# footer
include_once(APP_ROOT. '/inc/footer.php');