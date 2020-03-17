
	@include('Vendor::include.header')
	@include('Website::include.error')

	<section class="myDashboard">
	<div class="container">
	<div class="row">
	@include('Vendor::include.sidebar')
	<div class="col-md-9">
	<div class="rightBox">
	<div class="headFlex">
	<h3 class="formTitle">Meal List</h3>
	{{-- <div class="addBtn">
	<a href="{{url('/vendor/add-meal')}}"><i class="fa fa-plus"></i> Add meal</a>
	</div> --}}

	<div class="addBtn">
			<a href="javascript:addrow()"><i class="fa fa-plus"></i> Add meal</a>
	</div>

	</div>


	<div class="current-order-table">

	<div class="table-responsive">          
	<table class="table">
	<thead>
	<tr>
	<th>S.No</th>
	<th>Meal name</th>
	<th>Description</th>
	<th>Calories</th>
	<th>Fat</th>
	<th>Carb</th>
	<th>Protien</th>
	<th>Action</th>

	</tr>
	</thead>
	<tbody id="addnewrow">
	@php $sn = 0;  @endphp
	@foreach($data AS $data_val)
	@php $sn++;  @endphp
	<tr class="even-row" id="editrow_{{$data_val->lr_meal_id}}" >
	<td>{{$sn}}.</td>
	<td>{{$data_val->lr_meal_name}}</td>
	<td  class="meal-description">
	<span>
	 <?php $string = $data_val->lr_meal_description;
	if (strlen($string) > 100) {
	 $stringCut = substr($string, 0, 100);
	 $endPoint = strrpos($stringCut, ' ');
 
	 //if the string doesn't contain any space then it will cut without word basis.
	 $string = $endPoint? substr($stringCut, 0, $endPoint):substr($stringCut, 0);
	 $string .= '... <a href="JavaScript:void(0)" onclick="return readmore('.$data_val->lr_meal_id.')">Read More</a>';
 	}
 	echo $string; 
 ?>
	</span>
	</td>
	<td>{{$data_val->lr_meal_calories}}</td>
	<td>{{$data_val->lr_meal_fat}}</td>
	<td>{{$data_val->lr_meal_carb}}</td>
	<td>{{$data_val->lr_meal_protein}}</td>
	<td>
	<div class="editDeleteBtns">
	{{-- <a href="{{url('/vendor/edit-meal')}}/{{$data_val->lr_meal_id}}">
	<img src="{{url('/')}}/public/website/img/edit_1.png" alt="">
	</a> --}}
	<a href="javascript:edit_meal({{$data_val->lr_meal_id}},{{$sn}})">
		<img src="{{url('/')}}/public/website/img/edit_1.png" alt="">
		</a>
	<a href="javascript:void(0);" onclick=" return deletebtnrow({{$data_val->lr_meal_id}})" >
	<img src="{{url('/')}}/public/website/img/delete.png" alt="">
	</a>
	</div>
	</td>

	</tr>
	@endforeach
	</tbody>
	</table>
	</div>	
	</div>

	</div>
	</div>
	</div>
	</div>
	</section>


	<!-- Modal -->
	<div id="readmore_modal" class="modal fade readmore-modal-area" role="dialog">
	<div class="modal-dialog">

	<!-- Modal content-->
	<div class="modal-content">
	<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>

	</div>
	<div class="modal-body">
	<div class="report-problem-modal" id="readmoremsg">
	</div>

	</div>

	</div>

	</div>
	</div>

	<input type="hidden" id="rowidd" value="" name="rowidd" />
	<div id="deletebtn" class="modal fade readmore-modal-area" role="dialog">
	<div class="modal-dialog">
	<div class="modal-content">
	<div class="modal-header">
			
	<button type="button" class="close" data-dismiss="modal">&times;</button>

	</div>
	<div class="modal-body">
		<div class="letsroutine-delete-modal-area">
			<h4 class="modal-title">Are you sure you want to delete ?</h4>
			<div class="delete-cancel-btn-area">
				<button type="button" class="btn btn-danger btn-sx delete-btn" onclick=" return deleterow()" >Delete</button>&nbsp;&nbsp;&nbsp;&nbsp;
				<button type="button" id="cancelbutton" class="btn btn-success btn-sx cancel-btn" data-dismiss="modal">Cancel</button>
			</div>
		</div>	
	</div>

	</div>

	</div>

	</div>
	</div>

	@include('Vendor::include.footer')

	<script>
		function readmore(id)
		{
		
		var tblname='tbl_lr_meal';
		var colnamewhere = 'lr_meal_id';
		var colmsg = 'lr_meal_description';

		$.ajax({
		headers:{'X-CSRF-Token' : '{{ csrf_token() }}'},
		method: "POST",
		url:"{{url('/vendor/readmore')}}",
		data: { id:id, colnamewhere:colnamewhere,tblname:tblname,colmsg:colmsg}

		})
			.done(function( response ) {
		// console.log(response);
		console.log(response); 
		
		document.getElementById("readmoremsg").innerHTML = response;
			$('#readmore_modal').modal('show');

		});
		
		}

		function deletebtnrow(rowid)
        {
            $("#rowidd").val(rowid);
            $("#deletebtn").modal("show");
        }

        function deleterow()
        {
            var rowidd =$("#rowidd").val();
            var tblname = 'tbl_lr_meal';
            var colwhere = 'lr_meal_id';
            var statuscol = 'admin_status';
            $.ajax({
            headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
            method: "POST",
            url: "{{url('/deleterowstatus')}}",
            data: { id: rowidd,tblname: tblname,colwhere: colwhere,statuscol:statuscol}
            
            })
            .done(function( response ) {
              setTimeout(function() { location. reload(true); }, 1000);
            });
            return false;
        }

		function addrow()
		{
			var add = 0;
			var appendvar = '<tr class="even-row"><td><input type="text" /></td><td><input type="text" id="name_of_meal" /></td><td class="meal-description"><input type="text" id="description" /></td><td><input type="text" id="calories" /></td><td><input type="text" id="fat" /></td><td><input type="text" id="carb" /></td><td><input type="text" id="protien" /></td><td><input type="button" id="submit_meal" onclick="return save_meal('+add+')" value="submit" /></td></tr>';

			$('#addnewrow').append(appendvar);
		}

		function edit_meal(id,count)
		{
			
			var form = new FormData();     
			form.append('id',id);

			$.ajax(
			{
			headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
			type: 'POST',
			url: "{{url('/vendor/get_meal_data')}}",
			data:form,
			contentType: false,
			processData: false,
			success:function(response) 
			{
            console.log(response);  // return false;
            var status = response.status;       
            var result = response.msg;
            if(status=='200')
            {
				var update = result[0].lr_meal_id;
				var appendvar = '<tr class="even-row"><td>'+count+'</td><td><input type="text" id="name_of_meal" value="'+result[0].lr_meal_name+'" /></td><td class="meal-description"><input type="text" id="description" value="'+result[0].lr_meal_description+'" /></td><td><input type="text" id="calories" value="'+result[0].lr_meal_calories+'" /></td><td><input type="text" id="fat" value="'+result[0].lr_meal_fat+'" /></td><td><input type="text" id="carb" value="'+result[0].lr_meal_carb+'" /></td><td><input type="text" id="protien" value="'+result[0].lr_meal_protein+'" /></td><td><input type="button" id="submit_meal" onclick="return save_meal('+update+')" value="update" /></td></tr>';

				$('#editrow_'+id).replaceWith(appendvar);
             }
             else if(status=='401')
             {
				document.getElementById("readmoremsg").innerHTML = msg;
			    $('#readmore_modal').modal('show');
             }

         }
			});

			
		}

		function save_meal(values)
	{
		var updateid = '';
		if(values!=0)
		{
          updateid = values;
		}
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
		
			document.getElementById("submit_meal").innerHTML="Submitting..." ;

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
            document.getElementById("submit_meal").innerHTML="Submit" ; 
           

            var status = response.status;       
            var msg = response.msg;                     

            if(status=='200')
            {	 	

            	document.getElementById("readmoremsg").innerHTML = msg;
			    $('#readmore_modal').modal('show');
                 setTimeout(function() { location.reload(true) }, 1000);
             }
             else if(status=='401')
             {
             	document.getElementById("readmoremsg").innerHTML = msg;
			    $('#readmore_modal').modal('show');
             }

         }
			});

		return false;
		
	}

	</script>

<style type="text/css">
	
</style>
