

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
	<input type="text" id="name_of_meal" name="name_of_meal" value="{{$lr_meal_name}}" class="form-control">
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
</script>