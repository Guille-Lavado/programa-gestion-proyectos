<?php
class SesionController
{
    public function index()
    {
        session_start();

        $nombre = $_POST["nombre"] ?? "";
        $contrasenya = $_POST["contrasenya"] ?? "";
        $idioma = $_POST["idioma"] ?? "es";
        $error = "";

        // Validar credenciales si se envió el formulario
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if ($nombre === "daw" && $contrasenya === "daw2025") {
                $_SESSION["nombre"] = $nombre;
                $_SESSION["contrasenya"] = $contrasenya;
                $_SESSION["time"] = time();

                setcookie("idioma", $idioma, time() + 2*3600, "/");

                header("location: ./");
                exit;
            } else {
                $error = "Credenciales incorrectas";
            }
        }

        // Obtener idioma actual de la cookie para preseleccionar en el formulario
        $idioma = $_COOKIE["idioma"] ?? "es";
        
        require_once "views/sesion.php";
    }
}
?>