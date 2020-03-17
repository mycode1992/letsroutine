
	@include('Vendor::include.header')
	@include('Website::include.error')

	<section class="myDashboard">
	<div class="container">
	<div class="row">
	@include('Vendor::include.sidebar')
	<div class="col-md-9">
	<div class="rightBox">
	<h3 class="formTitle">Add Menu</h3>
	<form id="formData" onsubmit="return save_menu();" >
	<div class="col-md-12">
	<div class="form-group">
	<label for="">Menu name<span>*</span></label>
	<input type="text" name="menu_name" id="menu_name" placeholder="Enter menu name"  class="form-control">




	</div>
	</div>
	<div class="col-md-12">
	<div class="form-group">
	<label for="">Menu category (select all that applies) <span>*</span></label>
	<select name="menu_category" id="menu_category" onchange="showmeal_menu1(this.value)" data-placeholder="Select Menu" multiple class="form-control select2">
	@foreach($menu_list AS $val)
	<option value="{{$val->lr_category_id}}">{{$val->lr_category_name}}</option>
	@endforeach

	</select>
	</div>
	</div>
	<div id="meal_block">

	</div>
		
			@foreach($menu_list AS $val)
			<div id="{{$val->lr_category_id}}" class="fornone_lr fornone" style="display:none" >
			<div class="col-md-6">
				<div class="form-group">
					<label for="">{{$val->lr_category_name}} (select all that applies)<span>*</span></label>
					<select name="mealname[{{$val->lr_category_id}}][]" id="mealname_{{$val->lr_category_id}}" data-placeholder="Select Meal" multiple class="form-control select2">
						@foreach($meal_list as $value)
							<option value="{{$value->lr_meal_id}}">{{$value->lr_meal_name}}</option>
							@endforeach
					</select>
			</div>
		</div>
		<div class="col-md-6">
			OR <br>
				<div class="addBtn">
						<a href="javascript:void(0)" onclick="return openmealmodal({{$val->lr_category_id}})" ><i class="fa fa-plus"></i> Add new meal</a>
					</div>
		</div>
	
			</div>
			@endforeach
				

	<div class="col-md-6">
	<div class="submitButton">
	<div id="wordCnt" style="color:red"></div>
	<button type="submit" class="sbmtbtn">Submit</button>
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

	<div id="myModal" class="modal fade readmore-modal-area" role="dialog">
			<div class="modal-dialog">
		
			<!-- Modal content-->
			<div class="modal-content">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
		
			</div>
			<div class="modal-body">
			<div class="report-problem-modal">
			<h3 class="formTitle">Add Meal</h3>
			<div class="add-problem-form">
			<form onsubmit="return save_meal()">
				<input type="hidden" name="modal_mealid" id="modal_mealid" >
			<div class="col-md-12">
			<div class="form-group">
			<label for="">Name of meal<span>*</span></label>
			<input type="text" id="name_of_meal" name="name_of_meal" class="form-control">
			</div>
			</div>
			<div class="col-md-12">
			<div class="form-group">
			<label for="">Calories</label>
			<input type="text" id="calories" name="calories" class="form-control">
			</div>
			</div>
		
			<div class="col-md-12">
			<div class="form-group">
			<label for="">Fat</label>
			<input type="text" id="fat" name="fat" class="form-control">
			</div>
			</div>

			<div class="col-md-12">
			<div class="form-group">
			<label for="">Carb</label>
			<input type="text" id="carb" name="carb" class="form-control">
			</div>
			</div>

			<div class="col-md-12">
			<div class="form-group">
			<label for="">Protien</label>
			<input type="text" id="protien" name="protien" class="form-control">
			</div>
			</div>


			<div class="col-md-12">
			<div class="form-group">
			<label for="">Description<span>*</span></label> 
			<textarea name="description" id="description" cols="5" rows="5" class="form-control"></textarea>
			</div>
			</div>
		
			<div class="col-md-6">
			<div class="submitButton">
			<div class="form-group">
			<div id="wordCnt1" style="color:red"></div>
			</div>
			<button type="submit" class="sbmtbtn">Submit</button>
			</div>
			</div>
		
			<div class="clearfix"></div>
			</form>
		
			</div>
			</div>
		
			</div>
		
			</div>
		
			</div>
			</div>


	@include('Vendor::include.footer')

	<script>
		function showmeal_menu1(id)
		{

		$(".fornone").css("display","none")
	$('#menu_category :selected').each(function(i, selected) {
	var dataid = $(selected).val();
	$("#"+dataid).css("display","block");
	}); 
		}
		</script>
	<script>
	function showmeal_menu()
	{
	var menu_list = [];
	$('#menu_category :selected').each(function(i, selected) {
	menu_list[i] = $(selected).val();
	}); 

	var form = new FormData(); 
	form.append('menu_list', menu_list); 

	$.ajax({    
	headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
	type: 'POST',
	url: "{{url('/vendor/showmeal_menu')}}",
	data:form,
	contentType: false,
	processData: false,
	success:function(response) 
	{
	// console.log(response); // return false;
	var status = response.status;
	if(status=='200')
	{   
	var menu_list_name = response.menu_list_name; 
	var menu_list_id = response.menu_list_id; 
	var meal_list = response.meal_list; 

	var count_menu_detail = Object.keys(menu_list_name).length; 
	var count_meal_list = Object.keys(meal_list).length; 

	var string = '';
	for(var j=0; j < count_meal_list; j++){
	string += '<option value="'+meal_list[j].lr_meal_id+'">'+meal_list[j].lr_meal_name+'</option>';
	}

	var path = '{{url('/')}}/vendor/add-meal';

	$('#meal_block').html('');

	for(var i=0; i<count_menu_detail; i++)
	{
	$('#meal_block').append('<div class="col-md-6"><div class="form-group"><label for="">'+menu_list_name[i]+'<span>*</span></label><select name="mealname['+menu_list_id[i]+'][]" id="mealname_'+menu_list_id[i]+'" data-placeholder="Select Meal" multiple class="form-control select2">'+string+'</select></div></div><div class="col-md-6"><div class="orFlex"><div>Or</div><div class="addBtn"><a href="javascript:void(0)" onclick="return openmealmodal('+menu_list_id[i]+')" ><i class="fa fa-plus"></i> Add new meal</a></div></div></div>');

	$('.select2').select2();
	$(document).ready(function() {
	$('#example1').DataTable({
	"language": {
	"lengthMenu": '<div> <select class="troopets_selectbox">'+
	'<option value="10">10</option>'+
	'<option value="20">20</option>'+
	'<option value="30">30</option>'+
	'<option value="40">40</option>'+
	'<option value="50">50</option>'+
	'<option value="60">60</option>'+

	'<option value="-1">All</option>'+
	'</select> <span class="record">Records Per Page </span></div>'
	}
	});
	soTable = $('#example1').DataTable();
	$('#srch-term').keyup(function(){
	soTable.search($(this).val()).draw() ;
	});

	$('.something').click( function () {
	var ddval = $('.something option:selected').val();
	console.log(ddval);
	var oSettings = oTable.fnSettings();
	oSettings._iDisplayLength = ddval;
	oTable.fnDraw();
	});
	oTable = $('#example1').dataTable();
	} );
	}
	}
	else
	{
	$('#meal_block').html('');
	}
	}
	});
	return false;
	}

	function save_menu()   
	{
	var menu_name = document.getElementById("menu_name").value.trim();
	var menu_category = document.getElementById("menu_category").value.trim();
	if(menu_name=="")
	{
	document.getElementById('menu_name').style.border='1px solid #ff0000';
	document.getElementById("menu_name").focus();
	$('#menu_name').val('');
	$('#menu_name').attr("placeholder", "Please enter menu name");
	$("#menu_name").addClass( "errors" );
	return false;
	}
	else
	{
	document.getElementById("menu_name").style.border = "";   
	}

	if(menu_category=="")
	{
	document.getElementById('menu_category').style.border='1px solid #ff0000';
	document.getElementById("menu_category").focus();
	$("#menu_category").addClass( "error" );
	return false;
	}
	else
	{
	document.getElementById("menu_category").style.border = "";   
	}

	$.ajax({    
	headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
	type: 'POST',
	url: "{{url('/vendor/save_menu')}}",
	data : $("#formData").serialize(),
	success:function(response) 
	{
	console.log(response); // return false;
	document.getElementById("wordCnt").innerHTML="" ; 
	$('#wordCnt').css('color','green')
	var status = response.status;
	if(status=='200')
	{  
	document.getElementById("wordCnt").style.color = "green";
	document.getElementById("wordCnt").innerHTML=response.msg;
	setTimeout(function() { location.reload(true) }, 1000);
	}
	else if(status=='401')
	{
	document.getElementById("wordCnt").style.color = "#ff0000";
	document.getElementById("wordCnt").innerHTML=response.msg;
	}
	}
	});
	return false;


	}

	function openmealmodal(id)
	{
		$('#modal_mealid').val(id);
		$('#myModal').modal('show');
	}

	function save_meal()
	{          
		var updateid = '';
		var modal_mealid = document.getElementById("modal_mealid").value.trim();
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
		document.getElementById("wordCnt1").style.color = "#333333";
			document.getElementById("wordCnt1").innerHTML="Please wait..." ;
		
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
			url: "{{url('/vendor/save_meal_menu')}}",
			data:form,
			contentType: false,
			processData: false,
			success:function(response) 
			{
            console.log(response);  //return false;   
            document.getElementById("wordCnt1").innerHTML="" ; 
            document.getElementById("wordCnt1").style.color = "#ff0000"; 

            var status = response.status;       
            var msg = response.msg;                     

            if(status=='200')
            {
			document.getElementById("wordCnt1").style.color = "green";
			document.getElementById("wordCnt1").innerHTML=msg;
			 $('#mealname_'+modal_mealid)
			.append($("<option></option>")
			.attr("value",response.last_insert_id)
			.text(response.meal_name));
			 $("#myModal").modal('hide');
			 $('#name_of_meal,#calories,#fat,#carb,#protien,#description').val('');
			 $('#wordCnt1').text('');
             }
             else if(status=='401')
             {

             	document.getElementById("wordCnt1").style.color = "#ff0000";
             	document.getElementById("wordCnt1").innerHTML=msg;
             }

         }
			});

		return false;
		
	}

	</script>