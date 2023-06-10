<?php
    include("bd.php");

    session_start();

    $nombreParcial = $_GET['nombreParcial'];

    if(esGestor($_SESSION['username'])) {
        $cientificos = getCientificoPorCoincidenciaNombre($nombreParcial);
    } else {
        $cientificos = getCientificoPublicadoPorCoincidenciaNombre($nombreParcial);
    }

    header('Content-Type: application/json');

    echo json_encode($cientificos);
?>