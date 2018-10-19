<script type="text/javascript">
    $(function(){
    //Get the feedback form
    var form = $('#ajax-contact');

    //Get the messages div
    var formMessages = $('#form-messages');
    $(form).submit(function(event){
        event.preventDefault();
    });

    //Event listener to intercept submit events on the form
    $('#submit-feedform').click(function(){

        //Serialize the form data
        var formData = $(form).serialize();

        //form submission using ajax
        $.ajax({
            type: 'POST',
            url: 'http://localhost/includes/process_contact_form.php',
            data: formData,
            dataType:'json',
            success:function(response){
                console.log(response)
                if(response.id_numberError){
                    $('#id_error').html(response.id_numberError)
                }else{
                    $('#id_error').html('')
                }
            },
            error:function(err){
                console.log(err)
            }
        })
    });
});
</script>