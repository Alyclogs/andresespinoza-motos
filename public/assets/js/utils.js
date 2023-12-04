/**
 * 
 * @param {string} fileRoute El nombre del archivo que contiene la función a ejecutar
 * @param {string} functionName El nombre de la función a ejecutar
 * @param {string | undefined} parameter (Opcional) El parámetro de la función
 */
function ejecutarFuncion(fileRoute, functionName, parameter) {
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
        }
    };

    var urlCompleta = fileRoute + "?accion=" + encodeURIComponent(functionName) + parameter ? "&parametro=" + encodeURIComponent(parameter) : "";
    xmlhttp.open("GET", urlCompleta, true);
    xmlhttp.send();
}

function handleClick(event, nombreFuncion, parametro) {
    event.preventDefault();
    
    ejecutarFuncion(nombreFuncion, parametro);
}