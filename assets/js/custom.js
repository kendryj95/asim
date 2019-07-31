$(".solo-numeros").on("keypress", function (evt) {
    if (evt.which < 48  || evt.which > 57)
    {
        if(evt.which != 44 && evt.which != 46){

            evt.preventDefault();
        }
    }
});

$(".solo-numeros-pos-neg").on("keypress", function (evt) {
    if (evt.which < 48  || evt.which > 57)
    {
        if(evt.which != 44 && evt.which != 45 && evt.which != 46){

            evt.preventDefault();
        }
    }
});


$(".prevenir-escritura").on("keypress", function (evt) {
    evt.preventDefault();
});


function evaluarFechaFormat(fecha){

    if(fecha != ''){

        var arrayFecha = fecha.split('/');

        if(arrayFecha.length !== 3){
            return false;
        }else{

            var day = arrayFecha[0];
            var month = arrayFecha[1];
            var year = arrayFecha[2];

            console.log(arrayFecha);

            if(isNaN(day)){
                console.log(isNaN(day));
                return false;
            }else{
                day = parseInt(day);
                if(day > 0 && day < 32){
                    console.log('aqui va el true de días;');

                    if(isNaN(month)){
                        console.log('mes no es un numero')
                        return false;
                    }else{
                        month = parseInt(month);
                        if(month > 0 && month < 13){

                            console.log('aqui va el true de meses;');
                            if(isNaN(year)){

                                return false;
                            }else{
                                year = parseInt(year);
                                if(year > 0){
                                    return true
                                }else{
                                    return false;
                                }
                            }

                        }else{
                            return false;
                        }
                    }


                }else{
                    return false;
                }
            }

        }

    }else{
        return true;
    }

}