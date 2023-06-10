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
                mostrarResultados(cientificos, busqueda);
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

function mostrarResultados(cientificos, busqueda) {
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
            enlace.className = "enlaceCientificos";

            var nombreCientifico = resultados[i].nombre;
            var indiceCoincidencia = nombreCientifico.toLowerCase().indexOf(busqueda.toLowerCase());

            if (indiceCoincidencia !== -1) {
                var nombreResaltado = nombreCientifico.substring(0, indiceCoincidencia) +
                    '<span class="resaltado">' + nombreCientifico.substring(indiceCoincidencia, indiceCoincidencia + busqueda.length) + '</span>' +
                    nombreCientifico.substring(indiceCoincidencia + busqueda.length);

                enlace.innerHTML = nombreResaltado;
            } else {
                enlace.textContent = nombreCientifico;
            }

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
