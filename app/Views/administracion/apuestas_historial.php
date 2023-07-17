<link href="<?=base_url()?>css/tabulator.css" rel="stylesheet">
<script type="text/javascript" src="<?=base_url()?>js/tabulator.js"></script>
<div class="row">
    <div class="col m4 offset-m8">
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
    
    columnas.push(
        {title:'Resultado', field:'acciones', formatter:result,hozAlign:'center',headerHozAlign:'center',width:110,headerSort:false},
        {title:"Resultado", field:"resultado", sorter:"string",hozAlign:'center',width:120},
        {title:"Canal", field:"canal", sorter:"string",hozAlign:'center',width:200},
        {title:"F. Evento", field:"fecha_evento",headerFilter:"input",hozAlign:'center',width:100},
        {title:"Evento", field:"evento", sorter:"string",headerFilter:"input",hozAlign:'center',width:240},
        {title:"Pronostico", field:"pronostico",headerFilter:"input",hozAlign:'center',width:240},
        {title:"Cuota", field:"cuota",headerFilter:"input",hozAlign:'center',width:100},
        {title:"Stake", field:"stake",headerFilter:"input",hozAlign:'center',width:100},
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

    $('body').on('change','select[name=canales]',function(){
        let ide = $(this).val();
        actualiza_tabla(ide);
    })

</script>