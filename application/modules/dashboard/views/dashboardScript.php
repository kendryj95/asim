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
            'bLengthChange': false,
            'bFilter': true,
            'bSort': true,
            'order': [[ 0, "desc" ]],
            'bInfo': false,
            'bAutoWidth': true,
            dom: 'Bfrtip',
            buttons: [{
            extend: 'excelHtml5',
            text: 'Excel'
            }]
        });
    }

    datatableInit();


</script>