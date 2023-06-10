<?php
    require_once "./vendor/autoload.php";
    include("bd.php"); // Controlador.

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    session_start();

    if (!isset($_SESSION['registrado']) || !$_SESSION['registrado'] || !isset($_SESSION['gestor'])) {
        header("Location: index.php");
    } else if (isset($_GET['id']) && !isset($_POST['nombre'])) {
        // Hay que permitir que el usuario pueda cambiar su nombre de usuario y su correo.
        if (!is_numeric($_GET['id'])) {
            header("Location: index.php");
        }

        $id = $_GET['id'];

        if (isset($_POST['hashtags'])) {
            $hashtags = $_POST['hashtags'];
            $hashtags = explode(",", $hashtags);
            foreach($hashtags as $hashtag) {
                insertarHashtag($id, $hashtag);
            }
        }

        if (isset($_FILES['imagen'])) {
            $nombreimagen = $_FILES['imagen']['name'];
            move_uploaded_file($_FILES['imagen']['tmp_name'], "./img/" . $nombreimagen);
            $nombreimagen = "./img/" . $nombreimagen;
            insertarFoto($id, $nombreimagen);
        }
    } else if (isset($_POST['nombre'])) {
        $id = $_GET['id'];
        $cientifico = getCientifico($id);
        $nombre = $_POST['nombre'];
        $fechas = $_POST['fechas'];
        $texto = $_POST['texto'];
        $ciudad = $_POST['ciudad'];
        updateCientifico($nombre, $fechas, $ciudad, $texto, $id);

        if (!isset($_POST['publicado'])) {
            hacerNoPublicoCientifico($id);
        } else {
            hacerPublicoCientifico($id);
        }
    } else {
        header("Location: index.php");
    }



    echo $twig->render('gestorPage.html', ['cientifico' => getCientifico($id),
                                                'fotos' => getFotos($id)]);
