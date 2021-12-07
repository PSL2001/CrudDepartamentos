<?php

use Departamentos\{Profesores, Departamentos};

if (!isset($_GET['id'])) {
    header("Location: index.php");
    die();
}

require dirname(__DIR__, 2) . "/vendor/autoload.php";
$id = $_GET['id'];
$profesores = (new Profesores)->devolverProfesores($id);
$detDep = (new Departamentos)->setId($id)->read();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Detalles Departamento</title>
</head>
<body style="background-color:#6EAEFF ">
    <h3 class="text-center">Detalles departamento <?php echo $id ?></h3>
    <div class="container mt-2">
    <div class="card mx-auto" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title"><?php echo $detDep->nom_dep ?></h5>
                <p class="card-text">Profesores que pertenecen al departamento </p>
                <ul>
                <?php
                foreach ($profesores as $item) {
                    if ($item->dep_id == $detDep->id) {
                        echo "<li class='card-text'> $item->nom_prof</li>";
                    } 
                }
                ?>
                </ul>
                <a href="../departamentos/index.php" class="btn btn-primary"><i class="fas fa-backwards"></i> Volver</a>
            </div>
        </div>
    </div>
</body>
</html>