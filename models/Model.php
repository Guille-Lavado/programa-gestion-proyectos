<?php
class Model
{
    private $proyectos = [
        [
            'nombre'      => 'Intranet Corporativa',
            'descripcion' => 'Desarrollo de una intranet para centralizar documentos internos, comunicados y herramientas de gestión del personal',
            'tipo'        => 'Proyecto interno',
            'tecnologias' => ['PHP', 'Laravel', 'MySQL', 'Bootstrap'],
            'estado'      => 'En progreso',
        ],
        [
            'nombre'      => 'Portal del Cliente - Consultoría Alfa',
            'descripcion' => 'Plataforma web personalizada para la gestión de incidencias y seguimiento de proyectos para un cliente externo',
            'tipo'        => 'Consultoría',
            'tecnologias' => ['PHP', 'Symfony', 'MariaDB', 'Tailwind CSS'],
            'estado'      => 'En progreso',
        ],
        [
            'nombre'      => 'Gestor de Formación Continua',
            'descripcion' => 'Aplicación para el departamento de RRHH que permite planificar, inscribir y evaluar cursos de formación interna',
            'tipo'        => 'Proyecto interno',
            'tecnologias' => ['PHP', 'Laravel', 'PostgreSQL', 'Vue.js'],
            'estado'      => 'Bloqueado',
        ],
        [
            'nombre'      => 'Evaluación del Desempeño',
            'descripcion' => 'Aplicación web para gestionar las evaluaciones anuales del personal, con informes automáticos y exportación de resultados',
            'tipo'        => 'Iniciativa RRHH',
            'tecnologias' => ['PHP', 'Laravel', 'MySQL', 'Chart.js'],
            'estado'      => 'Finalizado',
        ],
        [
            'nombre'      => 'Sistema de Control de Accesos',
            'descripcion' => 'Herramienta web para registrar y monitorizar accesos físicos y digitales de empleados, integrada con la base de datos corporativa',
            'tipo'        => 'Proyecto interno',
            'tecnologias' => ['PHP', 'CodeIgniter', 'MySQL', 'jQuery'],
            'estado'      => 'Pendiente',
        ],
    ];

    public function getProyectos(): array
    {
        return $this->proyectos;
    }

    public function getTiposUnicos(): array
    {
        return array_unique(array_column($this->proyectos, "tipo"));
    }

    public function getTecnologiasUnicas(): array
    {
        $tecnologiasUnicas = [];
        foreach ($this->proyectos as $proyecto) {
            $tecnologiasUnicas = array_merge($tecnologiasUnicas, $proyecto["tecnologias"]);
        }
        return array_unique($tecnologiasUnicas);
    }

    public function getEstadosUnicos(): array
    {
        return array_unique(array_column($this->proyectos, "estado"));
    }

    public function aplicarFiltros($nombre, $tipo, $tecnologias, $estado): array
    {
        $proyectosFiltrados = [];
        
        foreach ($this->proyectos as $proyecto) {
            $cumpleFiltros = true;

            // Filtro por nombre (búsqueda parcial case-insensitive)
            if (!empty($nombre)) {
                if (stripos($proyecto["nombre"], $nombre) === false) {
                    $cumpleFiltros = false;
                }
            }

            // Filtro por tipo (coincidencia exacta)
            if (!empty($tipo) && $proyecto["tipo"] !== $tipo) {
                $cumpleFiltros = false;
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
                    $cumpleFiltros = false;
                }
            }

            // Filtro por estado (coincidencia exacta)
            if (!empty($estado) && $proyecto["estado"] !== $estado) {
                $cumpleFiltros = false;
            }

            if ($cumpleFiltros) {
                $proyectosFiltrados[] = $proyecto;
            }
        }

        return $proyectosFiltrados;
    }
}
?>
