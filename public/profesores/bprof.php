<?php
if (!isset($_POST['id'])) {
    header("Location: index.php");
    die();
}
session_start();
require dirname(__DIR__, 2)."/vendor/autoload.php";
use Departamentos\Profesores;
//Debemos borrar el profesor, y la imagen, pero solo si la imagen no es por defecto
$prohibido = "default.png";
$id = $_POST['id'];
$imagen = (new Profesores)->devolverImagen($id);
(new Profesores)->setId($id)->delete();
if (basename($imagen) != $prohibido) {
    unlink($imagen);
}
$_SESSION['mensaje'] = "Profesor borrado";
header("Location:index.php");