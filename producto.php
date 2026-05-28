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

// Fallback
if (!$producto) {
    $fallback = [
        1 => ['id'=>1,'nombre'=>'PHANTOM X-1','precio'=>3499,'imagen'=>'zapato1.png','categoria'=>'Running','descripcion'=>'Ingeniería de élite. Placas de propulsión con infusión de carbono y amortiguación de alta respuesta para un máximo retorno de energía.','tallas'=>'22,23,24,25,26,27,28'],
    ];
    $producto = $fallback[$id] ?? $fallback[1];
}

$titulo_pagina = $producto['nombre'];
$tallas = explode(',', $producto['tallas'] ?? '22,23,24,25,26,27,28');
include 'includes/header.php';
?>

    <div class="breadcrumbs" id="breadcrumbs">
        <a href="index.php">INICIO</a><span>›</span>
        <a href="catalogo.php">CATÁLOGO</a><span>›</span>
        <strong style="color:var(--primary)"><?php echo $producto['nombre']; ?></strong>
    </div>

    <section class="section" style="padding-top:24px;">
        <div class="two-col" id="detalle-producto">
            
            <div>
                <div style="background:var(--surface-container);border-radius:var(--radius-lg);overflow:hidden;margin-bottom:16px;">
                    <img src="img/<?php echo $producto['imagen']; ?>" alt="<?php echo $producto['nombre']; ?>" id="img-principal" style="width:100%;aspect-ratio:1;object-fit:cover;">
                </div>
                
                <div style="display:flex;gap:12px; flex-wrap: wrap;">
                    <?php
                    // Lógica: Toma el nombre base del archivo principal
                    $nombre_base = pathinfo($producto['imagen'], PATHINFO_FILENAME);
                    $imgs_disponibles = [$producto['imagen']]; // Incluye la principal
                    
                    // Intenta encontrar imágenes con sufijo 2, 3 y 4
                    for($i = 2; $i <= 4; $i++) {
                        $imgs_disponibles[] = $nombre_base . ' ' . $i . '.png';
                    }

                    foreach($imgs_disponibles as $i => $thumb): 
                        $ruta = 'img/' . $thumb;
                        // Solo muestra si el archivo existe en la carpeta img/
                        if(file_exists($ruta)): 
                    ?>
                        <img src="<?php echo $ruta; ?>" alt="Vista <?php echo $i+1; ?>" class="thumb-img"
                             style="width:80px;height:80px;object-fit:cover;border-radius:var(--radius-sm);cursor:pointer;
                                    border:2px solid <?php echo ($i === 0) ? 'var(--primary)' : 'transparent'; ?>;
                                    opacity:<?php echo ($i === 0) ? '1' : '0.6'; ?>;"
                             onclick="document.getElementById('img-principal').src='<?php echo $ruta; ?>'; 
                                      this.parentElement.querySelectorAll('img').forEach(el=>{el.style.borderColor='transparent';el.style.opacity='0.6'});
                                      this.style.borderColor='var(--primary)'; this.style.opacity='1';">
                    <?php 
                        endif;
                    endforeach; 
                    ?>
                </div>
            </div>

            <div>
                <p style="font-size:12px;color:var(--on-surface-variant);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:8px;"><?php echo $producto['categoria'] ?? 'Running'; ?></p>
                <h1 style="font-size:48px;font-weight:800;margin-bottom:16px;" id="nombre-producto"><?php echo $producto['nombre']; ?></h1>
                <p style="font-size:32px;font-weight:800;color:var(--primary);margin-bottom:24px;font-family:var(--font-headline);" id="precio-producto">$<?php echo number_format($producto['precio'],2); ?> MXN</p>
                <p style="font-size:16px;color:var(--on-surface-variant);line-height:1.7;margin-bottom:32px;"><?php echo $producto['descripcion']; ?></p>

                <div style="margin-bottom:24px;">
                    <label class="form-label">SELECCIONA TU TALLA</label>
                    <div class="size-grid" id="selector-talla">
                        <?php foreach($tallas as $t): ?>
                        <div class="size-chip" data-talla="<?php echo trim($t); ?>"><?php echo trim($t); ?></div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div style="display:flex;gap:16px;flex-wrap:wrap;">
                    <button class="btn-primary" style="flex:1;padding:18px;" onclick="agregarAlCarrito(<?php echo $producto['id']; ?>,'<?php echo $producto['nombre']; ?>',<?php echo $producto['precio']; ?>,'<?php echo $producto['imagen']; ?>')">AGREGAR AL CARRITO</button>
                    <a href="carrito.php" class="btn-secondary" style="flex:1;padding:18px;text-align:center;">COMPRAR AHORA</a>
                </div>

                <div style="margin-top:48px;border-top:1px solid rgba(255,255,255,0.06);padding-top:32px;">
                    <h3 style="font-size:18px;margin-bottom:20px;">ESPECIFICACIONES</h3>
                    <table class="data-table">
                        <tr><td style="color:var(--on-surface-variant);width:40%;">Material</td><td>Carbon Mesh Premium</td></tr>
                        <tr><td style="color:var(--on-surface-variant);">Suela</td><td>Nitro-Grip Rubber</td></tr>
                        <tr><td style="color:var(--on-surface-variant);">Tipo</td><td><?php echo $producto['categoria'] ?? 'High-Performance'; ?></td></tr>
                    </table>
                </div>
            </div>
        </div>
    </section>

<?php include 'includes/footer.php'; ?>
