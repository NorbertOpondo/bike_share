<?php
  require(__DIR__."/includes/process_user_login.php");
?>
<!DOCTYPE HTML>
<html>
    <head>
        <?php
        // import the reg_process.php file for for processing
        ?>
        <title>Log in</title>
        <!--Include javascript and css files-->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script  type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
        <script type="text/javascript" src="js/materialize.min.js"></script>
        <script type="text/javascript" src="js/angular.min.js"></script>
        <script type="text/javascript" src="js/alertify.min.js"></script>
        <link rel="stylesheet" href="css/materialize.min.css" />
        <link rel="stylesheet" href="fonts/material icons/icons.css"/>
        <link rel="stylesheet" href="css/index.css" />
        <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.css" />
        <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css"/>
        <link rel="stylesheet" href="css/alertify.min.css"/>
        <link rel="stylesheet" href="css/semantic.min.css"/>
        <style>
          .error{
            color:red;
          }
        </style>
   </head>
   <body>
       <div class="container">
           <h3 style="background-color: #26A69A; color:white" class=" card-panel center">MMU BIKE SHARE</h3>
           <div class="row card" >
               <div class="col s12">
                   <ul class="tabs">
                       <li  class="tab col s3 green-text"><a style="color:#26A69A;font-size:20px" id="logintab"class="active" href="#login"><i class="fa fa-key fa-2x" aria-hidden="true"></i> <b>&nbsp; LOG IN </b></a></li>
                       
                       <li class="tab col s3"><a style="color:#26A69A;font-size:20px" href="#register"> <i class="fa fa-book fa-2x "aria-hidden="true"></i>&nbsp; REGISTER</a></li>
                   </ul>
               </div>
               <!--Log in form for registered users-->
               <div style="font-family:consolas,Arial" id="login" class="col s8">
                   <div class="container">
                       <div class="row">
                           <form class="col s8" method="POST" action= "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                               <div class="row">
                                   <div class="input-field col s12">
                                       <input  id="name" type="text" class="active validate" name="username"  value="<?= $username ?>">
                                       <label for="name">Username</label>
                                       <span class="error"> <?= $usernameError ?> </span>
                                   </div>
                                   <div class="input-field col s12">
                                       <label for="password">Password</label>
                                       <input id="password" type="password" class="validate" name="password"  >
                                       <span class="error"> <?= $passwordError ?> </span>
                                   </div>
                                   <div>
                                       <button id="submit-login" class=" btn"> SUBMIT</button>
                                   </div>
                               </div>
                           </form>
                       </div>
                   </div>
               </div>
               <!--Registration form for new users-->
               <div style="font-family:consolas,Arial" id="register" class="col s12">
                   <div style="" class="row">
                       <form class="col s12" id="ajax-register">
                           <div class="row">
                               <div class="input-field col l4 s6">
                                   <input id="first_name" name="name" type="text" class="validate" >
                                       <label for="first_name">First Name</label>
                                       <span class="error" id="first_name_error">  </span>
                               </div>
                               <div class="input-field col l4 s6">
                                   <input id="last_name" name="last_name" type="text" class="validate">
                                       <label for="last_name">Last Name</label>
                                       <span class="error" id="last_name_error"> </span>
                               </div>
                           </div>
                           <div class="row">
                               <div class="input-field col l4 s12">
                                   <input id="stud-id" name="stud_id" type="text" class="validate" >
                                       <label for="stud-id">Student ID</label>
                                       <span class="error" id="stud_id_error"> </span>
                               </div>
                               <div class="input-field col l4 s12">
                                   <input id="email" name="email" type="email" class="validate">
                                       <label for="email">Email</label>
                                       <span class="error" id="email_error"> </span>
                               </div>
                           </div>
                           <div class="row">
                               <div class="input-field col l4 s6">
                                   <input id="password" name="password" type="password" class="validate">
                                       <label for="password">Password</label>
                                       <span class="error" id="password_error"> </span>
                               </div>
                               <div class="input-field col l4 s6">
                                   <input id="confirm-password" name="confirm_password" type="password" class="validate">
                                       <label for="confirm-password">Confirm Password</label>
                                       <span class="error" id="confirm_password_error"> </span>
                               </div>
                           </div>
                           <div class="row">
                               <div class="input-field col l4 s12">
                                   <input id="username" name="username" type="text" class="validate">
                                       <label for="username">Username</label>
                                       <span class="error" id="username_error"> </span>
                               </div>
                           </div>
                            <div> <p  style="font-weight:bold;font-family:consolas;font-size:20px;" id="success-msg" > </p></div>
                           <button class="btn" id="details-submit"> REGISTER</button>
                       </form>
                   </div>
               </div>
           </div>
       </div>
   </body>
</html>
<script type="text/javascript">
       $(function(){
            //Select the user registration form
            var reg_form = $('#ajax-register');

            //prevent form submission
            $(reg_form).submit(function(event){
              event.preventDefault();
            });

            //Event listener that intercepts submit events from the form
            $('#details-submit').click(function(){
              var formData = $(reg_form).serialize();

              $.ajax({
                type: 'POST',
                url: 'http://localhost/includes/reg_process.php',
                data: formData,
                dataType: 'json',
                success:function(response){
                  console.log(response)

                  if(response.first_nameError){
                    $('#first_name_error').html(response.first_nameError)
                  }else{
                    $('#first_name_error').html('')
                  }

                  if(response.last_nameError){
                    $('#last_name_error').html(response.last_nameError)
                  }else{
                    $('#last_name_error').html('')
                  }

                  if(response.studIdError){
                    $('#stud_id_error').html(response.studIdError)
                  }else{
                    $('#stud_id_error').html('')
                  }

                  if(response.emailError){
                    $('#email_error').html(response.emailError)
                  }else{
                    $('#email_error').html('')
                  }
                  if(response.sameId){
                    alertify.error(response.sameId)
                  }
                  if(response.passwordError){
                    $('#password_error').html(response.passwordError)
                  }else{
                    $('#password_error').html('')
                  }

                  if(response.confPasswordError){
                    $('#confirm_password_error').html(response.confPasswordError)
                  }else{
                    $('#confirm_password_error').html('')
                  }

                  if(response.usernameError){
                    $('#username_error').html(response.usernameError)
                  }else{
                    $('#username_error').html('')
                  }
                  if(response.status == 'success'){
                    $('.error').html('')
                    $(reg_form)[0].reset()
                    $('#success-msg').html('REGISTRATION WAS SUCCESFULL, YOU CAN NOW LOG INTO YOUR ACCOUNT')
                  }
                },
                error:function(err){
                  console.log(err)
                } 
            })
          });    
       });
   </script>
