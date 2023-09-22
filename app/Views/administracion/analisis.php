<script src="<?=base_url()?>js/pivot.js"></script>
<link rel="stylesheet" media="screen, print" href="<?=base_url()?>css/pivot.css">
<script src="https://pivottable.js.org/dist/pivot.es.js"></script>
<script src="<?=base_url()?>js/plotly-latest.js"></script>
<script src="<?=base_url()?>js/plotly_renderers.js"></script>
<script src='<?=base_url()?>js/d3.min.js'></script>
<script src='<?=base_url()?>js/jquery-ui.min.js'></script>
<div class="row">
    <div class="col m4">
        <label for="">Seleccion de tabla:</label>
        <select name="tabla">
            <option value="">Selecciona</option>
            <option value="vw_apuestas">General</option>
            <option value="vw_porcentajes">Porcentajes</option>
        </select>
    </div>
    <div class="col m8 text-right">
        <button type="button" onclick="actualizar_tabla()" class="btn teal">Actualizar Datos</button>
    </div>
</div>
<div class="row mt-3">
    <div class="col m12">
        <div id="tabla_apuestas"></div>
    </div>
</div>
<script>
    var pivot;
    var tabla = '';
    var obj = '';
    var renderers = $.extend($.pivotUtilities.renderers,$.pivotUtilities.plotly_renderers);
    // var obj= '[{canal:2,id:34,stake:4},{canal:22,id:334,stake:5}]';

    function actualizar_tabla(){
        api.get('<?=base_url()?>administracion/estadistica/'+tabla)
        .done(function(res){
            obj = JSON.parse(res).resultado
            console.log(obj);
            $("#tabla_apuestas").pivotUI(obj,{renderers});
        })         
    }

    $('body').on('change','select[name=tabla]',function(){
        if($(this).val() != ''){
            tabla = $(this).val();
            actualizar_tabla();
        }
    })

</script>