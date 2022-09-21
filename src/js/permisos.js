module.exports = {
    permisos: function (metodoId,grupoId) {

        let session_id = $('#session_id').val();
        let classConPermiso = 'con-permiso-btn';
        let classSinPermiso = 'sin-permiso-btn';

        let metodo = 'altaPermiso';
        let quitarClase = classSinPermiso;
        let ponerClase = classConPermiso;

        if ( $('#'+metodoId).hasClass(classConPermiso) ){
            metodo = 'bajaPermiso';
            quitarClase = classConPermiso;
            ponerClase = classSinPermiso;
        }

        let url = 'index.php?controlador=Group&metodo='+metodo+'&session_id='+session_id+'&metodoId='+metodoId+'&grupoId='+grupoId;

        $.ajax({
            url: url,
            type: "POST",
            data: {},
            success: function (data) {
                console.log(data);
                let respuesta = data['respuesta'];
                if(respuesta == true){
                    $('#'+metodoId).removeClass(quitarClase).addClass(ponerClase);
                    return false;
                }
                alert(data['error'])
                return false;
            },
            error: function (xhr, status) {
                console.log('entro a error');
            }
        });
    }
};