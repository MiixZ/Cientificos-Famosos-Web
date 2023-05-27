<?php
    require_once "./vendor/autoload.php";
    include("bd.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    session_start();        // Los datos se guardan en $_SESSION. Por ejemplo $_SESSION['count'];

    if(!isset($_SESSION['registrado'])) {
        header("Location: index.php");
    }

    if(isset($_POST['eliminar'])) {
        $idCientifico = $_POST['idc'];
        $texto = $_POST['texto_viejo'];
        $tipo_pagina = $_POST['tipo_pagina'];

        eliminarComentario($texto, $idCientifico);

        if($tipo_pagina == 1)
            header("Location: editComent.php");
        else
            header("Location: cientifico.php?id=$idCientifico");
    }

    if(isset($_POST['texto_nuevo'])) {
        $texto_nuevo = $_POST['texto_nuevo'];
        $texto_viejo = $_POST['texto_viejo'];
        $idCientifico = $_POST['idc'];
        $tipo_pagina = $_POST['tipo_pagina'];

        editComentario($texto_nuevo, $texto_viejo, $idCientifico);

        if($tipo_pagina == 1)
            header("Location: editComent.php");
        else
            header("Location: cientifico.php?id=$idCientifico");
    } else {
        header("Location: index.php");
    }