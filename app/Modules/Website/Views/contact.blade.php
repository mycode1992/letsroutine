@include('Website::include.header')
@include('Website::include.error')


<section class="health-routine-banner health-routine-contact-sec">
	<div class="container">
		<div class="health-routine-contact-container health-routine-signup-container">	
			<h2>Contact Us</h2>
			<form  class="health-routine-contact-form health-routine-sinup-form" onsubmit="return AddContact();">
				<div class="form-row">
				<div class="form-group col-md-6" >
					<input type="text" class="form-control" id="name" maxlength="50" onkeypress="return isChar(event)" placeholder="Full Name" name="name">
				</div>
				<div class="clearfix"></div>
				<div class="form-group col-md-6">
					<input type="text" class="form-control" maxlength="80" id="email" placeholder="E-mail" name="email">
				</div>
				<div class="clearfix"></div>
				<div class="form-group col-md-6" >
					<textarea class="form-control" placeholder="Add a message"  rows="5" id="message" name="message" maxlength="200" Value=""></textarea>
				</div>
				<div class="clearfix"></div>
				<div class="form-group col-md-6" >
				<div id="errormsg" class="contact-error" ></div>
				<button type="submit" id="Submit_but" class="btn btn-default">Submit</button>
				</div>
			</div>

			</form>		
		</div>

	</div>
</section>
@include('Website::include.footer')
<script type="text/javascript">
	function AddContact()
	{  
		document.getElementById("errormsg").innerHTML='';  
		var name =document.getElementById("name").value.trim();
		var email =document.getElementById("email").value.trim();
		var message =document.getElementById("message").value.trim();
		var strUserEml=email.toLowerCase();
		var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;  
		// validation for name 
		if(name=="")
		{
		  document.getElementById('name').style.border='1px solid #ff0000';
		  document.getElementById("name").focus();
		  $('#name').val('');
		  $('#name').attr("placeholder", "Please enter your full name");
		  $("#name").addClass( "errors" );
		  return false;
		}
		else if (name.length<=2 || name.length>=51) 
		{   
			document.getElementById('name').style.border='1px solid #ff0000';
			document.getElementById("name").focus();
			$('#name').val('');
			$('#name').attr("placeholder", "Name must be 2-50 characters");
			$("#name").addClass( "errors" );
			return false;
		}
		else
		{
		  document.getElementById("name").style.border = "";   
		}       
	
	 // validation for email 
		 if(email=="")
	  {
	
		   document.getElementById('email').style.border='1px solid #ff0000';
		   document.getElementById("email").focus();
		   $('#email').attr("placeholder", "Please enter your e-mail");
		   $("#email").addClass( "errors" );
	
			return false;
	  }
	  else if(!filter.test(strUserEml)) 
	  {
	
		document.getElementById('email').style.border='1px solid #ff0000';
		   document.getElementById("email").focus();
		   $('#email').val('');
		   $('#email').attr("placeholder", "Invalid e-mail address");
		   $("#email").addClass( "errors" );
	
			return false;
	  }
	  else
	  {
		 document.getElementById("email").style.borderColor = "";     
		   
	  }
	 
		// validation for message
		if(message=="")
		{
			
		  document.getElementById('message').style.border='1px solid #ff0000';
		  document.getElementById("message").focus();
		  $('#message').val('');
		  $('#message').attr("placeholder", "Please enter your message");
		  $("#message").addClass( "errors" );
		  return false;
		}
		else if (message.length<=4 || message.length>=201) 
		{   
			document.getElementById('message').style.border='1px solid #ff0000';
			document.getElementById("message").focus();
			$('#message').val('');
			$('#message').attr("placeholder", "Message must be between 5-201 char");
			$("#message").addClass( "errors" );
			return false;
		}
		else
		{
		  document.getElementById("message").style.border = "";   
		}
		document.getElementById('Submit_but').innerHTML='Sending...'; 
		var form = new FormData();
			form.append('name', name);
			form.append('email', strUserEml);
			form.append('message', message); 
				$.ajax({  
				headers: {'X-CSRF-Token':'{{ csrf_token() }}'},  
				type: 'POST',
				url: "{{url('/storecontact')}}",
				data: form,
				cache: false,
				contentType: false,
				processData: false,
				success:function(response) 
					{
					console.log(response);
					document.getElementById('Submit_but').innerHTML='Submit';
					var status=response.status;
					var msg=response.msg;
					if(status=='200')
					{
						$("#name,#email,#message").removeClass( "errors" );
						$("#name,#email,#message").val('');
						$('#name').attr("placeholder", "Full Name");
						$('#email').attr("placeholder", "Email Address");
						$('#message').attr("placeholder", "Message...");
					
						document.getElementById("errormsg").innerHTML=msg;
						document.getElementById("errormsg").style.marginBottom = "15px";
						document.getElementById("errormsg").style.color = "#278428";
					
					}
					else if(status=='401')
					{
						console.log(msg);
						document.getElementById('Submit_but').innerHTML='Submit'; 
						document.getElementById("errormsg").style.color = "#ff0000";
						document.getElementById("errormsg").innerHTML=response.msg ;
					}
					
					}
	
					});
			return false;
	}// end of function
	</script>