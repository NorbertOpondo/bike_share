<?php
    require(__DIR__.'/includes/adminloginprocess.php');
    session_start();
    if(!isset($_SESSION['admin'])){
        header("location: ../admin_login.php");
    }
    //$_SESSION['user'] = $username;
    //echo $_SESSION['user'];
    //echo $username;
    /*try{
        $conn = new PDO("mysql:host=$servername;dbname=bike_sharing",$usname,$pwd);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "SELECT adminName FROM administrators WHERE adminName = '".$username."' ";
        $stmt = $conn->query($query);
        $row = $stmt->fetch();
        $myUser = $row['adminName'];
        echo $username;
        echo $myUser;
        echo $username;

    }catch(PDOException $e){
        
    }
    $conn = null;
    */
    
?>
<!DOCTYPE HTML>

<html>

<head>
  <title> Admin Page </title>
        <script  type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
        <script type="text/javascript" src="js/materialize.min.js"></script>
        <script type="text/javascript" src="js/angular.min.js"></script>
        <script type="text/javascript" src="js/angular-route.min.js"></script>
        <link rel="stylesheet" type="text/css" href="css/jsgrid-theme.min.css"></link>
        <link rel="stylesheet" type="text/css" href="css/jsgrid.min.css"> </link>
        <script type="text/javascript" src="js/alertify.min.js"></script>
        <link rel="stylesheet" href="css/alertify.min.css"/>
        <link rel="stylesheet" href="css/semantic.min.css"/>
        <link rel="stylesheet" type="text/css" href="adminPage.css">
        <link rel="stylesheet" href="css/materialize.min.css" />
        <link rel="stylesheet" href="fonts/material icons/icons.css" />
        <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.css" />
        <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css"/>
        <script type="text/javascript"></script>
        <style type="text/css">
            .error{
                color:red;
                font-size: 12px;
            }
        </style>
</head>

<body>
    <div class="row">
        <div class="col l12 m12 s12 card-panel top-pane">
            <p class="admin center"> ADMINISTRATION CONTROL PANEL </p>
            <p style="float:right; font-family: consolas;"><i class="fa fa-calendar fa-1x " aria-hidden="true"></i>
                <?php $mydate=getdate(date("U"));
                    echo "$mydate[weekday],$mydate[month]-$mydate[mday]-$mydate[year]";
            ?> <p>
            <p id="login-id"><i class="fa fa-user fa-1x"aria-hidden="true"></i> &nbsp Logged in as <span id="user"><?php 
               echo $_SESSION['admin'];
            ?> </span>     
            </p>
            <form action="signout.php"> 
                <button id=sign-out> <i class="fa fa-power-off fa-1x" aria-hidden="true"></i>  Sign-out </button>
            </form>
            
        </div>
    </div>

    <div class="row" style="font-family: consolas; font-size: 17px">
        <div class="col l12 m12 s12">
            <form class="col l2 right" id="ajax-delete">
                <input  class="browser-default" placeholder="student id"  style="border:solid 1px black;" name="student_id">
                <button id="del_btn" class="btn ">DELETE ACCOUNT</button>
                <span class="error" id="Id_error"></span>
            </form>
            <form class="col l2 left" id="ajax-return">
                <input  class="browser-default" placeholder="student id"  style="border:solid 1px black;" name="student_id">
                <button id="return-btn" class="btn ">RETURN BIKE</button>
                <span class="error" id="Id_error2"></span>
            </form>
            <div class="center">
                <button class="btn print1">PRINT TABLE</button>
            </div>

             <br><br><br>
             <h4 style="color:red" class="center-align"> REGISTERED USERS</h4>
           <span id="externalPager"></span>
           <div style="font-size: 14px" id="jsGrid"></div>
        </div>
    </div>

    <div class="row" style="font-family: consolas; font-size: 17px">
        <div class="col l12 m12 s12">
            <div class="right">
                <button class="btn print2">PRINT TABLE</button>
            </div>
            <h4 style="color:red" class="center-align"> ACTIVE BIKERS</h4>
           <span id="externalPager"></span>
           <div style="font-size: 14px" id="jsGrid2"></div>
        </div>
    </div>
    <div class="row" style="font-family: consolas; font-size: 17px">
        <div class="col l12 m12 s12">
            <div class="right">
                <button class="btn print3">PRINT TABLE</button>
            </div>
            <h4 style="color:red" class="center-align"> OVERDUE BIKES</h4>
           <span id="externalPager"></span>
           <div style="font-size: 14px" id="jsGrid3"></div>
        </div>
    </div>
</body>
<script type="text/javascript">
    $(function(){
        //get the feedback form as a varibale
        var form = $('#ajax-delete');

        //Prevent the form submission
        $(form).submit(function(event){
            event.preventDefault();
        });

        //Intercept submit requests by the form 
        $('#del_btn').click(function(){
            //Serialize the form data
            var formData = $(form).serialize();

            //form submission using ajax
            $.ajax({
                type:'POST',
                url: 'http://localhost/dashboard/includes/process_del_account.php',
                data: formData,
                dataType:'json',

                success:function(response){
                    console.log(response)
                    if(response.student_id_error){
                        $('#Id_error').html(response.student_id_error)
                    }else{
                        $('#id_error').html('')
                    }

                     if (response.status == "success") {
                        $('.error').html('')
                        $(form)[0].reset()
                        alertify.success("ACCOUNT DELETED SUCCESSFULLY")
                    }else{
                        alertify.error("THIS ACCOUNT DOES NOT EXIST IN THE DATABASE")
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
        //get the feedback form as a varibale
        var form = $('#ajax-return');

        //Prevent the form submission
        $(form).submit(function(event){
            event.preventDefault();
        });

        //Intercept submit requests by the form 
        $('#return-btn').click(function(){
            //Serialize the form data
            var formData = $(form).serialize();

            //form submission using ajax
            $.ajax({
                type:'POST',
                url: 'http://localhost/dashboard/includes/process_return_bike.php',
                data: formData,
                dataType:'json',

                success:function(response){
                    console.log(response)
                    if(response.student_id_error){
                        $('#Id_error2').html(response.student_id_error)
                    }else{
                        $('#id_error2').html('')
                    }

                     if (response.status == "success") {
                        $('.error').html('')
                        $(form)[0].reset()
                        alertify.success("BIKE RETURN WAS SUCCESSFUL")
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
        function loadTable3(){
            $("#jsGrid3").jsGrid({
        width: "98%",
        height: "auto",

        filtering: true,
        editing: true,
        sorting: true,
        autoload: true,
        paging: true,
        pageSize: 18,
        pageButtonCount: 5,
        pagerContainer: "#externalPager",
        deleteConfirm:"Are you sure you want to delete this field?",
        pagerFormat: "current view: {pageIndex} &nbsp;&nbsp; {first} {prev} {pages} {next} {last} &nbsp;&nbsp; total views: {pageCount}",
        pagePrevText: "<",
        pageNextText: ">",
        pageFirstText: "<<",
        pageLastText: ">>",
        pageNavigatorNextText: "&#8230;",
        pageNavigatorPrevText: "&#8230;",

        /*
        *load data from api to
        display in
        Grid
        **/
        
        controller: {
                loadData: function(filter) {
                    return $.ajax({
                        type: "GET",
                        url: "http://localhost/api/table3_gen.php",
                        data: filter,
                        success:function(result){
                            //code...
                            //everything Ok!Data loaded in grid
                        },
                        error:function(err){
                            //internal server error

                        }
                    })
            }
        },
         fields: [
            { name: "student_id",title:"Student Id", type:"text",editing:true, width: 100, validate: "required",},
            { name: "gender",title:"gender",type:"text",filtering:false },
            { name: "return_date",title:"Return Date", type:"text", width: 100,filtering:false },
            { name: "datediff(return_date,curdate())",title:"Overdue Days"},
            { type: "control" }
        ]
    });
    }
    loadTable3();
    });
</script>
<script type="text/javascript" src="js/jsgrid.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        function loadTable(){
            $("#jsGrid").jsGrid({
        width: "98%",
        height: "auto",

        filtering: true,
        editing: true,
        sorting: true,
        autoload: true,
        paging: true,
        pageSize: 18,
        pageButtonCount: 5,
        pagerContainer: "#externalPager",
        deleteConfirm:"Are you sure you want to delete this field?",
        pagerFormat: "current view: {pageIndex} &nbsp;&nbsp; {first} {prev} {pages} {next} {last} &nbsp;&nbsp; total views: {pageCount}",
        pagePrevText: "<",
        pageNextText: ">",
        pageFirstText: "<<",
        pageLastText: ">>",
        pageNavigatorNextText: "&#8230;",
        pageNavigatorPrevText: "&#8230;",

        /*
        *load data from api to
        display in
        Grid
        **/
        
        controller: {
                loadData: function(filter) {
                    return $.ajax({
                        type: "GET",
                        url: "http://localhost/api/table_gen.php",
                        data: filter,
                        success:function(result){
                            //code...
                            //everything Ok!Data loaded in grid
                        },
                        error:function(err){
                            //internal server error

                        }
                    })
            },
        },
         fields: [
            { name: "firstName",title:"First Name", type:"text",editing:true, width: 100, validate: "required"},
            { name: "lastName",title:"Last Name", type: "text", width: 100,filtering:false },
            { name: "student_id",title:"Student Id", type: "text", width: 100,filtering:true },
            { name: "email",title:"Email",type:"text",filtering:false },
            { name: "username",title:"Username", type:"text",width:100,filtering:false },
            { type: "control"}
        ]
    });
    }
    loadTable();
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        function loadTable2(){
            $("#jsGrid2").jsGrid({
        width: "98%",
        height: "auto",

        filtering: true,
        editing: true,
        sorting: true,
        autoload: true,
        paging: true,
        pageSize: 18,
        pageButtonCount: 5,
        pagerContainer: "#externalPager",
        deleteConfirm:"Are you sure you want to delete this field?",
        pagerFormat: "current view: {pageIndex} &nbsp;&nbsp; {first} {prev} {pages} {next} {last} &nbsp;&nbsp; total views: {pageCount}",
        pagePrevText: "<",
        pageNextText: ">",
        pageFirstText: "<<",
        pageLastText: ">>",
        pageNavigatorNextText: "&#8230;",
        pageNavigatorPrevText: "&#8230;",

        /*
        *load data from api to
        display in
        Grid
        **/
        
        controller: {
                loadData: function(filter) {
                    return $.ajax({
                        type: "GET",
                        url: "http://localhost/api/table2_gen.php",
                        data: filter,
                        success:function(result){
                            //code...
                            //everything Ok!Data loaded in grid
                        },
                        error:function(err){
                            //internal server error

                        }
                    })
            }
        },
         fields: [
            { name: "student_id",title:"Student Id", type:"text",editing:true, width: 100, validate: "required",},
            { name: "date_aquired",title:"Date Aquired", type:"text", width: 100,filtering:false },
            { name: "return_date",title:"Return Date", type:"text", width: 100,filtering:false },
            { name: "gender",title:"gender",type:"text",filtering:false },
            { type: "control" }
        ]
    });
    }
    loadTable2();
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.print1').click(function(){
            var printme = document.getElementById('jsGrid');
            var wme = window.open("","","widht=900","height=700");
            wme.document.write(printme.outerHTML);
            wme.document.close();
            wme.focus();
            wme.print();
            wme.close();
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.print2').click(function(){
            var printme = document.getElementById('jsGrid2');
            var wme = window.open("","","widht=900","height=700");
            wme.document.write(printme.outerHTML);
            wme.document.close();
            wme.focus();
            wme.print();
            wme.close();
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.print3').click(function(){
            var printme = document.getElementById('jsGrid3');
            var wme = window.open("","","widht=900","height=700");
            wme.document.write(printme.outerHTML);
            wme.document.close();
            wme.focus();
            wme.print();
            wme.close();
        });
    });
</script>
</html>