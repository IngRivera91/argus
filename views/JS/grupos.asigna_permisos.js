var session_id = $('#session_id').val();
function asigna_permisos(metodo_id,grupo_id) {

    if ( $('#'+metodo_id).hasClass("btn-"+COLORBASE_BOOTSTRAP) ){
        // quitar permisos
        var url = 'index.php?controlador=grupos&metodo=baja_permiso&session_id='+session_id+'&metodo_id='+metodo_id+
            '&grupo_id='+grupo_id;
        $.ajax({
            url: url,
            type: "POST",
            data: {},
            success: function (data) {
                
                var respuesta = data['respuesta'];

                if(respuesta == true){
                    $('#'+metodo_id).removeClass("btn-"+COLORBASE_BOOTSTRAP).addClass("btn-default");
                    return false;
                }else{

                    alert('algo salio mal')
                    return false;
                }

            },
            error: function (xhr, status) {
                console.log('entro a error');
            }
        });

    }else{
        // agregar permisos
        var url = 'index.php?controlador=grupos&metodo=alta_permiso&session_id='+session_id+'&metodo_id='+metodo_id+
            '&grupo_id='+grupo_id;
        $.ajax({
            url: url,
            type: "POST",
            data: {},
            success: function (data) {
                
                
                var respuesta = data['respuesta'];

                if(respuesta == true){
                    $('#'+metodo_id).removeClass("btn-default").addClass("btn-"+COLORBASE_BOOTSTRAP );
                    return false;
                }else{

                    alert('algo salio mal')
                    return false;
                }

            },
            error: function (xhr, status) {
                console.log('entro a error');
            }
        });
    }
}