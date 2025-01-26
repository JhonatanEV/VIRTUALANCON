

$(document).ready(function() {
    $("#jstree").jstree();
    createJSTree(1);


});
function format(t) {
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;"><tr><td>Full name:</td><td>' + t.name + "</td></tr><tr><td>Extension number:</td><td>" + t.extn + "</td></tr><tr><td>Extra info:</td><td>And any further details here (images etc)...</td></tr></table>"
}


$('.btnGetAllTopLevelCheckedItems').click(function(){
    var checked_ids = []; 
    var selectedNodes = $('#SimpleJSTree').jstree("get_top_checked", true);
    $.each(selectedNodes, function() {
        checked_ids.push(this.id);
    });
    $('#idshow').text("Top level checked items:"+checked_ids);
});

$('.btnGetAllBottomLevelCheckedItems').click(function(){
    var checked_ids = []; 
    var selectedNodes = $('#SimpleJSTree').jstree("get_bottom_checked", true);
    $.each(selectedNodes, function() {
        checked_ids.push(this.id);
    });
    $('#idshow').text("Bottom level checked items:"+checked_ids);
});
      

    function selectedPerfil(id_perfil){
        console.log(id_perfil);
        //$("#SimpleJSTree").html("");
        $('#SimpleJSTree').jstree(true).settings.core.data = {
                    'url' :urljs+'SeguridadController/consulta_perfil',
                    "type": "GET",
                    "dataType": "json",
                    'data' : function (node) { 
                        return { 'id' : node.id,'id_perfil' : id_perfil }; 
                    } };
        $('#SimpleJSTree').jstree(true).refresh();
    }

    // $('#jstree').on('activate_node.jstree', function (e, data) {
    //     if (data == undefined || data.node == undefined || data.node.id == undefined)
    //     return;

    //     console.log('clicked node: ' + data.node.id);
    //     //createJSTree(data.node.id);
    // });

    function createJSTree(id_perfil) {

       var myTree = $('#SimpleJSTree').jstree({
            "themes": {
                "responsive": true
            },
            "core": {
                "check_callback": true,
                'data': {
                    'url' : urljs+'SeguridadController/consulta_perfil',
                    "type": "GET",
                    "dataType": "json",
                    'data' : function (node) { 
                        return { 'id' : node.id,'id_perfil' : id_perfil }; 
                    } 
                }                    
            },
            "checkbox" : {
                "keep_selected_style" : false
            },
            "plugins": ["checkbox"]
        });

        myTree.bind("click.jstree", function (event, data) { 
            console.log("Bind Result: " + event.type); 
        }); 
       

    }