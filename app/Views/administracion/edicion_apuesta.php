<form id="frm_apuesta">
    <input type="hidden" name="id">
<div class="row">
    <div class="col m6 s12">
        <label for="">Evento:</label>
        <input type="text" name="evento">
    </div>
</div>
<div class="row mt-2">
    <div class="col m6 s6">
        <label for="">Canal:</label>
        <select name="canal_id"><?=$canales_opc?></select>
    </div>
    <div class="col m6 s6">
        <label for="">Deporte:</label>
        <select name="deportes_id"><?=$deportes_opc?></select>
    </div>
</div>
<div class="row mt-2">
    <div class="col m6 s5">
        <label for="">Pronostico:</label>
        <input type="text" name="pronostico">
    </div>
    <div class="col m2 s3">
        <label for="">Cuota:</label>
        <input type="text" name="cuota" class="text-center">
    </div>
    <div class="col m2 s3">
        <label for="">Stake:</label>
        <input type="text" name="stake" class="text-center">
    </div>
</div>
<div class="row mt-2">
    <div class="col m3 s6">
        <label for="">Fecha Evento:</label>
        <input type="date" name="fecha_evento">
    </div>
    <div class="col m3 s6">
        <label for="">Resultado:</label>
        <select name="resultado"><option selected>Selecciona</option><option value="Acertada">Acertada</option><option value="Fallada">Fallada</option></select>
    </div>
    <div class="col m6 s12">
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
                if(res.status == 201 || res.status == 200)
                    alertf('Cambios realizados','','success',function(){ 
                        location.href = '<?=base_url()?>administracion/apuestas'
                    })
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