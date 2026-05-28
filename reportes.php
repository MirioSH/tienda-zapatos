<?php
session_start();
$pagina_activa = 'reportes';
$titulo_pagina = 'Reportes de Ventas';
include 'includes/header.php';

// Obtener datos para reportes
$pedidos = [];
$top_productos = [];
$catalogo = [];
$total_ventas = 0;
$total_pedidos = 0;
$promedio = 0;
$mejor_producto = 'PHANTOM X-1';

@include 'includes/conexion.php';
if (isset($conexion) && !$conexion->connect_error) {
    // Total ventas
    $r = $conexion->query("SELECT SUM(total) as total, COUNT(*) as num FROM pedidos WHERE estatus != 'Cancelado'");
    if ($r && $row = $r->fetch_assoc()) {
        $total_ventas = $row['total'] ?? 0;
        $total_pedidos = $row['num'] ?? 0;
        $promedio = $total_pedidos > 0 ? $total_ventas / $total_pedidos : 0;
    }

    // Pedidos recientes
    $r = $conexion->query("SELECT * FROM pedidos ORDER BY fecha DESC LIMIT 10");
    if ($r) while ($row = $r->fetch_assoc()) $pedidos[] = $row;

    // Top productos
    $r = $conexion->query("SELECT p.nombre, SUM(d.cantidad) as total_qty FROM detalle_pedido d JOIN productos p ON d.producto_id = p.id GROUP BY p.id ORDER BY total_qty DESC LIMIT 4");
    if ($r) while ($row = $r->fetch_assoc()) $top_productos[] = $row;

    // Catálogo
    $r = $conexion->query("SELECT p.*, c.nombre as categoria FROM productos p LEFT JOIN categorias c ON p.categoria_id = c.id");
    if ($r) while ($row = $r->fetch_assoc()) $catalogo[] = $row;

    if (!empty($top_productos)) $mejor_producto = $top_productos[0]['nombre'];
}

// Datos estáticos por si la base de datos está vacía
if (empty($pedidos)) {
    $total_ventas = 124500; $total_pedidos = 48; $promedio = 2593.75;
    $pedidos = [
        ['id'=>1,'nombre_cliente'=>'Carlos Méndez','fecha'=>'2026-05-20 14:30','total'=>6798,'estatus'=>'Completado'],
        ['id'=>2,'nombre_cliente'=>'Ana García','fecha'=>'2026-05-21 10:15','total'=>3499,'estatus'=>'Completado'],
        ['id'=>3,'nombre_cliente'=>'Roberto López','fecha'=>'2026-05-23 16:45','total'=>5998,'estatus'=>'Pendiente'],
        ['id'=>4,'nombre_cliente'=>'María Fernández','fecha'=>'2026-05-24 09:00','total'=>2799,'estatus'=>'Completado'],
        ['id'=>5,'nombre_cliente'=>'Luis Torres','fecha'=>'2026-05-25 11:30','total'=>3599,'estatus'=>'Cancelado'],
    ];
    $top_productos = [
        ['nombre'=>'PHANTOM X-1','total_qty'=>450],
        ['nombre'=>'TITAN GRIP','total_qty'=>320],
        ['nombre'=>'VOLT NITRO','total_qty'=>280],
        ['nombre'=>'APEX VELOCITY','total_qty'=>210],
    ];
    $catalogo = [
        ['id'=>1,'nombre'=>'PHANTOM X-1','categoria'=>'Running','precio'=>3499,'stock'=>45,'imagen'=>'zapato1.png'],
        ['id'=>2,'nombre'=>'ZENITH COURT','categoria'=>'Basketball','precio'=>3299,'stock'=>30,'imagen'=>'zapato2.png'],
        ['id'=>3,'nombre'=>'VOLT NITRO','categoria'=>'Lifestyle','precio'=>2799,'stock'=>60,'imagen'=>'zapato3.png'],
        ['id'=>4,'nombre'=>'KINETIC FORCE','categoria'=>'Training','precio'=>2999,'stock'=>40,'imagen'=>'zapato4.png'],
        ['id'=>5,'nombre'=>'APEX VELOCITY','categoria'=>'Basketball','precio'=>3599,'stock'=>25,'imagen'=>'zapato5.png'],
        ['id'=>6,'nombre'=>'TITAN GRIP','categoria'=>'Training','precio'=>3199,'stock'=>55,'imagen'=>'zapato6.png'],
    ];
}
$max_qty = !empty($top_productos) ? max(array_column($top_productos, 'total_qty')) : 450;
?>

    <section class="section" style="padding-top:100px;">
        <h1 class="section-title" id="titulo-reportes">REPORTES DE <span style="color:var(--primary)">VENTAS</span></h1>

        <!-- Summary Cards -->
        <div class="summary-grid" id="cards-resumen">
            <div class="summary-card">
                <div class="summary-card-label">TOTAL VENTAS</div>
                <div class="summary-card-value">$<?php echo number_format($total_ventas, 0); ?></div>
                <div class="summary-card-sub">MXN</div>
            </div>
            <div class="summary-card">
                <div class="summary-card-label">PEDIDOS REALIZADOS</div>
                <div class="summary-card-value"><?php echo $total_pedidos; ?></div>
                <div class="summary-card-sub">Total acumulado</div>
            </div>
            <div class="summary-card">
                <div class="summary-card-label">PRODUCTO MÁS VENDIDO</div>
                <div class="summary-card-value" style="font-size:22px;"><?php echo $mejor_producto; ?></div>
            </div>
            <div class="summary-card">
                <div class="summary-card-label">PROMEDIO POR PEDIDO</div>
                <div class="summary-card-value">$<?php echo number_format($promedio, 0); ?></div>
                <div class="summary-card-sub">MXN</div>
            </div>
        </div>

        <!-- Pedidos Recientes -->
        <div style="margin-bottom:64px;">
            <h2 style="font-size:24px;font-weight:700;margin-bottom:24px;">PEDIDOS RECIENTES</h2>
            <div style="overflow-x:auto;border-radius:var(--radius-lg);border:1px solid rgba(255,255,255,0.04);">
                <table class="data-table" id="tabla-pedidos">
                    <thead><tr><th>ID</th><th>CLIENTE</th><th>FECHA</th><th>TOTAL</th><th>ESTADO</th></tr></thead>
                    <tbody>
                    <?php foreach($pedidos as $p): ?>
                        <tr>
                            <td style="font-weight:600;">#<?php echo str_pad($p['id'],4,'0',STR_PAD_LEFT); ?></td>
                            <td><?php echo $p['nombre_cliente']; ?></td>
                            <td style="color:var(--on-surface-variant);"><?php echo date('d/m/Y H:i', strtotime($p['fecha'])); ?></td>
                            <td style="font-weight:700;">$<?php echo number_format($p['total'],2); ?></td>
                            <td><span class="status-<?php echo strtolower($p['estatus']); ?>"><?php echo $p['estatus']; ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Top Productos -->
        <div style="margin-bottom:64px;">
            <h2 style="font-size:24px;font-weight:700;margin-bottom:24px;">TOP PRODUCTOS</h2>
            <div style="background:var(--surface-container);border-radius:var(--radius-lg);padding:32px;">
                <?php foreach($top_productos as $tp): ?>
                <div class="progress-bar-container">
                    <div class="progress-bar-label">
                        <span style="font-weight:600;"><?php echo $tp['nombre']; ?></span>
                        <span style="color:var(--primary);font-weight:700;"><?php echo $tp['total_qty']; ?> uds</span>
                    </div>
                    <div class="progress-bar-track">
                        <div class="progress-bar-fill" style="width:<?php echo ($tp['total_qty']/$max_qty)*100; ?>%"></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Catálogo Actual -->
        <div>
            <h2 style="font-size:24px;font-weight:700;margin-bottom:24px;">PRODUCTOS EN CATÁLOGO</h2>
            <div style="overflow-x:auto;border-radius:var(--radius-lg);border:1px solid rgba(255,255,255,0.04);">
                <table class="data-table" id="tabla-catalogo">
                    <thead><tr><th>ID</th><th>IMAGEN</th><th>NOMBRE</th><th>CATEGORÍA</th><th>PRECIO</th><th>STOCK</th></tr></thead>
                    <tbody>
                    <?php foreach($catalogo as $c): ?>
                        <tr>
                            <td><?php echo $c['id']; ?></td>
                            <td><img src="img/<?php echo $c['imagen']; ?>" alt="<?php echo $c['nombre']; ?>" style="width:48px;height:48px;object-fit:cover;border-radius:4px;"></td>
                            <td style="font-weight:700;"><?php echo $c['nombre']; ?></td>
                            <td style="color:var(--on-surface-variant);"><?php echo $c['categoria']; ?></td>
                            <td style="color:var(--primary);font-weight:700;">$<?php echo number_format($c['precio'],2); ?></td>
                            <td><?php echo $c['stock']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

<?php include 'includes/footer.php'; ?>
