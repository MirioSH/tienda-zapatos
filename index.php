<?php
session_start();
$pagina_activa = 'inicio';
$titulo_pagina = 'Engineered Velocity';
include 'includes/header.php';
?>

    <!-- Hero Section -->
    <section class="hero" id="hero-section">
        <div class="hero-content">
            <div>
                <p style="font-family:var(--font-headline);font-size:14px;font-weight:700;color:var(--primary);letter-spacing:0.1em;margin-bottom:16px;">ENGINEERED VELOCITY</p>
                <h1 class="hero-title">DOMINA<br>CADA<br><span style="color:var(--primary);">PASO</span></h1>
                <p class="hero-subtitle">Tecnología de vanguardia fusionada con diseño atlético premium. Cada par es una obra maestra de ingeniería creada para el rendimiento extremo.</p>
                <div style="display:flex;gap:16px;flex-wrap:wrap;">
                    <a href="catalogo.php" class="btn-primary" id="btn-explorar">EXPLORAR CATÁLOGO</a>
                    <a href="#destacados" class="btn-secondary" id="btn-destacados">VER DESTACADOS</a>
                </div>
            </div>
            <div style="text-align:center;">
                <img src="img/hero-sneaker.png" alt="VoltKicks Hero Sneaker" class="hero-img" id="hero-img">
            </div>
        </div>
    </section>

    <!-- Productos Destacados -->
    <section class="section" id="destacados">
        <h2 class="section-title">COLECCIÓN <span style="color:var(--primary)">DESTACADA</span></h2>
        <div class="product-grid">
            <?php
            // Cargar productos desde la base de datos
            $productos = [];
            @include 'includes/conexion.php';
            if (isset($conexion) && !$conexion->connect_error) {
                $result = $conexion->query("SELECT p.*, c.nombre as categoria FROM productos p LEFT JOIN categorias c ON p.categoria_id = c.id WHERE p.destacado = 1 LIMIT 6");
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) $productos[] = $row;
                }
            }
            // Productos por defecto si la base de datos no está disponible
            if (empty($productos)) {
                $productos = [
                    ['id'=>1,'nombre'=>'PHANTOM X-1','precio'=>3499,'imagen'=>'zapato1.png','categoria'=>'Running'],
                    ['id'=>2,'nombre'=>'ZENITH COURT','precio'=>3299,'imagen'=>'zapato2.png','categoria'=>'Basketball'],
                    ['id'=>3,'nombre'=>'VOLT NITRO','precio'=>2799,'imagen'=>'zapato3.png','categoria'=>'Lifestyle'],
                    ['id'=>4,'nombre'=>'KINETIC FORCE','precio'=>2999,'imagen'=>'zapato4.png','categoria'=>'Training'],
                    ['id'=>5,'nombre'=>'APEX VELOCITY','precio'=>3599,'imagen'=>'zapato5.png','categoria'=>'Basketball'],
                    ['id'=>6,'nombre'=>'TITAN GRIP','precio'=>3199,'imagen'=>'zapato6.png','categoria'=>'Training'],
                ];
            }
            foreach ($productos as $p):
            ?>
            <div class="product-card" data-categoria="<?php echo $p['categoria'] ?? ''; ?>" id="producto-<?php echo $p['id']; ?>">
                <a href="producto.php?id=<?php echo $p['id']; ?>">
                    <img src="img/<?php echo $p['imagen']; ?>" alt="<?php echo $p['nombre']; ?>" class="product-card-img">
                </a>
                <div class="product-card-body">
                    <div class="product-card-category"><?php echo $p['categoria'] ?? 'Running'; ?></div>
                    <div class="product-card-name"><?php echo $p['nombre']; ?></div>
                    <div class="product-card-price">$<?php echo number_format($p['precio'], 2); ?> MXN</div>
                    <div class="product-card-actions" style="gap:8px;">
                        <a href="producto.php?id=<?php echo $p['id']; ?>" class="btn-secondary" style="flex:1; text-align:center;">VER DETALLES</a>
                        <button class="btn-primary" style="flex:1;" onclick="agregarAlCarrito(<?php echo $p['id']; ?>,'<?php echo $p['nombre']; ?>',<?php echo $p['precio']; ?>,'<?php echo $p['imagen']; ?>')">AGREGAR</button>
                        <button class="btn-secondary" onclick="toggleFavorito(<?php echo $p['id']; ?>,'<?php echo $p['nombre']; ?>',<?php echo $p['precio']; ?>,'<?php echo $p['imagen']; ?>', event)" style="padding:10px; flex:0 0 40px; display:flex; align-items:center; justify-content:center;" title="Favoritos">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Sección de video promocional -->
    <section class="section video-section" id="seccion-video">
        <h2 class="section-title">VELOCIDAD EN <span style="color:var(--primary)">MOVIMIENTO</span></h2>
        <div class="video-container">
            <video id="video-promo" controls muted loop playsinline poster="img/hero-sneaker.png">
                <!-- Agregar un video corto aquí si se tiene -->
                <source src="media/promo.mp4" type="video/mp4">
                <p style="padding:40px;color:var(--on-surface-variant);">Tu navegador no soporta video HTML5.</p>
            </video>
        </div>
        <p style="color:var(--on-surface-variant);margin-top:16px;font-size:14px;">Video promocional VoltKicks © 2026</p>
    </section>

    <!-- Stats Section -->
    <section class="section" id="stats-section">
        <div class="summary-grid" style="text-align:center;">
            <div class="summary-card">
                <div class="summary-card-value">240g</div>
                <div class="summary-card-label">PESO ULTRA LIGERO</div>
            </div>
            <div class="summary-card">
                <div class="summary-card-value">98%</div>
                <div class="summary-card-label">RETORNO ENERGÍA</div>
            </div>
            <div class="summary-card">
                <div class="summary-card-value">12+</div>
                <div class="summary-card-label">COLORES</div>
            </div>
            <div class="summary-card">
                <div class="summary-card-value">∞</div>
                <div class="summary-card-label">RENDIMIENTO</div>
            </div>
        </div>
    </section>

<?php include 'includes/footer.php'; ?>
