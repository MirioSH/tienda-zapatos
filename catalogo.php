<?php
session_start();
$pagina_activa = 'catalogo';
$titulo_pagina = 'Catálogo';
include 'includes/header.php';

// Cargar productos
$productos = [];
@include 'includes/conexion.php';
if (isset($conexion) && !$conexion->connect_error) {
    $sql = "SELECT p.*, c.nombre as categoria FROM productos p LEFT JOIN categorias c ON p.categoria_id = c.id";
    if (isset($_GET['cat']) && is_numeric($_GET['cat'])) {
        $sql .= " WHERE p.categoria_id = " . intval($_GET['cat']);
    }
    $sql .= " ORDER BY p.id ASC";
    $result = $conexion->query($sql);
    if ($result && $result->num_rows > 0) while ($row = $result->fetch_assoc()) $productos[] = $row;
}
if (empty($productos)) {
    $productos = [
        ['id'=>1,'nombre'=>'PHANTOM X-1','precio'=>3499,'imagen'=>'zapato1.png','categoria'=>'Running','descripcion'=>'Ingeniería de élite con placas de carbono.','categoria_id'=>1,'stock'=>45],
        ['id'=>2,'nombre'=>'ZENITH COURT','precio'=>3299,'imagen'=>'zapato2.png','categoria'=>'Basketball','descripcion'=>'Soporte lateral avanzado.','categoria_id'=>2,'stock'=>30],
        ['id'=>3,'nombre'=>'VOLT NITRO','precio'=>2799,'imagen'=>'zapato3.png','categoria'=>'Lifestyle','descripcion'=>'Estilo urbano premium.','categoria_id'=>3,'stock'=>60],
        ['id'=>4,'nombre'=>'KINETIC FORCE','precio'=>2999,'imagen'=>'zapato4.png','categoria'=>'Training','descripcion'=>'Entrenamiento de alto impacto.','categoria_id'=>4,'stock'=>40],
        ['id'=>5,'nombre'=>'APEX VELOCITY','precio'=>3599,'imagen'=>'zapato5.png','categoria'=>'Basketball','descripcion'=>'Basketball de élite.','categoria_id'=>2,'stock'=>25],
        ['id'=>6,'nombre'=>'TITAN GRIP','precio'=>3199,'imagen'=>'zapato6.png','categoria'=>'Training','descripcion'=>'Cross-training futurista.','categoria_id'=>4,'stock'=>55],
    ];
}
?>

    <section class="section" style="padding-top:100px;">
        <h1 class="section-title" id="titulo-catalogo">CATÁLOGO</h1>

        <div class="sidebar-layout">
            <!-- Sidebar Filtros -->
            <aside class="sidebar" id="filtros-sidebar">
                <div class="filter-section">
                    <h3>CATEGORÍA</h3>
                    <div class="form-check-group">
                        <label class="form-check"><input type="checkbox" class="filter-cat" value="Running" onchange="filtrarProductos()"> Running</label>
                        <label class="form-check"><input type="checkbox" class="filter-cat" value="Basketball" onchange="filtrarProductos()"> Basketball</label>
                        <label class="form-check"><input type="checkbox" class="filter-cat" value="Lifestyle" onchange="filtrarProductos()"> Lifestyle</label>
                        <label class="form-check"><input type="checkbox" class="filter-cat" value="Training" onchange="filtrarProductos()"> Training</label>
                    </div>
                </div>
                <div class="filter-section">
                    <h3>TALLA</h3>
                    <div class="size-grid">
                        <?php for($t=22;$t<=28;$t++): ?>
                        <div class="size-chip" id="talla-<?php echo $t; ?>"><?php echo $t; ?></div>
                        <?php endfor; ?>
                    </div>
                </div>
                <div class="filter-section">
                    <h3>PRECIO</h3>
                    <input type="range" min="2000" max="4000" value="4000" class="form-input" style="padding:8px;" id="filtro-precio">
                    <div style="display:flex;justify-content:space-between;font-size:12px;color:var(--on-surface-variant);margin-top:8px;">
                        <span>$2,000</span><span>$4,000</span>
                    </div>
                </div>
            </aside>

            <!-- Product Grid -->
            <div>
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
                    <p style="color:var(--on-surface-variant);font-size:14px;"><?php echo count($productos); ?> productos</p>
                    <select class="form-select" style="width:auto;padding:10px 40px 10px 16px;" id="sort-selector">
                        <option>Precio: Menor a Mayor</option>
                        <option>Precio: Mayor a Menor</option>
                        <option>Nombre: A-Z</option>
                    </select>
                </div>
                <div class="product-grid" id="grid-productos">
                    <?php foreach ($productos as $p): ?>
                    <div class="product-card" data-categoria="<?php echo $p['categoria']; ?>" data-precio="<?php echo $p['precio']; ?>" id="card-<?php echo $p['id']; ?>">
                        <a href="producto.php?id=<?php echo $p['id']; ?>">
                            <img src="img/<?php echo $p['imagen']; ?>" alt="<?php echo $p['nombre']; ?>" class="product-card-img">
                        </a>
                        <div class="product-card-body">
                            <div class="product-card-category"><?php echo $p['categoria']; ?></div>
                            <div class="product-card-name"><?php echo $p['nombre']; ?></div>
                            <div class="product-card-price">$<?php echo number_format($p['precio'],2); ?> MXN</div>
                            <div class="product-card-actions">
                                <a href="producto.php?id=<?php echo $p['id']; ?>" class="btn-secondary">VER DETALLES</a>
                                <button class="btn-primary" onclick="agregarAlCarrito(<?php echo $p['id']; ?>,'<?php echo $p['nombre']; ?>',<?php echo $p['precio']; ?>,'<?php echo $p['imagen']; ?>')">AGREGAR</button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

<?php include 'includes/footer.php'; ?>
