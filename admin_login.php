
<!DOCTYPE HTML>

<html>
    <head>
      <?php
        include __DIR__.'/dashboard/includes/adminloginprocess.php';
      ?>
        
        <title>Log in</title>
        <!--Include javascript and css files-->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script  type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
        <script type="text/javascript" src="js/materialize.min.js"></script>
        <link rel="stylesheet" href="css/materialize.min.css" />
        <link rel="stylesheet" href="fonts/material icons/icons.css" />
        <link rel="stylesheet" href="css/index.css" />
        <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.css" />
        <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css"/>
        <style>
            .head{
                font-family:consolas;
                font-size: 40px;
            }
            #login{
                margin-left:10%;
            }
            .error{
              color:red;
            }
            form{
              font-family:consolas;
              font-size:;
            }

        </style>
   </head>
   <body>
       <div class="row">
           <div class="col l12 m12 s12">
               <div class="card-panel head center"><b> ADMIN LOGIN </b> <br><span> <i style="color:#00A87E; "class="fa fa-shield fa-2x" aria-hidden="true"></i></span></div>
           </div>

       </div>
           <div class="row">
               <div id="login" class="col l12 m12 s12">
                   <div class="container">
                       <div class="row">
                           <form class="col s8" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                               <div class="row" >
                                   <div class="input-field col l6 m12 s12">
                                       <input class="active" name="username" id="name" type="text" value="<?= $username?>"/>
                                       <label for="name"><i class="fa fa-user fa-2x" aria-hidden="true"></i>Username</label>
                                       <span class="error"> <?= $usernameError ?> </span>
                                   </div>
                                   <div class="input-field col l6 m12 s12">
                                       <input id="password" type="password" name="password" class="validate" value="<?= $password?>"/>
                                       <label for="password"><i class="fa fa-key fa-2x" aria-hidden="true"></i>Password</label>
                                       <span class="error"> <?= $passwordError ?> </span>
                                   </div>
                                   <div class="input-field col l12 m12 s12">
                                       <button style="font-size:20px" id="submit-login" class=" btn"><b> LOG IN </b></button>
                                   </div>
                               </div>
                           </form>
                       </div>
                   </div>
               </div>
           </div>
   </body>
</html>