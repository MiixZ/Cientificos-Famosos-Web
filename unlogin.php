<?php
    session_start();

    if(isset($_SESSION['registrado']) && $_SESSION['registrado']) {
        $_SESSION['registrado'] = false;
        $_SESSION['username'] = "Anónimo";
        $_SESSION['correo'] = "";
        $_SESSION['modder'] = false;
    }

    header("Location: index.php");
?>