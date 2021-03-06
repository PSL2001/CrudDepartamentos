<?php
session_start();

use Departamentos\Profesores;

require dirname(__DIR__, 2) . "/vendor/autoload.php";
(new Profesores)->crearProfesores(20);
$datos = (new Profesores)->readAll();
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
    <!-- Datatables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
    <title>Profesores</title>
</head>

<body style="background-color:#6EAEFF ">
    <h3 class="text-center">Indice de Profesores</h3>
    <?php
    if (isset($_SESSION['mensaje'])) {
        echo <<< TXT1
        <div class="alert alert-success" role="alert">
        {$_SESSION['mensaje']}
        </div>
        TXT1;
        unset($_SESSION['mensaje']);
    }
    ?>
    <div class="container mt-2">
        <a href="cprof.php" class="btn btn-primary rounded-circle"> <i class="fas fa-folder-plus"></i></a>
        <table class="table table-info table-striped" id="profesores">
            <thead>
                <tr>
                    <th scope="col">Detalles</th>
                    <th scope="col">Nombre de Profesor</th>
                    <th scope="col">Sueldo</th>
                    <th scope="col">Imagen</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($fila = $datos->fetch(PDO::FETCH_OBJ)) {
                    echo <<< TXT
                    <tr>
                        <th scope="row"><a href="dprof.php?id={$fila->id}" class="btn btn-light rounded-circle"><i class="fas fa-info-circle"></i></a></th>
                        <td>{$fila->nom_prof}</td>
                        <td>{$fila->sueldo}</td>
                        <td><img src="{$fila->img}" width="34rem" height="34rem" class="mt-1 rounded-circle" /></td>
                        <td>
                        <form method="POST" action="bprof.php">
                        <input type="hidden" name="id" value="{$fila->id}">
                        <a href="eprof.php?id={$fila->id}" class="btn btn-warning rounded-circle"><i class="fas fa-pen-alt"></i></a>
                        <button type="submit" class="btn btn-danger rounded-circle" onclick="return confirm('??Deseas borrar el profesor?')"><i class="fas fa-folder-minus"></i></button> 
                        </form>
                        </td>
                    </tr>
                    TXT;
                }
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#profesores').DataTable();
        });
    </script>
</body>

</html>