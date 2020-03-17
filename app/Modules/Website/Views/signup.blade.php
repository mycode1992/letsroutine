@include('Website::include.header')
@include('Website::include.error')


<section class="health-routine-banner health-routine-contact-sec health-routine-signup-sec">
	<div class="container">
		<div class="health-routine-contact-container health-routine-signup-container">	
			<h2>SIGN UP</h2>
			<form enctype="multipart/form-data" method="POST" onsubmit="return register();" class="health-routine-contact-form health-routine-sinup-form">
				 <div class="form-row">	
				<div class="form-group col-md-6">
					<label class="form-title">Diet center name<span>*</span></label>
					<input type="text" class="form-control" onkeypress="return isChar(event) ;" id="diet_centre_name" name="diet_centre_name" placeholder="Diet Center Name" maxlength="50">
				</div>
				<div class="clearfix"></div>
				<div class="form-group col-md-6">
					<label class="form-title">Requester’s first name<span>*</span></label>
					<input type="text" class="form-control" onkeypress="return isChar(event) ;" id="fname" name="fname" placeholder="First Name" maxlength="50">
				</div>
				<div class="clearfix"></div>
				<div class="form-group col-md-6">
					<label class="form-title">Requester’s last name<span>*</span></label>
					<input type="text" class="form-control" onkeypress="return isChar(event) ;" id="lname" name="lname" placeholder="Last Name" maxlength="50">
				</div>
					<div class="clearfix"></div>
				<div class="form-group col-md-6">
					<label class="form-title">Phone number<span>*</span></label>
					<input type="text" class="form-control" onkeypress="return isNumber(event)"  id="phone" name="phone" placeholder="Phone Number" maxlength="10">
				</div>
					<div class="clearfix"></div>
				<div class="clearfix"></div>
				<div class="form-group col-md-6">
					<label class="form-title">Email address<span>*</span></label>
					<input type="text" class="form-control" id="email" name="email" placeholder="Email Address" maxlength="50">
				</div>
					<div class="clearfix"></div>
				<div class="form-group col-md-6">
					<label class="form-title">Password<span>*</span></label>
					<input type="password" class="form-control" id="password" name="password" placeholder="Password" maxlength="50">
				</div>
				<div class="clearfix"></div>
				<div class="form-group col-md-6">
					<label class="form-title">Confirm 	Password<span>*</span></label>
					<input type="password" class="form-control" id="con_password" name="con_password" placeholder="Confirm Password" maxlength="50">
				</div>
					<div class="clearfix"></div>
				<div class="form-group col-md-6">
					<label class="form-title">Diet center address<span>*</span></label>
					<input type="text" class="form-control" id="diet_centre_addr" name="diet_centre_addr" placeholder="Diet Center Address">
				</div>
					<div class="clearfix"></div>
				<div class="form-group col-md-6">
					<label class="form-title">Diet center logo<span>*</span></label>
					<span class="error-msg" id="errorMsg"></span>	
						<div class="fileUpload full-width-img">
							<input class="fileUploader" type="file"  id="coverimage" name="coverimage" onchange="uploadimg()">
							<input type="hidden" id="image_name" name="image_name" value="">
							<input type="hidden" name="imagePath" id="imagePath" value="" >
							<span id="error17" style="color:red"></span>
							<div> 
								<div class="useredit-img-text">
									<div class="useredit-img" id="imgTest"><img src="{{url('/')}}/public/website/img/camera_icon.png" alt="" class="img-responsive"></div>
								</div>
							</div>
						</div>
				</div>
				<div class="clearfix"></div>
			</div>
			<span id="errormsg1" class="error-msg"></span>	
			<button type="submit" class="btn btn-default" id="submit-approval">Submit</button>
			<div class="waiting-aproval">Wait for our approval</div>
			</form>		
		</div>

	</div>
</section>
@include('Website::include.footer')

<script>
	function register() 
	{ 	
	var diet_centre_name =document.getElementById("diet_centre_name").value;
	var fname =document.getElementById("fname").value;
	var lname =document.getElementById("lname").value;
	var phone =document.getElementById("phone").value;
	var email =document.getElementById("email").value;
	var password =document.getElementById("password").value;
	var con_password =document.getElementById("con_password").value;
	var diet_centre_addr =document.getElementById("diet_centre_addr").value;
	var coverimage =document.getElementById("coverimage").value.trim();
	var  coverimage = $('#coverimage')[0].files[0];
	
	var strUserEml=email.toLowerCase();
	var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;  
	
	
	if(diet_centre_name == "")
	{
	document.getElementById('diet_centre_name').style.border='1px solid red';
	document.getElementById("diet_centre_name").focus();
	$('#diet_centre_name').attr("placeholder", "Please enter diet centre name");
	$( "#diet_centre_name").addClass( "errors" );
	return false;
	}
	else
	{
	document.getElementById('diet_centre_name').style.border=' ';
	}
	
	if(fname == "")
	{
	document.getElementById('fname').style.borderColor='#ff0000';
	document.getElementById("fname").focus();
	$('#fname').attr("placeholder", "Please enter first name");
	$( "#fname").addClass( "errors" );
	return false;
	}
	else
	{
	document.getElementById('fname').style.borderColor=' ';
	}
	
	if(lname == "")
	{
	document.getElementById('lname').style.borderColor='#ff0000';
	document.getElementById("lname").focus();
	$('#lname').attr("placeholder", "Please enter last name");
	$( "#lname").addClass( "errors" );
	return false;
	}
	else
	{
	document.getElementById('lname').style.borderColor=' ';
	}
	
	if(phone=="")
	{
	
	document.getElementById('phone').style.border='1px solid #ff0000';
	document.getElementById("phone").focus();
	$('#phone').attr("placeholder", "Please enter your Mobile Number");
	$("#phone").addClass( "errors" );
	
	return false;
	}
	else if(phone.length <=9 || phone.length >=11)
	{
	document.getElementById('phone').style.border='1px solid #ff0000';
	document.getElementById("phone").focus();
	$("#phone").val('');
	$('#phone').attr("placeholder", "Phone no should be 10 digits");
	$("#phone").addClass( "errors" );
	
	return false;
	}
	else
	{
	document.getElementById("phone").style.border = "";     
	
	}
	       
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
	
 
		if(password=="")
	{
	document.getElementById('password').style.border='1px solid #ff0000';
	document.getElementById("password").focus();
	$('#password').val('');
	$('#password').attr("placeholder", "Please enter  password");
	$("#password").addClass( "errors" );
	return false;
	}
	else if (password.length<=5 || password.length>=51) 
	{   
	document.getElementById('password').style.borderColor='#ff0000';
	document.getElementById("password").focus();
	$('#password').val('');
	$('#password').attr("placeholder", "Password Must Be Between 6-50 Char");
	$("#password").addClass( "errors" );
	return false;
	}
	else
	{
	document.getElementById("password").style.border = "";   
	}
	
	if(con_password=="")
	{
	document.getElementById('con_password').style.border='1px solid #ff0000';
	document.getElementById("con_password").focus();
	$('#con_password').val('');
	$('#con_password').attr("placeholder", "Please enter confirm password");
	$("#con_password").addClass( "errors" );
	return false;
	}
	else
	{
	document.getElementById("con_password").style.border = "";   
	}
	
	if(password != con_password){
	document.getElementById("errormsg1").style.color = "#ff0000";
	document.getElementById("errormsg1").innerHTML="Password does not match" ; 
	return false;
	}
	else
	{
	document.getElementById("errormsg1").style.color = "";
	document.getElementById("errormsg1").innerHTML="" ; 
	}

	if(diet_centre_addr == "")
	{
	document.getElementById('diet_centre_addr').style.borderColor='#ff0000';
	document.getElementById("diet_centre_addr").focus();
	$('#diet_centre_addr').attr("placeholder", "Please enter center address");
	$( "#diet_centre_addr").addClass( "errors" );
	return false;
	}
	else
	{
	document.getElementById('diet_centre_addr').style.borderColor=' ';
	}
	document.getElementById("errormsg1").innerHTML="<i class='fa fa-spinner fa-spin' style='font-size:24px;color: #1a4f52;'></i>";
	var form = new FormData(); 
	form.append('diet_centre_name',diet_centre_name);
	form.append('fname',fname);
	form.append('lname',lname);
	form.append('phone',phone);
	form.append('email',email);
	form.append('password',password);
	form.append('diet_centre_addr',diet_centre_addr);
	form.append('coverimage',$('#coverimage')[0].files[0]);
	
	$.ajax({    
		headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
		type: 'POST',
		url: "{{url('/register')}}",
		data:form,
		contentType: false,
		processData: false,
		success:function(response) 
		{
		console.log(response); 	// return false;
		var status=response.status;
		var msg=response.msg;      
		  
		if(status=='200')
		{
			$('#errormsg1').css('color','green');
			document.getElementById("errormsg1").innerHTML=response.msg;
			setTimeout(function() { location.reload(true) }, 3000);
		}
		else if(status=='401')
		{			
		$('#errormsg1').css('color','red');
		document.getElementById("errormsg1").innerHTML=msg;
		}
		}
		 });
		return false;
		}
	
		var Image_64byte="";
		var filesSelected ="";
		function uploadimg() 
		{
		document.getElementById('error17').innerHTML="";
		var image_name =document.getElementById("image_name").value;
	
		if(image_name!="")
		{
	
		//document.getElementById('edit_image').style.display='none';
		}
	
		//$("#hidetxt").css("display", "none");
		var e = document.getElementById("coverimage"),
		t = e.value,
		n = $("#coverimage")[0].files[0].size / 1024;
		if (n > 2048) return document.getElementById("image_name").value = " ", document.getElementById("coverimage").value = "", document.getElementById("errorMsg").style.color = "#ff0000", document.getElementById("errorMsg").innerHTML = "Image size should be less than 2mb", !1;
		var m = document.getElementById("coverimage").value,
		m = m.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, "_");
		m = m.replace(/[^a-zA-Z0-9]/g, "_");
		var l = m.split("_"),
		d = t.substring(t.lastIndexOf(".") + 1).toLowerCase(),
		r = l[3] + "." + d;
			if ("png" != d && "jpeg" != d && "jpg" != d) return document.getElementById("image_name").value = "", document.getElementById("errorMsg").style.color = "#ff0000", document.getElementById("errorMsg").innerHTML = "Image only allows file types of PNG,JPG,JPEG", !1;
		if (document.getElementById("errorMsg").style.color = "", document.getElementById("errorMsg").innerHTML = "", filesSelected = document.getElementById("coverimage").files, filesSelected.length > 0) {
		var g = filesSelected[0],
		a = new FileReader;
		a.onload = function(e) {
		var t = e.target.result,
		n = t.split(",");
		document.getElementById("imagePath").value = n[1];
		var m = document.createElement("img");
	
		m.src = t, m.className = "img-responsive", document.getElementById("imgTest").innerHTML = m.outerHTML, document.getElementById("image_name").value = r, Image_64byte = document.getElementById("imgTest").innerHTML
	//	document.getElementById('edit_image').style.display='none';
	
		}, a.readAsDataURL(g)
		}
	
	
	
	
		}
	
		</script>


<style type="text/css">
	
	.error-msg {
		position: absolute;
	    bottom: 10%;
	}

	.health-routine-sinup-form {
		position: relative;
	}

</style>		