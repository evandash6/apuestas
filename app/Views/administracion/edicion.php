<form id="frm_canal">
    <input type="hidden" name="id">
<div class="row">
    <div class="col m3 s12">
        <label for="">Nombre Canal:</label>
        <input type="text" name="nombre">
    </div>
</div>
<div class="row mt-2">
    <div class="col m6 s12">
        <label for="">Link:</label>
        <input type="text" name="link">
    </div>
</div>
<div class="row mt-2">
    <div class="col m6 s12">
        <label for="">Observaciones:</label>
        <textarea class="materialize-textarea" name="observaciones"></textarea>
    </div>
</div>
<div class="row mt-2">
    <div class="col m6 s12 text-right">
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

    $('textarea').each(function(index, element) {
        let nombre = $(this).attr('name');
        $(this).html(obj[nombre])
    });

    $('body').on('click','.btx_save',function(e){
        e.stopPropagation();
        let forms = $('#frm_canal');
        if(forms[0].reportValidity() === false){
            forms[0].classList.add('was-validated');
        }
        else{
            let formData = new FormData(forms[0]);            
            api.post('<?=base_url()?>/administracion/save_canal',formData,true)
            .done(function(data){
                let res = JSON.parse(data);
                console.log(res);
                if(res.status == 201 || res.status == 200)
                    alertf('','','success',function(){ 
                        location.href = '<?=base_url()?>administracion/canales'
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