-- =============================================
-- VoltKicks - Tienda de Zapatos
-- Equipo 1
-- Base de Datos: Eq1Tienda
-- MySQL dump compatible con AppServ y MariaDB
-- =============================================

-- Crear base de datos
CREATE DATABASE IF NOT EXISTS Eq1Tienda
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

USE Eq1Tienda;

-- =============================================
-- Tabla: categorias
-- =============================================
CREATE TABLE IF NOT EXISTS categorias (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  descripcion TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO categorias (nombre, descripcion) VALUES
('Running', 'Zapatos de alto rendimiento para correr'),
('Basketball', 'Calzado deportivo para basketball'),
('Lifestyle', 'Tenis casuales de estilo urbano'),
('Training', 'Zapatos para entrenamiento y crossfit');

-- =============================================
-- Tabla: productos
-- =============================================
CREATE TABLE IF NOT EXISTS productos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(150) NOT NULL,
  descripcion TEXT,
  precio DECIMAL(10,2) NOT NULL,
  imagen VARCHAR(255) NOT NULL,
  categoria_id INT,
  tallas VARCHAR(255) DEFAULT '22,23,24,25,26,27,28',
  stock INT DEFAULT 50,
  destacado TINYINT(1) DEFAULT 0,
  fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (categoria_id) REFERENCES categorias(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO productos (nombre, descripcion, precio, imagen, categoria_id, tallas, stock, destacado) VALUES
('PHANTOM X-1', 'Ingeniería de élite. Placas de propulsión con infusión de carbono y amortiguación de alta respuesta para un máximo retorno de energía.', 3499.00, 'zapato1.png', 1, '22,23,24,25,26,27,28', 45, 1),
('ZENITH COURT', 'Domina la cancha con la tecnología Zenith de soporte lateral avanzado y suela adherente de máxima tracción.', 3299.00, 'zapato2.png', 2, '23,24,25,26,27,28', 30, 1),
('VOLT NITRO', 'Estilo urbano con rendimiento atlético. Malla ultraligera con costuras en naranja eléctrico para un look premium.', 2799.00, 'zapato3.png', 3, '22,23,24,25,26,27', 60, 1),
('KINETIC FORCE', 'Entrenamiento de alto impacto. Diseño futurista con acentos naranja sobre malla de carbón oscuro.', 2999.00, 'zapato4.png', 4, '23,24,25,26,27,28', 40, 1),
('APEX VELOCITY', 'Basketball de élite. Naranja eléctrico audaz con texturas de malla y cuero, iluminación dramática.', 3599.00, 'zapato5.png', 2, '24,25,26,27,28', 25, 1),
('TITAN GRIP', 'Cross-training de alta tecnología. Acentos naranja eléctrico sobre malla de carbón oscuro, diseño futurista.', 3199.00, 'zapato6.png', 4, '22,23,24,25,26,27,28', 55, 1);

-- =============================================
-- Tabla: pedidos
-- =============================================
CREATE TABLE IF NOT EXISTS pedidos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre_cliente VARCHAR(200) NOT NULL,
  email VARCHAR(200) NOT NULL,
  telefono VARCHAR(20),
  direccion TEXT NOT NULL,
  ciudad VARCHAR(100),
  codigo_postal VARCHAR(10),
  estado VARCHAR(100),
  metodo_envio VARCHAR(50) DEFAULT 'estandar',
  acepta_terminos TINYINT(1) DEFAULT 0,
  newsletter TINYINT(1) DEFAULT 0,
  envolver_regalo TINYINT(1) DEFAULT 0,
  notas TEXT,
  total DECIMAL(10,2) NOT NULL,
  estatus VARCHAR(50) DEFAULT 'Pendiente',
  fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Datos de ejemplo para reportes
INSERT INTO pedidos (nombre_cliente, email, telefono, direccion, ciudad, codigo_postal, estado, metodo_envio, total, estatus, fecha) VALUES
('Carlos Méndez', 'carlos@email.com', '5551234567', 'Av. Reforma 123', 'CDMX', '06600', 'CDMX', 'express', 6798.00, 'Completado', '2026-05-20 14:30:00'),
('Ana García', 'ana@email.com', '3331234567', 'Calle Juárez 456', 'Guadalajara', '44100', 'Jalisco', 'estandar', 3499.00, 'Completado', '2026-05-21 10:15:00'),
('Roberto López', 'roberto@email.com', '8181234567', 'Blvd. Garza Sada 789', 'Monterrey', '64849', 'Nuevo León', 'same_day', 5998.00, 'Pendiente', '2026-05-23 16:45:00'),
('María Fernández', 'maria@email.com', '2221234567', 'Av. Juárez 321', 'Puebla', '72000', 'Puebla', 'estandar', 2799.00, 'Completado', '2026-05-24 09:00:00'),
('Luis Torres', 'luis@email.com', '5559876543', 'Insurgentes Sur 654', 'CDMX', '03100', 'CDMX', 'express', 3599.00, 'Cancelado', '2026-05-25 11:30:00');

-- =============================================
-- Tabla: detalle_pedido
-- =============================================
CREATE TABLE IF NOT EXISTS detalle_pedido (
  id INT AUTO_INCREMENT PRIMARY KEY,
  pedido_id INT NOT NULL,
  producto_id INT NOT NULL,
  talla VARCHAR(10) NOT NULL,
  cantidad INT NOT NULL DEFAULT 1,
  subtotal DECIMAL(10,2) NOT NULL,
  FOREIGN KEY (pedido_id) REFERENCES pedidos(id),
  FOREIGN KEY (producto_id) REFERENCES productos(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO detalle_pedido (pedido_id, producto_id, talla, cantidad, subtotal) VALUES
(1, 1, '26', 1, 3499.00),
(1, 2, '26', 1, 3299.00),
(2, 1, '24', 1, 3499.00),
(3, 5, '27', 1, 3599.00),
(3, 3, '25', 1, 2399.00),
(4, 3, '23', 1, 2799.00),
(5, 5, '28', 1, 3599.00);

-- =============================================
-- Tabla: usuarios
-- =============================================
CREATE TABLE IF NOT EXISTS usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  telefono VARCHAR(20),
  direccion TEXT,
  ciudad VARCHAR(100),
  codigo_postal VARCHAR(10),
  estado VARCHAR(100),
  fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Insertar usuario de prueba
INSERT INTO usuarios (nombre, email, password, telefono, direccion, ciudad, codigo_postal, estado) VALUES
('Usuario de Prueba', 'test@voltkicks.com', 'password123', '5512345678', 'Av. Reforma 100', 'CDMX', '06600', 'CDMX');

-- =============================================
-- Tabla: favoritos
-- =============================================
CREATE TABLE IF NOT EXISTS favoritos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario_id INT NOT NULL,
  producto_id INT NOT NULL,
  fecha_agregado TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
  FOREIGN KEY (producto_id) REFERENCES productos(id),
  UNIQUE KEY unique_favorito (usuario_id, producto_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
