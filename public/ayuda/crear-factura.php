<?php

echo '<div class="container">';
echo '<h1>Ayuda</h1>';
echo '<h2>¿Cómo crear una factura?</h2>';

echo "<hr>";


echo '<h4>Primer paso:</h4>';
echo '<p>> Ir a "<a href="https://esinec.com/wp-admin/post-new.php?post_type=shop_order" target="_blank">crear pedido</a>"</p>';
echo '<p>> Si el cliente no existe en la base de datos, hay que crearlo. Ir a "<a href="https://esinec.com/wp-admin/user-new.php" target="_blank">dar de alta un nuevo usuario</a>". Marcar la opción <strong>"perfil : cliente"</strong></p>';

echo '<p>> Rellenar datos del cliente y detalles del pedido:</p>';

echo '<img src="'. APP_SERVER .'/inc/img/crear-factura1.jpg" alt="Factura" width="1200" height="585" style="margin-bottom:50px;">';

echo '<br>';

echo '<h4>Segundo paso:</h4>';

echo '<p>> Rellenar los datos de la factura:</p>';

echo '<img src="'. APP_SERVER .'/inc/img/crear-factura2.jpg" alt="Factura" width="1200" height="350" style="margin-bottom:50px">';

echo '<br>';

echo '<h4>Tercer paso:</h4>';

echo '<p>> Rellenar los metadatos de la factura:</p>';

echo '<img src="'. APP_SERVER .'/inc/img/crear-factura3.jpg" alt="Factura" width="1200" height="500" style="margin-bottom:50px">';


echo '<br>';

echo '<h4>Cuarto paso:</h4>';

echo '<p>> Incluir el producto comprado y el IVA.</p>';

echo '<p>> 1.Clicar en el botón "Añadir artículos".</p>';
echo '<p>> 2.Clicar en el botón "Añadir productos".</p>';
echo '<p>> 3. Buscar el producto, seleccionarlo y clicar en "Añadir".</p>';
echo '<p>> 4. Una vez el producto aparece en la factura, comprobar el precio del producto (SIN IVA)./p>';
echo '<p>> 5. Si el precio del producto no es correcto (SIN IVA), hay que modificarlo clicando el icono del lápiz. Hay dos campos, Antes del descuento y Total, los dos campos tienen que tener el mismo precio corregido. Una vez cambiado, clicar en "Guardar"</p>';
echo '<p>> 6. Volver a clicar en el botón de "Añadir artículo".</p>';

echo '<img src="'. APP_SERVER .'/inc/img/crear-factura4.jpg" alt="Factura" width="1200" height="345" style="margin-bottom:50px">';

echo '<p>> 7. Añadir impuesto > seleccionar IVA 21%.</p>';
echo '<p>> 8. Clicar en el boton "Recalcular" y aceptar.</p>';

echo '<img src="'. APP_SERVER .'/inc/img/crear-factura5.jpg" alt="Factura" width="1200" height="300" style="margin-bottom:50px">';

echo '<br>';

echo '<h4>Quinto paso:</h4>';

echo '<p>> Comprobar que todos los datos son correctos y clicar en el boton "Crear". Ya tenemos la nueva factura en el sistema.</p>';

echo '<img src="'. APP_SERVER .'/inc/img/crear-factura6.jpg" alt="Factura" width="1200" height="585" style="margin-bottom:50px">';

echo '</div>';


echo "</div>";

# footer
include_once(APP_ROOT. '/inc/footer.php');