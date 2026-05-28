<?php
session_start();
$pagina_activa = 'login';
$titulo_pagina = 'Crear Cuenta';

// Redirigir si ya hay sesión
if (isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

$error = '';
$exito = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    @include 'includes/conexion.php';
    if (isset($conexion) && !$conexion->connect_error) {
        $nombre = $conexion->real_escape_string($_POST['nombre']);
        $email = $conexion->real_escape_string($_POST['email']);
        $password = $_POST['password'];

        // Verificar si ya existe
        $check = $conexion->query("SELECT id FROM usuarios WHERE email = '$email'");
        if ($check && $check->num_rows > 0) {
            $error = 'Este correo electrónico ya está registrado.';
        } else {
            $sql = "INSERT INTO usuarios (nombre, email, password) VALUES ('$nombre', '$email', '$password')";
            if ($conexion->query($sql)) {
                $exito = 'Cuenta creada exitosamente. <br> <a href="login.php" style="color:#fff; text-decoration:underline;">Inicia sesión aquí</a>.';
            } else {
                $error = 'Hubo un problema al crear tu cuenta: ' . $conexion->error;
            }
        }
    } else {
        $error = 'Error de conexión a la base de datos.';
    }
}

include 'includes/header.php';
?>

<section class="section" style="padding-top:120px; min-height: 80vh; display: flex; align-items: center; justify-content: center;">
    <div style="background:var(--surface-container); border-radius:var(--radius-lg); padding:48px; max-width:500px; width:100%; border:1px solid rgba(255,255,255,0.04);">
        <h1 style="font-size:32px; font-weight:800; margin-bottom:8px; text-align:center;">CREAR <span style="color:var(--primary);">CUENTA</span></h1>
        <p style="color:var(--on-surface-variant); text-align:center; margin-bottom:32px;">Únete a la familia VoltKicks</p>
        
        <?php if($error): ?>
        <div style="background:rgba(255,87,26,0.1); color:var(--primary); padding:16px; border-radius:var(--radius-sm); margin-bottom:24px; font-weight:600; text-align:center;">
            <?php echo $error; ?>
        </div>
        <?php endif; ?>
        
        <?php if($exito): ?>
        <div style="background:rgba(76,175,80,0.1); color:#4caf50; padding:16px; border-radius:var(--radius-sm); margin-bottom:24px; font-weight:600; text-align:center;">
            <?php echo $exito; ?>
        </div>
        <?php else: ?>

        <form method="POST" action="registro.php">
            <div class="form-group">
                <label class="form-label" for="nombre">NOMBRE COMPLETO</label>
                <input type="text" class="form-input" id="nombre" name="nombre" required placeholder="Tu nombre">
            </div>
            <div class="form-group">
                <label class="form-label" for="email">CORREO ELECTRÓNICO</label>
                <input type="email" class="form-input" id="email" name="email" required placeholder="tu@email.com">
            </div>
            <div class="form-group">
                <label class="form-label" for="password">CONTRASEÑA</label>
                <input type="password" class="form-input" id="password" name="password" required placeholder="••••••••">
            </div>
            
            <button type="submit" class="btn-primary" style="width:100%; padding:16px; margin-top:16px;">CREAR CUENTA</button>
            
            <div style="text-align:center; margin-top:24px; color:var(--on-surface-variant); font-size:14px;">
                ¿Ya tienes cuenta? <a href="login.php" style="color:var(--primary); font-weight:600;">Inicia sesión</a>
            </div>
        </form>
        
        <?php endif; ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
