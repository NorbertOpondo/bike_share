<?php
    require(__DIR__.'/../includes/db_parameters.php');
    session_start();
?>
<div class="row">
	<div id="hireBike">
		<div class="row">
			<div id="form-header-container">
				<p id="hire-bike"> COMPLETE THE FORM TO HIRE A BIKE </p>
                <ul class="browser-default" style="font-size: 12px; list-style-type:square;">
                    <li>Payment is done at the Docking station</li>
                    <li>You must present your student id or a copy of your student id</li>
                    <li>Bikes should not be returned past the due date</li>
                </ul>
			</div>

            <div style="margin-right:100px;" class="right">
                <?php
                    try{
                        $conn = new PDO("mysql:host=$servername;dbname=bike_sharing",$usname,$pwd);
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $query = "SELECT bikes_remaining from bikes_remaining";
                        $stmt = $conn->query($query);
                        $row = $stmt->fetch();
                        $_SESSION['bikes_remaining'] = $row['bikes_remaining'];
                        $stmt = null;
                    }catch(PDOException $e){

                    }
                ?>
                <span style="font-size: 30px; font-weight:bold"> <?php echo $_SESSION['bikes_remaining']; ?> </span>  <span> bikes reamining  </span>
            </div>
		</div>
    		<div class="row">
                <div id="feedform" class="col l7 m10 s12">
                    <form style="font-family:consolas" id="ajax-hire" >
                        <div class="row">
                            <div class="input-field col s6 l6">
                                <input id="id_number" readonly name="id_number" type="text" value="<?php echo $_SESSION['student_id'];?>">
                                <label class="active" for="id_number">student Id</label>
                                <span class="error" id="id_error">  </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s6 l6">
                                <p style="color:gray"> from...<p><br>
                                <input  id="from" name="from" type="date" class="browser-default">
                                <span class="error" id="fromError"> </span>
                            </div>
                            <div class="input-field col s6 s12 l6">
                                <p style="color:gray">return date...</p><br>
                                <input id="return_date" name="return_date" type="date" class="browser-default">
                                <span class="error" id="return_date_error"> </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <Span style="color:gray"> Gender</span><br>
                                    <input id="male" type="radio" name="gender" value="male">
                                    <label style="color:black;" for="male">Male</label>
                             		<input id="female" type="radio" name="gender" value="female">
                             		<label style="color:black" for="female">Female</label>
                                <span class="error" id="genderError"> </span>
                            </div>	
                       	</div>
                        <div> <p style="font-weight:bold;font-family:consolas;font-size:20px;" id="success-msg"></p></div>
                        <div class="row">
                            <div class="input-field col l12 m12 s12">
                                <button id="submit-feedform" class="btn"> HIRE &nbsp;<i class="fa fa-bicycle fa-2x" aria-hidden="true"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        //get the hire_bike form
        var form = $('#ajax-hire');

         //prevent the form submission
         $(form).submit(function(event){
            event.preventDefault();
         });

         //event listener to intercept submit events from the form
         $('#submit-feedform').click(function(){

            //serialize the form data
            var formData = $(form).serialize();

            //form submission using ajax
            $.ajax({
                type: 'POST',
                url: 'http://localhost/includes/process_hire.php',
                data: formData,
                dataType: 'json',
                success:function(response){
                    console.log(response)
                    if (response.id_numberError) {
                        $('#id_error').html(response.id_numberError)
                    }else{
                        $('#id_error').html('')
                    }

                    if (response.fromError) {
                        $('#fromError').html(response.fromError)
                    }else{
                        $('#fromError').html('')
                    }

                    if (response.toError) {
                        $('#return_date_error').html(response.toError)
                    }else{
                        $('#return_date_error').html('')
                    }

                    if (response.genderError) {
                        $('#genderError').html(response.genderError)
                    }else{
                        $('#genderError').html('')
                    }

                    if (response.status == 'success') {
                        $('.error').html('')
                        $(form)[0].reset();
                        //$('#success-message').html('YOUR MESSAGE WAS SENT')
                        alertify.success("REQUEST SUCCESFULL. PRESENT A COPY OF YOUR STUDENT ID AT THE DOCK")
                    }
                },
                error:function(err){
                    console.log(err)
                }
            })
         });
    });
</script>
