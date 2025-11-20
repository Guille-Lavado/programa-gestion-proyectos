<!DOCTYPE html>
<html lang="<?= $idioma ?>">
<head>
    <meta charset="UTF-8">
    <title><?= $idioma === 'en' ? 'Project Manager' : 'Gestor de Proyectos' ?></title>
    <link rel="stylesheet" href="<?= $this->route ?>public/css/style.css">
</head>
<body>
    <?php
        // Textos traducidos
        $rutaJson = "./public/idioma.json";
        $json = fopen($rutaJson, "r");

        if ($json) {
            $data = fread($json, filesize($rutaJson));
            fclose($json);
        }
        
        $textos = json_decode($data, true);
        $t = $textos[$idioma];

        // Función para mostrar tecnologías
        function mostrarTecnologias($tecnologias)
        {
            $html = "";
            foreach ($tecnologias as $tec) {
                $html .= '<span class="tecnologia">' . $tec . "</span> ";
            }
            return $html;
        }

        // Función para mostrar un proyecto
        function mostrarProyecto($proyecto){
            $html = '<div class="proyecto">';
            $html .= "<h3>" . $proyecto["nombre"] . "</h3>";
            $html .= '<p class="descripcion">' . $proyecto["descripcion"] . "</p>";
            $html .= '<div class="detalles">';
            $html .= '<span class="tipo">' . $proyecto["tipo"] . "</span>";
            $html .= '<span class="estado" data-estado="' . $proyecto["estado"] . '">' . $proyecto["estado"] . "</span>";
            $html .= "</div>";
            $html .='<div class="tecnologias-container">' .mostrarTecnologias($proyecto["tecnologias"]) ."</div>";
            $html .= "</div>";
            return $html;
        }
    ?>

    <div class="container">
        <h1><?= $t['titulo'] ?></h1>
        
        <h3><?= $t['filtros'] ?></h3>
        <form method="GET">
            <div class="filtro">
                <label><?= $t['nombre'] ?>: </label>
                <input type="text" name="nombre" value="<?= htmlspecialchars($nombre) ?>">
            </div>
            
            <div class="filtro">
                <label><?= $t['tipo'] ?>: </label>
                <select name="tipo">
                    <option value=""><?= $t['ninguno'] ?></option>
                    <?php foreach ($tipos as $tipo_option): ?>
                        <option value="<?= $tipo_option ?>" <?= $tipo === $tipo_option ? 'selected' : '' ?>>
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
                            <input type="checkbox" name="tecnologias[]" value="<?= $tec ?>" 
                                <?= in_array($tec, $tecnologias) ? 'checked' : '' ?>>
                            <?= $tec ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <div class="filtro">
                <label><?= $t['estado'] ?>: </label>
                <select name="estado">
                    <option value=""><?= $t['ninguno'] ?></option>
                    <?php foreach ($estadosUnicos as $estado_option): ?>
                        <option value="<?= $estado_option ?>" <?= $estado === $estado_option ? 'selected' : '' ?>>
                            <?= $estado_option ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="botones">
                <button type="submit"><?= $t['filtrar'] ?></button>
                <a class="btn-limpiar" href="./"><?= $t['limpiar'] ?></a>
                <a class="btn-limpiar" href="./form/form"><?= $t['crear'] ?></a>
            </div>
        </form>
        
        <p><?= $t['mostrando'] ?> <?= count($proyectosFiltrados) ?> <?= $t['proyectos'] ?></p>
        
        <div class="proyectos">
            <h2><?= $t['proyectos_titulo'] ?></h2>
            <?php foreach ($proyectosFiltrados as $proyecto): ?>
                <?= mostrarProyecto($proyecto) ?>
            <?php endforeach; ?>
        </div>
        
        <p><?= $t['total'] ?>: <?= $proyectos_length ?></p>
    </div>
</body>
</html>