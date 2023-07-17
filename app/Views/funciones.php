<script>
    //Funcion de un simple alert con salida
    function alert(titulo,texto,icono,salida=null){
        Swal.fire({
        icon: icono,
        title: titulo,
        html: texto,
        allowOutsideClick: false,
        allowEscapeKey: false
        })
        .then(() => {
            if(salida != null)
                location.href = salida
        })
    }

    //Funcion  de un alert con funcion extra
    function alertf(titulo,texto,icono,fn=function(){}){
        Swal.fire({
        icon: icono,
        title: titulo,
        html: texto,
        allowOutsideClick: false,
        allowEscapeKey: false,
        onClose: () => {
            fn();
        }
        })
    }

    //Funcion para un modal de confirmacion
    function confirm(titulo,texto,icono,fn=function(){},fn2=function(){}){
        return new Promise(function(resolve, reject) {
        Swal.fire({
            icon: icono,
            title: titulo,
            html:texto,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Confirmar',
            allowOutsideClick: false,
            allowEscapeKey: false
        })
        .then(function(result){
            if(result.value){
                resolve(true);
                fn();
            }
            else{
                fn2();
            }
        })
        });
    }

    async function pausa(tiempo,fn=function(){}) {
        await sleep(tiempo);
        fn();
    }

    //Funcion para determinar el tiempo en la carga
    function sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

    //Funcion generica para mostrar o no un alert de carga
    async function cargando(t=0,fn=function(){},view=1){
        if(view==1){
            Swal.fire({
            html: '<div class="row text-center"><div class="col-md-12"><img style="max-width:150px" src="<?=base_url()?>img/spinner.gif" class="img"></div><div class="col-md-12"><p style="font-size:20px"><b id="mdl_txt_carga">Cargando..</b></p></div></div>',
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false
            })
            if(t > 0){
            await sleep(t*1000);
            Swal.close();
            fn();
            }
        }
        else{
            if(t > 0){
                await sleep(t*1000);
                fn();
            }
        }
    }

    function modal(titulo,codigo,ancho=750,footer=null){
        Swal.fire({
            width: ancho,
            position: 'center',
            title: titulo,
            html:'<hr style="background-color: #eee">'+codigo,
            footer:footer,
            showCancelButton: false,
            showConfirmButton: false,
            showCloseButton: false,
            allowOutsideClick: false,
            allowEscapeKey: true
        })
    }

    var api = { 
        get: function (url,activo=true) {
            (activo)?cargando():'';
            return $.ajax({
                url: url,
                type : 'GET',
                contentType: false,
                processData: false,
                cache: false
            }).done(function(){ if(activo)swal.close()});
        },
        post: function (url,data,activo=false,load=true,tipo='formdata'){
           switch (tipo) {
            case 'formdata':
                (activo)?cargando():'';
                return $.ajax({
                    url: url,
                    type : 'POST',
                    data: data,
                    contentType: false,
                    processData: false,
                    cache: false
                }).done(function(){ if(activo)swal.close()});
            break;
            case 'text':
                (activo)?cargando():'';
                console.log(data);
                return $.ajax({
                    url: url,
                    type : 'POST',
                    dataType: 'text',
                    contentType: 'text/plain',
                    processData: true,
                    data: data,
                    cache: false
                }).done(function(){ if(activo)swal.close()});
            break;
            case 'json':
                (activo)?cargando():'';
                return $.ajax({
                    url: url,
                    type: "POST",
                    dataType: "json",
                    contentType: "application/json;charset=UTF-8",
                    data: JSON.stringify(data)
                }).done(function(){ if(activo)swal.close()});
            break;
           }
        }
    };

    //funcion para cerar chosen
    function crea_chose(){
        var config = {
        '.chosen-select'           : {},
        '.chosen-select-deselect'  : { allow_single_deselect: true },
        '.chosen-select-no-single' : { disable_search_threshold: 10 },
        '.chosen-select-no-results': { no_results_text: 'Oops, no hay registros!' },
        '.chosen-select-rtl'       : { rtl: true },
        '.chosen-select-width'     : { width: '95%' }
        }
        for (var selector in config) {
            $(selector).chosen(config[selector]);
            $(selector).trigger("chosen:updated");
            $(selector).attr('style','opacity:0;position:absolute;width:10px');
        }
    }

    $('body').on('click','.profile-button',function(){
        $('#profile-dropdown').show();
    })
</script>
