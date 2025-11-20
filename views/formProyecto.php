<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $idioma === 'en' ? 'Create Proyect' : 'Crear Proyecto' ?></title>
    <link rel="stylesheet" href="<?= $this->route ?>public/css/style.css">
</head>
<body>
    <?php
        $rutaJson = "./public/idioma.json";
        $json = fopen($rutaJson, "r");

        if ($json) {
            $data = fread($json, filesize($rutaJson));
            fclose($json);
        }
        
        $textos = json_decode($data, true);
        $t = $textos[$idioma];
    ?>

    <div class="container">
        <h1><?= $idioma === 'en' ? 'Create Proyect' : 'Crear Proyecto' ?></h1>

        <form action="crearProyecto" method="POST">
            <div class="filtro">
                <label><?= $t['nombre'] ?>: </label>
                <input type="text" name="nombre">
            </div>

            <div class="filtro">
                <label><?= $t['descripcion'] ?>: </label>
                <input type="text" name="descripcion">
            </div>
            
            <div class="filtro">
                <label><?= $t['tipo'] ?>: </label>
                <select name="tipo">
                    <?php foreach ($tipos as $tipo_option): ?>
                        <option value="<?= $tipo_option ?>">
                            <?= $tipo_option ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="filtro">
                <label><?= $t['tecnologias'] ?>: </label>
                <div class="tecnologias-container">
                    <?php foreach ($tecnologiasUnicas as $tec): ?>
                        <label class="checkbox-label">
                            <input type="checkbox" name="tecnologias[]" value="<?= $tec ?>">
                            <?= $tec ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <div class="filtro">
                <label><?= $t['estado'] ?>: </label>
                <select name="estado">
                    <?php foreach ($estadosUnicos as $estado_option): ?>
                        <option value="<?= $estado_option ?>">
                            <?= $estado_option ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
                
            <div class="botones">
                <button type="submit" class="btn-submit"><?= $t['crear'] ?></button>
            </div>
        </form>
    </div>
</body>
</html>