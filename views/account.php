<?php
    session_start();
?>
<div>
    <div class="row">
        <div style="" class="col l12 m12 s12">
            <p class="account-header">MANAGE YOUR ACCOUNT SETTINGS</p>
        </div>
    </div>
    <div class="row">
        <div class="col l12 m12 s12">
            <div class="tabs tabs1">
                <a href=""><span id="reset" class="links">Reset my password</span></a> &nbsp &nbsp &nbsp &nbsp 
                <a href=""><span id="changeUname" class="links">Change my username</span></a> &nbsp &nbsp &nbsp &nbsp 
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col l12 m12 s12">
            <div class="tabs1">
               <div class="row">
                    <div id="feedform" class="col l7 m10 s12">
                        <form id="ajax-resetUname"  >
                            <div class="row">
                                <div class="input-field col s6 l6">
                                     <p style="float:left">Student id: </p> <br><br>
                                    <input  id="current_username" name="student_id" type="text" readonly value="<?php echo $_SESSION['student_id'] ?>" >
                                    <label for="student id"></label>
                                    <span class="error" id="studentId_error">  </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col l6 s6">
                                    <input id="new_username" name="new_username" type="text" >
                                    <label for="new_username">new username</label>
                                    <span class="error" id="new_username_Error"> </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col l6 m6 s6">
                                    <button id="submit-resetp" class="btn">CHANGE USERNAME &nbsp;<i class="fa fa-save fa-2x" aria-hidden="true"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="feedform" class="col l7 m10 s12">
                        <form  style="display:none" id="ajax-resetPwd" >
                            <div class="row">
                                <div class="input-field col s6 l6">
                                     <p style="float:left">Student id: </p> <br><br>
                                    <input  id="current_username" name="student_id" type="text" readonly value="<?php echo $_SESSION['student_id'] ?>" >
                                    <label for="student id"></label>
                                    <span class="error" id="studentId_error">  </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col l6 s6">
                                    <input id="new_password" name="new_password" type="password" class="validate">
                                    <label for="new_password">new password</label>
                                    <span class="error" id="new_password_Error"> </span>
                                </div>
                            </div>
                            <div class="row">
                            </div>
                            <div class="row">
                                <div class="input-field col l6 s6">
                                    <input id="conf_new_password" name="conf_new_password" type="password" class="validate">
                                    <label for="conf_new_password">Re-enter new password</label>
                                    <span class="error" id="conf_new_password_Error"> </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col l6 m6 s6">
                                    <button id="submit-resetpwd" class="btn">RESET PASSWORD &nbsp;<i class="fa fa-save fa-2x" aria-hidden="true"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        //get feedback form and store in a variable
        var form = $('#ajax-resetUname');

        //prevent form submission
        $(form).submit(function(event){
            event.preventDefault();
        });

        $('#submit-resetp').click(function(){
            var formData = $(form).serialize();

            //form submission with ajax
            $.ajax({
                type: 'POST',
                url: 'http://localhost/includes/process_uname_change.php',
                data: formData,
                dataType:'json',

                success:function(response){
                    console.log(response)
                    if (response.studentId_error) {
                        $('#studentId_error').html(response.studentId_error)
                    }else{
                        $('#studentId_error').html('')
                    }

                    if(response.new_uname_error){
                        $('#new_username_Error').html(response.new_username_Error)
                    }else{
                        $('#new_username_Error').html('')
                    }

                    if(response.status == 'success'){
                        $('.error').html('')
                        $(form)[0].reset()
                        alertify.success("USERNAME UPDATED SUCCESSFULLY <br> CHANGES WILL TAKE EFFECT ON NEXT LOG IN")
                    }
                },
                error:function(err){
                    console.log(err)
                }
            })
        });
    });
</script>
<script type="text/javascript">
    $(function(){
        //get feedback form and store in a variable
        var form = $('#ajax-resetPwd');

        //prevent form submission
        $(form).submit(function(event){
            event.preventDefault();
        });

        $('#submit-resetpwd').click(function(){
            var formData = $(form).serialize();

            //form submission with ajax
            $.ajax({
                type: 'POST',
                url: 'http://localhost/includes/process_pwd_reset.php',
                data: formData,
                dataType:'json',

                success:function(response){
                    console.log(response)
                    if (response.studentId_error) {
                        $('#studentId_error').html(response.studentId_error)
                    }else{
                        $('#studentId_error').html('')
                    }
                    if (response.new_passwordError) {
                        $('#new_password_Error').html(response.new_passwordError)
                    }else{
                        $('#new_password_Error').html('')
                    }
                    if(response.conf_new_passwordError){
                        $('#conf_new_password_Error').html(response.conf_new_passwordError)
                    }else{
                        $('#conf_new_password_Error').html('')
                    }

                    if(response.status == 'success'){
                        $('.error').html('')
                        $(form)[0].reset()
                        alertify.success("PASSWORD UPDATED SUCCESSFULLY <br> CHANGES WILL TAKE EFFECT ON NEXT LOG IN")
                    }
                },
                error:function(err){
                    console.log(err)
                }
            })
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        var reset = $('#reset');
        var changeUname = $('#changeUname');
        var del = $('#delete');

        $(reset).click(function(){
            $('#ajax-resetPwd').show();
            $('#ajax-deleteAcc').hide();
            $('#ajax-resetUname').hide();
        });

        $(changeUname).click(function(){
            $('#ajax-resetUname').show();
            $('#ajax-resetPwd').hide();
            $('#ajax-deleteAcc').hide();
        });

        $(del).click(function(){
            $('#ajax-deleteAcc').show();
            $('#ajax-resetUname').hide();
            $('#ajax-resetPwd').hide();

        })
    });
</script>