    </main>

    <!-- Footer -->
    <footer id="footer-principal" class="footer">
        <div class="footer-container">
            <div class="footer-grid">
                <div class="footer-col">
                    <h3 class="footer-titulo"><?php echo $nombre_tienda ?? 'VOLTKICKS'; ?></h3>
                    <p class="footer-texto">Ingeniería de velocidad. Zapatos de alto rendimiento diseñados para atletas de élite.</p>
                    <!-- Link externo (requisito: hipervínculo a sitio externo) -->
                    <a href="https://www.nike.com/mx" target="_blank" class="footer-link-externo" id="link-externo-nike">Visita Nike México ↗</a>
                </div>
                <div class="footer-col">
                    <h4 class="footer-subtitulo">NAVEGACIÓN</h4>
                    <ul class="footer-lista">
                        <li><a href="index.php" class="footer-link">Inicio</a></li>
                        <li><a href="catalogo.php" class="footer-link">Catálogo</a></li>
                        <li><a href="carrito.php" class="footer-link">Carrito</a></li>
                        <li><a href="reportes.php" class="footer-link">Reportes</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4 class="footer-subtitulo">CATEGORÍAS</h4>
                    <ul class="footer-lista">
                        <li><a href="catalogo.php?cat=1" class="footer-link">Running</a></li>
                        <li><a href="catalogo.php?cat=2" class="footer-link">Basketball</a></li>
                        <li><a href="catalogo.php?cat=3" class="footer-link">Lifestyle</a></li>
                        <li><a href="catalogo.php?cat=4" class="footer-link">Training</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4 class="footer-subtitulo">CONTACTO</h4>
                    <p class="footer-texto">contacto@voltkicks.com</p>
                    <p class="footer-texto">+52 (55) 1234-5678</p>
                    <div class="footer-social">
                        <a href="#redes" class="social-link" id="link-social-ig">Instagram</a>
                        <a href="#redes" class="social-link" id="link-social-tw">Twitter</a>
                        <a href="#redes" class="social-link" id="link-social-fb">Facebook</a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>© 2026 <?php echo $nombre_tienda ?? 'VOLTKICKS'; ?> — Equipo 1. Todos los derechos reservados.</p>
                <p class="footer-creditos">Proyecto de Sitio Web 2026-2 | Diseño con Stitch AI</p>
            </div>
        </div>
    </footer>

    <script src="js/main.js"></script>
</body>
</html>
