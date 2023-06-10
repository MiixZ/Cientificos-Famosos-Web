function cambiazo() {
    var inicio_sesion = document.getElementById("login");
    var registro = document.getElementById("registro");

    if (inicio_sesion.style.display !== "none" && inicio_sesion.style.display !== "") {
        inicio_sesion.style.display = "none";
        registro.style.display = "flex";
    } else {
        inicio_sesion.style.display = "flex";
        registro.style.display = "none";
    }
}

function checkCientificos() {
    var busqueda = document.getElementById("busqueda").value;

    if (busqueda.length > 0) {
        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                var cientificos = JSON.parse(this.responseText);
                mostrarResultados(cientificos);
            }
        };

        xhttp.open("GET", "busqueda.php?nombreParcial=" + busqueda, true);
        xhttp.send();
    } else {
        var divResultado = document.getElementById("resultado");
        divResultado.innerHTML = "";
        divResultado.style.display = "none";
    }
}

function mostrarResultados(cientificos) {
    var resultados = [];

    var divResultado = document.getElementById("resultado");
    divResultado.innerHTML = "";

    for (let i = 0; i < cientificos.length; i++) {
        resultados.push(cientificos[i]);
    }

    if (resultados.length > 0) {
        for (let i = 0; i < resultados.length; i++) {
            var resultado = document.createElement("div");
            var enlace = document.createElement("a");
            enlace.href = "cientifico.php?id=" + resultados[i].id;
            enlace.textContent = resultados[i].nombre;
            enlace.className = "enlaceCientificos"; // Añade la clase "enlaceCientificos"
            resultado.appendChild(enlace);
            divResultado.appendChild(resultado);
        }
    } else {
        var mensaje = document.createElement("p");
        mensaje.textContent = "No se encontraron coincidencias.";
        divResultado.appendChild(mensaje);
    }

    divResultado.style.display = "block";
}