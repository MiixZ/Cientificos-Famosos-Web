<?php
    require_once "./vendor/autoload.php";
    include("bd.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    session_start();        // Los datos se guardan en $_SESSION. Por ejemplo $_SESSION['count'];

    if(!isset($_SESSION['registrado'])) {
        header("Location: index.php");
    }

    if(isset($_POST['user_comentario'])) {
        $username = $_POST['username'];
        $idC = $_POST['id_cientifico'];
        $fecha = date("d/m/y");
        $hora = date("H:i");
        $texto = $_POST['user_comentario'];

        registrarComentario($username, $idC, $fecha, $hora, $texto);
        header("Location: cientifico.php?id=$idC");
    } else {
        header("Location: index.php");
    }
?>