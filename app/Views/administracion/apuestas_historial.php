<link href="<?=base_url()?>css/tabulator.css" rel="stylesheet">
<script type="text/javascript" src="<?=base_url()?>js/tabulator.js"></script>
<div class="row">
    <div class="col m3 mt-4">
        <h6 class="teal-text" id="txt_cantidad_reg"></h6>
    </div>
    <div class="col m4 offset-m5">
        <label for="">Filtro por Canal:</label>
        <select name="canales"><?=$canales_opc?></select>
    </div>
</div>
<div class="row mt-2">
    <div class="col m12 s12">
        <div id="tabla_apuestas"></div>
    </div>
</div>



<script>
    var table;
    var frm_mini = '<form id="#frm_estatus"> <div class="row"> <div class="col m12"> <label for="">Resultado:</label> <select name="resultado"><option selected>Selecciona</option><option value="Acertada">Acertada</option><option value="Fallada">Fallada</option></select> </div> </div> <div class="row"> <div class="col m12 text-right"> <button class="btn teal">Guardar</button> </div> </div> </form>';
    function actualiza_tabla(ide=null){
        api.get('<?=base_url()?>administracion/lista_apuestas_historial/'+ide,false)
        .done(function(res){
            $('body').on('ready','#mdl_txt_carga',function(){
                $(this).text('Data')
            })
            table.setData(JSON.parse(res).resultado);
        })    
    }

    let columnas = [];
    let result = function(cell, formatterParams){
        let res = '';
        if(cell.getRow().getData().resultado == 'Acertada')
            res = '<b class="green-text">Acertada</b>';
        else if(cell.getRow().getData().resultado == 'Fallada')
            res = '<b class="red-text">Fallada</b>';
        else
            res = 'Nulo';
        return res;
    };

    let icons = function(cell, formatterParams){
        return '<button onclick="location.href=\'<?=base_url()?>administracion/edicion_apuesta/2/'+cell.getRow().getData().id+'\'" class="btn btn-sm orange darken-1 mr-5"><i class="fa fa-edit"></i></button>';
    };
    
    columnas.push(
        {title:'Acciones', formatter:icons,hozAlign:'center',headerHozAlign:'center',width:100},
        {title:'Resultado', field:'resultado',headerFilter:"input",formatter:result,hozAlign:'center',headerHozAlign:'center',width:110,headerSort:true},
        {title:"F. Evento", field:"fecha_evento",headerFilter:"input",hozAlign:'center',width:100},
        {title:"Evento", field:"evento", sorter:"string",headerFilter:"input",hozAlign:'center',width:240},
        {title:"Pronostico", field:"pronostico",headerFilter:"input",hozAlign:'center',width:240},
        {title:"Cuota", field:"cuota",headerFilter:"input",hozAlign:'center',width:80},
        {title:"Tipo", field:"deporte",headerFilter:"input",hozAlign:'center',width:80},
        {title:"Stake", field:"stake",headerFilter:"input",hozAlign:'center',width:80},
        {title:"Combinada", field:"combinada",headerFilter:"input",hozAlign:'center',width:100},
    );

        table = new Tabulator("#tabla_apuestas", {
        layout:"fitData",
        columns:columnas,
        movableRows: true,
        pagination:true, //enable pagination
        paginationMode:"local", //enable remote pagination
        paginationSize:40, //optional parameter to request a certain number of rows per page
    });

    $(document).ready(function(){
        actualiza_tabla();

        table.on("dataFiltered", function(filters,rows){
            $('#txt_cantidad_reg').text("Total de Registros: "+rows.length);
        });
    })

    $('body').on('change','select[name=canales]',function(){
        let ide = $(this).val();
        actualiza_tabla(ide);
    })

</script>