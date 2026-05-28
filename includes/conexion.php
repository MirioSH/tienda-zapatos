<?php
/**
 * VoltKicks - Conexión a Base de Datos
 * Equipo 1
 */

// Configuración para AppServ (Windows)
 $host = 'localhost';
 $usuario = 'root';
 $password = '12345678';
 $basedatos = 'Eq1Tienda';
 $puerto = 3306;

// Configuración para Linux (local)
//$host = 'localhost';
//$usuario = 'root';
//$password = 'admin';
//$basedatos = 'Eq1Tienda';
//$puerto = 3306;

// Conexión con MySQLi
$conexion = new mysqli($host, $usuario, $password, $basedatos, $puerto);

// Verificar conexión
if ($conexion->connect_error) {
    // Si falla la conexión, mostrar mensaje informativo
    die("<div style='background:#93000a;color:#ffdad6;padding:20px;border-radius:8px;font-family:Outfit,sans-serif;margin:20px;'>
        <h3>⚠ Error de Conexión a la Base de Datos</h3>
        <p>No se pudo conectar a MySQL. Verifica que:</p>
        <ul>
            <li>MySQL/MariaDB esté corriendo</li>
            <li>La base de datos 'Eq1Tienda' exista (importa bd/esquema.sql)</li>
            <li>El usuario y contraseña sean correctos</li>
        </ul>
        <p><small>Error: " . $conexion->connect_error . "</small></p>
    </div>");
}

// Establecer charset UTF-8
$conexion->set_charset("utf8");

// Crear las tablas necesarias si no existen aún
$check_table = $conexion->query("SHOW TABLES LIKE 'usuarios'");
if ($check_table && $check_table->num_rows == 0) {
    $conexion->query("CREATE TABLE usuarios (
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
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8");
    
    $conexion->query("INSERT INTO usuarios (nombre, email, password, telefono, direccion, ciudad, codigo_postal, estado) VALUES
    ('Usuario de Prueba', 'test@voltkicks.com', 'password123', '5512345678', 'Av. Reforma 100', 'CDMX', '06600', 'CDMX')");
    
    $conexion->query("CREATE TABLE favoritos (
      id INT AUTO_INCREMENT PRIMARY KEY,
      usuario_id INT NOT NULL,
      producto_id INT NOT NULL,
      fecha_agregado TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
      FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
      FOREIGN KEY (producto_id) REFERENCES productos(id),
      UNIQUE KEY unique_favorito (usuario_id, producto_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8");
}
?>
