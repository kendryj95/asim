<script>
    $( document ).ready(function() {
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

        $(document.body).on('submit','#form-nuevo-registro-inversion',function(e){
            e.preventDefault();

            var form = new FormData($('#form-nuevo-registro-inversion')[0]);

            $.ajax({
                url: 'reporteInversion/procesarGuardarRegistroDeInversion', // point to server-side PHP script
                dataType: 'text',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form,
                type: 'post',
                success: function(response){
                    var r = JSON.parse(response);
                    if(r['response'] === 'failed'){
                        swalMsj('Error! Falló al guardar registro!','error');
                    }else if(r['response'] === 'success'){
                        $('#accordion-registros').empty();
                        $('#accordion-registros').html(r['registros']);
                        $('.fc-b1').val('1');
                        $('.fc-clean').val('');
                        $('#myModal').modal('hide');
                        swalMsj('Registro Guardado Con Éxito!!','success');
                    }
                }
            });

        });


        $(document.body).on('submit','#form-editar-registro-inversion',function(e){
            e.preventDefault();

            var form = new FormData($('#form-editar-registro-inversion')[0]);

            $.ajax({
                url: 'reporteInversion/procesarEditarRegistroDeInversion', // point to server-side PHP script
                dataType: 'text',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form,
                type: 'post',
                success: function(response){
                    var r = JSON.parse(response);
                    if(r['response'] === 'failed'){
                        swalMsj('Error! Falló al guardar registro!','error');
                    }else if(r['response'] === 'success'){
                        $('#accordion-registros').empty();
                        $('#accordion-registros').html(r['registros']);
                        $('#myModal-editar').modal('hide');
                        swalMsj('Registro Guardado Con Éxito!!','success');
                    }
                }
            });

        });

        // quede pendiente de coolocar el modal hide en la edición y hacer funcionar la eliminación


        $(document.body).on('click','.eliminar',function(){

            var id          = $(this).data('id');
            var idEmpresa   = $('#idEmpresa').val();

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
                    $.post('reporteInversion/procesarEliminarRegistroDeInversion',{id:id,idEmpresa:idEmpresa},function(response){
                        var r = JSON.parse(response);
                        if(r['response'] === 'failed'){
                            swalMsj('Error! Falló al eliminar registro!','error');
                        }else if(r['response'] === 'success'){
                            $('#accordion-registros').empty();
                            $('#accordion-registros').html(r['registros']);
                            $('.form-control').val('');
                            swalMsj('Registro eliminado!!','success');
                        }
                    });
                });

        });

        $(document.body).on('click','#btn-comentario',function(){

            var texto = $('#comentario').val();
            var id_empresa = $('#idEmpresa').val();

            $.post(
                'reporteInversion/procesarGuardarComentario',
                {texto:texto,id_empresa:id_empresa},
                function(response){
                    var r = JSON.parse(response);
                    if (r['response'] === 'failed') {
                        swalMsj('Error! Falló al guardar registro!', 'error');
                    } else if (r['response'] === 'success') {

                        swalMsj('Registro Actualizado Con Éxito!!', 'success');

                    }
                }
            );

        });


        $(document.body).on('change','#years_id',function(){

            $.post(
                'reporteInversion/obtenerAcordeon',
                {year:$(this).val(),id_empresa:$('#idEmpresa').val()},
                function(response) {
                    var r = JSON.parse(response);
                    if (r['response'] === 'success') {
                        $('#accordion-registros').empty();
                        $('#accordion-registros').html(r['registros']);
                    }
                });

        });

        $(document.body).on('click','.edit',function(){

            var id = $(this).data('id');
            $('#e-idReporte').val(id);

            $.post(
                'reporteInversion/obtenerDatosRegistroDeInversion',
                {id,id},
                function(response){

                    var r = JSON.parse(response);

                    if(r['status'] == 'success'){

                        for(var i = 0; i < 3 ; i++){

                            // verifica si la fecha ha sido seteada para proceder a mostrarla en el modal
                            if(r['registro'][i]['fecha'] != '0000-00-00'){
                                var arrayFecha = r['registro'][i]['fecha'].split('-');
                                var year = arrayFecha[0];
                                var month = arrayFecha[1];
                                var day = arrayFecha[2];
                                $('#e-fecha'+(i+1)).datepicker('update',day+'/'+month+'/'+year);
                            }else{
                                //si la fecha no esta seteada, enviara un string vacío
                                $('#e-fecha'+(i+1)).val('');
                            }

                            $('#e-detalle_glosa'+(i+1)).val(r['registro'][i]['detalle_glosa']);
                            $('#e-tipo'+(i+1)).val(r['registro'][i]['tipo']);
                            if(r['registro'][i]['monto'] === ''){
                                $('#e-monto'+(i+1)).val();
                            }else{
                                $('#e-monto'+(i+1)).val(Number(r['registro'][i]['monto']).toLocaleString('de-DE'));
                            }

                            $('#e-id'+(i+1)).val(r['registro'][i]['id']);

                        }

                        $('#myModal-editar').modal('show');

                    }else{
                        console.log('error');
                    }

                }
            );

        });

    });
</script>