<?php
session_start();
$pagina_activa = 'carrito';
$titulo_pagina = 'Carrito y Pago';

// Procesar pedido si se envía el formulario
$pedido_exitoso = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre_cliente'])) {
    @include 'includes/conexion.php';
    if (isset($conexion) && !$conexion->connect_error) {
        $nombre = $conexion->real_escape_string($_POST['nombre_cliente']);
        $email = $conexion->real_escape_string($_POST['email']);
        $telefono = $conexion->real_escape_string($_POST['telefono'] ?? '');
        $direccion = $conexion->real_escape_string($_POST['direccion']);
        $ciudad = $conexion->real_escape_string($_POST['ciudad'] ?? '');
        $cp = $conexion->real_escape_string($_POST['codigo_postal'] ?? '');
        $estado = $conexion->real_escape_string($_POST['estado_select'] ?? '');
        $metodo = $conexion->real_escape_string($_POST['metodo_envio'] ?? 'estandar');
        $terminos = isset($_POST['acepta_terminos']) ? 1 : 0;
        $newsletter = isset($_POST['newsletter']) ? 1 : 0;
        $regalo = isset($_POST['envolver_regalo']) ? 1 : 0;
        $notas = $conexion->real_escape_string($_POST['notas'] ?? '');
        $total = floatval($_POST['total'] ?? 0);

        $sql = "INSERT INTO pedidos (nombre_cliente, email, telefono, direccion, ciudad, codigo_postal, estado, metodo_envio, acepta_terminos, newsletter, envolver_regalo, notas, total) VALUES ('$nombre','$email','$telefono','$direccion','$ciudad','$cp','$estado','$metodo',$terminos,$newsletter,$regalo,'$notas',$total)";
        
        if ($conexion->query($sql)) {
            $pedido_id = $conexion->insert_id;
            $carrito_json = json_decode($_POST['carrito_json'] ?? '[]', true);
            foreach ($carrito_json as $item) {
                $pid = intval($item['id']);
                $talla = $conexion->real_escape_string($item['talla']);
                $qty = intval($item['cantidad']);
                $sub = floatval($item['precio']) * $qty;
                $conexion->query("INSERT INTO detalle_pedido (pedido_id, producto_id, talla, cantidad, subtotal) VALUES ($pedido_id, $pid, '$talla', $qty, $sub)");
            }
            $pedido_exitoso = true;
        }
    }
}

include 'includes/header.php';
?>

<?php if ($pedido_exitoso): ?>
    <section class="section" style="padding-top:120px;text-align:center;">
        <div style="font-size:72px;margin-bottom:24px;">✓</div>
        <h1 class="section-title" style="color:var(--primary);">¡PEDIDO REALIZADO!</h1>
        <p style="font-size:18px;color:var(--on-surface-variant);margin-bottom:32px;">Tu pedido #<?php echo $pedido_id; ?> ha sido registrado exitosamente.</p>
        <a href="index.php" class="btn-primary">VOLVER AL INICIO</a>
        <script>sessionStorage.removeItem('voltkicks_carrito');</script>
    </section>
<?php else: ?>
    <section class="section" style="padding-top:100px;">
        <h1 class="section-title" id="titulo-carrito">TU <span style="color:var(--primary)">CARRITO</span></h1>

        <div class="two-col">
            <!-- Cart Items -->
            <div>
                <div id="cart-items"></div>
                <div class="cart-total-section" id="cart-summary">
                    <div class="cart-total-row"><span>Subtotal</span><span id="cart-subtotal">$0.00</span></div>
                    <div class="cart-total-row"><span>Envío</span><span id="cart-envio">GRATIS</span></div>
                    <div class="cart-total-row total"><span>TOTAL</span><span id="cart-total">$0.00</span></div>
                </div>
            </div>

            <!-- Formulario de Pedido -->
            <div>
                <form method="POST" action="carrito.php" onsubmit="return validarPedido(event)" id="form-pedido">
                    <h2 style="font-family:var(--font-headline);font-size:24px;font-weight:700;margin-bottom:32px;">FINALIZAR PEDIDO</h2>

                    <!-- Datos Personales -->
                    <h3 style="font-size:14px;color:var(--primary);margin-bottom:16px;letter-spacing:0.08em;">DATOS PERSONALES</h3>
                    <div class="form-group">
                        <label class="form-label" for="nombre_cliente">NOMBRE COMPLETO</label>
                        <input type="text" class="form-input" id="nombre_cliente" name="nombre_cliente" required placeholder="Tu nombre completo">
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                        <div class="form-group">
                            <label class="form-label" for="email">EMAIL</label>
                            <input type="email" class="form-input" id="email" name="email" required placeholder="tu@email.com">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="telefono">TELÉFONO</label>
                            <input type="tel" class="form-input" id="telefono" name="telefono" placeholder="55 1234 5678">
                        </div>
                    </div>

                    <!-- Dirección -->
                    <h3 style="font-size:14px;color:var(--primary);margin:24px 0 16px;letter-spacing:0.08em;">DIRECCIÓN DE ENVÍO</h3>
                    <div class="form-group">
                        <label class="form-label" for="direccion">DIRECCIÓN</label>
                        <input type="text" class="form-input" id="direccion" name="direccion" required placeholder="Calle, número, colonia">
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px;">
                        <div class="form-group">
                            <label class="form-label" for="ciudad">CIUDAD</label>
                            <input type="text" class="form-input" id="ciudad" name="ciudad" placeholder="Ciudad">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="codigo_postal">C.P.</label>
                            <input type="text" class="form-input" id="codigo_postal" name="codigo_postal" placeholder="06600" maxlength="5">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="estado_select">ESTADO</label>
                            <select class="form-select" id="estado_select" name="estado_select">
                                <option value="">Selecciona...</option>
                                <option>CDMX</option><option>Aguascalientes</option><option>Baja California</option>
                                <option>Chihuahua</option><option>Guanajuato</option><option>Jalisco</option>
                                <option>Estado de México</option><option>Monterrey</option><option>Nuevo León</option>
                                <option>Oaxaca</option><option>Puebla</option><option>Querétaro</option>
                                <option>Quintana Roo</option><option>Sonora</option><option>Yucatán</option>
                            </select>
                        </div>
                    </div>

                    <!-- Método de Envío (Radio buttons) -->
                    <h3 style="font-size:14px;color:var(--primary);margin:24px 0 16px;letter-spacing:0.08em;">MÉTODO DE ENVÍO</h3>
                    <div class="form-radio-group">
                        <label class="form-radio"><input type="radio" name="metodo_envio" value="estandar" data-costo="0" checked> Estándar — Gratis (5-7 días)</label>
                        <label class="form-radio"><input type="radio" name="metodo_envio" value="express" data-costo="150"> Express — $150 (2-3 días)</label>
                        <label class="form-radio"><input type="radio" name="metodo_envio" value="same_day" data-costo="300"> Same Day — $300 (hoy)</label>
                    </div>

                    <!-- Opciones Adicionales (Checkboxes) -->
                    <h3 style="font-size:14px;color:var(--primary);margin:24px 0 16px;letter-spacing:0.08em;">OPCIONES ADICIONALES</h3>
                    <div class="form-check-group">
                        <label class="form-check"><input type="checkbox" id="acepta_terminos" name="acepta_terminos" required> Acepto los términos y condiciones</label>
                        <label class="form-check"><input type="checkbox" name="newsletter"> Suscribirme al newsletter de VoltKicks</label>
                        <label class="form-check"><input type="checkbox" name="envolver_regalo"> Envolver para regalo</label>
                    </div>

                    <!-- Notas (Textarea) -->
                    <div class="form-group" style="margin-top:24px;">
                        <label class="form-label" for="notas">NOTAS DEL PEDIDO</label>
                        <textarea class="form-textarea" id="notas" name="notas" placeholder="Instrucciones especiales de entrega..."></textarea>
                    </div>

                    <!-- Botones de Acción -->
                    <div style="display:flex;gap:16px;margin-top:32px;">
                        <button type="submit" class="btn-primary" style="flex:2;padding:18px;" id="btn-realizar-pedido">REALIZAR PEDIDO</button>
                        <a href="catalogo.php" class="btn-secondary" style="flex:1;padding:18px;text-align:center;" id="btn-seguir-comprando">SEGUIR COMPRANDO</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
