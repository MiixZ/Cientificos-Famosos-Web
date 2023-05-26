class Comentario {
    autor; fecha; anio; mes; dia; hora; minutos; texto;
    g;

    constructor(aut, fecha, texto) {
        this.autor = aut;
        this.fecha = fecha;
        this.anio = fecha.getFullYear() - 53;
        this.mes = fecha.getMonth() + 1;
        this.dia = fecha.getDay();
        this.hora = ((this.fecha.getHours() + 12) % 24).toString();
        this.minutos = fecha.getMinutes();
        this.texto = texto;
    }

    generateComentario() {
        this.g = document.createElement('div');
        this.g.setAttribute("class", "comment");
        document.getElementById("comentarios_presentes").appendChild(this.g);

        this.g.innerHTML =  "Autor: " + this.autor + " <br/>" +
                            "Fecha: " + this.dia + "-" + this.mes + "-" + this.anio + " <br/>" +
                            "Hora: " + this.hora + ":" + this.minutos + " <br/>" +
                            "Comentario: " + this.texto;
    }
}

function addComentario1() {
    var date = new Date(2022, 10);
    date.setHours(9, 13, 30);
    var coment = new Comentario("Aitor Ruibal", date, "¡Esta página te muestra todo sobre los científico favoritos de la mayoría!");
    coment.generateComentario();
}

function addComentario2() {
    var date = new Date(2023, 1);
    date.setHours(17, 23, 10);
    var comenta = new Comentario("Borja Iglesias", date, "Aún se puede mejorar algo más... ¡No dice nada de sus vidas!");
    comenta.generateComentario();
}

function activarComentariosIniciales() {
    addComentario1();
    addComentario2();
}

function mostrarComentarios() {
    var x = document.getElementById("poner_comentario");
    var comentarios = document.getElementById("comentarios");

    if(comentarios.style.display === "none" || comentarios.style.display === "") {
        comentarios.style.display = "flex";
        comentarios.style.flexDirection = "column";
        x.style.display = "flex";
        x.style.flexDirection = "column";
    } else {
        comentarios.style.display = "none";
    }
}

function aniadirComentarioUsuario() {
    var nombre = document.getElementById("name") ;
    var email = document.getElementById("mail") ;
    var comentario = document.getElementById("comentario_usuario") ;
    var comentarios = document.getElementById("comentarios") ;

    // trim() para eliminar los espacios en blanco al final y al inicio de la cadena.
    if (nombre.textContent.trim() !== "" && email.textContent.trim() && comentario.value.trim() !== "") {
        eliminarErrorComentarios(comentarios);
        if(validarCorreoElectronico(email.textContent.trim().toString())) {
            var date = new Date();
            date.setMilliseconds(Date.now());
            var comentarioUsuario = new Comentario(nombre.textContent.toString(), date, comentario.value.toString());
            comentarioUsuario.generateComentario();
        } else {
            console.log(email.textContent.toString());
            ErrorComentarios(comentarios, 2);
        }
    } else {
        ErrorComentarios(comentarios, 1);
    }
}

function validarCorreoElectronico(correo) {
    // Expresión regular para verificar el formato de correo electrónico
    const patron = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    /*
    ^ Indica el comienzo de la cadena.
    [^]+ Indica uno o más caracteres que no sean espacio en blanco.
    @ Indica la arroba literal.
    [^]+ Indica uno o más caracteres que no sean espacio en blanco.
    \. Indica el punto literal (se debe escapar con la barra invertida).
    [^\s@]+ Indica uno o más caracteres que no sean espacio en blanco.
    $ Indica el final de la cadena.
    */
    // Comprobación del correo electrónico mediante la función test (comprueba que la cadena sigue el patrón)
    return patron.test(correo);
}

function ErrorComentarios(comentarios, codError) {
    var excepcion = document.createElement('a');
    excepcion.setAttribute("id", "excepcion");
    eliminarErrorComentarios(comentarios);
    comentarios.appendChild(excepcion);

    if(codError === 1)
        excepcion.innerHTML = "Por favor, rellene todos los campos." ;
    else
        excepcion.innerHTML = "Correo electrónico inválido." ;

    excepcion.style.color = "red" ;
    excepcion.style.textAlign = "center";
    excepcion.style.fontFamily = "Comic Sans MS";
}

function eliminarErrorComentarios(comentarios) {
    if (comentarios.querySelector('#excepcion') !== null) {
        comentarios.removeChild(comentarios.querySelector('#excepcion'));
    }
}

function comprobarPalabrasMalsonantes() {
    var palabras_prohibidas = [];
    palabras_prohibidas = JSON.parse(document.getElementById('palabrasProhibidas').textContent);

    var textArea = document.getElementById("comentario_usuario");
    var texto = textArea.value;

    // Reemplazamos 10 palabras que creemos malsonantes por asteriscos. /gi para que sea insensible a mayúsculas y minúsculas y sea global.
    for (let palabra of palabras_prohibidas) {
        const patron = new RegExp(palabra[0], 'gi');
        let asteriscos = '*'.repeat(palabra[0].length);
        texto = texto.replace(patron, asteriscos);
    }

    textArea.value = texto;
}

function editarComentario(id_comentario) {
    var comentario = document.getElementById(id_comentario);
    var texto_comentario = comentario.textContent;
    comentario.innerHTML = prompt("Introduzca el nuevo comentario: ", texto_comentario) + " { editado por el moderador }";
}