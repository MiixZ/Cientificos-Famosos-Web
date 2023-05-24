function cambiazo() {
    var inicio_sesion = document.getElementById("login");
    var registro = document.getElementById("registro");

    if (inicio_sesion.style.display !== "none" && inicio_sesion.style.display !== "") {
        inicio_sesion.style.display = "none";
        registro.style.display = "flex";
    }
    else {
        inicio_sesion.style.display = "flex";
        registro.style.display = "none";
    }
}