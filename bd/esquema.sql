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
('Nike Air Max Correlate', 'Los Nike Air Max Correlate te brindan un estilo retro con una parte superior multitexturizada y la unidad Max Air. La entresuela de espuma suave y la parte superior transpirable ofrecen comodidad durante todo el día donde sea que te lleve.', '2299.00', 'Nike Air Max Correlate.png', 1, '22,22.5,23,23.5,24,24.5,25,25.5,26,26.5,27,27.5,28', 45, 1),
('Nike Air Monarch IV', 'Los Nike Air Monarch IV te preparan para entrenar con cuero duradero en la parte superior para brindarte soporte. La espuma ligera se une a la amortiguación Nike Air para brindar comodidad en cada paso.', '1999.00', 'Nike Air Monarch IV.png', 3, '25,25.5,26,26.5,27,27.5,28,28.5,29,29.5,30,31', 30, 1),
('Kobe XI Elite Protro', 'Los Kobe 11 de corte low se lanzaron durante la última temporada de Kobe y representaban su esencia a la perfección: alto rendimiento, ligereza y sofisticación. Los Kobe 11 Protro mantienen ese mismo ethos, pero al más puro estilo Mamba. La famosa parte superior Flyknit de Kobe está reforzada con TPU en zonas específicas para ofrecer resistencia sin agregar peso innecesario. La entresuela incorporada ReactX se combina con una unidad Air Zoom en el talón, lo que ofrece flexibilidad y responsividad. Y la suela tiene un patrón de tracción innovador, que refleja la antigua obsesión de Kobe por revolucionar la tracción en la cancha.', '4499.00', 'Kobe XI Elite Protro.png', 2, '23,23.5,24,24.5,25,25.5,26,26.5,27,27.5,28,28.5,29,29.5,30,30.5,31,31.5,32', 60, 1),
('Nike Free Metcon 7', 'Presume tu rendimiento con las Free Metcon 7. Nuestros tenis de entrenamiento más versátiles se actualizan con mayor contención en el mediopié, sin perder nuestra reconocida tecnología Nike Free. El antepié flexible y el talón estable te permiten pasar fácilmente de movimientos dinámicos a ejercicios de fuerza.', '2999.00', 'Nike Free Metcon 7.png', 4, '24,24.5,25,25.5,26,26.5,27,27.5,28,28.5,29,29.5,30,30.5', 40, 1),
('Nike Flex Train', 'Levanta pesas. Sprint. Muévete. Con los Nike Flex Train tienes la libertad de elegir tu propia aventura de entrenamiento. Con una suela flexible y una parte superior ligera, ofrecen muchas opciones de entrenamiento.', '1899.00', 'Nike Flex Train.png', 4, '22,22.5,23,23.5,24,24.5,25,25.5,26,26.5,27', 25, 1),
('Nike P-6000', 'Los P-6000 actualizan el estilo de los runners de principios de los 2000 con líneas de diseño deportivo y materiales transpirables. Además, la amortiguación de espuma agrega un detalle elevado, inspirado en la pista, que ofrece una comodidad increíble.', '2699.00', 'Nike P-6000.png', 3, '22,22.5,23,23.5,24,24.5,25,25.5,26,26.5,27', 55, 1),
('Nike Flight Legacy', 'Inspirados en los tenis de básquetbol de finales de la década de 1980, los Nike Flight Legacy actualizan un look clásico para los tiempos modernos. La amortiguación ligera y la suela de goma completa brindan detalles de diseño retro y comodidad moderna.', '1049.00', 'Nike Flight Legacy.png', 3, '24,24.5,25,25.5,26,26.5,27,27.5,28,28.5,29,29.5,30,30.5', 50, 0),
('Nike Air Max Plus OG', 'Luce tu actitud con los Air Max Plus. Su icónica estructura aporta intensidad a tu look, mientras que la malla transpirable mantiene la frescura. Y la amortiguación visible realza tu estilo desafiante con total comodidad.', '4199.00', 'Nike Air Max Plus OG.png', 1, '24,24.5,25,25.5,26,26.5,27,27.5,28,28.5,29,29.5,30,30.5,31', 80, 0),
('Kobe V Protro', 'En 1996, Kobe llevó a su equipo de básquetbol de la preparatoria a su primer campeonato en 53 años. Este modelo Kobe 5 Protro con los colores del equipo rinde homenaje a ese momento. El rojo team se combina con el plata metalizado para crear una combinación de colores que rinde homenaje al legado con un toque moderno, con iconografía y una firma en la parte posterior que demuestra que conoces tu historia.', '4229.00', 'Kobe V Protro.png', 2, '24.5,25,25.5,26,26.5,27,27.5,28,28.5,29,29.5,30,30.5,31', 90, 1),
('Nike Reax 8 TR', '¿Quieres lograr avances en el gimnasio? Trabaja duro. ¿Quieres aprovechar al máximo esos avances? Elige los Nike Reax 8. Con la espuma superresponsiva que impulsa cada repetición, puedes ir del rack a la sala de cardio o donde necesites entrenar. Es hora de ponerse manos a la obra.', '2099.00', 'Nike Reax 8 TR.png', 3, '22,22.5,23,23.5,24,24.5,25,25.5,26,26.5,27', 75, 0);

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
