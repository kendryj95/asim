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

        function covertidorFecha(fecha){
            var arrayFecha = (fecha).split('/');
            var year = arrayFecha[2];
            var month = arrayFecha[1];
            var day = arrayFecha[0];

            return year+'-'+month+'-'+day;
        }

        $(document.body).on('change','#years_id',function(){

            $.post(
                'reporteEmpresa/obtenerAcordeon',
                {year:$(this).val(),id_empresa:$('#id_empresa').val()},
                function(response) {
                    var r = JSON.parse(response);
                    if (r['response'] === 'success') {
                        $('#accordion-reportes-empresas').empty();
                        $('#accordion-reportes-empresas').html(r['registros']);
                    }
                });

        });

        $(document.body).on('change','#descripcion',function(){


            var val = $(this).val();
            var idEmpresa = $('#id_empresa').val();

            if(val === '1' || val === '2'){

                if($('.fecha-limite-div').css('display') != 'none'){
                    $('.fecha-limite-div').css('display','none');
                    $('#fecha-limite').removeAttr('required');
                }

            }else{

                if($('.fecha-limite-div').css('display') == 'none'){
                    $('.fecha-limite-div').css('display','block');
                    $('#fecha-limite').attr('required','');
                }

            }


            // si es un ingreso, el destino seleccionado es la empresa en donde estoy
            if(val === '1' || val === '3'){

                $('#origen').val('');
                $('#origen').removeAttr('disabled');
                $('#destino').val(idEmpresa);
                $('#destino').attr('disabled','');

            }else{

                // si es egreso, el origen es la compañia donde estoy
                $('#destino').val('');
                $('#destino').removeAttr('disabled');
                $('#origen').val(idEmpresa);
                $('#origen').attr('disabled','');

            }



        });

        //NUEVO NUEVO NUEVO NUEVO NUEVO NUEVO

        $(document.body).on('submit','#form-nueva-transaccion-compromiso',function(e){
            e.preventDefault();

            var desc = $('#descripcion').val();

            var eval = true;

            if(desc == '3' || desc == '4'){

                var fechaF = Date.parse(covertidorFecha($('#fecha-realizacion').val())) ;
                var fechaL = Date.parse(covertidorFecha($('#fecha-limite').val())) ;

                if(fechaL >= fechaF){
                    eval =  true;
                }else{
                    eval = false;
                }

            }


            if(eval == true){
                $('.free-disabled').removeAttr('disabled');

                var form = new FormData($('#form-nueva-transaccion-compromiso')[0]);

                $.ajax({
                    url: 'reporteEmpresa/procesarGuardarRegistroDeEmpresa', // point to server-side PHP script
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
                            $('#accordion-reportes-empresas').empty();
                            $('#accordion-reportes-empresas').html(r['registros']);
                            $('#nueva-transaccion-y-compromisol').modal('hide');
                            swalMsj('Registro Guardado Con Éxito!!','success');
                        }
                    }
                });
            }else{
                $('#alertaNuevo').fadeIn('slow');
            }

        });

        //EDITAR EDITAR EDITAR EDITAR

        $(document.body).on('submit','#form-editar-transaccion-compromiso',function(e){
            e.preventDefault();

            var desc = $('#e-descripcion_id').val();

            var eval = true;

            if(desc == '3' || desc == '4'){

                var fechaF = Date.parse(covertidorFecha($('#e-fecha-realizacion').val())) ;
            var fechaL = Date.parse(covertidorFecha($('#e-fecha-limite').val())) ;

            if(fechaL >= fechaF){
                eval =  true;
            }else{
                eval = false;
            }

        }

        if(eval == true) {

            var form = new FormData($('#form-editar-transaccion-compromiso')[0]);

            $.ajax({
                url: 'reporteEmpresa/procesarEditarRegistroDeEmpresa', // point to server-side PHP script
                dataType: 'text',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form,
                type: 'post',
                success: function (response) {
                    var r = JSON.parse(response);
                    if (r['response'] === 'failed') {
                        swalMsj('Error! Falló al guardar registro!', 'error');
                    } else if (r['response'] === 'success') {

                        $('#accordion-reportes-empresas').empty();
                        $('#accordion-reportes-empresas').html(r['registros']);
                        $('#editar-transaccion-y-compromiso').modal('hide');
                        swalMsj('Registro Actualizado Con Éxito!!', 'success');

                    }
                }
            });

        }else{
            $('#alertaEditar').fadeIn('slow');
        }

    });

    $(document.body).on('click','.edit',function(){

        $('.clean').empty();


        $('#e-id').val($(this).data('id'));
        $('#e-par_id').val($(this).data('pares'));
        $('#e-descripcion_id').val($(this).data('descripcion_id'));
        $('#e-registro_transaccion').html($(this).data('registro_transaccion'));
        $('#e-descripcion').html($(this).data('descripcion'));
        $('#e-origen').html($(this).data('origen'));
        $('#e-destino').html($(this).data('destino'));
        $('#e-monto').val($(this).data('monto'));

        //esto le da formato a la fecha de realización y la coloca en el modal
        var arrayFecha = ($(this).data('fecha_realizacion')).split('-');
        var year = arrayFecha[0];
        var month = arrayFecha[1];
        var day = arrayFecha[2];
            $('#e-fecha-realizacion').datepicker('update',day+'/'+month+'/'+year);


            //esto verifica y le da formato a la fecha de limite
            if($(this).data('fecha_limite') != '0000-00-00'){
                var arrayFecha = ($(this).data('fecha_limite')).split('-');
                var year = arrayFecha[0];
                var month = arrayFecha[1];
                var day = arrayFecha[2];
                $('#e-fecha-limite-div').css('display','block');
                $('#e-fecha-limite').datepicker('update',day+'/'+month+'/'+year);
            }else{
                //si la fecha no esta seteada, enviara un string vacío
                $('#e-fecha-limite-div').css('display','none');
                $('#e-fecha-limite').val('');
            }


            $('#editar-transaccion-y-compromiso').modal('show');

        });

        $(document.body).on('click','.eliminar',function(){

            var id          = $(this).data('id');
            var idPar       = $(this).data('pares');
            var idEmpresa   = $('#id_empresa').val();

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
                    $.post('reporteEmpresa/procesarEliminarRegistroDeEmpresa',{id:id,idEmpresa:idEmpresa,idPar:idPar},function(response){
                        var r = JSON.parse(response);
                        if(r['response'] === 'failed'){
                            swalMsj('Error! Falló al eliminar registro!','error');
                        }else if(r['response'] === 'success'){
                            $('#accordion-reportes-empresas').empty();
                            $('#accordion-reportes-empresas').html(r['registros']);
                            $('.form-control').val('');
                            swalMsj('Registro eliminado!!','success');
                        }
                    });
                });

        });


        /* ***************************************************************************************************************
        ******************************************************************************************************************
        * *************************************************************************************************************
        * *************************************************************************************************************
        * *************************************************************************************************************
         */

        $(document.body).on('click','.edit-caja',function(){

            $('#e-id-caja').val($(this).data('id'));
            $('#e-caja').val($(this).data('caja'));
            $('#e-saldo').val($(this).data('saldo'));

            //esto le da formato a la fecha de emision y la coloca en el modal
            var arrayFecha = ($(this).data('fecha_emision')).split('-');
            var year = arrayFecha[0];
            var month = arrayFecha[1];
            var day = arrayFecha[2];
            $('#e-fecha_emision').datepicker('update',day+'/'+month+'/'+year);

            $('#modal-editar-caja').modal('show');

        });

        $(document.body).on('submit','#form-nueva-caja',function(e){

                e.preventDefault();

                var form = new FormData($('#form-nueva-caja')[0]);

                $.ajax({
                    url: 'reporteEmpresa/procesarGuardarCaja', // point to server-side PHP script
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
                            $('#div-tabla-cajas').empty();
                            $('#div-tabla-cajas').html(r['cajas']);
                            $('#modal-nueva-caja').modal('hide');
                            swalMsj('Registro Guardado Con Éxito!!','success');
                        }
                    }
                });

        });

        $(document.body).on('submit','#form-editar-caja',function(e){
            e.preventDefault();

                var form = new FormData($('#form-editar-caja')[0]);

                $.ajax({
                    url: 'reporteEmpresa/procesarEditarCaja', // point to server-side PHP script
                    dataType: 'text',  // what to expect back from the PHP script, if anything
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form,
                    type: 'post',
                    success: function (response) {
                        var r = JSON.parse(response);
                        if (r['response'] === 'failed') {
                            swalMsj('Error! Falló al guardar registro!', 'error');
                        } else if (r['response'] === 'success') {

                            $('#div-tabla-cajas').empty();
                            $('#div-tabla-cajas').html(r['cajas']);
                            $('#modal-editar-caja').modal('hide');
                            swalMsj('Registro Actualizado Con Éxito!!', 'success');

                        }
                    }
                });

        });

        $(document.body).on('click','.eliminar-caja',function(){

            var id          = $(this).data('id');
            var id_empresa   = $(this).data('id_empresa');

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
                    $.post('reporteEmpresa/eliminarCaja',{id:id,id_empresa:id_empresa},function(response){
                        var r = JSON.parse(response);
                        if(r['response'] === 'failed'){
                            swalMsj('Error! Falló al eliminar registro!','error');
                        }else if(r['response'] === 'success'){
                            $('#div-tabla-cajas').empty();
                            $('#div-tabla-cajas').html(r['cajas']);
                            swalMsj('Registro eliminado!!','success');
                        }
                    });
                });

        });


        /* ***************************************************************************************************************
         ******************************************************************************************************************
         * *************************************************************************************************************
         * *************************************************************************************************************
         * *************************************************************************************************************
         */


        $(document.body).on('click','.edit-favor',function(){

            $('#e-id-favor').val($(this).data('id'));
            $('#e-favor').val($(this).data('favor'));
            $('#e-favor-saldo').val($(this).data('saldo'));

            //esto le da formato a la fecha de emision y la coloca en el modal
            var arrayFecha = ($(this).data('fecha_emision')).split('-');
            var year = arrayFecha[0];
            var month = arrayFecha[1];
            var day = arrayFecha[2];
            $('#e-favor-fecha_emision').datepicker('update',day+'/'+month+'/'+year);

            $('#modal-editar-favor').modal('show');

        });

        $(document.body).on('submit','#form-nueva-favor',function(e){

            e.preventDefault();

            var form = new FormData($('#form-nueva-favor')[0]);

            $.ajax({
                url: 'reporteEmpresa/procesarGuardarFavor', // point to server-side PHP script
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
                        $('#div-tabla-favores').empty();
                        $('#div-tabla-favores').html(r['favores']);
                        $('#modal-nueva-favor').modal('hide');
                        swalMsj('Registro Guardado Con Éxito!!','success');
                    }
                }
            });

        });

        $(document.body).on('submit','#form-editar-favor',function(e){
            e.preventDefault();

            var form = new FormData($('#form-editar-favor')[0]);

            $.ajax({
                url: 'reporteEmpresa/procesarEditarFavor', // point to server-side PHP script
                dataType: 'text',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form,
                type: 'post',
                success: function (response) {
                    var r = JSON.parse(response);
                    if (r['response'] === 'failed') {
                        swalMsj('Error! Falló al guardar registro!', 'error');
                    } else if (r['response'] === 'success') {

                        $('#div-tabla-favores').empty();
                        $('#div-tabla-favores').html(r['favores']);
                        $('#modal-editar-favor').modal('hide');
                        swalMsj('Registro Actualizado Con Éxito!!', 'success');

                    }
                }
            });

        });

        $(document.body).on('click','.eliminar-favor',function(){

            var id          = $(this).data('id');
            var id_empresa   = $(this).data('id_empresa');

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
                    $.post('reporteEmpresa/eliminarFavor',{id:id,id_empresa:id_empresa},function(response){
                        var r = JSON.parse(response);
                        if(r['response'] === 'failed'){
                            swalMsj('Error! Falló al eliminar registro!','error');
                        }else if(r['response'] === 'success'){
                            $('#div-tabla-favores').empty();
                            $('#div-tabla-favores').html(r['favores']);
                            swalMsj('Registro eliminado!!','success');
                        }
                    });
                });

        });


        /* ***************************************************************************************************************
         ******************************************************************************************************************
         * *************************************************************************************************************
         * *************************************************************************************************************
         * *************************************************************************************************************
         */


        $(document.body).on('click','.edit-contra',function(){

            $('#e-id-contra').val($(this).data('id'));
            $('#e-contra').val($(this).data('contra'));
            $('#e-contra-saldo').val($(this).data('saldo'));

//esto le da formato a la fecha de emision y la coloca en el modal
            var arrayFecha = ($(this).data('fecha_emision')).split('-');
            var year = arrayFecha[0];
            var month = arrayFecha[1];
            var day = arrayFecha[2];
            $('#e-contra-fecha_emision').datepicker('update',day+'/'+month+'/'+year);

            $('#modal-editar-contra').modal('show');

        });

        $(document.body).on('submit','#form-nueva-contra',function(e){

            e.preventDefault();

            var form = new FormData($('#form-nueva-contra')[0]);

            $.ajax({
                url: 'reporteEmpresa/procesarGuardarContra', // point to server-side PHP script
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
                        $('#div-tabla-contras').empty();
                        $('#div-tabla-contras').html(r['contras']);
                        $('#modal-nueva-contra').modal('hide');
                        swalMsj('Registro Guardado Con Éxito!!','success');
                    }
                }
            });

        });

        $(document.body).on('submit','#form-editar-contra',function(e){
            e.preventDefault();

            var form = new FormData($('#form-editar-contra')[0]);

            $.ajax({
                url: 'reporteEmpresa/procesarEditarContra', // point to server-side PHP script
                dataType: 'text',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form,
                type: 'post',
                success: function (response) {
                    var r = JSON.parse(response);
                    if (r['response'] === 'failed') {
                        swalMsj('Error! Falló al guardar registro!', 'error');
                    } else if (r['response'] === 'success') {

                        $('#div-tabla-contras').empty();
                        $('#div-tabla-contras').html(r['contras']);
                        $('#modal-editar-contra').modal('hide');
                        swalMsj('Registro Actualizado Con Éxito!!', 'success');

                    }
                }
            });

        });

        $(document.body).on('click','.eliminar-contra',function(){

            var id          = $(this).data('id');
            var id_empresa   = $(this).data('id_empresa');

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
                    $.post('reporteEmpresa/eliminarContra',{id:id,id_empresa:id_empresa},function(response){
                        var r = JSON.parse(response);
                        if(r['response'] === 'failed'){
                            swalMsj('Error! Falló al eliminar registro!','error');
                        }else if(r['response'] === 'success'){
                            $('#div-tabla-contras').empty();
                            $('#div-tabla-contras').html(r['contras']);
                            swalMsj('Registro eliminado!!','success');
                        }
                    });
                });

        });

        /* ***************************************************************************************************************
         ******************************************************************************************************************
         * *************************************************************************************************************
         * *************************************************************************************************************
         * *************************************************************************************************************
         */

        $(document.body).on('click','.edit-balance-general',function(){



            $('#e-bg-id').val($(this).data('id'));
            $('#e-bg-id_empresa').val($(this).data('id_empresa'));


            $('#e-bg-activo_saldo').val($(this).data('activo_saldo'));
            //esto le da formato a la fecha de emision y la coloca en el modal
            //esto verifica y le da formato a la fecha de limite
            if($(this).data('activo_fecha') != '0000-00-00'){
                var arrayFecha = ($(this).data('activo_fecha')).split('-');
                var year = arrayFecha[0];
                var month = arrayFecha[1];
                var day = arrayFecha[2];
                $('#e-bg-activo_fecha').datepicker('update',day+'/'+month+'/'+year);
            }else{
                //si la fecha no esta seteada, enviara un string vacío
                $('#e-bg-activo_fecha').val('');
            }



            $('#e-bg-pasivo_patrimonio_saldo').val($(this).data('pasivo_patrimonio_saldo'));
            //esto le da formato a la fecha de emision y la coloca en el modal
            //esto verifica y le da formato a la fecha de limite
            if($(this).data('pasivo_patrimonio_fecha') != '0000-00-00'){
                var arrayFecha = ($(this).data('pasivo_patrimonio_fecha')).split('-');
                var year = arrayFecha[0];
                var month = arrayFecha[1];
                var day = arrayFecha[2];
                $('#e-bg-pasivo_patrimonio_fecha').datepicker('update',day+'/'+month+'/'+year);
            }else{
                //si la fecha no esta seteada, enviara un string vacío
                $('#e-bg-pasivo_patrimonio_fecha').val('');
            }




            $('#e-bg-resultado_perdida_saldo').val($(this).data('resultado_perdida_saldo'));
            //esto le da formato a la fecha de emision y la coloca en el modal
            //esto verifica y le da formato a la fecha de limite
            if($(this).data('resultado_perdida_fecha') != '0000-00-00'){
                var arrayFecha = ($(this).data('resultado_perdida_fecha')).split('-');
                var year = arrayFecha[0];
                var month = arrayFecha[1];
                var day = arrayFecha[2];
                $('#e-bg-resultado_perdida_fecha').datepicker('update',day+'/'+month+'/'+year);
            }else{
                //si la fecha no esta seteada, enviara un string vacío
                $('#e-bg-resultado_perdida_fecha').val('');
            }




            $('#e-bg-resultado_ganancia_saldo').val($(this).data('resultado_ganancia_saldo'));
            //esto le da formato a la fecha de emision y la coloca en el modal
            //esto verifica y le da formato a la fecha de limite
            if($(this).data('resultado_ganancia_fecha') != '0000-00-00'){
                var arrayFecha = ($(this).data('resultado_ganancia_fecha')).split('-');
                var year = arrayFecha[0];
                var month = arrayFecha[1];
                var day = arrayFecha[2];
                $('#e-bg-resultado_ganancia_fecha').datepicker('update',day+'/'+month+'/'+year);
            }else{
                //si la fecha no esta seteada, enviara un string vacío
                $('#e-bg-resultado_ganancia_fecha').val('');
            }



            if($(this).data('utilidad_fecha') != '0000-00-00'){
                var arrayFecha = ($(this).data('utilidad_fecha')).split('-');
                var year = arrayFecha[0];
                var month = arrayFecha[1];
                var day = arrayFecha[2];
                $('#e-bg-utilidad_fecha').datepicker('update',day+'/'+month+'/'+year);
            }else{
                //si la fecha no esta seteada, enviara un string vacío
                $('#e-bg-utilidad_fecha').val('');
            }


            $('#editar-balance-general').modal('show');

        });



        $(document.body).on('submit','#form-gb-editar',function(e){
            e.preventDefault();

            var form = new FormData($('#form-gb-editar')[0]);

            $.ajax({
                url: 'reporteEmpresa/procesarEditarBalanceGeneral', // point to server-side PHP script
                dataType: 'text',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form,
                type: 'post',
                success: function (response) {
                    var r = JSON.parse(response);
                    if (r['response'] === 'failed') {
                        swalMsj('Error! Falló al guardar registro!', 'error');
                    } else if (r['response'] === 'success') {

                        $('#div-balance-general').empty();
                        $('#div-balance-general').html(r['registros']);
                        $('#editar-balance-general').modal('hide');
                        swalMsj('Registro Actualizado Con Éxito!!', 'success');

                    }
                }
            });

        });


        $(document.body).on('click','#btn-comentario',function(){

            var texto = $('#comentario').val();
            var id_empresa = $('#id_empresa').val();

            $.post(
                'reporteEmpresa/procesarGuardarComentario',
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
    });
</script>