<?php
session_start();
$pagina_activa = 'login';
$titulo_pagina = 'Mi Cuenta';

// Redirigir si ya hay sesión
if (isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    @include 'includes/conexion.php';
    if (isset($conexion) && !$conexion->connect_error) {
        $email = $conexion->real_escape_string($_POST['email']);
        $password = $_POST['password'];

        $result = $conexion->query("SELECT * FROM usuarios WHERE email = '$email'");
        
        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if ($password === $user['password']) {
                $_SESSION['usuario_id'] = $user['id'];
                $_SESSION['usuario_nombre'] = $user['nombre'];
                $_SESSION['usuario_email'] = $user['email'];
                $_SESSION['usuario_direccion'] = $user['direccion'];
                $_SESSION['usuario_telefono'] = $user['telefono'];
                $_SESSION['usuario_ciudad'] = $user['ciudad'];
                $_SESSION['usuario_cp'] = $user['codigo_postal'];
                $_SESSION['usuario_estado'] = $user['estado'];
                header("Location: index.php");
                exit;
            } else {
                $error = 'Contraseña incorrecta.';
            }
        } else {
            $error = 'El correo electrónico no está registrado.';
        }
    } else {
        $error = 'Error de conexión a la base de datos.';
    }
}

include 'includes/header.php';
?>

<section class="section" style="padding-top:120px; min-height: 80vh; display: flex; align-items: center; justify-content: center;">
    <div style="background:var(--surface-container); border-radius:var(--radius-lg); padding:48px; max-width:500px; width:100%; border:1px solid rgba(255,255,255,0.04);">
        <h1 style="font-size:32px; font-weight:800; margin-bottom:8px; text-align:center;">INICIAR <span style="color:var(--primary);">SESIÓN</span></h1>
        <p style="color:var(--on-surface-variant); text-align:center; margin-bottom:32px;">Accede a tu cuenta de VoltKicks</p>
        
        <?php if($error): ?>
        <div style="background:rgba(255,87,26,0.1); color:var(--primary); padding:16px; border-radius:var(--radius-sm); margin-bottom:24px; font-weight:600; text-align:center;">
            <?php echo $error; ?>
        </div>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <div class="form-group">
                <label class="form-label" for="email">CORREO ELECTRÓNICO</label>
                <input type="email" class="form-input" id="email" name="email" required placeholder="tu@email.com">
            </div>
            <div class="form-group">
                <label class="form-label" for="password">CONTRASEÑA</label>
                <input type="password" class="form-input" id="password" name="password" required placeholder="••••••••">
            </div>
            
            <button type="submit" class="btn-primary" style="width:100%; padding:16px; margin-top:16px;">INGRESAR</button>
            
            <div style="text-align:center; margin-top:24px; color:var(--on-surface-variant); font-size:14px;">
                ¿No tienes cuenta? <a href="registro.php" style="color:var(--primary); font-weight:600;">Regístrate aquí</a>
            </div>
        </form>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
