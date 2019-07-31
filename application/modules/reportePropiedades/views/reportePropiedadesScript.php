<script language="javascript" type="text/javascript">

    $('.datepicker').datepicker({
        autoclose: true
    });


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

        $(".tabla-reporte_propiedades").empty();
        $(".tabla-reporte_propiedades").html(data);
        datatableInit();

    }

    datatableInit();

    $(document.body).on('click','.edit',function(){

        $("#e-id").val($(this).data('id'));
        if($(this).data('fecha_registro') != ''){
            $("#e-fecha_registro").datepicker('update',$(this).data('fecha_registro'));
        }else{
            $("#e-fecha_registro").val('');
        }
        $("#e-rental").val($(this).data('rental'));
        $("#e-rol").val($(this).data('rol'));
        if($(this).data('fecha_compra') != ''){
            $("#e-fecha_compra").datepicker('update',$(this).data('fecha_compra'));
        }else{
            $("#e-fecha_compra").val('');
        }
        $("#e-folio").val($(this).data('folio'));
        $("#e-notaria").val($(this).data('notaria'));
        $("#e-deuda_uf").val($(this).data('deuda_uf'));
        $("#e-banco").val($(this).data('banco'));
        $("#e-dividendo").val($(this).data('dividendo'));
        $("#e-monto_uf").val($(this).data('monto_uf'));
        if($(this).data('fecha_vencimiento') != ''){
            $("#e-fecha_vencimiento").datepicker('update',$(this).data('fecha_vencimiento'));
        }else{
            $("#e-fecha_vencimiento").val('');
        }

        $('#modal-edit').modal('show');
    });


    $(document.body).on('submit','#form-nuevo',function(e){
        e.preventDefault();

        var form = new FormData($('#form-nuevo')[0]);

        // aqui evaluamos si la fecha cumple con el formato
        if(!evaluarFechaFormat(form.get('fecha_registro'))){return false;}
        if(!evaluarFechaFormat(form.get('fecha_compra'))){return false;}
        if(!evaluarFechaFormat(form.get('fecha_vencimiento'))){return false;}


        $('#modal-nuevo').modal('hide');
        $.ajax({
            url: 'reportePropiedades/procesarNuevoReporte_propiedade', // point to server-side PHP script
            dataType: 'text',  // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form,
            type: 'post',
            success: function(response){
                var r = JSON.parse(response);
                if(r['response'] === 'failed'){
                    swalMsj('Error! Falló al crear registro!','error');
                }else if(r['response'] === 'success'){
                    resetDatatable(r.reporte_propiedades);
                    $('.form-control').val('');
                    swalMsj('Registro creado con éxito!!','success');
                }
            }
        });

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
                $.post('reportePropiedades/eliminarReporte_propiedade',{id:id},function(response){
                    var r = JSON.parse(response);
                    if(r.response === 'failed'){
                        swalMsj('Error! Falló al eliminar registro!','error');
                    }else if(r.response === 'success'){
                        resetDatatable(r.reporte_propiedades);
                        $('.form-control').val('');
                        swalMsj('Registro eliminado!!','success');
                    }
                });
            });

    });

    $(document.body).on('click','.ver-mas',function(){

        $(".vm-clean").empty();

        if($(this).data('fecha_registro') != ''){
            $("#vm-fecha_registro").html($(this).data('fecha_registro'));
        }else{
            $("#vm-fecha_registro").html('');
        }
        $("#vm-rental").html($(this).data('rental'));
        $("#vmrol").html($(this).data('rol'));
        if($(this).data('fecha_compra') != ''){
            $("#vm-fecha_compra").html($(this).data('fecha_compra'));
        }else{
            $("#vm-fecha_compra").html('');
        }
        $("#vm-folio").html($(this).data('folio'));
        $("#vm-notaria").html($(this).data('notaria'));
        $("#vm-deuda_uf").html($(this).data('deuda_uf'));
        $("#vm-banco").html($(this).data('banco'));
        $("#vm-dividendo").html($(this).data('dividendo'));
        $("#vm-monto_uf").html($(this).data('monto_uf'));
        if($(this).data('fecha_vencimiento') != ''){
            $("#vm-fecha_vencimiento").html($(this).data('fecha_vencimiento'));
        }else{
            $("#vm-fecha_vencimiento").html('');
        }


        $("#modal-vm").modal('show');
    });





    $(document.body).on('submit','#form-edit',function(e){
        e.preventDefault();
        var form = new FormData($('#form-edit')[0]);

        // aqui evaluamos si la fecha cumple con el formato
        if(!evaluarFechaFormat(form.get('fecha_registro'))){return false;}
        if(!evaluarFechaFormat(form.get('fecha_compra'))){return false;}
        if(!evaluarFechaFormat(form.get('fecha_vencimiento'))){return false;}

        $.ajax({
            url: 'reportePropiedades/procesarEditarReporte_propiedade', // point to server-side PHP script
            dataType: 'text',  // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form,
            type: 'post',
            success: function(response){
                var r = JSON.parse(response);
                if(r.response === 'failed'){
                    swalMsj('Error! Falló al registro!','error');
                }else if(r.response === 'success'){
                    $('#modal-edit').modal('hide');
                    resetDatatable(r.reporte_propiedades);
                    $('.form-control').val('');
                    swalMsj('Registro actualizado con éxito!!','success');
                }
            }
        });

    });

</script>