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



            



            'bPaginate': false,



            "language": {



                "lengthMenu": "Mostar _MENU_ registros por página",



                "zeroRecords": "No se encontraron registros",



                "info": "Mostrando Página _PAGE_ de _PAGES_",



                "infoEmpty": "No hay registros disponibles",



                "infoFiltered": "(filtered from _MAX_ total records)",



                "search": "Buscar",



                "paginate": {



                    "previous": "Anterior",



                    "next":"próximo"



                }



            },



            "ordering": false



        });



    }











    function number_format(amount, decimals) {







        amount += ''; // por si pasan un numero en vez de un string



        amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto







        decimals = decimals || 0; // por si la variable no fue fue pasada







        // si no es un numero o es igual a cero retorno el mismo cero



        if (isNaN(amount) || amount === 0) 



            return parseFloat(0).toFixed(decimals);







        // si es mayor o menor que cero retorno el valor formateado como numero



        amount = '' + amount.toFixed(decimals);







        var amount_parts = amount.split('.'),



            regexp = /(\d+)(\d{3})/;







        while (regexp.test(amount_parts[0]))



            amount_parts[0] = amount_parts[0].replace(regexp, '$1' + '.' + '$2');







        return amount_parts.join(',');



    }



    function fecha_format(texto){

      return texto.replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3/$2/$1');

    }

    



    $(document).ready(function() {



        $('.detalleSaldo').on('click', function(){







            var empOrigen = $(this).attr('data-origen');



            var empDestino = $(this).attr('data-destino');



            var nombreOrigen = $(this).attr('nombre-origen');



            var nombreDestino = $(this).attr('nombre-destino');



            var operacion = $(this).attr('data-op');







            $('#view-resumen-saldo span#empOrigen').text('');



            $('#view-resumen-saldo span#empDestino').text('');



            $('#view-resumen-saldo table tbody').html('');







            $.ajax({



                url: 'resumenSaldo/detallesSaldo',



                type: 'POST',



                dataType: 'json',



                data: {op: operacion, origen: empOrigen, destino: empDestino},



                success: function(response){







                    var html = '';



                    var sumaMonto = 0;







                    response.data.forEach(function(data){



                        let tipo_transaccion = '';







                        switch(data.descripcion){



                            case '1':



                                tipo_transaccion = 'Devolución Prestamo (Ingreso)';



                                break;



                            case '2':



                                tipo_transaccion = 'Devolución Préstamo (Egreso)';



                                break;



                            case '3':



                                tipo_transaccion = 'Ingreso Préstamo';



                                break;



                            case '4':



                                tipo_transaccion = 'Préstamo';



                                break;



                        }



                        html += '<tr><td>'+tipo_transaccion+'</td><td>'+number_format(data.monto, 2)+'</td><td>'+fecha_format(data.fecha_realizacion)+'</td></tr>';



                        sumaMonto += parseInt(data.monto);



                    });



                    html += '<tr><td colspan="2"><b>Total: '+number_format(sumaMonto, 2)+'</b></td></tr>'



                    $('#view-resumen-saldo span#empOrigen').text(nombreOrigen);



                    $('#view-resumen-saldo span#empDestino').text(nombreDestino);



                    $('#view-resumen-saldo table tbody').html(html);







                },



                error: function(error){



                    console.log("Error en el ajax",error);



                }



            });



            



        });







    //datatableInit();



    var $tablaResumen = jQuery(".tabla");

    /*var table = $tablaResumen.dataTable({

        "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],

        "aoColumnDefs": [

            { "width": "50px", "targets": 0 },

            { "width": "150px", "targets": 2 },

            { "width": "80px", "targets": 3 },

            {"className": "dt-center", "targets": [0, 2, 3,4,5,6,7]},

            {"targets": [8,9,10,11,12],"visible": false},

        ],

        "language": {

            "lengthMenu": "Mostar _MENU_ registros por página",

            "zeroRecords": "No se encontraron registros",

            "info": "Mostrando Página _PAGE_ de _PAGES_",

            "infoEmpty": "No hay registros disponibles",

            "infoFiltered": "(filtered from _MAX_ total records)",

            "search": "Buscar",

            "paginate": {

                "previous": "Anterior",

                "next":"próximo"

            }

        },



    });*/

    /*var tablaResumen = $tablaResumen.DataTable({

        "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],

        "aoColumnDefs": [

            { "width": "50px", "targets": 0 },

            { "width": "150px", "targets": 2 },

            { "width": "80px", "targets": 3 },

            {"className": "dt-center", "targets": [0, 2, 3,4,5,6,7]},

            {"targets": [8,9,10,11,12],"visible": false},

        ],

        "ordering": false,

        "bPaginate": false,

        "language": {

            "decimal":        "",

            "emptyTable":     "Sin registros",

            "info":           "Mostrando de _START_ a _END_ registros de _TOTAL_ en total",

            "infoEmpty":      "Mostrando 0 de 0 de 0 registros",

            "infoFiltered":   "(filtrado desde _MAX_ registros en total)",

            "infoPostFix":    "",

            "thousands":      ",",

            "lengthMenu":     "Mostrar _MENU_ registros",

            "loadingRecords": "Cargando...",

            "processing":     "Procesando...",

            "search":         "Buscar:",

            "zeroRecords":    "No se encontraron registros",

            "paginate": {

                "first":      "Primero",

                "last":       "Último",

                "next":       "Siguiente",

                "previous":   "Anterior"

            },

            "aria": {

                "sortAscending":  ": activar para ordenar la columna ascendente",

                "sortDescending": ": activar para ordenar la columna descendente"

            }

        }

    });*/



    /*$('#tablaResumen_filter').hide(); // Forzando que desasparezca el campo de texto de filtro



    $('#filterEmp').on('change', function(){

        let filtro = $(this);



        if(filtro.val() == 'EMPRESA'){

            tablaResumen.column(0).search('').draw();

        } else {

            tablaResumen.column(0).search(filtro.val()).draw();

        }

    });*/



    });



/*var $table = $('#tablaResumen');

var $fixedColumn = $table.clone().insertBefore($table).addClass('fixed-column');



$fixedColumn.find('tr').each(function (i, elem) {

    $(this).height($table.find('tr:eq(' + i + ')').height());

});



$fixedColumn.find('th:not(:first-child),td:not(:first-child)').remove();*/











</script>