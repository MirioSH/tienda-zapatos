/**
 * VoltKicks - JavaScript Principal
 * Equipo 1
 * Incluye: Carrito (sessionStorage), animaciones, interactividad
 */

// ============================================
// CARRITO DE COMPRAS (Client-side)
// ============================================
const Carrito = {
  items: JSON.parse(sessionStorage.getItem('voltkicks_carrito') || '[]'),

  guardar() {
    sessionStorage.setItem('voltkicks_carrito', JSON.stringify(this.items));
    this.actualizarContador();
  },

  agregar(producto) {
    const existente = this.items.find(i => i.id === producto.id && i.talla === producto.talla);
    if (existente) {
      existente.cantidad++;
    } else {
      this.items.push({ ...producto, cantidad: 1 });
    }
    this.guardar();
    this.mostrarNotificacion(`${producto.nombre} agregado al carrito`);
  },

  eliminar(index) {
    this.items.splice(index, 1);
    this.guardar();
  },

  actualizarCantidad(index, delta) {
    this.items[index].cantidad += delta;
    if (this.items[index].cantidad <= 0) this.items.splice(index, 1);
    this.guardar();
  },

  getTotal() {
    return this.items.reduce((sum, i) => sum + (i.precio * i.cantidad), 0);
  },

  getCantidadTotal() {
    return this.items.reduce((sum, i) => sum + i.cantidad, 0);
  },

  actualizarContador() {
    const badge = document.getElementById('contador-carrito');
    const total = this.getCantidadTotal();
    if (badge) {
      badge.textContent = total;
      badge.style.display = total > 0 ? 'flex' : 'none';
    }
  },

  mostrarNotificacion(msg) {
    const noti = document.createElement('div');
    noti.className = 'notificacion';
    noti.innerHTML = `<span>✓</span> ${msg}`;
    noti.style.cssText = `
      position:fixed; bottom:24px; right:24px; z-index:9999;
      background:#ff571a; color:#fff; padding:16px 24px; border-radius:8px;
      font-family:'Outfit',sans-serif; font-weight:600; font-size:14px;
      box-shadow:0 8px 32px rgba(255,77,0,0.3); animation: slideIn 0.3s ease;
    `;
    document.body.appendChild(noti);
    setTimeout(() => { noti.style.opacity = '0'; setTimeout(() => noti.remove(), 300); }, 2500);
  },

  vaciar() { this.items = []; this.guardar(); }
};

// ============================================
// SELECTOR DE TALLA
// ============================================
function initSizeSelector() {
  document.querySelectorAll('.size-chip').forEach(chip => {
    chip.addEventListener('click', function() {
      this.closest('.size-grid').querySelectorAll('.size-chip').forEach(c => c.classList.remove('selected'));
      this.classList.add('selected');
    });
  });
}

// ============================================
// AGREGAR AL CARRITO - Catálogo
// ============================================
function agregarAlCarrito(id, nombre, precio, imagen) {
  const tallaSeleccionada = '25'; // Default
  Carrito.agregar({ id, nombre, precio: parseFloat(precio), imagen, talla: tallaSeleccionada });
}

// ============================================
// PERSONALIZACIÓN DE PRODUCTO (Detalle)
// ============================================
function initProductoDetalle() {
  const qtyDisplay = document.getElementById('qty-valor');
  const btnMenos = document.getElementById('qty-menos');
  const btnMas = document.getElementById('qty-mas');
  if (!qtyDisplay) return;
  let qty = 1;
  btnMenos?.addEventListener('click', () => { if(qty > 1) { qty--; qtyDisplay.textContent = qty; }});
  btnMas?.addEventListener('click', () => { if(qty < 10) { qty++; qtyDisplay.textContent = qty; }});

  // Color selector
  document.querySelectorAll('.color-swatch').forEach(swatch => {
    swatch.addEventListener('click', function() {
      document.querySelectorAll('.color-swatch').forEach(s => s.classList.remove('selected'));
      this.classList.add('selected');
    });
  });
}

// ============================================
// RENDERIZAR CARRITO EN PÁGINA
// ============================================
function renderCarrito() {
  const container = document.getElementById('cart-items');
  if (!container) return;
  if (Carrito.items.length === 0) {
    container.innerHTML = `<div style="text-align:center;padding:60px 0;">
      <p style="font-size:48px;margin-bottom:16px;">🛒</p>
      <h3 style="font-family:var(--font-headline);font-size:24px;margin-bottom:8px;">TU CARRITO ESTÁ VACÍO</h3>
      <p style="color:var(--on-surface-variant);">Agrega productos desde el catálogo</p>
      <a href="catalogo.php" class="btn-primary" style="margin-top:24px;display:inline-flex;">EXPLORAR CATÁLOGO</a>
    </div>`;
    document.getElementById('cart-summary')?.remove();
    return;
  }
  let html = '';
  Carrito.items.forEach((item, i) => {
    html += `<div class="cart-item" id="cart-item-${i}">
      <img src="img/${item.imagen}" alt="${item.nombre}" class="cart-item-img">
      <div class="cart-item-info">
        <div class="cart-item-name">${item.nombre}</div>
        <div style="font-size:13px;color:var(--on-surface-variant);">Talla: ${item.talla}</div>
        <div class="qty-control">
          <button class="qty-btn" onclick="actualizarQty(${i},-1)">−</button>
          <span style="font-weight:700">${item.cantidad}</span>
          <button class="qty-btn" onclick="actualizarQty(${i},1)">+</button>
        </div>
      </div>
      <div style="text-align:right;">
        <div class="cart-item-price">$${(item.precio * item.cantidad).toLocaleString('es-MX', {minimumFractionDigits:2})}</div>
        <button class="cart-item-remove" onclick="eliminarItem(${i})">✕ Eliminar</button>
      </div>
    </div>`;
  });
  container.innerHTML = html;

  // Totales
  const subtotal = Carrito.getTotal();
  const envioSelect = document.querySelector('input[name="metodo_envio"]:checked');
  let envio = 0;
  if (envioSelect) envio = parseFloat(envioSelect.dataset.costo || 0);
  const total = subtotal + envio;
  const sumEl = document.getElementById('cart-subtotal');
  const totEl = document.getElementById('cart-total');
  const envioEl = document.getElementById('cart-envio');
  if (sumEl) sumEl.textContent = `$${subtotal.toLocaleString('es-MX',{minimumFractionDigits:2})}`;
  if (envioEl) envioEl.textContent = envio > 0 ? `$${envio.toLocaleString('es-MX',{minimumFractionDigits:2})}` : 'GRATIS';
  if (totEl) totEl.textContent = `$${total.toLocaleString('es-MX',{minimumFractionDigits:2})}`;
}

function actualizarQty(i, delta) { Carrito.actualizarCantidad(i, delta); renderCarrito(); }
function eliminarItem(i) { Carrito.eliminar(i); renderCarrito(); }

// ============================================
// FILTRO DE CATÁLOGO
// ============================================
function filtrarProductos() {
  const cats = Array.from(document.querySelectorAll('.filter-cat:checked')).map(c => c.value);
  const cards = document.querySelectorAll('.product-card');
  cards.forEach(card => {
    const cat = card.dataset.categoria;
    card.style.display = (cats.length === 0 || cats.includes(cat)) ? '' : 'none';
  });
}

// ============================================
// ANIMACIONES DE SCROLL (Intersection Observer)
// ============================================
function initScrollAnimations() {
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.1 });
  document.querySelectorAll('.product-card, .summary-card, .section').forEach(el => {
    el.style.opacity = '0'; el.style.transform = 'translateY(20px)';
    el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    observer.observe(el);
  });
}

// Add 'visible' class styles
const style = document.createElement('style');
style.textContent = `.visible { opacity: 1 !important; transform: translateY(0) !important; }
@keyframes slideIn { from { transform: translateX(100px); opacity: 0; } to { transform: translateX(0); opacity: 1; } }`;
document.head.appendChild(style);

// ============================================
// VALIDACIÓN DE FORMULARIO
// ============================================
function validarPedido(event) {
  event.preventDefault();
  const form = event.target;
  const nombre = form.querySelector('#nombre_cliente');
  const email = form.querySelector('#email');
  const direccion = form.querySelector('#direccion');
  const terminos = form.querySelector('#acepta_terminos');

  let errores = [];
  if (!nombre?.value.trim()) errores.push('Nombre es requerido');
  if (!email?.value.trim() || !email.value.includes('@')) errores.push('Email válido es requerido');
  if (!direccion?.value.trim()) errores.push('Dirección es requerida');
  if (terminos && !terminos.checked) errores.push('Debes aceptar los términos');
  if (Carrito.items.length === 0) errores.push('El carrito está vacío');

  if (errores.length > 0) {
    alert('Corrige los siguientes errores:\n\n' + errores.join('\n'));
    return false;
  }

  // Agregar items del carrito al formulario como campos ocultos
  const carritoInput = document.createElement('input');
  carritoInput.type = 'hidden';
  carritoInput.name = 'carrito_json';
  carritoInput.value = JSON.stringify(Carrito.items);
  form.appendChild(carritoInput);

  const totalInput = document.createElement('input');
  totalInput.type = 'hidden';
  totalInput.name = 'total';
  totalInput.value = Carrito.getTotal();
  form.appendChild(totalInput);

  form.submit();
  return true;
}

// ============================================
// INICIALIZACIÓN
// ============================================
document.addEventListener('DOMContentLoaded', () => {
  Carrito.actualizarContador();
  initSizeSelector();
  initProductoDetalle();
  initScrollAnimations();
  renderCarrito();

  // Radio envío recalcula total
  document.querySelectorAll('input[name="metodo_envio"]').forEach(r => {
    r.addEventListener('change', renderCarrito);
  });
});
