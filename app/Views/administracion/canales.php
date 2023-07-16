<link href="<?=base_url()?>css/tabulator.css" rel="stylesheet">
<script type="text/javascript" src="<?=base_url()?>js/tabulator.js"></script>
<div class="row">
    <div class="col s12 text-right">
        <button onclick="location.href='<?=base_url()?>administracion/edicion'" class="btn indigo">Nuevo Canal</button>
    </div>
</div>
<div class="row mt-2">
    <div class="col s12">
        <div id="tabla_canales"></div>
    </div>
</div>
<script>
    
    function actualiza_tabla(){
        api.get('<?=base_url()?>administracion/lista_canales')
        .done(function(res){
            table.setData(JSON.parse(res).resultado);
        })    
    }

    let columnas = [];
    let icons = function(cell, formatterParams){
        return '<button ide="'+cell.getRow().getData().id+'" class="btx_edit btn btn-sm orange darken-1 mr-5"><i class="fa fa-edit"></i></button>'+
        '<button ide="'+cell.getRow().getData().id+'" eve="'+cell.getRow().getData().nombre+'" class="btx_elim btn btn-sm red darken-1 mr-5"><i class="fa fa-trash"></i></button>';
    };
    
    columnas.push(
        {title:'Acciones', formatter:icons,hozAlign:'center',headerHozAlign:'center',width:100},
        {title:"Nombre", field:"nombre", sorter:"string",headerFilter:"input",hozAlign:'center',width:240},
        {title:"Link", field:"link",headerFilter:"input",hozAlign:'center',width:240},
        {title:"Observaciones", field:"observaciones", sorter:"string",hozAlign:'center',width:400}
    );

    var table = new Tabulator("#tabla_canales", {
        layout:"fitData",
        columns:columnas,
        pagination:true, //enable pagination
        paginationMode:"local", //enable remote pagination
        paginationSize:40, //optional parameter to request a certain number of rows per page
    });

    $(document).ready(function(){
        actualiza_tabla();
    })

    $('body').on('click','.btx_edit',function(){
        let ide = $(this).attr('ide');
        location.href = '<?=base_url()?>administracion/edicion/'+ide;
    })

    $('body').on('click','.btx_elim',function(){
        let eve = $(this).attr('eve');
        let ide = $(this).attr('ide');
        confirm('Eliminación de Canal','<div style="text-align:center;width:100%">¿Deseas eliminar el canal <b>'+eve+'</b>, esto eliminara tambien las apuestas asociadas a este canal?</div>','info',function(){
            api.get('<?=base_url()?>/administracion/elimina_canal/'+ide,true)
            .done(function(data){
                let res = JSON.parse(data);
                console.log(res);
                if(res.status == 200)
                    alertf('Eliminación realizada','','success',function(){ 
                        actualiza_tabla();
                    })
                else
                alertf('Error al eliminar el canal','','error',function(){ 
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