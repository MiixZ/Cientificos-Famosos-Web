<?php
    require_once "./vendor/autoload.php";
    include("bd.php"); // Controlador.

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    session_start();

    if(isset($_POST['nombre']) && isset($_SESSION['registrado']) && esGestor($_SESSION['username'])) {
        $nombre = $_POST['nombre'];
        $fechas = $_POST['fechas'];
        $ciudad = $_POST['ciudad'];
        $biografia = $_POST['biografia'];
        $nombre_imagen = $_FILES['imagen']['name'];
        move_uploaded_file($_FILES['imagen']['tmp_name'], "./img/" . $nombre_imagen);

        $nombre_imagen = "./img/" . $nombre_imagen;

        insertarCientifico($nombre, $fechas, $ciudad, $biografia, $nombre_imagen);

        header("Location: index.php");
    }

    echo $twig->render('aniadirCientifico.html', []);
