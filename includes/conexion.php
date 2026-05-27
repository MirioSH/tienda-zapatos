<?php
/**
 * VoltKicks - Conexión a Base de Datos
 * Equipo 1
 * 
 * Configuración dual: AppServ (Windows) / Linux local
 * Cambiar la sección activa según el entorno
 */

// ============================================
// CONFIGURACIÓN PARA APPSERV (WINDOWS)
// Descomentar estas líneas cuando uses AppServ
// ============================================
// $host = 'localhost';
// $usuario = 'root';
// $password = 'admin';
// $basedatos = 'Eq1Tienda';
// $puerto = 3306;

// ============================================
// CONFIGURACIÓN PARA LINUX (LOCAL)
// Usar estas líneas para pruebas locales
// ============================================
$host = 'localhost';
$usuario = 'root';
$password = '12345678';
$basedatos = 'Eq1Tienda';
$puerto = 3306;

// ============================================
// CONEXIÓN CON MYSQLI
// ============================================
$conexion = new mysqli($host, $usuario, $password, $basedatos, $puerto);

// Verificar conexión
if ($conexion->connect_error) {
    // En producción no mostrar error detallado
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
?>
