@include('Website::include.header')
@if(!empty(Session::get('sessionvendor')))
<script>
	var path="{{url('/vendor/myprofile')}}";
			setTimeout(function() {
			
			window.location=path; }, 10);
</script>
@endif
<section class="health-routine-banner health-routine-contact-sec health-routine-signup-sec">
	<div class="container">
		<div class="health-routine-contact-container health-routine-signup-container">	
			<h2>Login</h2>
			<form id="userlogin" onsubmit="return loginFunction();" class="health-routine-contact-form health-routine-sinup-form">
				 <div class="form-row">	
				
				<div class="form-group col-md-7">
					<label class="form-title">Email </label>
					<input type="text" class="form-control" id="email" placeholder="Enter E-mail" name="email">
				</div>
				<div class="clearfix"></div>
				<div class="form-group col-md-7">
					<label class="form-title">Password </label>
					
					<input type="password" class="form-control" id="password" placeholder="Enter Password" name="password">
				<span class="forget-pwd"><a href="{{url('/forgot-password')}}">Forgot Password</a></span>
				</div>
			
				<div class="clearfix"></div>
			</div>	
			<div id="loginerror" style="color:#ff0000;text-align: left;">
			</div>
			<button type="submit" class="btn btn-default">Submit</button>
			
			</form>		
		</div>

	</div>
</section>
@include('Website::include.footer')


<script>
	function loginFunction()
	{
		
		var email =document.getElementById("email").value.trim();
		var strUserEml=email.toLowerCase();
		var password =document.getElementById("password").value.trim();
		var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
		var PswFilter = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[^\w\s]).{8,}$/;
		var test=PswFilter.test(password);
	
		if(email=="")
		{
		  document.getElementById("email").style.borderWidth = "1px";
		  document.getElementById('email').style.borderColor='#ff0000';
			document.getElementById("email").focus();
			$('#email').attr("placeholder", "Enter E-Mail");
			$("#email").addClass( "errors" );
			return false;
		}
	   else if(!filter.test(strUserEml)) 
		{
			document.getElementById("email").style.borderWidth = "1px";
			document.getElementById('email').style.borderColor='#ff0000';
			document.getElementById("email").focus();
			$('#email').val('');
			$('#email').attr("placeholder", "Invalid E-mail");
			$("#email").addClass( "errors" );
			return false;
		}
	  else
		{
			document.getElementById("email").style.borderColor = "";     
			   
		}
		if(password=="")
		  {
			document.getElementById("password").style.borderWidth = "1px";
			document.getElementById('password').style.borderColor='#ff0000';
			document.getElementById("password").focus();
			$('#password').val('');
			$('#password').attr("placeholder", "Enter Password");
			$("#password").addClass( "errors" );
			return false;
		  }
		   
	   else
		  {
			document.getElementById("password").style.borderColor = "";   
		  }

	
		var loginformdata = new FormData($('#userlogin')[0]);
			loginformdata.append('email', email);
			loginformdata.append('password', password);
			 document.getElementById("loginerror").innerHTML="<i class='fa fa-spinner fa-spin' style='font-size:24px;color: #1a4f52;'></i>";
			   console.log(loginformdata);
			  
		
		$.ajax({
			  headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
			  type: 'POST',
			  url: "{{ url('/login_check') }}",
			  data:loginformdata ,
			  cache: false,
			  contentType: false,
			  processData: false,  
			  success:function(response) 
			  {
				
				  console.log(response);
	
				  var status=response.status;
			var msg=response.msg;
			if(status=='200')
			{
				$('#loginerror').css('color','green');
				document.getElementById("loginerror").innerHTML=response.msg;
			var path="{{url('/vendor/myprofile')}}";
			setTimeout(function() {
			
			window.location=path; }, 3000);
	
			}
			 else if(status=='401')
			{
				$('#loginerror').css('color','red');
				document.getElementById("loginerror").innerHTML=msg;
			}
			  else {
	
			  }
		  }
	
	
		});
		
	   
	  return false;
	}
	
	  </script>