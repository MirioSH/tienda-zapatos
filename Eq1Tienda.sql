-- MySQL dump 10.13  Distrib 5.7.15, for Win32 (AMD64)
-- =============================================
-- VoltKicks - Tienda de Zapatos (Equipo 1)
-- =============================================

DROP DATABASE IF EXISTS Eq1Tienda;

CREATE DATABASE Eq1Tienda
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

USE Eq1Tienda;

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
('Nike Air Max Correlate', 'Los Nike Air Max Correlate te brindan un estilo retro con una parte superior multitexturizada y la unidad Max Air.', '2299.00', 'Nike Air Max Correlate.png', 1, '22,23,24,25,26,27,28', 45, 1),
('Nike Air Monarch IV', 'Los Nike Air Monarch IV te preparan para entrenar con cuero duradero en la parte superior para brindarte soporte.', '1999.00', 'Nike Air Monarch IV.png', 3, '25,26,27,28,29,30', 30, 1),
('Kobe XI Elite Protro', 'Los Kobe 11 de corte low se lanzaron durante la última temporada de Kobe y representaban su esencia a la perfección.', '4499.00', 'Kobe XI Elite Protro.png', 2, '23,24,25,26,27,28,29', 60, 1),
('Nike Free Metcon 7', 'Presume tu rendimiento con las Free Metcon 7. Nuestros tenis de entrenamiento más versátiles se actualizan.', '2999.00', 'Nike Free Metcon 7.png', 4, '24,25,26,27,28,29,30', 40, 1),
('Nike Flex Train', 'Levanta pesas. Sprint. Muévete. Con los Nike Flex Train tienes la libertad de elegir tu propia aventura de entrenamiento.', '1899.00', 'Nike Flex Train.png', 4, '22,23,24,25,26,27', 25, 1),
('Nike P-6000', 'Los P-6000 actualizan el estilo de los runners de principios de los 2000 con líneas de diseño deportivo y materiales transpirables.', '2699.00', 'Nike P-6000.png', 3, '22,23,24,25,26,27', 55, 1);

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

INSERT INTO pedidos (nombre_cliente, email, telefono, direccion, ciudad, codigo_postal, estado, metodo_envio, total, estatus, fecha) VALUES
('Carlos Méndez', 'carlos@email.com', '5551234567', 'Av. Reforma 123', 'CDMX', '06600', 'CDMX', 'express', 6798.00, 'Completado', '2026-05-20 14:30:00'),
('Ana García', 'ana@email.com', '3331234567', 'Calle Juárez 456', 'Guadalajara', '44100', 'Jalisco', 'estandar', 3499.00, 'Completado', '2026-05-21 10:15:00'),
('Roberto López', 'roberto@email.com', '8181234567', 'Blvd. Garza Sada 789', 'Monterrey', '64849', 'Nuevo León', 'same_day', 5998.00, 'Pendiente', '2026-05-23 16:45:00');

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
(1, 1, '26', 1, 2299.00),
(1, 2, '26', 1, 1999.00),
(2, 1, '24', 1, 2299.00),
(3, 5, '27', 1, 1899.00),
(3, 3, '25', 1, 4499.00);
<<<<<<< Updated upstream

-- NOTA: Se eliminaron las tablas usuarios y favoritos de acuerdo a la reducción del proyecto
=======
>>>>>>> Stashed changes
