<?php
if (!isset($_GET['id'])) {
    header("Location: index.php");
    die();
}
use Departamentos\Departamentos;
$id = $_GET['id'];
session_start();
require dirname(__DIR__, 2) . "/vendor/autoload.php";
$miDep = (new Departamentos)->setId($id)->read();

$error = false;
function hayError($nombre, $valor, $longitud)
{
    global $error;
    if ($valor < $longitud) {
        $_SESSION['err_' . $nombre] = "El $nombre debe tener al menos $longitud caracteres";
        $error = true;
    }
}

if (isset($_POST['btnCrear'])) {
    $nom_dep = ucfirst(trim($_POST['nombre']));

    hayError("nombre", $nom_dep, 5);
    if (!$error) {
        //Si no hay error (error = false) guardamos el dep
        (new Departamentos)->setNom_dep($nom_dep)
            ->setId($id)->update();
        $_SESSION['mensaje'] = "Departamento Actualizado";
        header("Location: index.php");
    } else {
        header("Localtion: {$_SERVER['PHP_SELF']}?id=$id");
    }
}
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
    <title>Editar Departamento</title>
</head>

<body style="background-color:#6EAEFF ">
    <h3 class="text-center">Editar Departamento (<?php echo $id ?>)</h3>
    <div class="container mt-2">
        <div class="m-auto bg-gradient bg-danger text-white rounded p-4 shadow-lg" style="width: 48rem;">
            <form action="<?php echo $_SERVER['PHP_SELF']."?id=$id" ?>" method="post">
                <div class="mb-3">
                    <label for="nombreCat" class="form-label">Nombre de Categoria</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $miDep->nom_dep ?>" placeholder="Introduce el nombre aqui" required>
                    <?php
                    if (isset($_SESSION['err_nombre'])) {
                        echo <<< TXT
                            <div class="alert alert-danger text-black" role="alert">
                                {$_SESSION['err_nombre']}
                            </div>
                            TXT;
                        unset($_SESSION['err_nombre']);
                    }
                    ?>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-outline-light" name="btnCrear"><i class="fas fa-cloud-upload-alt"></i> Guardar</button>
                    <button type="reset" class="btn btn-outline-warning"><i class="fas fa-broom"></i> Limpiar</button>
                </div>
        </div>
        </form>
    </div>
</body>

</html>