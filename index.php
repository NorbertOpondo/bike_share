<?php
  require(__DIR__.'/includes/process_user_login.php');
  session_start();
  if(!isset($_SESSION['user'])){
    header("Location: userlogin.php");
  }
?>
<html ng-app="myApp">
    <head>
            <title> Mmu bike share </title>
            <!--
            <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
            <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular-route.js"></script>-->
            <script  type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
            <script type="text/javascript" src="js/materialize.min.js"></script>
            <script type="text/javascript" src="js/angular.min.js"></script>
            <script type="text/javascript" src="js/angular-route.min.js"></script>
            <script type="text/javascript" src="js/alertify.min.js"></script>
            <link rel="stylesheet" href="css/alertify.min.css"/>
            <link rel="stylesheet" href="css/semantic.min.css"/>
            <link href = "https://fonts.googleapis.com/icon?family=Material+Icons" rel =  "stylesheet">
            <link rel="stylesheet" href="css/materialize.min.css" />
            <link rel="stylesheet" href="fonts/material icons/icons.css" />
            <link rel="stylesheet" href="css/index.css" />
            <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.css" />
            <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css"/>
            <script type="text/javascript"></script>
            <style>
                .error{
                    color:red;
                    font-size: 13px;
                }
                a:focus{
                    color:;
                }
            </style>

    </head>

    <body>
        <ul id="slide-out" class="s-nav side-nav fixed ">
            <li>
                <div class="user-view">
                    <div class="background"></div>
                    <a href="#!user"><img class="square" src="images/o-BIKE-TO-WORK-DAY-2013-facebook.jpg"></a>

                </div>
            </li>
            <li class="hoverable"><a id="show-home" class="waves-effect white-text" href="#/"> <i class="fa fa-home fa-2x white-text darken-10" aria-hidden="true"></i>Home</a></li>
            <!--<li><div class="divider"></div></li>-->
            <li class=" hoverable"><a id="show-rates" class=" waves-effect white-text" href="#/bikerates"> <i class="fa fa-euro fa-2x white-text" aria-hidden="true"></i>Bike Rates</a></li>
            <!--<li><div class="divider"></div></li>-->
            <li class=" hoverable"><a class="waves-effect white-text" href="#/hirebike"> <i class="fa fa-bicycle fa-2x white-text" aria-hidden ="true"></i>Hire Bike</a></li>
            <!--<li><div class="divider"></div></li>-->
            <li class=" hoverable"><a id ="show-feed" class=" waves-effect white-text" href="#/feedback"><i class="fa fa-envelope fa-2x white-text" aria-hidden="true"></i>Feedback</a></li>

            <li class=" hoverable"><a id ="show-feed" class=" waves-effect white-text" href="#/account"><i class="fa fa-cog fa-2x white-text" aria-hidden="true"></i>My Account</a></li>
        </ul>

        <a href="#" data-activates="slide-out" class="button-collapse show-on-small"><i class=" white-text fa fa-bars fa-2x"></i></a>
        <div class="row">
            <div  id="header" class="col l12 m12 s12 z-depth-5">
                
                <div class="head-txt center white-text"> <p>MMU BIKE SHARE</p> </div>
                <div style="margin-top:-40px; font-weight: bold;font-family:consolas; font-size:14px; float:right;" class="head-txt white-text">
                    <p style="margin-bottom: -20px">Welcome, <i class="fa fa-user fa-1x"aria-hidden="true"></i> <?php echo $_SESSION['user']; echo "{"; echo $_SESSION['student_id']; echo "}"; ?></p>
                    <span> <?php
                            $mydate=getdate(date("U"));
                            echo "$mydate[weekday],$mydate[month]-$mydate[mday]-$mydate[year]";
                        ?>
                    </span>
                    <form method="POST" action="user_signout.php"> 
                        <button id=sign-out> <i class="fa fa-power-off fa-1x" aria-hidden="true"></i>  Log-out </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="back row">
            <div id="home" class="col l9 m12 s12">
                <div>
                    <ul class="n1 center-on-small-only center ">
                        <li> <p title="register as a member to access the bikes"class=" btn-large"><span class="txt">1</span>  REGISTER</p> </li>
                        <li> <p title="hire your bike" class=" btn-large"><span class="txt">2</span>  GET BIKE</p> </li>
                        <li> <p title="enjoy your ride" class=" btn-large"><span class="txt">3</span>  RIDE BIKE</p> </li>
                        <li> <p title="return bike to station when done" class=" btn-large"><span class="txt">4</span>  RETURN</p> </li>
                    </ul>
                </div>
            </div>
        </div>
        <div  class="row" >
              <div ng-view>  </div>
        </div>

        <script  type="text/javascript" src="js/app.js"></script>
    </body>
    <script type="text/javascript">
        angular.module('myApp',['ngRoute']).config(function($routeProvider){
            $routeProvider
            .when('/',{
                templateUrl: 'views/home.html'
            })
            .when('/feedback',{
                templateUrl: 'views/feedback.php'
            })
            .when('/bikerates',{
                templateUrl:'views/bikerates.htm'
            })
            .when('/account',{
                templateUrl:'views/account.php'
            })
            .when('/hirebike',{
                templateUrl:'views/hirebike.php'
            })
            .otherwise({redirectTo: '/'
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('select').material_select();
            //initiliaze the side nav in small devices
            $(".button-collapse").sideNav();
        });
    </script>
</html>
<!--<script type="text/javascript">
$('.button-collapse').sideNav('show');
    // Hide sideNav
    $('.button-collapse').sideNav('hide');
    // Destroy sideNav
    $('.button-collapse').sideNav('destroy');
</script>
<script type="text/javascript">
// Initialize collapse button
    $(".button-collapse").sideNav();
    // Initialize collapsible (uncomment the line below if you use the dropdown variation)
    //$('.collapsible').collapsible();
</script>
<script type="text/javascript">
(function($){
    $(function(){

        $('.button-collapse').sideNav();

    }); // end of document ready
})(jQuery); // end of jQuery name space
</script>



