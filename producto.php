<?php
session_start();
$pagina_activa = 'catalogo';

// Obtener producto
$id = isset($_GET['id']) ? intval($_GET['id']) : 1;
$producto = null;

@include 'includes/conexion.php';
if (isset($conexion) && !$conexion->connect_error) {
    $stmt = $conexion->prepare("SELECT p.*, c.nombre as categoria FROM productos p LEFT JOIN categorias c ON p.categoria_id = c.id WHERE p.id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) $producto = $result->fetch_assoc();
}

// Si el producto no existe en la base de datos, cargar datos por defecto
if (!$producto) {
    $productos_defecto = [
        1 => ['id'=>1,'nombre'=>'PHANTOM X-1','precio'=>3499,'imagen'=>'zapato1.png','categoria'=>'Running','descripcion'=>'Ingeniería de élite. Placas de propulsión con infusión de carbono y amortiguación de alta respuesta para un máximo retorno de energía.','tallas'=>'22,23,24,25,26,27,28'],
        2 => ['id'=>2,'nombre'=>'ZENITH COURT','precio'=>3299,'imagen'=>'zapato2.png','categoria'=>'Basketball','descripcion'=>'Domina la cancha con tecnología Zenith de soporte lateral avanzado y suela adherente de máxima tracción.','tallas'=>'23,24,25,26,27,28'],
        3 => ['id'=>3,'nombre'=>'VOLT NITRO','precio'=>2799,'imagen'=>'zapato3.png','categoria'=>'Lifestyle','descripcion'=>'Estilo urbano con rendimiento atlético. Malla ultraligera con costuras en naranja eléctrico.','tallas'=>'22,23,24,25,26,27'],
        4 => ['id'=>4,'nombre'=>'KINETIC FORCE','precio'=>2999,'imagen'=>'zapato4.png','categoria'=>'Training','descripcion'=>'Entrenamiento de alto impacto. Diseño futurista con acentos naranja sobre malla de carbón.','tallas'=>'23,24,25,26,27,28'],
        5 => ['id'=>5,'nombre'=>'APEX VELOCITY','precio'=>3599,'imagen'=>'zapato5.png','categoria'=>'Basketball','descripcion'=>'Basketball de élite. Naranja eléctrico audaz con texturas de malla y cuero.','tallas'=>'24,25,26,27,28'],
        6 => ['id'=>6,'nombre'=>'TITAN GRIP','precio'=>3199,'imagen'=>'zapato6.png','categoria'=>'Training','descripcion'=>'Cross-training de alta tecnología con diseño futurista.','tallas'=>'22,23,24,25,26,27,28'],
    ];
    $producto = $productos_defecto[$id] ?? $productos_defecto[1];
}

$titulo_pagina = $producto['nombre'];
$tallas = explode(',', $producto['tallas'] ?? '22,23,24,25,26,27,28');
include 'includes/header.php';
?>

    <!-- Breadcrumbs -->
    <div class="breadcrumbs" id="breadcrumbs">
        <a href="index.php">INICIO</a><span>›</span>
        <a href="catalogo.php">CATÁLOGO</a><span>›</span>
        <strong style="color:var(--primary)"><?php echo $producto['nombre']; ?></strong>
    </div>

    <section class="section" style="padding-top:24px;">
        <div class="two-col" id="detalle-producto">
            <!-- Galería de Imágenes -->
            <div>
                <div style="background:var(--surface-container);border-radius:var(--radius-lg);overflow:hidden;margin-bottom:16px;">
                    <img src="img/<?php echo $producto['imagen']; ?>" alt="<?php echo $producto['nombre']; ?>" id="img-principal" style="width:100%;aspect-ratio:1;object-fit:cover;">
                </div>
                <div style="display:flex;gap:12px;">
                    <?php
                    $imgs = ['zapato1.png','zapato2.png','zapato3.png','zapato4.png'];
                    foreach($imgs as $i => $thumb): ?>
                    <img src="img/<?php echo $thumb; ?>" alt="Vista <?php echo $i+1; ?>" class="thumb-img"
                         style="width:80px;height:80px;object-fit:cover;border-radius:var(--radius-sm);cursor:pointer;border:2px solid <?php echo $thumb === $producto['imagen'] ? 'var(--primary)' : 'transparent'; ?>;opacity:<?php echo $thumb === $producto['imagen'] ? '1' : '0.6'; ?>;"
                         onclick="document.getElementById('img-principal').src='img/<?php echo $thumb; ?>';this.parentElement.querySelectorAll('img').forEach(i=>{i.style.borderColor='transparent';i.style.opacity='0.6'});this.style.borderColor='var(--primary)';this.style.opacity='1';"
                         id="thumb-<?php echo $i; ?>">
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Info del Producto -->
            <div>
                <p style="font-size:12px;color:var(--on-surface-variant);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:8px;"><?php echo $producto['categoria'] ?? 'Running'; ?></p>
                <h1 style="font-size:48px;font-weight:800;margin-bottom:16px;" id="nombre-producto"><?php echo $producto['nombre']; ?></h1>
                <p style="font-size:32px;font-weight:800;color:var(--primary);margin-bottom:24px;font-family:var(--font-headline);" id="precio-producto">$<?php echo number_format($producto['precio'],2); ?> MXN</p>
                <p style="font-size:16px;color:var(--on-surface-variant);line-height:1.7;margin-bottom:32px;"><?php echo $producto['descripcion']; ?></p>

                <!-- Selector de Talla -->
                <div style="margin-bottom:24px;">
                    <label class="form-label">SELECCIONA TU TALLA</label>
                    <div class="size-grid" id="selector-talla">
                        <?php foreach($tallas as $t): ?>
                        <div class="size-chip" data-talla="<?php echo trim($t); ?>"><?php echo trim($t); ?></div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Colores -->
                <div style="margin-bottom:24px;">
                    <label class="form-label">COLOR</label>
                    <div style="display:flex;gap:12px;">
                        <div class="color-swatch selected" style="width:36px;height:36px;border-radius:50%;background:#1a1a1a;border:2px solid var(--primary);cursor:pointer;" id="color-negro"></div>
                        <div class="color-swatch" style="width:36px;height:36px;border-radius:50%;background:#ff571a;border:2px solid transparent;cursor:pointer;" id="color-naranja"></div>
                        <div class="color-swatch" style="width:36px;height:36px;border-radius:50%;background:#e3e2e2;border:2px solid transparent;cursor:pointer;" id="color-blanco"></div>
                    </div>
                </div>

                <!-- Cantidad -->
                <div style="margin-bottom:32px;">
                    <label class="form-label">CANTIDAD</label>
                    <div class="qty-control">
                        <button class="qty-btn" id="qty-menos">−</button>
                        <span style="font-weight:700;font-size:18px;min-width:40px;text-align:center;" id="qty-valor">1</span>
                        <button class="qty-btn" id="qty-mas">+</button>
                    </div>
                </div>

                <!-- Botones -->
                <div style="display:flex;gap:16px;flex-wrap:wrap;">
                    <button class="btn-primary" style="flex:1;padding:18px;" id="btn-agregar-carrito"
                            onclick="agregarAlCarrito(<?php echo $producto['id']; ?>,'<?php echo $producto['nombre']; ?>',<?php echo $producto['precio']; ?>,'<?php echo $producto['imagen']; ?>')">
                        AGREGAR AL CARRITO
                    </button>
                    <a href="carrito.php" class="btn-secondary" style="flex:1;padding:18px;text-align:center;" id="btn-comprar-ahora">COMPRAR AHORA</a>
                    <button class="btn-secondary" onclick="toggleFavorito(<?php echo $producto['id']; ?>,'<?php echo $producto['nombre']; ?>',<?php echo $producto['precio']; ?>,'<?php echo $producto['imagen']; ?>', event)" style="padding:18px; flex:0 0 60px; display:flex; align-items:center; justify-content:center;" title="Favoritos">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                    </button>
                </div>

                <!-- Especificaciones -->
                <div style="margin-top:48px;border-top:1px solid rgba(255,255,255,0.06);padding-top:32px;">
                    <h3 style="font-size:18px;margin-bottom:20px;">ESPECIFICACIONES</h3>
                    <table class="data-table" id="tabla-specs">
                        <tr><td style="color:var(--on-surface-variant);width:40%;">Material</td><td>Carbon Mesh Premium</td></tr>
                        <tr><td style="color:var(--on-surface-variant);">Suela</td><td>Nitro-Grip Rubber</td></tr>
                        <tr><td style="color:var(--on-surface-variant);">Peso</td><td>240g</td></tr>
                        <tr><td style="color:var(--on-surface-variant);">Tipo</td><td><?php echo $producto['categoria'] ?? 'High-Performance'; ?></td></tr>
                        <tr><td style="color:var(--on-surface-variant);">Drop</td><td>8mm</td></tr>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Productos Relacionados -->
    <section class="section" id="relacionados">
        <h2 class="section-title">COMPLEMENTA TU <span style="color:var(--primary)">EQUIPO</span></h2>
        <div class="product-grid" style="grid-template-columns:repeat(3,1fr);">
            <?php
            $rel = [
                ['id'=>5,'nombre'=>'APEX VELOCITY','precio'=>3599,'imagen'=>'zapato5.png','categoria'=>'Basketball'],
                ['id'=>4,'nombre'=>'KINETIC FORCE','precio'=>2999,'imagen'=>'zapato4.png','categoria'=>'Training'],
                ['id'=>6,'nombre'=>'TITAN GRIP','precio'=>3199,'imagen'=>'zapato6.png','categoria'=>'Training'],
            ];
            foreach($rel as $r): ?>
            <div class="product-card">
                <a href="producto.php?id=<?php echo $r['id']; ?>"><img src="img/<?php echo $r['imagen']; ?>" alt="<?php echo $r['nombre']; ?>" class="product-card-img"></a>
                <div class="product-card-body">
                    <div class="product-card-category"><?php echo $r['categoria']; ?></div>
                    <div class="product-card-name"><?php echo $r['nombre']; ?></div>
                    <div class="product-card-price">$<?php echo number_format($r['precio'],2); ?> MXN</div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

<?php include 'includes/footer.php'; ?>
