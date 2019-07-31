/**
 * Created by La gorda de Carlos on 27/09/2016.
 */
$(document.body).on('submit','#form-login',function(e){
    e.preventDefault();
    var form = new FormData($('#form-login')[0]);
    $.ajax({
        url: 'login/authUser', // point to server-side PHP script
        dataType: 'text',  // what to expect back from the PHP script, if anything
        cache: false,
        contentType: false,
        processData: false,
        data: form,
        type: 'post',
        success: function(response){
            try{
                var r = JSON.parse(response);
                if(r.status === 'forbidden'){

                }else if(r.status === 'failed'){
                    $('.login-alert').fadeIn('slow');
                }else if(r.status === 'success'){
                    window.location.replace('dashboard/')
                }
            }catch(err){
                console.log(err)
            }
        },
        error: function (xhr, textStatus, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });
});