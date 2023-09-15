<script src="<?=base_url()?>js/pivot.js"></script>
<link rel="stylesheet" media="screen, print" href="<?=base_url()?>css/pivot.css">
<script src="https://pivottable.js.org/dist/pivot.es.js"></script>
<script src="<?=base_url()?>js/plotly-latest.js"></script>
<script src="<?=base_url()?>js/plotly_renderers.js"></script>
<script src='<?=base_url()?>js/d3.min.js'></script>
<script src='<?=base_url()?>js/jquery-ui.min.js'></script>
<div class="row">
    <div class="col m12">
        <div id="tabla_apuestas"></div>
    </div>
</div>
<script>
    var pivot;
    var obj = <?=$datos?>.resultado;
    console.log(obj);
    var renderers = $.extend($.pivotUtilities.renderers,$.pivotUtilities.plotly_renderers);
    // var obj= '[{canal:2,id:34,stake:4},{canal:22,id:334,stake:5}]';

    $(document).ready(function(){
        console.log(obj);
        $("#tabla_apuestas").pivotUI(obj,{renderers});
    })

</script>