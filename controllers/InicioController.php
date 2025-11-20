<?php
class InicioController
{
    private $model;
    private $route;

    function __construct()
    {
        require_once "models/Model.php";
        $this->model = new Model();
        $this->route = explode($_SERVER["DOCUMENT_ROOT"], str_replace("\\", "/", getcwd()))[1]."/";
        self::sesionLog();
    }

    public function index()
    {
        // Filtros
        $nombre = $_GET["nombre"] ?? "";
        $tipo = $_GET["tipo"] ?? "";
        $tecnologias = $_GET["tecnologias"] ?? [];
        $estado = $_GET["estado"] ?? "";

        // Obtener idioma de la cookie
        $idioma = $_COOKIE["idioma"] ?? "es";

        // Aplicar filtros
        $proyectosFiltrados = $this->model->aplicarFiltros($nombre, $tipo, $tecnologias, $estado);

        // Obtener únicos para los filtros
        $tipos = $this->model->getTiposUnicos();
        $tecnologiasUnicas = $this->model->getTecnologiasUnicas();
        $estadosUnicos = $this->model->getEstadosUnicos();

        $proyectos_length = count($this->model->getProyectos());

        // Cargamos el View pasando el idioma
        require_once "views/inicio.php";
    }

    public function formCrearProyecto()
    {
        // Obtener idioma de la cookie
        $idioma = $_COOKIE["idioma"] ?? "es";

        // Obtener únicos para los filtros
        $tipos = $this->model->getTiposUnicos();
        $tecnologiasUnicas = $this->model->getTecnologiasUnicas();
        $estadosUnicos = $this->model->getEstadosUnicos();

        require_once("views/formProyecto.php");
    }

    public function crearProyecto()
    {
        $nombre = $_POST["nombre"] ?? "";
        $descripcion = $_POST["descripcion"] ?? "";
        $tipo = $_POST["tipo"] ?? "";
        $tecnologias = $_POST["tecnologias"] ?? [];
        $estado = $_POST["estado"] ?? "";

        $this->model->setProyecto($nombre, $descripcion, $tipo, $tecnologias, $estado);

        header("location: {$this->route}");
    }

    public function sesionLog()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Verificar existencia y validez temporal de la sesión
        if (!isset($_SESSION["nombre"]) || !isset($_SESSION["time"])) {
            session_destroy();
            header("location: {$this->route}sesion");
        }

        // Verificar expiración (2 minutos = 120 segundos)
        if (time() - $_SESSION["time"] > 120) {
            session_destroy();
            header("location: {$this->route}sesion");
        }

        // Actualizar tiempo de sesión en cada interacción
        $_SESSION["time"] = time();
    }
}
?>