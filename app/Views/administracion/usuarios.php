<link href="<?=base_url()?>css/tabulator.css" rel="stylesheet">
<script type="text/javascript" src="<?=base_url()?>js/tabulator.js"></script>
<link href="<?=base_url()?>css/chosen.css" rel="stylesheet"/>
<script src="<?=base_url()?>js/chosen.jquery.js"></script>
<div class="row mt-1">
    <div class="col12">
        <div id="tabla_usuarios"></div>
    </div>
</div>
<br><br><br><br>

<script>

    function actualiza_tabla(){
        api.get('<?=base_url()?>/administracion/consulta_usuarios')
        .done(function(res){
            table.setData(JSON.parse(res).resultado);
        })
    }

    let columnas = [];
    let icons = function(cell, formatterParams){
            let color = (cell.getRow().getData().activo == 1)? 'green lighten-2':'grey';
            return '' +
            '<button ide="'+cell.getRow().getData().id+'" val="'+cell.getRow().getData().activo+'" class="btx_activar btn btn-sm '+color+' mr-5"><i class="fa fa-power-off"></i></button>' + 
            '<button ide="'+cell.getRow().getData().id+'" val="'+cell.getRow().getData().perfil_id+'" pro="'+cell.getRow().getData().promotoria_id+'" class="btx_editar btn btn-sm yellow darken-3 mr-1"><i class="fa fa-edit"></i></button>';
    };
    columnas.push(
        {title:'Acciones', formatter:icons,hozAlign:'center',headerHozAlign:'center',width:100},
        {title:"Nombre", field:"nombre",headerFilter:"input",hozAlign:'center',width:250},
        {title:"Email", field:"email", sorter:"string",headerFilter:"input",hozAlign:'center',width:250},
        {title:"Perfil", field:"perfil", sorter:"string",hozAlign:'center',width:150},
        {title:"PDF", field:"pdf", sorter:"string",hozAlign:'center',width:200},
        {title:"Estatus", field:"estatus", sorter:"string",hozAlign:'center',width:150}
    );

    var table = new Tabulator("#tabla_usuarios", {
        layout:"fitData",
        columns:columnas,
        pagination:"local",
        paginationSize:20,
        rowFormatter:function(row){
            if(row.getData().salida > 0){
                row.getElement().style.backgroundColor = "#8BDBF1";
            }
            if(row.getData().entrada > 0){
                row.getElement().style.backgroundColor = "#D4F5B8";
            }
        }
    });

    $(document).ready(function(){
        actualiza_tabla();
    })

    $('body').on('click','.btx_activar',function(){
        let ide = $(this).attr('ide');
        let val = $(this).attr('val');
        api.get('<?=base_url()?>/administracion/activa_usuarios/'+ide+'/'+val,false)
        .done(function(res){
            actualiza_tabla();
        })
    })

    $('body').on('click','.btx_editar',function(){
        let ide = $(this).attr('ide');
        let val = $(this).attr('val');
        let pro = $(this).attr('pro');
        modal('Asignación de Perfil','<form id="frm_edit" action="#"> <div class="row"> <input type="hidden" name="id" value="'+ide+'" /> <div class="col m12"> <label for="">Perfil:</label> <select name="perfil_id" class="chosen-select browser-default" required> <?=$perfiles_opc?> </select> </div> </div> <div class="row mt-2"> <div class="col m12"> <label for="">Promotorias:</label> <select name="promotoria_id" class="chosen-select browser-default" required><?=$promotorias_opc?></select> </div> </div> <div class="row mt-4"> <div class="col m12 text-right"><button type="button" onclick="swal.close()" class="btn red lighten-1 mr-1">Cancelar</button> <button ide="'+ide+'" type="button" class="btn teal btx_asig">Asignar</button></div> </div> </form> ',500)
        $('select[name="perfil_id"]').val(val);
        $('select[name="promotoria_id"]').val(pro);
        crea_chose();
    })

    $('body').on('change','select[name=perfil_id]',function(){
        let tipo = $(this).val();
        if(tipo == 1){
            $('select[name="promotoria_id"]').val(1);
            crea_chose();
        }
    })

    $('body').on('click','.btx_asig',function(){
        let forms = $('#frm_edit');
        if(forms[0].reportValidity() === false){
            forms[0].classList.add('was-validated');
        }
        else{
            let formData = new FormData(forms[0]);
            // console.log(formData)
            api.post('<?=base_url()?>/administracion/actualiza_usuarios',formData,true,false)
            .done(function(data){
                let res = JSON.parse(data);
                if(res.status == 200){
                    actualiza_tabla();
                }
                else{
                    console.log(res.msg);
                    alert('Hubo un error al actualizar el registro',res.msg,'error');
                }
            })
            .fail(function(res){
                console.log(res)
            })
        }
    })

</script>