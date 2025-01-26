<?php
$param = $_GET?$_GET:$_POST;
$url = trim($param['p1']);
$java = trim($param['vjs']);
$width = trim($param['vwidth']);
$height= trim($param['vheight']);
$vtitle= trim($param['vtitle']);
$parametros = '';
foreach($param as $index =>$value)
    $parametros.=$index.'='.$value.'&';    
?>
<script type="text/javascript">
Ext.ns('reportes_view');
reportes_view = {
    vurl:'<?php echo $url;?>',
    vParam:'<?php echo $parametros;?>',    
    init:function(){       
        var panel = new Ext.Panel({
            html:"<iframe src='"+this.vurl+"?"+this.vParam+"' onload='reportes_view.unMask()' width='99%' height='450px' style='border:0px' more attributes></iframe>"            
        });
            var winx = new Ext.Window({
            id:'reportes_view_win',            
            title:'<?php echo $vtitle?>',
			width:<?php echo $width; ?>,
            height:<?php echo $height; ?>,
			layout:'fit',
            autoDestroy:true, autoScroll:false, minimizable: false, maximizable: true,
            closable:true,
	    collapsible:false, draggable:true, modal:true,
            onEsc:function(){winx.close();win.destroy();}, resizable:false,
            padding:2,
            buttonAlign:'left',
            buttons:[{
                        text:'Cerrar',iconCls:'btn_cancelar',
                        listeners:{
                            click:function(){
                                winx.close();
				if($java!='')
                                eval('<?php echo $java;?>');
                            }
                        }
                    }
                ],
            items:[ panel ]
            });
        winx.show();
    },
    unMask:function(){        
    }
}
Ext.onReady(reportes_view.init,reportes_view);
</script>