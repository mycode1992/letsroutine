

@include('Vendor::include.header')
@include('Website::include.error')

@php
 if(isset($data) && count($data)>0)
 {
	 $updateid = $data[0]->lr_meal_id;
	 $lr_meal_name = $data[0]->lr_meal_name;
	 $lr_meal_calories = $data[0]->lr_meal_calories;
	 $lr_meal_fat = $data[0]->lr_meal_fat;
	 $lr_meal_carb = $data[0]->lr_meal_carb;
	 $lr_meal_protein = $data[0]->lr_meal_protein;
	 $lr_meal_description = $data[0]->lr_meal_description;
	 $lr_meal_image = $data[0]->lr_meal_image;
	 $butttext = 'Update';
	 $page_name = 'Edit Meal';
 }
 else
 {
	 $updateid = '';
	 $lr_meal_name = '';
	 $lr_meal_calories = '';
	 $lr_meal_fat = '';
	 $lr_meal_carb = '';
	 $lr_meal_protein = '';
	 $lr_meal_description = '';
	 $lr_meal_image = '';
	 $butttext = 'Add';
	 $page_name = 'Add Meal';
 }
@endphp

	<section class="myDashboard">
	<div class="container">
	<div class="row">
	@include('Vendor::include.sidebar')
	<div class="col-md-9">
	<div class="rightBox">
	<h3 class="formTitle">{{$page_name}}</h3>
	<form onsubmit="return save_meal()">
	<input type="hidden" name="updateid" id="updateid" value="{{$updateid}}">
	<div class="col-md-6">
	<div class="form-group">
	<label for="">Name of meal<span>*</span></label>
	<input type="text" id="name_of_meal"  name="name_of_meal" value="{{$lr_meal_name}}" class="form-control">
	</div>
	</div>

	<div class="col-md-3">
	<div class="form-group">
	<label for="">Calories</label>
	<input type="text" id="calories" name="calories" value="{{$lr_meal_calories}}" class="form-control">
	</div>
	</div>

	<div class="col-md-3">
	<div class="form-group">
	<label for="">Fat</label>
	<input type="text" id="fat" name="fat" value="{{$lr_meal_fat}}" class="form-control">
	</div>
	</div>

	<div class="col-md-3">
	<div class="form-group">
	<label for="">Carb</label>
	<input type="text" id="carb" name="carb" value="{{$lr_meal_carb}}" class="form-control">
	</div>
	</div>

	<div class="col-md-3">
	<div class="form-group">
	<label for="">Protien</label>
	<input type="text" id="protien" name="protien" value="{{$lr_meal_protein}}" class="form-control">
	</div>
	</div>

	<div class="col-md-12">
	<div class="form-group">
	<label for="">Description<span>*</span></label> 
	<textarea name="description" id="description" cols="10" rows="10" class="form-control"><?php echo $lr_meal_description; ?></textarea>
	</div>
	</div>

	<div class="col-md-12">
	<div class="form-group">
	<span class="error-msg" id="errorMsg"></span>
	<input type="hidden" id="image_name" name="image_name" value="">
	<input type="hidden" name="imagePath" id="imagePath" value="" >
	<span id="error17" style="color:red"></span>
	<div class="useredit-img" id="imgTest">
	<img src="{{url('/')}}/public/vendor/upload/meal_image/{{$lr_meal_image}}" alt="" class="img-responsive">
	</div>
	<label for="">Image<span>*</span></label> 
	<input type="file" id="meal_image" onchange="uploadimg()" name="meal_image">
	</div>
	</div>

	<div class="col-md-6">
	<div class="submitButton">
	<div class="form-group">
	<div id="wordCnt" style="color:red"></div>
	</div>
	<button type="submit" class="sbmtbtn">{{$butttext}}</button>
	</div>
	</div>

	<div class="col-md-6">
		<div class="submitButton">
		<button type="button" onclick="window.history.back()" class="sbmtbtn">Goback</button>
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
	function save_meal()
	{
		var updateid = document.getElementById("updateid").value.trim();
		var name_of_meal = document.getElementById("name_of_meal").value.trim();
		var calories = document.getElementById("calories").value.trim();
		var fat = document.getElementById("fat").value.trim();
		var carb = document.getElementById("carb").value.trim();
		var protien = document.getElementById("protien").value.trim();
		var description = document.getElementById("description").value.trim();
		var  meal_image = $('#meal_image')[0].files[0];

		if(name_of_meal=="")
		{
		document.getElementById('name_of_meal').style.border='1px solid #ff0000';
		document.getElementById("name_of_meal").focus();
		$('#name_of_meal').val('');
		$('#name_of_meal').attr("placeholder", "Please enter  name of meal");
		$("#name_of_meal").addClass( "errors" );
		return false;
		}
		else
		{
		document.getElementById("name_of_meal").style.border = "";   
		}

		if(description=="")
		{
		document.getElementById('description').style.border='1px solid #ff0000';
		document.getElementById("description").focus();
		$('#description').val('');
		$('#description').attr("placeholder", "Please enter description");
		$("#description").addClass( "errors" );
		return false;
		}
		else
		{
		document.getElementById("description").style.border = "";   
		}

		if(meal_image==null)
		{
		  alert("Add meal image"); return false;
		}
		
		

		document.getElementById("wordCnt").style.color = "#333333";
			document.getElementById("wordCnt").innerHTML="Please wait..." ;

		var form = new FormData();     
			form.append('name_of_meal',name_of_meal);
			form.append('calories',calories);
			form.append('fat',fat);
			form.append('carb',carb);
			form.append('protien',protien);
			form.append('description',description);
			form.append('updateid',updateid);
			form.append('meal_image',meal_image);

			$.ajax(
			{
			headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
			type: 'POST',
			url: "{{url('/vendor/save_meal')}}",
			data:form,
			contentType: false,
			processData: false,
			success:function(response) 
			{
            console.log(response);  //return false;
            document.getElementById("wordCnt").innerHTML="" ; 
            document.getElementById("wordCnt").style.color = "#ff0000"; 

            var status = response.status;       
            var msg = response.msg;                     

            if(status=='200')
            {	 	

            	document.getElementById("wordCnt").style.color = "green";
             	document.getElementById("wordCnt").innerHTML=msg;
                 setTimeout(function() { location.reload(true) }, 1000);
             }
             else if(status=='401')
             {

             	document.getElementById("wordCnt").style.color = "#ff0000";
             	document.getElementById("wordCnt").innerHTML=msg;
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
			var e = document.getElementById("meal_image"),
			t = e.value,
			n = $("#meal_image")[0].files[0].size / 1024;
			if (n > 2048) return document.getElementById("image_name").value = " ", document.getElementById("meal_image").value = "", document.getElementById("errorMsg").style.color = "#ff0000", document.getElementById("errorMsg").innerHTML = "Image size should be less than 2mb", !1;
			var m = document.getElementById("meal_image").value,
			m = m.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, "_");
			m = m.replace(/[^a-zA-Z0-9]/g, "_");
			var l = m.split("_"),
			d = t.substring(t.lastIndexOf(".") + 1).toLowerCase(),
			r = l[3] + "." + d;
			if ("png" != d && "jpeg" != d && "jpg" != d) return document.getElementById("image_name").value = "", document.getElementById("errorMsg").style.color = "#ff0000", document.getElementById("errorMsg").innerHTML = "Image only allows file types of PNG,JPG,JPEG", !1;
			if (document.getElementById("errorMsg").style.color = "", document.getElementById("errorMsg").innerHTML = "", filesSelected = document.getElementById("meal_image").files, filesSelected.length > 0) {
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