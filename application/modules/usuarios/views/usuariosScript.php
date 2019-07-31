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

        $(".tabla-usuarios").empty();
        $(".tabla-usuarios").html(data);
        datatableInit();

    }

    datatableInit();

    $(document.body).on('click','.edit',function(){

        $("#e-id").val($(this).data('id'));
        $("#e-nombre").val($(this).data('nombre'));
        $("#e-email").val($(this).data('email'));
        $("#e-tipo").val($(this).data('tipo'));

        $('#modal-edit').modal('show');

    });



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
                $.post('usuarios/eliminarUsuario',{id:id},function(response){
                    var r = JSON.parse(response);
                    if(r['response'] === 'failed'){
                        swalMsj('Error! Falló al eliminar usuario!','error');
                    }else if(r['response'] === 'success'){
                        resetDatatable(r['usuarios']);
                        $('.form-control').val('');
                        swalMsj('Usuario eliminado!!','success');
                    }
                });
            });

    });

    // quitar permisos
    $(document.body).on('click','.quitar-permisos',function(){

        var id_empresa = $(this).data('id_empresa');
        var id_user = $(this).data('id_user');

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
                $.post('usuarios/procesarEliminarPermisosAsignados',{id_empresa:id_empresa,id_user:id_user},function(response){
                    var r = JSON.parse(response);
                    if(r['response'] === 'failed'){
                        swalMsj('Error! Falló al remover permisos!','error');
                    }else if(r['response'] === 'success'){
                        resetDatatable(r['usuarios']);
                        $('.form-control').val('');
                        swalMsj('permiso removido!!','success');
                    }
                });
            });

    });


    $(document.body).on('submit','#form-nuevo',function(e){
        e.preventDefault();
        var form = new FormData($('#form-nuevo')[0]);
        if($('#pass-n').val() === $('#pass2-n').val() ){
            $('#modal-nuevo').modal('hide');
            $.ajax({
                url: 'usuarios/procesarNuevoUsuario', // point to server-side PHP script
                dataType: 'text',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form,
                type: 'post',
                success: function(response){
                    var r = JSON.parse(response);
                    if(r['response'] === 'failed'){
                        swalMsj('Error! Falló al crear usuario!','error');
                    }else if(r['response'] === 'success'){
                        resetDatatable(r['usuarios']);
                        $('.form-control').val('');
                        swalMsj('Usuario creado con éxito!!','success');
                    }
                }
            });
        }else{
            swalMsj("las contraseñas no coinciden","error");
        }
    });


    $(document.body).on('submit','#form-edit',function(e){
        e.preventDefault();
        var form = new FormData($('#form-edit')[0]);
        if($('#e-pass-n').val() === $('#e-pass2-n').val() ){
            $('#modal-edit').modal('hide');
            $.ajax({
                url: 'usuarios/procesarEditarUsuario', // point to server-side PHP script
                dataType: 'text',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form,
                type: 'post',
                success: function(response){
                    var r = JSON.parse(response);
                    if(r['response'] === 'failed'){
                        swalMsj('Error! Falló al editar usuario!','error');
                    }else if(r['response'] === 'success'){
                        resetDatatable(r['usuarios']);
                        $('.form-control').val('');
                        swalMsj('Usuario actualizado con éxito!!','success');
                    }
                }
            });
        }else{
            swalMsj("las contraseñas no coinciden","error");
        }
    });


    function resetearEmpresasDisponiblesAsignadas(r){

        $('#empresas_disponibles').empty();
        $('#empresas-asignadas-modal').empty();

        if(r['empresas'] !== false){
            $('#empresas_disponibles').append("<option value='' disabled selected> Seleccione una Empresa </option>");
            for(var i = 0; i < Object.keys(r['empresas']).length; i++){
                $('#empresas_disponibles').append('<option value="'+r['empresas'][i]['id']+'">'+r['empresas'][i]['empresa']+'</option>');
            }
            //console.log(r['empresas'][0]['id']);
            $('#modal-permisos').modal('show');
        }

        if(r['empresasAsignadas'] !== false){
            for(var i = 0; i < Object.keys(r['empresasAsignadas']).length; i++){
                $('#empresas-asignadas-modal').append('<span class="badge badge-primary">'+r['empresasAsignadas'][i]['empresa']+'</span>');
            }
            //console.log(r['empresas'][0]['id']);

        }else{
            $('#empresas-asignadas-modal').append("<p>No hay empresas asignadas a este usuario</p>");
        }

    }

    $(document.body).on('click','.asignar',function(){

        var id = $(this).data('id');
        $('#id_user').val(id);

        $.post('usuarios/obtenerListadoPermisos',{id:id},function(response){
            var r = JSON.parse(response);
            resetearEmpresasDisponiblesAsignadas(r);
            $('#modal-permisos').modal('show');
        });

    });


    // aqui se asignan los permisos a los usuarios

    $(document.body).on('submit','#form-permisos',function(e){
        e.preventDefault();

        var form = new FormData($('#form-permisos')[0]);

            $.ajax({
                url: 'usuarios/procesarGuardarEmpresaAsignada', // point to server-side PHP script
                dataType: 'text',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form,
                type: 'post',
                success: function(response){
                    var r = JSON.parse(response);
                    if(r['response'] === 'failed'){
                        swalMsj('Error! Falló al asignar permisos al usuario!','error');
                    }else if(r['response'] === 'success'){
                        resetDatatable(r['usuarios']);
                        $('.form-control').val('');
                        resetearEmpresasDisponiblesAsignadas(r);
                        swalMsj('Permisos actualizados con éxito!!','success');

                    }
                }
            });

    });

</script>