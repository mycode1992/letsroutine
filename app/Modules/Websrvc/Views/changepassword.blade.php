@include('Website::include.header')
@include('Website::include.error')
@php 
$segment = $token; 
@endphp
<section class="health-routine-banner health-routine-contact-sec health-routine-signup-sec">
	<div class="container">
		<div class="health-routine-contact-container health-routine-signup-container">	
           @if($token_status==1)
			<h2>Change Password</h2>
			<form id="userlogin" onsubmit="return change_password();" class="health-routine-contact-form health-routine-sinup-form">
                    <input type="hidden" name="user_id" id="user_id" value="<?php echo $segment;?>" >
				<div class="form-row">
					<div class="clearfix"></div>
					<div class="form-group col-md-7">
						<label class="form-title">New Password </label>

						<input type="password" class="form-control" id="password" placeholder="Enter New Password" name="password">
					</div>
					<div class="form-group col-md-7">
						<label class="form-title">Confirm Password </label>

						<input type="password" class="form-control" id="repassword" placeholder="Enter Confirm Password" name="repassword">
					</div>
					<div class="clearfix"></div>
				</div>	
				<div id="loginerror" style="color:#ff0000;text-align: left;">
				</div>
				<button type="submit" class="btn btn-default">Submit</button>
            </form>	
            @endif
            @if($token_status==2)
            <div class="dos-company-info-title" style="color:#FF0000;">Sorry! Your requested token has been expired</div>
        
            @endif
            @if($token_status==3)
            <div class="dos-company-info-title" style="text-align:center;margin: 60px 0 15px;color: #FF0000;">Unauthorized Access</div>
        
            @endif	
		</div>

	</div>
</section>

@include('Website::include.footer')

<script>
        function change_password()
        {  
        var password =document.getElementById("password").value.trim();
        var user_id =document.getElementById("user_id").value.trim();
        var repassword =document.getElementById("repassword").value.trim();
        var PswFilter = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[^\w\s]).{8,}$/;
        var test=PswFilter.test(password);
        if(password=="")
        {
        document.getElementById('password').style.borderColor='#ff0000';
        document.getElementById("password").focus();
        $('#password').val('');
        $('#password').attr("placeholder", "Enter password");
        $("#password").addClass( "errors" );
        return false;
        }
        else if (password.length<6 || password.length>=51) 
        {   
        document.getElementById('password').style.borderColor='#ff0000';
        document.getElementById("password").focus();
        $('#password').val('');
        $('#password').attr("placeholder", "Password should be at least 6-50 characters");
        $("#password").addClass( "errors" );
        return false;
        }
        else
        {
        document.getElementById("password").style.borderColor = "";   
        }
        if(repassword=="")
        {
        document.getElementById('repassword').style.borderColor='#ff0000';
        document.getElementById("repassword").focus();
        $('#repassword').val('');
        $('#repassword').attr("placeholder", "Enter confirm password");
        $("#repassword").addClass( "errors" );
        return false;
        }
    
        else
        {
        document.getElementById("repassword").style.borderColor = "";   
        }
    
        if(password!=repassword)
        {
        document.getElementById('repassword').style.borderColor='#ff0000';
        document.getElementById("repassword").focus();
        $('#repassword').val('');
        $('#repassword').attr("placeholder", "Confirm password does not match");
        $("#repassword").addClass( "errors" );
        return false;
        }
    
    
    
        $.ajax({  
        headers: {'X-CSRF-Token':'{{ csrf_token() }}'},    
        type: 'POST',
        url: "{{url('/websrvc/changepasswordinsert')}}",
        data: {password:password,user_id:user_id}, 
    
        success:function(response) 
        {
        console.log(response); //  return false;
        var status=response.status;
        var msg=response.msg;
        if(status=='200')
        {
        var path="{{url('/')}}";
        $("#password,#repassword").removeClass( "errors" );
        $("#password,#repassword").val('');
        document.getElementById("loginerror").innerHTML=msg;
        document.getElementById("loginerror").style.color = "#278428";
        setTimeout(function() { window.location=path; }, 3000);
        }
        else if(status=='401')
        {
        document.getElementById("loginerror").style.color = "#ff0000";
        document.getElementById("loginerror").innerHTML=response.msg ;
        }
    
        }
    
        });
        return false;
    
        }  // end of function
        </script>