<?php
    session_start();
    include("bd.php");

    if (isset($_SESSION['registrado']) && $_GET['id']) {
        $idCientifico = $_GET['id'];
        $ruta = $_GET['ruta'];
        eliminarFoto($idCientifico, $ruta);
        header("Location: gestorPage.php?id=$idCientifico");
    } else {
        header("Location: index.php");
    }

    header("Location: gestorPage.php?id=$idCientifico");
