<?php
    session_start();
?>
<div  class="row">
    <div id="feedback">
        <div class="row">
            <div id="form-container">
                <div id="form-messages"> </div>
                <p id="contact-us">CONTACT US</p>
            </div>
        </div>
        <div class="row">
            <div id="feedform" class="col l7 m10 s12">
                <form style="font-family:consolas" id="ajax-contact" >
                    <div class="row">
                        <div class="input-field col s6 l6">
                            <input id="id_number" name="id_number" type="text" readonly value="<?php echo $_SESSION['student_id'] ?>" >
                            <label class="active" for="id_number"> student Id </label>
                            <span class="error" id="id_error">  </span>
                        </div>
                    
                        <div class="input-field col s6 l6">
                            <input  id="name" name="name" type="text" class="validate" readonly value="<?php echo $_SESSION['user'] ?>">
                            <label class="active" for="name"> Username</label>
                            <span class="error" id="nameError"> </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="email" name="email" type="email" class="validate">
                            <label for="email">Email</label>
                            <span class="error" id="emailError"> </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <textarea style="height: 20%;" id="message" name="message" type="text" class="validate">   </textarea>
                            <label for="message">Your feedback here</label>
                            <span class="error" id="messageError"> </span>
                        </div>
                    </div>
                    <div> <p style="font-weight:bold;font-family:consolas;font-size:20px;" id="success-msg"></p></div>
                    <div class="row">
                        <div class="input-field col l12 m12 s12">
                            <button id="submit-feedform" class="btn"> SEND &nbsp;<i class="fa fa-envelope fa-2x" aria-hidden="true"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
                    
</div>
<script type="text/javascript">
    $(function(){
        //Get the feedback form
        var form = $('#ajax-contact');

        //Get the messages div
        var formMessages = $('#form-messages');

        //prevents the form submission

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
                    if(response.nameError){
                        $('#nameError').html(response.nameError)
                    }else{
                        $('#nameError').html('')
                    }
                    if(response.emailError){
                        $('#emailError').html(response.emailError)
                    }else{
                        $('#emailError').html('')
                    }
                    if(response.messageError){
                        $('#messageError').html(response.messageError)
                    }else{
                        $('#messageError').html('')
                    }
                    if(response.status == 'success'){
                        $('.error').html('')
                        $(form)[0].reset();
                        alertify.success("YOUR MESSAGE WAS SENT")
                    }
                },
                error:function(err){
                    console.log(err)
                }
            })
        });
    });
</script>