<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $idioma === 'en' ? 'Login' : 'Iniciar Sesión' ?></title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <div class="container login-container">
        <h1><?= $idioma === 'en' ? 'Login' : 'Iniciar Sesión' ?></h1>
        
        <?php if (!empty($error)): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>

        <form action="sesion" method="POST">
            <div class="form-group">
                <label for="nombre"><?= $idioma === 'en' ? 'Username:' : 'Usuario:' ?></label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            
            <div class="form-group">
                <label for="contrasenya"><?= $idioma === 'en' ? 'Password:' : 'Contraseña:' ?></label>
                <input type="password" id="contrasenya" name="contrasenya" required>
            </div>
            
            <div class="form-group">
                <label for="idioma"><?= $idioma === 'en' ? 'Language:' : 'Idioma:' ?></label>
                <select name="idioma" id="idioma">
                    <option value="es" <?= $idioma === 'es' ? 'selected' : '' ?>>Español</option>
                    <option value="en" <?= $idioma === 'en' ? 'selected' : '' ?>>English</option>
                </select>
            </div>
            
            <div class="botones">
                <button type="submit" class="btn-submit"><?= $idioma === 'en' ? 'Login' : 'Iniciar Sesión' ?></button>
            </div>
        </form>
    </div>
</body>
</html>