<link href="<?=base_url()?>css/tabulator.css" rel="stylesheet">
<script type="text/javascript" src="<?=base_url()?>js/tabulator.js"></script>
<div class="row">
    <div class="col m12 text-right">
        <button onclick="location.href='<?=base_url()?>administracion/edicion_apuesta/1/'" class="btn teal">Nueva Apuestas</button>
    </div>
</div>
<div class="row mt-2">
    <div class="col m12 s12">
        <div id="tabla_apuestas"></div>
    </div>
</div>



<script>

    var frm_mini = '<form id="#frm_estatus"> <div class="row"> <div class="col m12"> <label for="">Resultado:</label> <select name="resultado"><option selected>Selecciona</option><option value="Acertada">Acertada</option><option value="Fallada">Fallada</option></select> </div> </div> <div class="row"> <div class="col m12 text-right"> <button class="btn teal">Guardar</button> </div> </div> </form>';
    function actualiza_tabla(){
        api.get('<?=base_url()?>administracion/lista_apuestas')
        .done(function(res){
            table.setData(JSON.parse(res).resultado);
            console.log(table.getRows().length)
        })    
    }

    let columnas = [];
    let icons = function(cell, formatterParams){
        return '<button onclick="location.href=\'<?=base_url()?>administracion/edicion_apuesta/1/'+cell.getRow().getData().id+'\'" class="btn btn-sm orange darken-1 mr-5"><i class="fa fa-edit"></i></button>' + 
        '<button ide="'+cell.getRow().getData().id+'" eve="'+cell.getRow().getData().evento+'" class="btx_elim btn btn-sm red darken-1 mr-5"><i class="fa fa-trash"></i></button>';
    };
    
    columnas.push(
        {title:'Acciones', formatter:icons,hozAlign:'center',headerHozAlign:'center',width:100},
        {title:"Evento", field:"evento", sorter:"string",headerFilter:"input",hozAlign:'center',width:240},
        {title:"Pronostico", field:"pronostico",headerFilter:"input",hozAlign:'center',width:240},
        {title:"Cuota", field:"cuota",headerFilter:"input",hozAlign:'center',width:100},
        {title:"Stake", field:"stake",headerFilter:"input",hozAlign:'center',width:100},
        {title:"Canal", field:"canal", sorter:"string",hozAlign:'center',width:200},
        {title:"Resultado", field:"resultado", sorter:"string",hozAlign:'center',width:200},
    );

    var table = new Tabulator("#tabla_apuestas", {
        layout:"fitData",
        columns:columnas,
        pagination:true, //enable pagination
        paginationMode:"local", //enable remote pagination
        paginationSize:40, //optional parameter to request a certain number of rows per page
    });

    $(document).ready(function(){
        actualiza_tabla();
    })

    $('body').on('click','.btx_elim',function(){
        let eve = $(this).attr('eve');
        let ide = $(this).attr('ide');
        confirm('Eliminación de Evento','<div style="text-align:center;width:100%">¿Deseas eliminar el evento <b>'+eve+'</b>?</div>','info',function(){
            api.get('<?=base_url()?>/administracion/elimina_apuesta/'+ide,true)
            .done(function(data){
                let res = JSON.parse(data);
                console.log(res);
                if(res.status == 200)
                    alertf('Eliminación realizada','','success',function(){ 
                        actualiza_tabla();
                    })
                else
                alertf('','Error al eliminar el registro','error',function(){ 
                    console.error(res.messages)
                });
            })
            .fail(function(res){
                console.error(JSON.parse(res).messages);
            })
        },
        function(){
            alert('Eliminación Cancelada')
        })
    })
</script>