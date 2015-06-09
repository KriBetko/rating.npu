$(document).ready(function(){
    $('#fos_user_registration_form_institute').change(function() {

        if ($(this).val()){
            $.ajax({
                method: "get",
                url: "/app_dev.php/cathedras/get/"+$(this).val()
            })
                .done(function( msg ) {
                    if (msg.status == 1){
                        $('#fos_user_registration_form_cathedra').empty().append(msg.output).prop('disabled', false);
                    } else  {
                        $('#fos_user_registration_form_cathedra').empty().append('<option value="">MODELL</option>').prop('disabled', 'disabled');
                    }

                });
        } else {
            $('#fos_user_registration_form_cathedra').empty();
        }
    });
});