
function(metodoId,grupoId) {

    let session_id = document.getElementById('session_id').value;
    let classConPermiso = 'con-permiso-btn';
    let classSinPermiso = 'sin-permiso-btn';

    let metodo = 'altaPermiso';
    let quitarClase = classSinPermiso;
    let ponerClase = classConPermiso;

    if ( document.getElementById(metodoId).classList.contains(classConPermiso) ){
        metodo = 'bajaPermiso';
        quitarClase = classConPermiso;
        ponerClase = classSinPermiso;
    }

    let url = 'index.php?controlador=Group&metodo='+metodo+'&session_id='+session_id+'&metodoId='+metodoId+'&grupoId='+grupoId;

    fetch(url,{method: 'POST'})
    .then(function(response) {
        if(response.ok) {
            document.getElementById(metodoId).classList.remove(quitarClase);
            document.getElementById(metodoId).classList.add(ponerClase);
            return false;
        } else {
            console.log('Respuesta de red OK pero respuesta HTTP no OK');
        }
    })
    .catch(function(error) {
        console.log('Hubo un problema con la petición Fetch:' + error.message);
    });
}
