# 📘 MANUAL DE USUARIO — VoltKicks
## Tienda de Zapatos Deportivos | Equipo 1
### Guía paso a paso para ejecutar el proyecto con AppServ (Windows)

---

## 📋 REQUISITOS PREVIOS

| Requisito | Versión recomendada |
|-----------|-------------------|
| Sistema Operativo | Windows 10 / 11 |
| AppServ | 9.3.0 o superior |
| Navegador | Chrome, Firefox o Edge (actualizado) |
| Espacio en disco | Mínimo 100 MB libres |

---

## PASO 1: DESCARGAR E INSTALAR APPSERV

1. Abrir el navegador y entrar a: **https://www.appserv.org**
2. Hacer clic en el botón **"Download"**
3. Descargar la versión más reciente de AppServ (archivo `.exe`)
4. Ejecutar el instalador como **Administrador** (clic derecho → "Ejecutar como administrador")
5. Durante la instalación, configurar lo siguiente:

   | Campo | Valor |
   |-------|-------|
   | Server Name | `localhost` |
   | Admin Email | (tu correo o dejarlo por defecto) |
   | Apache HTTP Port | `80` |
   | MySQL Root Password | 12345678 |

   > ⚠️ **IMPORTANTE:** La contraseña de MySQL DEBE ser **`12345678`** para que el proyecto funcione sin modificaciones. Si pones otra contraseña, tendrás que cambiarla en el archivo `includes/conexion.php`.

6. Marcar los componentes a instalar:
   - ✅ Apache HTTP Server
   - ✅ MySQL Database
   - ✅ PHP
   - ✅ phpMyAdmin
7. Hacer clic en **"Install"** y esperar a que termine
8. Al finalizar, marcar **"Start Apache"** y **"Start MySQL"** si lo pide
9. Para verificar que funciona, abrir el navegador y entrar a:
   ```
   http://localhost
   ```
   Debe aparecer la página de bienvenida de AppServ

---

## PASO 2: COPIAR LOS ARCHIVOS DEL PROYECTO

1. Localizar la carpeta del proyecto: **`tienda-zapatos`**
2. **Copiar** toda la carpeta `tienda-zapatos` completa
3. **Pegar** la carpeta en la ruta de AppServ:
   ```
   C:\AppServ\www\
   ```
4. Verificar que la estructura quedó así:
   ```
   C:\AppServ\www\tienda-zapatos\
   ├── index.php
   ├── catalogo.php
   ├── producto.php
   ├── carrito.php
   ├── reportes.php
   ├── css\
   │   └── styles.css
   ├── js\
   │   └── main.js
   ├── img\
   │   ├── logo.png
   │   ├── hero-sneaker.png
   │   ├── zapato1.png
   │   ├── zapato2.png
   │   ├── zapato3.png
   │   ├── zapato4.png
   │   ├── zapato5.png
   │   └── zapato6.png
   ├── includes\
   │   ├── conexion.php
   │   ├── header.php
   │   └── footer.php
   ├── bd\
   │   ├── esquema.sql
   │   └── password.txt
   └── media\
   ```

---

## PASO 3: CREAR LA BASE DE DATOS

### Opción A: Usando phpMyAdmin (Recomendado)

1. Abrir el navegador y entrar a:
   ```
   http://localhost/phpMyAdmin
   ```
2. Iniciar sesión con:
   - **Usuario:** `root`
   - **Contraseña:** `la que definiste al instalar appserv`
3. En el panel izquierdo, hacer clic en **"Nuevo"** (o "New") para crear una base de datos
4. Escribir el nombre: **`Eq1Tienda`**
5. En cotejamiento seleccionar: **`utf8_general_ci`**
6. Hacer clic en **"Crear"**
7. Ahora importar el esquema SQL:
   - Hacer clic en la pestaña **"Importar"** (arriba)
   - Hacer clic en **"Seleccionar archivo"**
   - Navegar a: `C:\AppServ\www\tienda-zapatos\bd\esquema.sql`
   - Seleccionar el archivo y hacer clic en **"Continuar"** o **"Go"**
8. Debe aparecer un mensaje verde: **"La importación se ejecutó exitosamente"**
9. En el panel izquierdo ahora verás la base de datos `Eq1Tienda` con 4 tablas:
   - `categorias` (4 registros)
   - `productos` (6 registros)
   - `pedidos` (5 registros de ejemplo)
   - `detalle_pedido` (7 registros de ejemplo)

### Opción B: Usando la consola de MySQL

1. Abrir la consola de MySQL desde:
   ```
   Inicio → AppServ → MySQL Command Line Client
   ```
2. Ingresar la contraseña: `12345678`
3. Ejecutar:
   ```sql
   SOURCE C:/AppServ/www/tienda-zapatos/bd/esquema.sql;
   ```
4. Verificar con:
   ```sql
   USE Eq1Tienda;
   SHOW TABLES;
   ```

---

## PASO 4: CONFIGURAR LA CONEXIÓN (Solo si es necesario)

El archivo `includes/conexion.php` ya viene configurado para AppServ con:

| Parámetro | Valor |
|-----------|-------|
| Host | `localhost` |
| Usuario | `root` |
| Contraseña | `12345678` |
| Base de datos | `Eq1Tienda` |
| Puerto | `3306` |

> ⚠️ Si usaste una contraseña diferente a `12345678` durante la instalación de AppServ, debes abrir el archivo `includes/conexion.php` y cambiar la línea que dice:
> ```php
> $password = '12345678';
> ```
> Por tu contraseña real.

---

## PASO 5: ABRIR EL SITIO WEB

1. Abrir el navegador (Chrome recomendado)
2. Escribir en la barra de direcciones:
   ```
   http://localhost/tienda-zapatos/
   ```
3. ✅ **¡Listo!** Deberías ver la página de inicio de **VoltKicks**

---

## 🗺️ NAVEGACIÓN DEL SITIO

### Páginas disponibles:

| URL | Página | Descripción |
|-----|--------|-------------|
| `/tienda-zapatos/` | **INICIO** | Página principal con hero, productos destacados y video |
| `/tienda-zapatos/catalogo.php` | **CATÁLOGO** | Grid de 6 productos con filtros (categoría, talla, precio) |
| `/tienda-zapatos/producto.php?id=1` | **DETALLE** | Detalle del producto con selector de talla, color y cantidad |
| `/tienda-zapatos/carrito.php` | **CARRITO** | Carrito de compras + formulario de pedido completo |
| `/tienda-zapatos/reportes.php` | **REPORTES** | Dashboard de ventas con estadísticas y tablas |

### Flujo de compra:

```
INICIO → CATÁLOGO → VER DETALLES → AGREGAR AL CARRITO → CARRITO → LLENAR FORMULARIO → REALIZAR PEDIDO
```

---

## 🔐 CÓMO PROBAR EL INICIO DE SESIÓN

Se ha configurado una cuenta de prueba para que puedas experimentar la función de autocompletado en el carrito de compras.

1. Haz clic en **"INICIAR SESIÓN"** en el menú principal.
2. Ingresa los siguientes datos:
   - **Correo Electrónico:** `test@voltkicks.com`
   - **Contraseña:** `password123`
3. Al iniciar sesión, verás que el menú cambia y ahora muestra "CERRAR SESIÓN".
4. Si ahora vas al carrito de compras, verás que tus datos personales y dirección se han llenado automáticamente.

*(Nota: También puedes crear tu propia cuenta haciendo clic en "Regístrate aquí" en la pantalla de Iniciar Sesión).*

---

## 🛒 CÓMO HACER UN PEDIDO (Prueba)

1. Ir a **CATÁLOGO** (`http://localhost/tienda-zapatos/catalogo.php`)
2. Hacer clic en **"AGREGAR"** en cualquier producto
3. Aparecerá una notificación naranja confirmando que se agregó
4. Ir al **CARRITO** (hacer clic en el ícono de bolsa arriba a la derecha)
5. Llenar el formulario con datos de prueba:
   - **Nombre:** Juan Pérez (O puedes iniciar sesión y se llenará solo)
   - **Email:** juan@test.com
   - **Teléfono:** 5512345678
   - **Dirección:** Av. Reforma 100
   - **Ciudad:** CDMX
   - **C.P.:** 06600
   - **Estado:** Seleccionar → CDMX
   - **Método de envío:** Seleccionar → Estándar
   - **Método de pago (Tarjeta):** Puedes usar datos falsos para la prueba:
     - *Nombre:* Usuario de Prueba
     - *Número:* 4111 1111 1111 1111
     - *Expiración:* 12/30
     - *CVV:* 123
   - **Acepto términos:** ✅ Marcar
6. Hacer clic en **"REALIZAR PEDIDO"**
7. Debe aparecer la confirmación con el número de pedido
8. Verificar en **REPORTES** que el pedido aparece en la tabla

---

## 📊 CÓMO VER LOS REPORTES

1. Ir a **REPORTES** (`http://localhost/tienda-zapatos/reportes.php`)
2. Se muestran:
   - **4 tarjetas** con métricas: Total Ventas, Pedidos, Producto Más Vendido, Promedio
   - **Tabla de pedidos recientes** con estado (Completado, Pendiente, Cancelado)
   - **Gráfico de barras** con los productos más vendidos
   - **Tabla del catálogo** con stock actual de cada producto

---

## ⚠️ SOLUCIÓN DE PROBLEMAS

### "Error de Conexión a la Base de Datos"
- **Causa:** MySQL no está corriendo o la BD no existe
- **Solución:**
  1. Verificar que MySQL esté activo en AppServ
  2. Verificar que importaste `esquema.sql` en phpMyAdmin
  3. Verificar que la contraseña en `conexion.php` sea correcta

### "La página aparece en blanco"
- **Causa:** Apache no está corriendo o error de PHP
- **Solución:**
  1. Verificar que Apache esté activo
  2. Revisar que los archivos estén en `C:\AppServ\www\tienda-zapatos\`

### "Las imágenes no se ven"
- **Causa:** La carpeta `img/` no se copió correctamente
- **Solución:** Verificar que existen los 8 archivos .png dentro de `img/`

### "El carrito no guarda productos"
- **Causa:** JavaScript bloqueado por el navegador
- **Solución:** Verificar que JavaScript esté habilitado en el navegador

---

## 🔐 CREDENCIALES

| Recurso | Usuario | Contraseña |
|---------|---------|------------|
| MySQL / phpMyAdmin | `root` | `12345678` |
| Base de datos | — | `Eq1Tienda` |
| Cuenta de Cliente | `test@voltkicks.com` | `password123` |

---

## 📝 INFORMACIÓN DEL EQUIPO

| Campo | Valor |
|-------|-------|
| Equipo | **1** |
| Proyecto | Tienda de Zapatos — VoltKicks |
| Tecnologías | PHP, MySQL, HTML, CSS, JavaScript |
| Servidor | AppServ (Apache + MySQL + PHP) |
| Diseño | Personalizado (Dark Mode Premium) |

---

## 🎨 PERSONALIZACIÓN RÁPIDA

### Cambiar nombre de la tienda:
Abrir `includes/header.php`, línea 10:
```php
$nombre_tienda = 'VOLTKICKS';  // ← Cambiar aquí
```

### Cambiar colores:
Abrir `css/styles.css`, buscar `:root` y modificar:
```css
--primary: #ff571a;        /* ← Color principal (naranja) */
--surface: #121414;        /* ← Color de fondo */
```

---

*Manual creado para el proyecto VoltKicks — Equipo 1 — 2026*
