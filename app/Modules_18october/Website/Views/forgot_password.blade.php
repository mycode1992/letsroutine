@include('Website::include.header')
@include('Website::include.error')


<section class="health-routine-banner health-routine-contact-sec health-routine-signup-sec">
	<div class="container">
		<div class="health-routine-contact-container health-routine-signup-container">	
			<h2>Forgot Password</h2>
			<form id="userlogin" onsubmit="return loginFunction();" class="health-routine-contact-form health-routine-sinup-form">
				 <div class="form-row">	
				
				<div class="form-group col-md-7">
					<label class="form-title">Enter Your E-mail</label>
					<input type="text" class="form-control" id="email" placeholder="Enter E-mail" name="email">
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
		var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;

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
		
	
		var loginformdata = new FormData($('#userlogin')[0]);
			loginformdata.append('email', email);
			 document.getElementById("loginerror").innerHTML="<i class='fa fa-spinner fa-spin' style='font-size:24px;color: #1a4f52;'></i>";
			
			  
		
		$.ajax({
			  headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
			  type: 'POST',
			  url: "{{ url('/post_forgot_password') }}",
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
			var path="{{url('/login')}}";
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