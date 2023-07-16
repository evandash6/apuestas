<link href="<?=base_url()?>css/tabulator.css" rel="stylesheet">
<script type="text/javascript" src="<?=base_url()?>js/tabulator.js"></script>
<div class="row">
    <div class="col m12 text-right">
        <button onclick="location.href='<?=base_url()?>administracion/edicion_apuesta'" class="btn teal">Nueva Apuestas</button>
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
        api.get('<?=base_url()?>administracion/lista_apuestas_historial')
        .done(function(res){
            table.setData(JSON.parse(res).resultado);
        })    
    }

    let columnas = [];
    
    columnas.push(
        {title:"Resultado", field:"resultado", sorter:"string",hozAlign:'center',width:200},
        {title:"Canal", field:"canal", sorter:"string",hozAlign:'center',width:200},
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

</script>