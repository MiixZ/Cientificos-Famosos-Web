<?php
    require_once "./vendor/autoload.php";
    include("bd.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    session_start();        // Los datos se guardan en $_SESSION. Por ejemplo $_SESSION['count'];

    if (!isset($_SESSION['registrado'])) {
        header("Location: index.php");
    }

    if(isset($_GET['id']) && esGestor($_SESSION['username'])) {
        $id_cientifico = $_GET['id'];

        eliminarCientifico($id_cientifico);
    }

    header("Location: index.php");