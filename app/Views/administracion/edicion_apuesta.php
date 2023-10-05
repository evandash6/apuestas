<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<form id="frm_apuesta">
    <input type="hidden" name="id">
    <input name="deportes_id" type="hidden" value="1">
<div class="row">
    <div class="col m6 s12">
        <label for="">Evento:</label>
        <input type="text" name="evento" required value="Generico">
    </div>
</div>
<div class="row mt-2">
    <div class="col m6 s6">
        <label for="">Canal:</label>
        <select name="canal_id" required><?=$canales_opc?></select>
    </div>
    <div class="col m6 s5">
        <label for="">Pronostico:</label>
        <div id="select"></div>
    </div>
</div>
<div class="row mt-2">
    
    <div class="col m2 s3">
        <label for="">Cuota:</label>
        <input type="number" name="cuota" class="text-center" step="0.01" required>
    </div>
    <div class="col m2 s3">
        <label for="">Stake:</label>
        <input type="number" name="stake" class="text-center" required>
    </div>
    <div class="col m2 s3">
        <label for="">Combinada:</label>
        <input type="text" name="combinada" class="text-center" required>
    </div>
    <div class="col m3 s6">
        <label for="">Fecha Evento:</label>
        <input type="date" name="fecha_evento" value="<?=$fecha_evento?>">
    </div>
    <div class="col m3 s6">
        <label for="">Resultado:</label>
        <select name="resultado"><option selected>Selecciona</option><option value="Acertada">Acertada</option><option value="Fallada">Fallada</option><option value="Nulo">Nulo</option></select>
    </div>
</div>
<div class="row mt-2">
    <div class="col m12 s12">
        <label for="">Observaciones:</label>
        <textarea class="materialize-textarea" name="observaciones"></textarea>
    </div>
</div>
<div class="row mt-2">
    <div class="col m12 s12 text-right">
        <button type="button" class="btn btx_save teal">Guardar</button>
    </div>
</div>
</form>

<script>

    var obj = <?=$resultado?>;
    
    $(document).ready(function(){
        $('#select').html('<select name="pronostico" class="select2" style="position: absolute;width: 100%;heigth:40px !important"><?=$pronosticos?></select>');
        $('.select2').select2();
        $('.select2').focus();
    })

    if(Object.keys(obj).length > 0){
        $('input').each(function(index, element) {
            let nombre = $(this).attr('name');
            $(this).val(obj[nombre])
        });

        $('select').each(function(index, element) {
            let nombre = $(this).attr('name');
            $(this).val(obj[nombre])
        });

        $('textarea').each(function(index, element) {
            let nombre = $(this).attr('name');
            $(this).html(obj[nombre])
        });
    }
    else{
        $('select[name=canal_id]').val(<?=$canal_id?>);
    }
    

    $('body').on('click','.btx_save',function(e){
        e.stopPropagation();
        let forms = $('#frm_apuesta');
        if(forms[0].reportValidity() === false){
            forms[0].classList.add('was-validated');
        }
        else{
            let formData = new FormData(forms[0]);            
            api.post('<?=base_url()?>/administracion/save_apuesta',formData,true)
            .done(function(data){
                let res = JSON.parse(data);
                console.log(res);
                if(res.status == 201 || res.status == 200){
                    if(<?=$tipo?> == 1)
                        location.href = '<?=base_url()?>administracion/apuestas'                           
                    else
                        location.href = '<?=base_url()?>administracion/apuestas_historial'
                }
                else
                alertf('','Error al guardar/actualizar el registro','error',function(){ 
                    console.error(res.messages)
                });
            })
            .fail(function(res){
                console.error(JSON.parse(res).messages);
            })       
        }
        
    })

</script>