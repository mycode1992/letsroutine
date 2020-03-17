

		@include('Vendor::include.header')
		@include('Website::include.error')
		@php 
		$lr_user_userid = $data[0]->lr_user_userid;
		$lr_user_email = $data[0]->lr_user_email;
		$lr_userdetail_fname = $data[0]->lr_userdetail_fname;
		$lr_userdetail_lname = $data[0]->lr_userdetail_lname;
		$lr_userdetail_phone = $data[0]->lr_userdetail_phone;
		$lr_userdetail_centrename = $data[0]->lr_userdetail_centrename; 
		$lr_userdetail_centreaddr = $data[0]->lr_userdetail_centreaddr;
		$lr_area = $data[0]->lr_userdetail_area;
		$lr_block = $data[0]->lr_userdetail_block;
		$lr_street = $data[0]->lr_userdetail_street;
		$lr_building_number = $data[0]->lr_userdetail_building_number;
		$lr_office = $data[0]->lr_userdetail_office;
		$lr_userdetail_logo = $data[0]->lr_userdetail_logo; 
		@endphp
		<section class="myDashboard">
		<div class="container">
		<div class="row">
		@include('Vendor::include.sidebar')

		<div class="col-md-9">
		<div class="rightBox">
		<h3 class="formTitle">MY PROFILE</h3>
		<form onsubmit="return edit_profile();" action="">
		<input type="hidden" value="{{$lr_user_userid}}" name="userid" id="userid">
		<div class="col-md-12">
		<div class="form-group">
		<label for="">Diet center name<span>*</span></label>
		<input type="text" value="{{$lr_userdetail_centrename}}" readonly class="form-control">
		</div>
		</div>
		<div class="col-md-6">
		<div class="form-group">
		<label for="">Requester's first name<span>*</span></label>
		<input type="text" value="{{$lr_userdetail_fname}}" name="fname" id="fname" class="form-control">
		</div>
		</div>
		<div class="col-md-6">
		<div class="form-group">
		<label for="">Requester's last name<span>*</span></label>
		<input type="text" value="{{$lr_userdetail_lname}}" id="lname" name="lname" class="form-control">
		</div>
		</div>
		<div class="col-md-6">
		<div class="form-group">
		<label for="">Phone number<span>*</span></label>
		<input type="text"  onkeypress="return isNumber(event)" value="{{$lr_userdetail_phone}}" maxlength="8" id="phone" name="phone"  class="form-control">
		</div>
		</div>
		<div class="col-md-6">
		<div class="form-group">
		<label for="">Email address<span>*</span></label>
		<input type="text" value="{{$lr_user_email}}" id="email" name="email" class="form-control">
		</div>
		</div>
		<!-- <div class="col-md-12">
		<div class="form-group">
		<label for="">Diet center address <span>*</span></label>
		<textarea  id="center_address" name="center_address" class="form-control">@php echo $lr_userdetail_centreaddr @endphp</textarea>
		</div>
		</div> -->
		<div class="col-md-6">
		<div class="form-group">
		<label for="">Area<span>*</span></label>
		<input type="text" value="{{$lr_area}}" maxlength="250" id="area" name="email" class="form-control">
		</div>
		</div>
		<div class="col-md-6">
		<div class="form-group">
		<label for="">Block<span>*</span></label>
		<input type="text" value="{{$lr_block}}" maxlength="50" id="block" name="email" class="form-control">
		</div>
		</div>
		<div class="col-md-6">
		<div class="form-group">
		<label for="">Street<span>*</span></label>
		<input type="text" value="{{$lr_street}}" onkeypress="return isNumber(event);"  id="street" name="email" maxlength="10" class="form-control">
		</div>
		</div>
		<div class="col-md-6">
		<div class="form-group">
		<label for="">Building number<span>*</span></label>
		<input type="text" value="{{$lr_building_number}}" id="building" name="email" class="form-control" onkeypress="return isNumber(event);">
		</div>
		</div>
		<div class="col-md-6">
		<div class="form-group">
		<label for="">Office</label>
		<input type="text" value="{{$lr_office}}" maxlength="100" id="office" name="email" class="form-control">
		</div>
		</div>

		<div class="col-md-6">
		<div class="form-group">
		<!-- <label for="">Diet center address<span>*</span></label> -->
		<div class="rp-textsend-cols-btn">
		<label for="">
			<span class="error-msg" id="errorMsg"></span>	
			
				<!--  <span class="upload_logo">Upload your logo</span> -->
				<input type="hidden" id="image_name" name="image_name" value="">
			<input type="hidden" name="imagePath" id="imagePath" value="" >
			<span id="error17" style="color:red"></span>
			<div class="useredit-img-text">
				<div class="useredit-img" id="imgTest"><img src="{{url('/')}}/public/vendor/upload/logo/{{$lr_userdetail_logo}}" alt="" class="img-responsive"></div>
					<span class="upload_logo">Upload your logo
						<input type="file" id="coverimage" name="coverimage" onchange="uploadimg()">
					</span>
			</div>
		</label>
		</div>
		</div>
		</div>

		<div class="clearfix"></div>
		<div class="col-md-6">
		<div class="submitButton">
		<div id="wordCnt" style="color:red"></div>
		<button type="submit" class="sbmtbtn">Update</button>
		</div>
		</div>

		<div class="clearfix"></div>
		</form>
		</div>
		</div>
		</div>
		</div>
		</section>

		


		@include('Vendor::include.footer')

<script>
	function change_area()
	{
		var governorate_id = [];
		$('#select_governorate :selected').each(function(i, selected) {
			governorate_id[i] = $(selected).val();
			}); 

		var form = new FormData(); 
		form.append('governorate_id', governorate_id); 
		$.ajax({    
		headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
		type: 'POST',
		url: "{{url('/vendor/change_area')}}",
		data:form,
		contentType: false,
		processData: false,
		success:function(response) 
		{
		console.log(response); // return false;
		document.getElementById("wordCnt").innerHTML="" ; 
		$('#wordCnt').css('color','green')
		var status = response.status;
		if(status=='200')
		{  
		var area_id = response.area_id;       
		var area_name = response.area_name;
		var count_area_id = Object.keys(area_id).length; 
		var count_area_name = Object.keys(area_name).length; 
		$("#delivery_area option").remove();
		for(var i=0; i<count_area_id; i++)
		{
		$('#delivery_area')
		.append($("<option></option>")
		.attr("value",area_id[i])
		.text(area_name[i]));
		}
		}
		}
		});
		return false;
	}
</script>

		<script>

		function edit_profile()   
		{ 
		var fname = document.getElementById("fname").value.trim();
		var lname =document.getElementById("lname").value.trim();
		var phone =document.getElementById("phone").value.trim(); 
		var email =document.getElementById("email").value.trim();
		var userid =document.getElementById("userid").value.trim();

		//var center_address =document.getElementById("center_address").value.trim();
		var area =document.getElementById("area").value.trim();
		var block =document.getElementById("block").value.trim();
		var street =document.getElementById("street").value.trim();
		var building =document.getElementById("building").value.trim();
		var office =document.getElementById("office").value.trim();
		var coverimage =document.getElementById("coverimage").value.trim();
		var  coverimage = $('#coverimage')[0].files[0];

		var strUserEml=email.toLowerCase();
		var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
    //  console.log('sweta'); return false;
		if(fname=="")
		{
		document.getElementById('fname').style.border='1px solid #ff0000';
		document.getElementById("fname").focus();
		$('#fname').val('');
		$('#fname').attr("placeholder", "Please enter requester's first name.");
		$("#fname").addClass( "errors" );
		return false;
		}
		else
		{
		document.getElementById("fname").style.border = "";   
		}

		if(lname=="")
		{
		document.getElementById('lname').style.border='1px solid #ff0000';
		document.getElementById("lname").focus();
		$('#lname').val('');
		$('#lname').attr("placeholder", "Please enter requester's last name.");
		$("#lname").addClass( "errors" );
		return false;
		}
		else
		{
		document.getElementById("lname").style.border = "";   
		}
		if(phone=="")
		{

		document.getElementById('phone').style.border='1px solid #ff0000';
		document.getElementById("phone").focus();
		$('#phone').attr("placeholder", "Please enter your phone number.");
		$("#phone").addClass( "errors" );

		return false;
		}
		else if(phone.length <=7 || phone.length >8)
		{
		document.getElementById('phone').style.border='1px solid #ff0000';
		document.getElementById("phone").focus();
		$("#phone").val('');
		$('#phone').attr("placeholder", "Phone no should be 8 digits.");
		$("#phone").addClass( "errors" );

		return false;
		}
		else if(phone =='00000000')
		{
		document.getElementById('phone').style.border='1px solid #ff0000';
		document.getElementById("phone").focus();
		$("#phone").val('');
		$('#phone').attr("placeholder", "Please enter valid phone no.");
		$("#phone").addClass( "errors" );

		return false;
		}
		else
		{
		document.getElementById("phone").style.borderColor = "";     

		}
		// validation for email 
		if(email=="")
		{

		document.getElementById('email').style.border='1px solid #ff0000';
		document.getElementById("email").focus();
		$('#email').attr("placeholder", "Please enter your E-mail Id.");
		$("#email").addClass( "errors" );

		return false;
		}
		else if(!filter.test(strUserEml)) 
		{

		document.getElementById('email').style.border='1px solid #ff0000';
		document.getElementById("email").focus();
		$('#email').val('');
		$('#email').attr("placeholder", "Invalid E-mail Id");
		$("#email").addClass( "errors" );

		return false;
		}
		else
		{
		document.getElementById("email").style.borderColor = "";     

		}  


		// validation for phone no


		/*if(center_address=="")
		{

		document.getElementById('center_address').style.border='1px solid #ff0000';
		document.getElementById("center_address").focus();
		$('#center_address').attr("placeholder", "Please enter center address");
		$("#center_address").addClass( "errors" );

		return false;
		}
		else
		{
		document.getElementById("center_address").style.borderColor = "";     

		}*/
		if(area=="")
		{

		document.getElementById('area').style.border='1px solid #ff0000';
		document.getElementById("area").focus();
		$('#area').attr("placeholder", "Please enter center's area.");
		$("#area").addClass( "errors" );

		return false;
		}
		else
		{
		document.getElementById("area").style.borderColor = "";     

		}
		if(block=="")
		{

		document.getElementById('block').style.border='1px solid #ff0000';
		document.getElementById("block").focus();
		$('#block').attr("placeholder", "Please enter center's block.");
		$("#block").addClass( "errors" );

		return false;
		}
		else
		{
		document.getElementById("block").style.borderColor = "";     

		}
		if(street=="")
		{

		document.getElementById('street').style.border='1px solid #ff0000';
		document.getElementById("street").focus();
		$('#street').attr("placeholder", "Please enter center's street.");
		$("#street").addClass( "errors" );

		return false;
		}
		else
		{
		document.getElementById("street").style.borderColor = "";     

		}
		if(building=="")
		{

		document.getElementById('building').style.border='1px solid #ff0000';
		document.getElementById("building").focus();building
		$('#building').attr("placeholder", "Please enter center's building number.");
		$("#building").addClass( "errors" );

		return false;
		}
		else
		{
		document.getElementById("building").style.borderColor = "";     

		}


		document.getElementById("wordCnt").style.color = "green";
		document.getElementById("wordCnt").innerHTML="Please wait..." ;


		var form = new FormData(); 
		form.append('userid', userid);  
		form.append('fname', fname);  
		form.append('lname', lname);
		form.append('phone', phone);
		form.append('email', email);
		form.append('area', area); 
		form.append('block', block); 
		form.append('street', street); 
		form.append('building', building); 
		form.append('office', office); 
		//form.append('center_address', center_address); 
		form.append('coverimage', coverimage); 

		$.ajax({    
		headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
		type: 'POST',
		url: "{{url('/vendor/update_profile')}}",
		data:form,
		contentType: false,
		processData: false,
		success:function(response) 
		{
		console.log(response); // return false;
		document.getElementById("wordCnt").innerHTML="" ; 
		$('#wordCnt').css('color','green')
		var status = response.status;       
		var msg = response.msg;       

		if(status=='200')
		{  
		$('#wordCnt').css('color','green')
		document.getElementById("wordCnt").innerHTML=msg;

		setTimeout(function() { location.reload(true) }, 3000);
		}
		else if(status=='401')
		{
		$('#wordCnt').css('color','red')
		document.getElementById("wordCnt").innerHTML=msg;
		}


		}

		});
		return false;

		}// end of function

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
 
	