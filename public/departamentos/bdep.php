<?php

use Departamentos\Departamentos;

if (!isset($_POST['id'])) {
    header("Location: index.php");
    die();
}
session_start();
$id = $_POST['id'];
require dirname(__DIR__, 2)."/vendor/autoload.php";
(new Departamentos)->setId($id)->delete();
$_SESSION['mensaje'] = "Departamento borrado";
header("Location: index.php");