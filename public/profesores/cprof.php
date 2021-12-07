<?php

use Departamentos\{Profesores, Departamentos};

session_start();
require dirname(__DIR__, 2) . "/vendor/autoload.php";
$departamentos = (new Departamentos)->devolverDepartamentos();

$URL_APP = "http://127.0.0.1/public/2do%20año/Segundo_Anio/Entorno%20Servidor/CrudDepartamentos/public/";
$error = false;
function hayError($nombre, $valor, $longitud)
{
    global $error;
    if (strlen($valor) < $longitud) {
        $_SESSION['err_' . $nombre] = "El $nombre debe tener al menos $longitud caracteres";
        $error = true;
    }
}

function isImagen($tipo)
{

    $tiposBuenos = [
        'image/jpeg',
        'image/bmp',
        'image/png',
        'image/webp',
        'image/gif',
        'image/svg-xml',
        'image/x-icon'
    ];
    return in_array($tipo, $tiposBuenos);
}

if (isset($_POST['btnCrear'])) {
    $nom_prof = ucfirst(trim($_POST['nom_prof']));
    $sueldo = ucfirst(trim($_POST['sueldo']));
    $dep_id = ucfirst(trim($_POST['dep_id']));

    hayError("nom_prof", $nom_prof, 5);
    hayError("sueldo", $sueldo, 1);

    if (is_uploaded_file($_FILES['img']['tmp_name'])) {
        if (isImagen($_FILES['img']['type'])) {
            $nombreImg = uniqid() . "_" . $_FILES['img']['name'];
            if (!move_uploaded_file($_FILES['img']['tmp_name'], trim(dirname(__DIR__,1 )."/img/$nombreImg"))) {
                $_SESSION['err_img'] = "No se pudo guardar la imagen";
                $error = true;
            } else {
                $imagen = $URL_APP."img/$nombreImg";
            }
        } else {
            $_SESSION['err_img'] = "El campo debe ser de tipo imagen";
            $error = true;
        }
    } else {
        $imagen = $URL_APP."img/default.png";
    }
    if (!$error) {
        //Si no hay error (error = false) guardamos el dep
        (new Profesores)->setNom_prof($nom_prof)
        ->setSueldo($sueldo)
        ->setImg($imagen)
        ->setDep_id($dep_id)
        ->create();
        $_SESSION['mensaje'] = "Profesor creado";
        header("Location: index.php");
    } else {
        header("Localtion: {$_SERVER['PHP_SELF']}");
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
    <title>Nuevo Profesor</title>
</head>

<body style="background-color:#6EAEFF ">
    <h3 class="text-center">Crear Profesor</h3>
    <div class="container mt-2">
        <div class="m-auto bg-gradient bg-danger text-white rounded p-4 shadow-lg" style="width: 48rem;">
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="nombreCat" class="form-label">Nombre de Profesor</label>
                    <input type="text" class="form-control" id="nombre" name="nom_prof" placeholder="Introduce el nombre aqui" required>
                    <?php
                    if (isset($_SESSION['err_nom_prof'])) {
                        echo <<< TXT
                            <div class="alert alert-danger text-black" role="alert">
                                {$_SESSION['err_nom_prof']}
                            </div>
                            TXT;
                        unset($_SESSION['err_nom_prof']);
                    }
                    ?>
                </div>
                <div class="mt-3">
                    <label for="sueldo" class="form-label">Sueldo</label>
                    <input type="number" class="form-control" id="nombre" name="sueldo" placeholder="El sueldo" required>
                    <?php
                    if (isset($_SESSION['err_sueldo'])) {
                        echo <<< TXT
                            <div class="alert alert-danger text-black" role="alert">
                                {$_SESSION['err_sueldo']}
                            </div>
                            TXT;
                        unset($_SESSION['err_sueldo']);
                    }
                    ?>
                </div>
                <div class="mt-3">
                    <label for="f" class="form-label">Imagen de perfil</label>
                    <input class="form-control" type="file" id="f" name="img">
                    <?php
                    if (isset($_SESSION['err_img'])) {
                        echo "<div class='alert alert-danger text-black'>{$_SESSION['err_img']}</div>";
                        unset($_SESSION['err_img']);
                    }
                    ?>
                </div>
                <div class="mt-3">
                    <label for="i" class="form-label">Departamento</label>
                    <select class="form-select" aria-label="Default select example" required name="dep_id">
                        <?php
                        foreach ($departamentos as $item) {
                            echo "<option value='{$item->id}'>{$item->nom_dep}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-outline-light" name="btnCrear"><i class="fas fa-cloud-upload-alt"></i> Guardar</button>
                    <button type="reset" class="btn btn-outline-warning"><i class="fas fa-broom"></i> Limpiar</button>
                </div>
                </form>
        </div>
    </div>
</body>

</html>