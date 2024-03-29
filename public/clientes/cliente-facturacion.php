<?php
// woocommerce restful api get customer all orders with meta key wcpdf_invoice_number

$rootDirectory = $_SERVER['DOCUMENT_ROOT'];
$substring = "/public_html/gestion";
$result = str_replace($substring, "", $rootDirectory);
$path = $result . "/pass/connection.php";

require_once($path);
require_once(APP_ROOT. '/vendor/autoload.php');
require_once(APP_ROOT. '/inc/php/functions.php');

use Automattic\WooCommerce\Client;

if(isset($params['id'])) {
    $id = $params['id'];
}

echo '<div class="container">';
echo '<h1>Gestión de Clientes</h1>';
echo '<h2>Historial de facturación del cliente</h2>';

echo "<hr>";

// Authenticate with the API
$woocommerce = new Client(
    'https://esinec.com/',
     WC_API_KEY, 
     WC_API_SECRET,
    [
        'version' => 'wc/v3',
    ]
);

// Get the customer ID
$customer_id = $id;

// Retrieve the customer information
$customer = $woocommerce->get("customers/$customer_id");

$state = $customer->billing->state;
 if ($state == 'A') {
    $stateNom = 'Álava';
} elseif ($state == 'AB') {
    $stateNom = 'Albacete';
} elseif ($state == 'AL') {
    $stateNom = 'Alicante';
} elseif ($state == 'AM') {
    $stateNom = 'Almería';
} elseif ($state == 'O') {
    $stateNom = 'Asturias';
} elseif ($state == 'AV') {
    $stateNom = 'Ávila';
} elseif ($state == 'BA') {
    $stateNom = 'Badajoz';
} elseif ($state == 'PM') {
    $stateNom = 'Baleares';
} elseif ($state == 'B') {
    $stateNom = 'Barcelona';
} elseif ($state == 'BU') {
    $stateNom = 'Burgos';
} elseif ($state == 'CC') {
    $stateNom = 'Cáceres';
} elseif ($state == 'CA') {
    $stateNom = 'Cádiz';
} elseif ($state == 'S') {
    $stateNom = 'Cantabria';
} elseif ($state == 'CS') {
    $stateNom = 'Castellón';
} elseif ($state == 'CE') {
    $stateNom = 'Ceuta';
} elseif ($state == 'CR') {
    $stateNom = 'Ciudad Real';
} elseif ($state == 'CO') {
    $stateNom = 'Córdoba';
} elseif ($state == 'CU') {
    $stateNom = 'Cuenca';
} elseif ($state == 'GI') {
    $stateNom = 'Girona';
} elseif ($state == 'GR') {
    $stateNom = 'Granada';
} elseif ($state == 'GU') {
    $stateNom = 'Guadalajara';
} elseif ($state == 'SS') {
    $stateNom = 'Guipúzcoa';
} elseif ($state == 'H') {
    $stateNom = 'Huelva';
} elseif ($state == 'HU') {
    $stateNom = 'Huesca';
} elseif ($state == 'J') {
    $stateNom = 'Jaén';
} elseif ($state == 'LO') {
    $stateNom = 'La Rioja';
} elseif ($state == 'GC') {
    $stateNom = 'Las Palmas';
} elseif ($state == 'LE') {
    $stateNom = 'León';
} elseif ($state == 'L') {
    $stateNom = 'Lleida';
} elseif ($state == 'LU') {
    $stateNom = 'Lugo';
} elseif ($state == 'M') {
    $stateNom = 'Madrid';
} elseif ($state == 'MA') {
    $stateNom = 'Málaga';
} elseif ($state == 'ML') {
    $stateNom = 'Melilla';
} elseif ($state == 'MU') {
    $stateNom = 'Murcia';
} elseif ($state == 'NA') {
    $stateNom = 'Navarra';
} elseif ($state == 'OR') {
    $stateNom = 'Ourense';
} elseif ($state == 'P') {
    $stateNom = 'Palencia';
} elseif ($state == 'PO') {
    $stateNom = 'Pontevedra';
} elseif ($state == 'SA') {
    $stateNom = 'Salamanca';
} elseif ($state == 'TF') {
    $stateNom = 'Santa Cruz de Tenerife';
} elseif ($state == 'SG') {
    $stateNom = 'Segovia';
} elseif ($state == 'SE') {
    $stateNom = 'Sevilla';
} elseif ($state == 'SO') {
    $stateNom = 'Soria';
} elseif ($state == 'T') {
    $stateNom = 'Tarragona';
} elseif ($state == 'TE') {
    $stateNom = 'Teruel';
} elseif ($state == 'TO') {
    $stateNom = 'Toledo';
} elseif ($state == 'V') {
    $stateNom = 'Valencia';
} elseif ($state == 'VA') {
    $stateNom = 'Valladolid';
} elseif ($state == 'BI') {
    $stateNom = 'Vizcaya';
} elseif ($state == 'ZA') {
    $stateNom = 'Zamora';
} elseif ($state == 'Z') {
    $stateNom = 'Zaragoza';
}

// Display the customer information
echo '<div class="customer-info">';
echo '<h4>Cliente:</h4>';

echo '<p><button type="button" class="btn btn-primary btn-sm" onclick="modificarDatosCliente('.$customer_id.')" data-bs-toggle="modal" data-bs-target="#modalModificarDatosCliente" data-variable="'.$customer_id.'">
Modificar datos del cliente &rarr;
</button></p>';

echo '<ul>
<li><strong>Nombre y apellidos</strong> : <a href="https://gestion.esinec.com/clientes/'.$customer_id.'/">' . $customer->first_name . ' '  . $customer->last_name .'</a></li>';
echo '<li><strong>Dirección:</strong> ' . $customer->billing->address_1 . '</li>';
echo '<li><strong>Ciudad:</strong> ' . $customer->billing->city . '</li>';
if ($customer->billing->country == "ES") {
    echo "<li><strong>Provincia: </strong>".$stateNom."</li>";
}
echo '<li><strong>País:</strong>';
if ($customer->billing->country == "ES") {
    echo " España</li>";
} else {
    echo  '' .$customer->billing->country . '</li>';
}
echo '<li><strong>Código Postal:</strong> ' . $customer->billing->postcode . '</li>';
echo '<li><strong>Email</strong> : ' . $customer->email . '</li>';
echo '<li><strong>Teléfono:</strong> ' . $customer->billing->phone . '</li>';


// Verificar si existe el meta value "_nif" (DNI) y mostrarlo
if (isset($customer->meta_data)) {
    foreach ($customer->meta_data as $meta) {
        if ($meta->key === 'billing_nif') {
            echo '<li><strong>DNI:</strong> ' . $meta->value . '</li>';
            break;
        }
    }
}
echo '</ul>';
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

echo '<h6>Facturas generadas en la web:</h6>';

echo '<a href="https://esinec.com/wp-admin/post-new.php?post_type=shop_order" class="btn btn-primary btn-sm" role="button" aria-pressed="true" target="_blank">Crear factura web &rarr;</a>';

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
        echo '<td><button type="button" id="btnFacturasGenerarPDF'.$order->id.'" class="btn btn-sm btn-warning" onclick="facturasWebGenerarPDF('.$order->id.')" value="'.$order->id.'">PDF</button></td>';
        echo '</tr>';
    }

    echo "</tbody>";
    echo "</table>";
    echo "</div>";
} else {
    echo '<div class="alert alert-danger" role="alert" style="margin-top:20px"><p>Este cliente no tiene ninguna factura en el sistema.</div></p>';
}

echo '<h6>Facturas generadas en la intranet:</h6>';

echo '<p><button type="button" id="btnGenerarFactura" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearFacturaIntranet" onclick="generarFacturaIntranet()">Crear factura &rarr;</button></p>';
?>
<input type="hidden" id="customerId" name="customerId" value="<?php echo $customer_id?>">
<input type='hidden' id='url' value='<?php echo APP_SERVER;?>'/>

        <div class="table-responsive" style='margin-top:20px;margin-bottom:25px'>
            <table class="table table-striped" id="facturasIntranet">
                <thead class="table-primary">
                <tr>
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
                    var urlAjax = urlRoot + "/controller/clientes.php?type=facturas-intranet&id="+idCustomer;
                    $.ajax({
                        url:urlAjax,
                        method:"POST",
                        dataType:"json",
                        success: function(data) {
                    if (data.length > 0) {
                        var html = '';
                        for (var i = 0; i < data.length; i++) {

                            var date = data[i].date;
                            var year = new Date(date).getFullYear();
                            var formattedDate = new Date(date).toLocaleDateString('en-GB', {
                                day: '2-digit',
                                month: '2-digit',
                                year: 'numeric'
                                });
                            var orderId = data[i].order_id;
                            var precio_neto = data[i].total;
                            var iva = data[i].tax;
                            var productName = data[i].product_name;
                            var productoVariante = data[i].productoVariante;

                            var precio_neto_net = parseFloat(precio_neto);
                            var iva_net = parseInt(iva);

                            var importeIva = precio_neto_net * (iva_net / 100);
                            var totalConIva = precio_neto_net + importeIva;

                            var totalConIva_net = Math.ceil(totalConIva * 100) / 100;
                            var importeIva_net = Math.ceil(importeIva * 100) / 100;

                            var precio_neto_net2 = new Intl.NumberFormat('es-ES', {
                                        style: 'currency',
                                        currency: 'EUR',
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2,
                                        useGrouping: true
                                 }).format(precio_neto_net);
                        
                            var importeIva_net2 = new Intl.NumberFormat('es-ES', {
                                        style: 'currency',
                                        currency: 'EUR',
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2,
                                        useGrouping: true
                                 }).format(importeIva_net);

                            var totalConIva_net2 = new Intl.NumberFormat('es-ES', {
                                        style: 'currency',
                                        currency: 'EUR',
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2,
                                        useGrouping: true
                                 }).format(totalConIva_net);

                            var payment = data[i].payment_method;
                            var invoice_number = data[i].invoice_number;
                            var numPago = data[i].numPago;

                            if (data[i].payment_method == 1) {
                                var paymentMethod = "Transferencia bancaria";
                            } else if (data[i].payment_method == 2) {
                                var paymentMethod = "Tarjeta";
                            } else if (data[i].payment_method == 3) {
                                var paymentMethod = "PayPal";
                            } else if (data[i].payment_method == 4) {
                                var paymentMethod = "Cash";
                            } else if (data[i].tipoPago == 5) {
                                html += 'Financiado Frakmenta';     
                            } else if (data[i].tipoPago == 6) {
                                html += 'Financiado Banc Sabadell';
                                        
                            } else if (data[i].tipoPago == 7) {
                                html += 'Domiciliado SEPA';
                            } else {
                                var paymentMethod = "";
                            }

                            var status = data[i].status;
                            if (status == 1) {
                                var statusName = "Pendiente de pago";
                            } else if (status == 2) {
                                var statusName = "Pagado";
                            } else if (status == 3) {
                                var statusName = "Cancelado";
                            } else {
                                var statusName = "";
                            }
                            
                            html += '<tr>';
                            html += '<td><a href="/../facturacion/intranet/'+orderId+'">ESINEC.' + year + '.' + invoice_number + '</a></td>';
                            html += '<td>' + formattedDate + '</td>';
                            html += '<td>' + productName + '';
                            if (productoVariante !== "") {
                                html += ' - ' + productoVariante + ' ';
                            } else {
                                html += '';
                            }
                            html += '</td>';
                            html += '<td>' + precio_neto_net2 + '</td>';
                            html += '<td>' + importeIva_net2 + '</td>';
                            html += '<td>' + totalConIva_net2 + '</td>';
                            html += '<td>' + paymentMethod + '</td>';
                            html += '<td>' + statusName + '</td>';
                            html += '<td>Pago ' + numPago + '</td>';

                            html += '<td><button type="button" onclick="modificarFacturaIntranet('+orderId+')" id="btnModificarFactura" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalModificarFactura" data-id="'+orderId+'" value="'+orderId+'" data-title="'+ orderId+ '" data-slug="'+ orderId+'" data-text="'+orderId+'">Modificar factura</button></td>';

                            html += '<td><button type="button" id="btnCrearFacturaIntranet'+orderId+'" class="btn btn-sm btn-warning" onclick="facturasIntranetGenerarPDF('+orderId+')">PDF</button></td>';

                            html += '</tr>';
                        }
                        $('#facturasIntranet tbody').html(html);
                        $('#facturasIntranet').show(); // Show the table if data is available
                    } else {
                        $('#facturasIntranet').hide(); // Hide the table if data is empty
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
<?php       

echo "<hr>";
echo '<h4>Cobros programados:</h4>';

echo '
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalCrearCobro" data-variable="'.$customer_id.'" onclick="nuevoCobroCliente('.$customer_id.')">
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
                <th></th>
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
                                    } else if (data[i].tipoPago == 5) {
                                            html += 'Financiado Frakmenta';
                                        
                                    } else if (data[i].tipoPago == 6) {
                                            html += 'Financiado Banc Sabadell';
                                        
                                    } else if (data[i].tipoPago == 7) {
                                            html += 'Domiciliado SEPA';
                                    }
                                html += '</td>';
                                
                                if (data[i].fecha == null) {
                                    html += '<td>Sin determinar</td>';
                                } else  {
                                    fecha2 = new Date(data[i].fecha).toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit', year: 'numeric' }) ;
                                    html += '<td>'+fecha2 + '</td>';
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
                                html += '<td><button type="button" id="btnModificaPagos' + data[i].id +'" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#btnModificaPagos" onclick="updateModalPagos(' + data[i].id +')">Modificar</button></td>';

                                html += '<td><button type="button" id="btnAvisoEmail-'+data[i].id+ '" onclick="AvisoEmailCobroProgramado('+data[i].id+')" class="btn btn-sm btn-primary">Aviso email</button></td>';
                                
                                html += '<td><button type="button" onclick="generarFacturaIntranet('+data[i].id+', '+data[i].estado+', '+data[i].IDproducto+', '+data[i].importe+', \'' + data[i].fecha + '\', '+idCustomer+', '+data[i].tipoPago+', '+data[i].numPago+')" id="btnCrearFacturaIntranet" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalCrearFacturaIntranet" data-id="'+data[i].id+ '" value="'+data[i].id+ '" data-title="'+data[i].id+ '" data-slug="'+data[i].id+ '" data-text="'+data[i].id+ '">Generar factura</button></td>';

                                html += '<td><button type="button" id="btnDeleteCobroProgramado" onclick="eliminarCobroProgramado('+data[i].id+')" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalEliminarCobroPendiente">Eliminar</button></td>';

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
<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalCrearInscripcion" data-variable="<?php echo $customer_id;?>" onclick="nuevoSubscripcionCliente(<?php echo $customer_id;?>)">
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
                                html += '<td> <button type="button" id="btnModificaInscripcion' + data[i].id +'" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalModificaInscripcion" onclick="updateInscripcion(' + data[i].id +')">Modificar datos</button></td>';

                                html += '<td> <button type="button" id="btnEliminarInscripcion-importeTotal' + data[i].id +'" class="btn btn-sm btn-danger" onclick="eliminarInscripcion(' + data[i].id +')">Eliminar</button></td>';

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