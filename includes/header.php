<?php
if (!isset($pagina_activa)) $pagina_activa = 'inicio';
$nombre_tienda = 'VOLTKICKS';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="VoltKicks - Tienda de zapatos deportivos de alto rendimiento. Equipo 1.">
    <title><?php echo $nombre_tienda; ?> | <?php echo $titulo_pagina ?? 'Engineered Velocity'; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Hanken+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <!-- CSS -->
    <?php if (isset($css_pagina)): ?>
    <style><?php echo $css_pagina; ?></style>
    <?php endif; ?>
</head>
<body>

    <!-- Integrantes -->
    <div id="equipo-info" class="equipo-badge">
        <span class="equipo-label">EQUIPO 1</span>
        <span class="equipo-nombres">
<<<<<<< Updated upstream
            Arroyo Llanes Miguel Alejandro<br>
            González Frías Ana Paula<br>
            Soto Huerta Gustavo Isaac<br>
            Trujillo Salazar Wendy Jazmin
=======
            • Arroyo Llanes Miguel Alejandro<br>
            • González Frías Ana Paula<br>
            • Soto Huerta Gustavo Isaac<br>
            • Trujillo Salazar Wendy Jazmin
>>>>>>> Stashed changes
        </span>
    </div>

    <!-- Navegación -->
    <nav id="nav-principal" class="nav-glass">
        <div class="nav-container">
            <a href="index.php" class="nav-logo" id="logo-link">
                <img src="img/logo.png" alt="<?php echo $nombre_tienda; ?> Logo" class="logo-img" id="logo-imagen">
                <span class="logo-text"><?php echo $nombre_tienda; ?></span>
            </a>
            <ul class="nav-links" id="menu-navegacion">
                <li><a href="index.php" class="nav-link <?php echo $pagina_activa === 'inicio' ? 'activo' : ''; ?>" id="link-inicio">INICIO</a></li>
                <li><a href="catalogo.php" class="nav-link <?php echo $pagina_activa === 'catalogo' ? 'activo' : ''; ?>" id="link-catalogo">CATÁLOGO</a></li>
                <li><a href="carrito.php" class="nav-link <?php echo $pagina_activa === 'carrito' ? 'activo' : ''; ?>" id="link-carrito">CARRITO</a></li>
                <li><a href="reportes.php" class="nav-link <?php echo $pagina_activa === 'reportes' ? 'activo' : ''; ?>" id="link-reportes">REPORTES</a></li>
            </ul>
            <a href="carrito.php" class="nav-cart" id="boton-carrito">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"></path>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <path d="M16 10a4 4 0 01-8 0"></path>
                </svg>
                <?php
                $total_carrito = 0;
                if (isset($_SESSION['carrito'])) {
                    foreach ($_SESSION['carrito'] as $item) {
                        $total_carrito += $item['cantidad'];
                    }
                }
                if ($total_carrito > 0):
                ?>
                <span class="cart-count" id="contador-carrito"><?php echo $total_carrito; ?></span>
                <?php endif; ?>
            </a>
        </div>
    </nav>

    <main id="contenido-principal">
