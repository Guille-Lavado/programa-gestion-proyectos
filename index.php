<?php
require 'lib/Router.php';

// Ruta relativa del server
$route = explode($_SERVER["DOCUMENT_ROOT"], str_replace("\\", "/", getcwd()))[1]."/";

// Crear instancia del Router
$router = new Router();

// Definir rutas simples
$router->add($route."", 'InicioController@index');
$router->add($route."sesion", 'SesionController@index');

$router->add($route."form/form", 'InicioController@formCrearProyecto');
$router->add($route."form/crearProyecto", 'InicioController@crearProyecto');
$router->add($route."form/borrarMetodo", 'InicioController@borrarMetodo');

// Procesar la ruta actual
$router->dispatch($_SERVER['REQUEST_URI']);
?>