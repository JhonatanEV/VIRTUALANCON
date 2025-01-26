$(document).ready(function(){

});

function verPerfil(){
    let url = "seguridad/perfil";
    showPopup(url,"modalPerfil",className="modal-lg",titulo="Mi perfil");
}
function cambiarClave(){
    let url = "seguridad/claveView";
    showPopup(url,"modalPerfil",className="modal-sm",titulo="Cambiar clave");
}

function cambiarArea(val){
    let url = "seguridad/cambiar-area?AREA_CODIGO="+val;

    fetchGet(url,function(data){
        showMessage(data.accion,data.smg, "Alerta!");
        location.reload();
    });
}

