<?php
session_start();
$pagina_activa = 'favoritos';
$titulo_pagina = 'Mis Favoritos';
include 'includes/header.php';
?>

<section class="section" style="padding-top:100px;">
    <h1 class="section-title">MIS <span style="color:var(--primary)">FAVORITOS</span></h1>
    <div id="favoritos-container" class="product-grid">
        <!-- Los favoritos se cargarán aquí vía JavaScript -->
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('favoritos-container');
    const favs = JSON.parse(localStorage.getItem('voltkicks_favoritos') || '[]');
    
    if (favs.length === 0) {
        container.innerHTML = `
            <div style="grid-column: 1 / -1; text-align:center; padding:60px 0;">
                <p style="font-size:48px; margin-bottom:16px;">🤍</p>
                <h3 style="font-family:var(--font-headline); font-size:24px; margin-bottom:8px;">TU LISTA DE FAVORITOS ESTÁ VACÍA</h3>
                <p style="color:var(--on-surface-variant);">Agrega productos haciendo clic en el corazón.</p>
                <a href="catalogo.php" class="btn-primary" style="margin-top:24px; display:inline-flex;">EXPLORAR CATÁLOGO</a>
            </div>
        `;
        return;
    }
    
    let html = '';
    favs.forEach(p => {
        html += `
        <div class="product-card" id="fav-${p.id}">
            <a href="producto.php?id=${p.id}">
                <img src="img/${p.imagen}" alt="${p.nombre}" class="product-card-img">
            </a>
            <div class="product-card-body">
                <div class="product-card-name">${p.nombre}</div>
                <div class="product-card-price">$${p.precio.toLocaleString('es-MX', {minimumFractionDigits:2})} MXN</div>
                <div class="product-card-actions" style="margin-top:16px;">
                    <a href="producto.php?id=${p.id}" class="btn-secondary" style="flex:1;">VER DETALLES</a>
                    <button class="btn-primary" onclick="toggleFavorito(${p.id}, '${p.nombre}', ${p.precio}, '${p.imagen}', event)" style="padding:10px; flex:0 0 40px;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="#fff" stroke="#fff" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                    </button>
                </div>
            </div>
        </div>`;
    });
    container.innerHTML = html;
});
</script>

<?php include 'includes/footer.php'; ?>
