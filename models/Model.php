<?php
class Model
{
    private $pdo;
    private $proyectos;

    function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:host=localhost;dbname=gestion_proyectos;charset=utf8", "alumno", "alumno");
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Error Al connectar con BDD".$e->getMessage();
        }

        $this->proyectos = self::getProyectos();

        // echo "Ruta actual __DIR__: ".__DIR__;
        // echo "<br>";
        // echo "Ruta actual getcwd: ".getcwd();
    }

    private function juntarProyectosTecnologias($tablaProyectos, $tablaTecnologias) {
        $proyectos = [];
        $tecnologias = [[]];

        foreach ($tablaProyectos as $filaProyecto) {
            $idProyecto = $filaProyecto["id"];
            $tecnologias[$idProyecto] = [];

            foreach ($tablaTecnologias as $filaTecnologia) {
                if ($filaTecnologia["id"] == $idProyecto) {
                    array_push($tecnologias[$idProyecto], $filaTecnologia["tecnologia"]);
                }
            }

            array_push($proyectos, [
                "id" => $filaProyecto["id"],
                "nombre" => $filaProyecto["nombre"],
                "descripcion" => $filaProyecto["descripcion"],
                "tipo" => $filaProyecto["tipo"],
                "tecnologias" => $tecnologias[$idProyecto],
                "estado" => $filaProyecto["estado"]]);
        }

        return $proyectos;
    }

    public function getProyectos(): array
    {
        $proyectos = [];

        /**
        * SELECT p.nombre, GROUP_CONCAT(t.nombre) FROM proyectos p
        * LEFT JOIN proyecto_tecnologias pt on pt.id_proyectos = p.id
        * LEFT JOIN tecnologias t on pt.id_tecnologias = t.id
        * GROUP BY p.id;
        */
        try {
            $sql = <<<END
            SELECT pt.id_proyectos as id, t.nombre AS tecnologia FROM proyecto_tecnologias pt 
            INNER JOIN tecnologias t on pt.id_tecnologias = t.id;
            END;
            $stmt = $this->pdo->query($sql);

            $todosTecnologias = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $sql = <<<END
            SELECT p.id, p.nombre, p.descripcion, t.nombre AS tipo, e.nombre AS estado FROM proyectos p
            INNER JOIN tipo t on p.id_tipo = t.id
            INNER JOIN estado e on p.id_estado = e.id;
            END;

            $stmt = $this->pdo->query($sql);

            $todosProyectos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $proyectos = self::juntarProyectosTecnologias($todosProyectos, $todosTecnologias);
            $this->proyectos = $proyectos;
        } catch (PDOException $e) {
            echo "Error".$e->getMessage();
        }

        return $proyectos;
    }

    public function setProyecto($nombre, $descripcion, $tipo, $tecnologias, $estado): void
    {
        try {
            $stmt = $this->pdo->prepare("SELECT id FROM tipo WHERE nombre=?");
            $stmt->execute([$tipo]);

            $id_tipo = $stmt->fetch(PDO::FETCH_ASSOC)["id"];
            
            $stmt = $this->pdo->prepare("SELECT id FROM estado WHERE nombre=?");
            $stmt->execute([$estado]);

            $id_estado = $stmt->fetch(PDO::FETCH_ASSOC)["id"];

            $sql = "INSERT INTO proyectos (nombre, descripcion, id_tipo, id_estado) VALUES (:nombre, :descripcion, :tipo, :estado)";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ":nombre" => $nombre,
                ":descripcion" => $descripcion,
                ":tipo" => $id_tipo,
                ":estado" => $id_estado
            ]);

            $id_proyecto = $this->pdo->lastInsertId();

            foreach ($tecnologias as $tec) {
                $stmt = $this->pdo->prepare("SELECT id FROM tecnologias WHERE nombre=?");
                $stmt->execute([$tec]);

                $id_tecnologia = $stmt->fetch(PDO::FETCH_ASSOC)["id"];

                $sql = "INSERT INTO proyecto_tecnologias (id_proyectos, id_tecnologias) VALUES (:id_proyectos, :id_tecnologias)";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([":id_proyectos" => $id_proyecto, ":id_tecnologias" => $id_tecnologia]);
            }          
        } catch (PDOException $e) {
            echo "Error en el insert: ".$e->getMessage();
        }
    }

    public function rmProyecto($id)
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM proyectos WHERE id=?");
            $stmt->execute([$id]);
        } catch (PDOException $e) {
            echo "Error: ".$e->getMessage();
        }
    }

    public function getTiposUnicos(): array
    {
        $tiposUnicos = [];
        try {
            $stmt = $this->pdo->query("SELECT nombre FROM tipo");
            $tiposUnicos = array_column($stmt->fetchAll(PDO::FETCH_ASSOC), "nombre");
        } catch (PDOException $e) {
            echo "Error: ".$e->getMessage();
        }

        return $tiposUnicos;
    }

    public function getTecnologiasUnicas(): array
    {
        $tecnologiasUnicas = [];
        try {
            $stmt = $this->pdo->query("SELECT nombre FROM tecnologias");
            $tecnologiasUnicas = array_column($stmt->fetchAll(PDO::FETCH_ASSOC), "nombre");
        } catch (PDOException $e) {
            echo "Error: ".$e->getMessage();
        }

        return $tecnologiasUnicas;
    }

    public function getEstadosUnicos(): array
    {
        $estadosUnicos = [];
        try {
            $stmt = $this->pdo->query("SELECT nombre FROM estado");
            $estadosUnicos = array_column($stmt->fetchAll(PDO::FETCH_ASSOC), "nombre");
        } catch (PDOException $e) {
            echo "Error: ".$e->getMessage();
        }

        return $estadosUnicos;
    }

    public function aplicarFiltros($nombre, $tipo, $tecnologias, $estado): array
    {
        $proyectosFiltrados = [];

        foreach ($this->proyectos as $proyecto) {
            // Filtro por nombre (búsqueda parcial case-insensitive)
            if (!empty($nombre) && stripos($proyecto["nombre"], $nombre) === false) {
                continue;
            }

            // Filtro por tipo (coincidencia exacta)
            if (!empty($tipo) && $proyecto["tipo"] !== $tipo) {
                continue;
            }

            // Filtro por tecnologías (al menos una debe coincidir)
            if (!empty($tecnologias)) {
                $coincideTecnologia = false;
                foreach ($tecnologias as $tec) {
                    if (in_array($tec, $proyecto["tecnologias"])) {
                        $coincideTecnologia = true;
                        break;
                    }
                }
                if (!$coincideTecnologia) {
                    continue;
                }
            }

            // Filtro por estado (coincidencia exacta)
            if (!empty($estado) && $proyecto["estado"] !== $estado) {
                continue;
            }

            $proyectosFiltrados[] = $proyecto;
        }

        return $proyectosFiltrados;
    }
}
?>
