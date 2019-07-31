<script language="javascript" type="text/javascript">

    function swalMsj(mensaje,type){
        swal({
            title: '',
            text: mensaje,
            type: type,
            confirmButtonColor: '#CE1129',
            html: true
        });
    }



    function datatableInit(){
        //parametros del datatables
        $('.tabla').dataTable({
            
            'bPaginate': true,
            'bLengthChange': false,
            'bFilter': true,
            'bSort': true,
            'order': [[ 0, "desc" ]],
            'bInfo': false,
            'bAutoWidth': true,
            "language": {
                "lengthMenu": "Mostar _MENU_ registros por página",
                "zeroRecords": "No Hay Resultados - Disculpe",
                "info": "Mostrando Página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(filtered from _MAX_ total records)",
                "search": "Buscar",
                "paginate": {
                    "previous": "Anterior",
                    "next":"próximo"
                }
            }
        });
    }


    function resetDatatable(data){

        $(".tabla-empresas").empty();
        $(".tabla-empresas").html(data);
        datatableInit();

    }

    function resetMenuRed(red){
        $('.red-class-eliminar').remove();
        $('#seccion-red').after(red);
        $('.treeview-menu:empty').remove();
    }

    datatableInit();

    $(document.body).on('click','.eliminar',function(){

        var id = $(this).data('id');

        swal({
                title: "Esta seguro?",
                text: "La eliminación de un registro es permanente!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Si, Eliminar!",
                closeOnConfirm: false
            },
            function(){
                $.post('empresas/eliminarEmpresa',{id:id},function(response){
                    var r = JSON.parse(response);
                    if(r.response === 'failed'){
                        swalMsj('Error! Falló al eliminar registro!','error');
                    }else if(r.response === 'success'){
                        resetDatatable(r['empresas']);
                        $('.form-control').val('');

                        resetMenuRed(r.red);

                        swalMsj('Registro eliminado!!','success');
                    }
                });
            });

    });



    $(document.body).on('click','.edit',function(){

        var id = $(this).data('id');
        var parent_id = $(this).data('parent_id');

        $("#e-id").val(id);
        $("#e-empresa").val($(this).data('empresa'));
        $("#e-ghost").val($(this).data('ghost'));
        $("#e-participacion").val($(this).data('participacion'));
        $("#e-inversor").val($(this).data('inversor'));
        $("#e-comentario_reporte_empresa").val($(this).data('comentario_reporte_empresa'));
        $("#e-comentario_reporte_inversion").val($(this).data('comentario_reporte_inversion'));

        $.post('empresas/obtenerDatosNuevoRegistro',{},function(response){


            var r           = JSON.parse(response);
            var empresas    = r.empresas;
            var empresasHtml = '<option value="0"> Ninguna.. </option>';

            for(var i in empresas)
            {
                if(empresas[i].id != id){

                    var selected = (empresas[i].id == parent_id) ? 'selected':'';

                    empresasHtml += '<option value="'+empresas[i].id+'" '+selected+'>'+empresas[i].empresa+'</option>';
                }
            }

            $('#e-parent_id').html(empresasHtml);

            $('#modal-edit').modal('show');
        });

    });

    $(document.body).on('click','#btn-nuevo-registro',function(){

        $.post('empresas/obtenerDatosNuevoRegistro',{},function(response){

            var r           = JSON.parse(response);
            var empresas    = r.empresas;
            var empresasHtml = '<option value="0"> Ninguna.. </option>';

            for(var i in empresas)
            {
                empresasHtml += '<option value="'+empresas[i].id+'">'+empresas[i].empresa+'</option>';
            }

            $('#parent_id').html(empresasHtml);

            $('#modal-nuevo').modal('show');
        });

    });

    $(document.body).on('submit','#form-nuevo',function(e){
        e.preventDefault();
        var form = new FormData($('#form-nuevo')[0]);

            $.ajax({
                url: 'empresas/procesarNuevoEmpresa', // point to server-side PHP script
                dataType: 'text',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form,
                type: 'post',
                success: function(response){
                    var r = JSON.parse(response);
                    if(r.response === 'failed'){
                        swalMsj('Error! Falló al editar empresa!','error');
                    }else if(r.response === 'success'){
                        $('#modal-nuevo').modal('hide');
                        resetDatatable(r['empresas']);
                        $('.form-control').val('');
                        resetMenuRed(r.red);
                        swalMsj('Registro creado con éxito!!','success');
                    }
                }
            });

    });

    $(document.body).on('submit','#form-edit',function(e){
        e.preventDefault();
        var form = new FormData($('#form-edit')[0]);

            $('#modal-edit').modal('hide');
            $.ajax({
                url: 'empresas/procesarEditarEmpresa', // point to server-side PHP script
                dataType: 'text',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form,
                type: 'post',
                success: function(response){
                    var r = JSON.parse(response);
                    if(r['response'] === 'failed'){
                        swalMsj('Error! Falló al editar empresa!','error');
                    }else if(r['response'] === 'success'){
                        resetDatatable(r['empresas']);
                        $('.form-control').val('');
                        resetMenuRed(r.red);
                        swalMsj('Empresa actualizado con éxito!!','success');
                    }
                }
            });

    });
</script>