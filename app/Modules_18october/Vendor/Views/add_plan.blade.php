
	@include('Vendor::include.header')
	@include('Website::include.error')

	<section class="myDashboard">
	<div class="container">
	<div class="row">
	@include('Vendor::include.sidebar')
	@php
	if(isset($data) && count($data)>0)
	{
	$updateid = $data[0]->vendor_plan_id;
	$vendor_plan_name = $data[0]->vendor_plan_name;
	$vendor_plan_meals = $data[0]->vendor_plan_meals;
	$vendor_plan_snacks = $data[0]->vendor_plan_snacks;
	$vendor_plan_macros = $data[0]->vendor_plan_macros;
	$macros_yes_min_carb = $data[0]->macros_yes_min_carb;
	$macros_yes_max_carb = $data[0]->macros_yes_max_carb;
	$macros_yes_min_protein = $data[0]->macros_yes_min_protein;
	$macros_yes_max_protein = $data[0]->macros_yes_max_protein;
	$macros_yes_plan = $data[0]->macros_yes_plan;
	$macros_no_max_carb = $data[0]->macros_no_max_carb;
	$macros_no_max_protein = $data[0]->macros_no_max_protein;
	$vendor_plan_gendor = $data[0]->vendor_plan_gendor;
	$vendor_plan_pause = $data[0]->vendor_plan_pause;
	$lr_plancategory_id = $data[0]->lr_plancategory_id;
	$lr_plan_subcat_id = $data[0]->lr_plan_subcat_id;
	$vendor_plan_duration = $data[0]->vendor_plan_duration;
	$vendor_plan_offdays = $data[0]->vendor_plan_offdays;
	$vendor_plan_menu_type = $data[0]->vendor_plan_menu_type;   
	$custom_menu_vendor_menu_id = $data[0]->custom_menu_vendor_menu_id; 
	$vendor_plan_type = $data[0]->vendor_plan_type; 
	$plantype_weekly = $data[0]->plantype_weekly; 
	$plantype_weekly_packagefeature = $data[0]->plantype_weekly_packagefeature; 
	$cost_plan_package_feature = $data[0]->cost_plan_package_feature; 
	$plan_cost = $data[0]->plan_cost; 

	$butttext = 'Update';
	$page_name = 'Edit Plan';
	}
	else
	{
	$updateid = '';
	$vendor_plan_name ='';
	$vendor_plan_meals = '';
	$vendor_plan_snacks = '';
	$vendor_plan_macros = '';
	$macros_yes_min_carb = '';
	$macros_yes_max_carb = '';
	$macros_yes_min_protein = '';
	$macros_yes_max_protein = '';
	$macros_yes_plan = '';
	$macros_no_max_carb = '';
	$macros_no_max_protein = '';
	$vendor_plan_gendor = '';
	$vendor_plan_pause = '';
	$lr_plancategory_id = '';
	$lr_plan_subcat_id = '';
	$vendor_plan_duration = '';
	$vendor_plan_offdays = '';
	$vendor_plan_menu_type = '';  
	$custom_menu_vendor_menu_id = '';
	$vendor_plan_type = '';
	$plantype_weekly = '';
	$plantype_weekly_packagefeature = '';
	$cost_plan_package_feature = '';
	$plan_cost = '';
		$butttext = 'Add';
		$page_name = 'Add Plan';
	}
   @endphp
	

	<div class="col-md-9">
	<div class="rightBox">
	<h3 class="formTitle">{{$page_name}}</h3>
	<form onsubmit="return save_plan()">
	<input type="hidden" name="updateid" id="updateid" value="{{$updateid}}" >
	<div class="col-md-6">
	<div class="form-group">
	<label for="">What is the plan name?<span>*</span></label>
	<input type="text" placeholder="Enter plan name" id="plan_name" value="{{$vendor_plan_name}}" name="plan_name" class="form-control">
	</div>
	</div>
	<div class="clearfix"></div>
	<div class="col-md-6">
	<div class="form-group">
	<label for="">No. of meals</label>
	<input type="text" id="meal_count" maxlength="1" oninput="this.value=this.value.replace(/[^0-9]/g,'');" name="meal_count" value="{{$vendor_plan_meals}}" class="form-control">
	</div>
	</div>
	<div class="col-md-6">
	<div class="form-group">
	<label for="">No. of snacks</label>
	<input type="text" id="snack_count" maxlength="1" oninput="this.value=this.value.replace(/[^0-9]/g,'');" name="snack_count" value="{{$vendor_plan_snacks}}" class="form-control">
	</div>
	</div>
	<div class="col-md-6">
	<div class="form-group">
	<label for="">3. Will the users be able to manually input their macros (Carb, Protein) intake? <span>*</span></label>
	<select name="macros-carb-pro" id="macros-carb-pro" onchange="return macros()" class="form-control">
	<option value="-1" >Please Select</option>
	<option value="YES" <?php if($vendor_plan_macros=='YES'){echo 'selected';} ?>>Yes</option>
	<option value="NO" <?php if($vendor_plan_macros=='NO'){echo 'selected';} ?> >No</option>
	</select>
	</div>
	</div>


	<div class="clearfix"></div>
	<div style="display:none" id="macros-yes">
	<div class="col-md-6">
	<div class="form-group">
	<label for="">Min carb <span>*</span></label>
	<input type="text" id="min_carb_macros_yes" maxlength="2" oninput="this.value=this.value.replace(/[^0-9]/g,'');" value="{{$macros_yes_min_carb}}" name="min_carb_macros_yes" class="form-control">
	</div>
	</div>
	<div class="col-md-6">
	<div class="form-group">
	<label for="">Max carb <span>*</span></label>
	<input type="text" id="max_carb_macros_yes" maxlength="2" oninput="this.value=this.value.replace(/[^0-9]/g,'');" value="{{$macros_yes_max_carb}}" name="max_carb_macros_yes" class="form-control">
	</div>
	</div>
	<div class="col-md-6">
	<div class="form-group">
	<label for="">Min protein <span>*</span></label>
	<input type="text" id="min_protien_macros_yes" maxlength="2" oninput="this.value=this.value.replace(/[^0-9]/g,'');" value="{{$macros_yes_min_protein}}" name="min_protien_macros_yes" class="form-control">
	</div>
	</div>
	<div class="col-md-6">
	<div class="form-group">
	<label for="">Max protein <span>*</span></label>
	<input type="text" id="max_protien_macros_yes" maxlength="2" oninput="this.value=this.value.replace(/[^0-9]/g,'');" value="{{$macros_yes_max_protein}}" name="max_protien_macros_yes" class="form-control">
	</div>
	</div>
	<div class="col-md-6">
	<div class="form-group">
	<label for="">Will the users be able to manually input their macros intake per meal, per day or once for the whole plan period?<span>*</span></label>
	<select id="macros_yes_plan" name="macros_yes_plan" class="form-control">
	<option value="-1" >Please Select</option>
	<option value="PERMEAL" <?php if($macros_yes_plan=='PERMEAL'){echo 'selected';} ?> >Per meal</option>
	<option value="WHOLEPLANPERIOD" <?php if($macros_yes_plan=='WHOLEPLANPERIOD'){echo 'selected';} ?> >Once for the whole plan period</option>
	</select>
	</div>
	</div>
	</div>
	<div style="display:none" id="macros-no">
	<div class="col-md-6">
	<div class="form-group">
	<label for="">Max carb (For diet centers who provides fixed macros plans only)</label>
	<input type="text" id="max_carb_macros_no" maxlength="2" oninput="this.value=this.value.replace(/[^0-9]/g,'');" name="max_carb_macros_no" value="{{$macros_no_max_carb}}"  class="form-control">
	</div>
	</div>
	<div class="col-md-6">
	<div class="form-group">
	<label for="">Max protein (For diet centers who provides fixed macros plans only)</label>
	<input type="text" id="max_protein_macros_no" maxlength="2" oninput="this.value=this.value.replace(/[^0-9]/g,'');" value="{{$macros_no_max_protein}}" name="max_protein_macros_no" class="form-control">
	</div>
	</div>
	</div>
	<div class="col-md-6">
	<div class="form-group">
	<label for="">Which gender does the plan serve? </label>
	<select id="gender" name="gender" class="form-control">
	<option value="-1" >Please Select</option>
	<option value="MALE" <?php if($vendor_plan_gendor=='MALE'){echo 'selected';} ?>>Male</option>
	<option value="FEMALE" <?php if($vendor_plan_gendor=='FEMALE'){echo 'selected';} ?>>Female</option>
	<option value="BOTH"  <?php if($vendor_plan_gendor=='BOTH'){echo 'selected';} ?>>Both</option>
	</select>
	</div>
	</div>
	<div class="col-md-12">
	<div class="form-group">
	<label for="">What is the maximum number of days users can pause their plan? <span>*</span></label>
	<select id="user_plan_pause" name="user_plan_pause" class="form-control">
	<option value="-1">Please Select</option>
	<option value="none" <?php if($vendor_plan_pause=='none'){echo 'selected';} ?>>None</option>
	<option value="1" <?php if($vendor_plan_pause=='1'){echo 'selected';} ?>>1</option>
	<option value="2" <?php if($vendor_plan_pause=='2'){echo 'selected';} ?>>2</option>
	<option value="3" <?php if($vendor_plan_pause=='3'){echo 'selected';} ?>>3</option>
	<option value="4" <?php if($vendor_plan_pause=='4'){echo 'selected';} ?>>4</option>
	<option value="5" <?php if($vendor_plan_pause=='5'){echo 'selected';} ?>>5</option>
	<option value="6" <?php if($vendor_plan_pause=='6'){echo 'selected';} ?>>6</option>
	<option value="7" <?php if($vendor_plan_pause=='7'){echo 'selected';} ?>>7</option>
	<option value="8" <?php if($vendor_plan_pause=='8'){echo 'selected';} ?>>8</option>
	<option value="9" <?php if($vendor_plan_pause=='9'){echo 'selected';} ?>>9</option>
	<option value="10" <?php if($vendor_plan_pause=='10'){echo 'selected';} ?>>10</option>
	<option value="11" <?php if($vendor_plan_pause=='11'){echo 'selected';} ?>>11</option>
	<option value="12" <?php if($vendor_plan_pause=='12'){echo 'selected';} ?>>12</option>
	<option value="13" <?php if($vendor_plan_pause=='13'){echo 'selected';} ?>>13</option>
	<option value="14" <?php if($vendor_plan_pause=='14'){echo 'selected';} ?>>14</option>
	<option value="15" <?php if($vendor_plan_pause=='15'){echo 'selected';} ?>>15</option>
	<option value="16" <?php if($vendor_plan_pause=='16'){echo 'selected';} ?>>16</option>
	<option value="17" <?php if($vendor_plan_pause=='17'){echo 'selected';} ?>>17</option>
	<option value="18" <?php if($vendor_plan_pause=='18'){echo 'selected';} ?>>18</option>
	<option value="19" <?php if($vendor_plan_pause=='19'){echo 'selected';} ?>>19</option>
	<option value="20" <?php if($vendor_plan_pause=='20'){echo 'selected';} ?>>20</option>
	<option value="21" <?php if($vendor_plan_pause=='21'){echo 'selected';} ?>>21</option>
	<option value="22" <?php if($vendor_plan_pause=='22'){echo 'selected';} ?>>22</option>
	<option value="23" <?php if($vendor_plan_pause=='23'){echo 'selected';} ?>>23</option>
	<option value="24" <?php if($vendor_plan_pause=='24'){echo 'selected';} ?>>24</option>
	<option value="25" <?php if($vendor_plan_pause=='25'){echo 'selected';} ?>>25</option>
	<option value="26" <?php if($vendor_plan_pause=='26'){echo 'selected';} ?>>26</option>
	<option value="27" <?php if($vendor_plan_pause=='27'){echo 'selected';} ?>>27</option>
	<option value="28" <?php if($vendor_plan_pause=='28'){echo 'selected';} ?>>28</option>
	<option value="29" <?php if($vendor_plan_pause=='29'){echo 'selected';} ?>>29</option>
	<option value="30" <?php if($vendor_plan_pause=='30'){echo 'selected';} ?>>30</option>
	<option value="unlimited" <?php if($vendor_plan_pause=='unlimited'){echo 'selected';} ?>>unlimited</option>
	</select>
	</div>
	</div>
	<div class="col-md-12">
	<div class="form-group">
	<label for="">Which of the following categories does the plan fall under? <span>*</span></label>
	<select id="plan-category" name="plan-category" onchange="return change_sub_cat()" class="form-control">
	<option value="-1">Please Select</option>
	@foreach($category_plan AS $cat_val)
	<option value="{{$cat_val->lr_plancategory_id}}" <?php if($lr_plancategory_id==$cat_val->lr_plancategory_id){echo 'selected';} ?>>{{$cat_val->lr_plancategory_name}}</option>
	@endforeach
	</select>
	</div>
	</div>

	<div class="col-md-12">
	<div class="form-group">
	<label for="">Which of the following subcategory does the plan fall under? <span>*</span></label>
	<select id="plan-sub-category" name="plan-sub-category" class="form-control">
	<option  value="-1">Please Select</option>
	
	</select>
	</div>
	</div>

	<div class="col-md-12">
	<div class="form-group">
	<label for="">What is the plan type?<span>*</span></label>
	<select name="plan_type" onchange="return changeplan()" id="plan_type" class="form-control">
	<option value="-1" >Please Select</option>
	<option value="MONTHLY" <?php if($vendor_plan_type=='MONTHLY'){echo 'selected';}?> >Monthly</option>
	<option value="WEEKLY" <?php if($vendor_plan_type=='WEEKLY'){echo 'selected';}?>>Weekly</option>
	</select>
	</div>
	</div>

	<div class="col-md-12" id="plan_type_weekly_block" style="display:none">
	<div class="form-group">
	<select name="plan_type_week" onchange="return changeplan_type_week()"  id="plan_type_week" class="form-control">
	<option value="-1" >Please select</option>
	<option value="ONEWEEK" <?php if($plantype_weekly=='ONEWEEK'){echo 'selected';} ?> >One week</option>
	<option value="TWOWEEK" <?php if($plantype_weekly=='TWOWEEK'){echo 'selected';} ?>>Two weeks</option>
	<option value="THREEWEEK" <?php if($plantype_weekly=='THREEWEEK'){echo 'selected';} ?>>Three weeks</option>
	</select>
	</div>
	</div>
 
  
	<div class="col-md-12" id="one_two_week_block" style="display:none">
	<div class="form-group">
	<label for="">Routine is providing a package feature which combines multiple diet centers plans under one package, are you interested in including the current plan under both the packages feature and weekly plans feature ?<span>*</span></label>
	<select name="package_feature" id="package_feature" onchange="return changepackagefeature()" class="form-control">
	<option value="-1" >Please select</option>
	@foreach($package_feature AS $package_val)
	<option value="{{$package_val->id}}" <?php if($plantype_weekly_packagefeature==$package_val->id){echo 'selected';} ?> >{{$package_val->name}}</option>
	@endforeach

	
	</select>
	</div>
	</div>

	<div class="col-md-6" id="two_three_week_block" style="display:none">
	<div class="form-group">
	<label for="">For the packages feature only, What is the cost of the plan per week? <span>*</span></label>
	<input type="text" id="cost_plan_package_feature" value="{{$cost_plan_package_feature}}" name="cost_plan_package_feature" class="form-control">
	</div>
	</div>

	 <div class="col-md-6">
	<div class="form-group">
	<label for="">What is the plan duration in terms of days (excluding the off days) ? <span>*</span></label>
	<input type="text" id="plan-duration" name="plan-duration" value="{{$vendor_plan_duration}}" placeholder="Number of days" class="form-control">
	</div>
	</div> 

	<div class="col-md-12">
	<div class="form-group">
	<label for="">What are the off days for the current plan ? <span>*</span></label>
	<select id="off_days" name="off_days" class="form-control">
	<option value="-1" >Please Select</option>
	<option value="NONE" <?php if($vendor_plan_offdays=='NONE'){echo 'selected';} ?> >None</option>
	<option value="WEEKEND" <?php if($vendor_plan_offdays=='WEEKEND'){echo 'selected';} ?> >Weekend</option>
	<option value="SUNDAY" <?php if($vendor_plan_offdays=='SUNDAY'){echo 'selected';} ?> >Sunday</option>
	<option value="MONDAY" <?php if($vendor_plan_offdays=='MONDAY'){echo 'selected';} ?> >Monday</option>
	<option value="TUESDAY" <?php if($vendor_plan_offdays=='TUESDAY'){echo 'selected';} ?>>Tuesday</option>
	<option value="WEDNESDAY" <?php if($vendor_plan_offdays=='WEDNESDAY'){echo 'selected';} ?>>Wednesday</option>
	<option value="THURSDAY" <?php if($vendor_plan_offdays=='THURSDAY'){echo 'selected';} ?>>Thursday</option>
	<option value="FRIDAY" <?php if($vendor_plan_offdays=='FRIDAY'){echo 'selected';} ?>>Friday</option>
	<option value="SATURDAY" <?php if($vendor_plan_offdays=='SATURDAY'){echo 'selected';} ?>>Saturday</option>
	</select>
	</div>
	</div>
	<div class="col-md-6" id="cost_plan_block">
	<label for="">What is the cost of the plan (Excluding Packages Feature) ? <span>*</span></label>
	<div class="form-group">
	<input type="text" id="cost_plan" name="cost_plan" value="{{$plan_cost}}" class="form-control">
	</div>
	</div>

	<div class="col-md-12">
	<div class="form-group">
	<label for="">Does the plan follow a custom menu where users can choose from or a fixed menu? <span>*</span></label>
	<select id="custom_fixed_menu" name="custom_fixed_menu" class="form-control">
	<option value="-1" >Please select</option>
	<option value="FIXEDMENU" <?php if($vendor_plan_menu_type=='FIXEDMENU'){echo 'selected';} ?>>Fixed menu</option>
	<option value="CUSTOMMENU" <?php if($vendor_plan_menu_type=='CUSTOMMENU'){echo 'selected';} ?> >Custom menu</option>
	</select>
	</div>
	</div>

	<!-- <div class="col-md-12" id="custom_menu_block" style="display:none">
	<div class="form-group">
	<label for="">Select the menu that represents the current plan? <span>*</span></label>
	<select name="custom_menu_list" id="custom_menu_list" onclick="openaddmenumodal(this.value)" class="form-control">
	<option value="-1" >Please Select</option>
	<?php //if(!empty($menu_list)){ ?>
	@foreach($menu_list AS $menu_val)
	<option value="{{$menu_val->vendor_menu_id}}" <?php //if($custom_menu_vendor_menu_id==$menu_val->vendor_menu_id){echo 'selected';} ?> >{{$menu_val->vendor_menu_name}}</option>
	@endforeach	
	<option value="NEWMENU" >Create a new menu</option>
	<?php //}else{?>
	<option value="NEWMENU" >Create a new menu</option>
	<?php //} ?>
	</select>
	</div>
	</div> -->
	




	<div class="col-md-6">
	<div class="submitButton">
	<div id="wordCnt" style="color:red"></div>
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


<!--add custom menu modal start-->
{{-- <div id="mymenuModal" class="modal fade readmore-modal-area" role="dialog">
			<div class="modal-dialog">
		
			<!-- Modal content-->
			<div class="modal-content">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
		
			</div>
			<div class="modal-body">
			<div class="report-problem-modal">
			<h3 class="formTitle">Add Menu </h3>
			<div class="add-problem-form">
			<form id="GetValue" onsubmit="return save_meal()">
				<input type="hidden" name="modal_mealid" id="modal_mealid" >
			<div class="col-md-12">
				<div class="form-group">
					<label for="">Menu name<span>*</span></label>
					<input type="text" name="menu_name" id="menu_name" placeholder="Enter menu name"  class="form-control">
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label for="">Menu category<span>*</span></label>
					<select name="menu_category" id="menu_category" data-placeholder="Select Menu" multiple class="form-control select2">
					@foreach($menu_list_m AS $val)
					<option value="{{$val->lr_category_id}}">{{$val->lr_category_name}}</option>
					@endforeach

					</select>
				</div>
			</div>
			<div class="col-md-6">
				<div class="submitButton">
					<div class="form-group">
						<div id="custom_error"></div>
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
			</div> --}}


	<script type="text/javascript">

	// function save_meal()
	// {          
	
	// 	var menu_name = document.getElementById("menu_name").value.trim();
	// 	var menu_category = document.getElementById("menu_category").value.trim();
	// 	var arraydata = $('#menu_category').serialize();
	// 	if(menu_name=="")
	// 	{
	// 	document.getElementById('menu_name').style.border='1px solid #ff0000';
	// 	document.getElementById("menu_name").focus();
	// 	$('#menu_name').val('');
	// 	$('#menu_name').attr("placeholder", "Please enter  name ");
	// 	$("#menu_name").addClass( "errors" );
	// 	return false;
	// 	}
	// 	else
	// 	{
	// 	document.getElementById("menu_name").style.border = "";   
	// 	}

	// 	if(menu_category=="")
	// 	{
	// 	document.getElementById('menu_category').style.border='1px solid #ff0000';
	// 	document.getElementById("menu_category").focus();
	// 	$('#menu_category').val('');
	// 	$('#menu_category').attr("placeholder", "Please select category");
	// 	$("#menu_category").addClass( "errors" );
	// 	return false;
	// 	}
	// 	else
	// 	{
	// 	document.getElementById("menu_category").style.border = "";   
	// 	}		
	// 	var form = new FormData();     
	// 		form.append('menu_name',menu_name);
	// 		form.append('menu_category',$('#menu_category').serialize());
	// 		//form.append('updateid',updateid);

	// 		$.ajax(
	// 		{
	// 		headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
	// 		type: 'POST',
	// 		url: "{{url('/vendor/save_custom_menu')}}",
	// 		data: form,
	// 		contentType: false,
	// 		processData: false,
	// 		success:function(response) 
	// 		{
    //         console.log(response); // return false;   
    //         document.getElementById("custom_error").innerHTML="" ; 
    //         document.getElementById("custom_error").style.color = "#ff0000"; 

    //         var status = response.status;       
    //         var msg = response.msg;  
    //         var menuid = response.menuid;
    //         var menu_name = response.menu_name;
	// 		if(status=='200')
    //         {
	// 			document.getElementById("custom_error").style.color = "green";
	// 		 	document.getElementById("custom_error").innerHTML=msg;
	// 			setTimeout(function(){
							
    //     					$("#mymenuModal").modal('hide');
	// 					 	$('#menu_category,#menu_name').val('');
	// 					 	$('#custom_error').text('');
    //     		}, 3000);
				
	// 			$('#custom_menu_list').append('<option value="'+menuid+'" selected >'+menu_name+'</option>');
    //          }
    //          else if(status=='401')
    //          {

    //          	document.getElementById("custom_error").style.color = "#ff0000";
    //          	document.getElementById("custom_error").innerHTML=msg;
    //          }

    //      }
	// 		});

	// 	return false;
		
	// }

	// function openaddmenumodal(value)
	// {
	// 	if(value == 'NEWMENU')
	// 	{
	// 		$('#mymenuModal').modal('show');
	// 	}
	// }

	</script>
<!--add custom menu modal end-->



	@include('Website::include.footer')
	<script>  

	function changeplan()
	{
	if($('#plan_type').val()=='MONTHLY')
	{
	$('#plan_type_weekly_block').css('display','none'); 
	$('#plan_type_week').val('-1');
	$('#package_feature').val('');   
	$('#cost_plan_package_feature').val('');
	}
	else if($('#plan_type').val()=='WEEKLY')
	{
	$('#plan_type_weekly_block').css('display','block');
	}
	else
	{

	}
	}

	function changeplan_type_week()      
	{
		if($('#plan_type_week').val()=='ONEWEEK')
		{
           $('#one_two_week_block').css('display','block');
		   $('#two_three_week_block').css('display','none');
		   $('#package_feature').val('');   
		   $('#cost_plan_package_feature').val('');
		}
		else if($('#plan_type_week').val()=='TWOWEEK')
		{
			/*$('#one_two_week_block').css('display','block');
			$('#two_three_week_block').css('display','block');
			$('#package_feature').val('');   
		    $('#cost_plan_package_feature').val('');*/
		    $('#one_two_week_block').css('display','block');
		   $('#two_three_week_block').css('display','none');
		   $('#package_feature').val('');   
		   $('#cost_plan_package_feature').val('');
		}
		else if($('#plan_type_week').val()=='THREEWEEK')    
		{
			$('#one_two_week_block').css('display','none');
			$('#two_three_week_block').css('display','none');    
			$('#package_feature').val('');   
			$('#cost_plan_package_feature').val('');  
		   $('#cost_plan_package_feature').val('');
		}
		
	}


	function macros()
	{ 
	if($('#macros-carb-pro').val()=='YES')
	{
	$('#macros-yes').css('display','block');
	$('#macros-no').css('display','none');   
	$('#max_carb_macros_no').val('');
	$('#max_protein_macros_no').val('');
	}
	else if($('#macros-carb-pro').val()=='NO')
	{
	$('#macros-no').css('display','block');
	$('#macros-yes').css('display','none');
	$('#min_carb_macros_yes').val('');
	$('#max_carb_macros_yes').val('');
	$('#min_protien_macros_yes').val('');
	$('#max_protien_macros_yes').val('');
	}
	else if($('#macros-carb-pro').val()=='-1')
	{
	$('#macros-no').css('display','none');
	$('#macros-yes').css('display','none');
	$('#max_carb_macros_no').val('');
	$('#max_protein_macros_no').val('');
	$('#min_carb_macros_yes').val('');
	$('#max_carb_macros_yes').val('');
	$('#min_protien_macros_yes').val('');
	$('#max_protien_macros_yes').val('');
	}
	
	}

	// function show_custommenu()
	// {
	// if($('#custom_fixed_menu').val()=='CUSTOMMENU')
	// {
	// $('#custom_menu_block').css('display','block');
	// }
	// else if($('#custom_fixed_menu').val()=='FIXEDMENU')
	// {
	// $('#custom_menu_block').css('display','none');
	// $('#custom_menu_list').val('-1');
	// }
	// else if($('#custom_fixed_menu').val()=='-1')
	// {
	// $('#custom_menu_block').css('display','none');
	// }
	// else
	// {
	
	// }
	// }

	function changepackagefeature()
	{
		if($('#package_feature').val()=='2')
		{
			$('#cost_plan_block').css('display','none');
			$('#two_three_week_block').css('display','block');
			$('#cost_plan').val('');
		}
		else if($('#package_feature').val()=='3')
		{
			$('#two_three_week_block').css('display','block');
			$('#cost_plan_block').css('display','block');
		}
		else if($('#package_feature').val()=='1')
		{
			$('#cost_plan_block').css('display','block');
			$('#two_three_week_block').css('display','none');
			$('#cost_plan_package_feature').val('');
			
		
		}
	}

	function save_plan()    
	{           
	var updateid = document.getElementById("updateid").value.trim();
	var plan_name = document.getElementById("plan_name").value.trim();
	var meal_count = document.getElementById("meal_count").value.trim();
	var snack_count = document.getElementById("snack_count").value.trim();
	var macros_carb_pro = document.getElementById("macros-carb-pro").value.trim();
	var gender = document.getElementById("gender").value.trim();
	var user_plan_pause = document.getElementById("user_plan_pause").value.trim();
	var plan_category = document.getElementById("plan-category").value.trim();
	var plan_sub_category = document.getElementById("plan-sub-category").value.trim();
	var plan_duration = document.getElementById("plan-duration").value.trim();
	var off_days = document.getElementById("off_days").value.trim();
	var custom_fixed_menu = document.getElementById("custom_fixed_menu").value.trim();
	var max_carb_macros_no = document.getElementById("max_carb_macros_no").value.trim();
	var max_protein_macros_no = document.getElementById("max_protein_macros_no").value.trim();
	var min_carb_macros_yes = document.getElementById("min_carb_macros_yes").value.trim();
	var max_carb_macros_yes = document.getElementById("max_carb_macros_yes").value.trim();
	var min_protien_macros_yes = document.getElementById("min_protien_macros_yes").value.trim();
	var max_protien_macros_yes = document.getElementById("max_protien_macros_yes").value.trim();
	var macros_yes_plan = document.getElementById("macros_yes_plan").value.trim();
	//var custom_menu_list = document.getElementById("custom_menu_list").value.trim();
	var plan_type = document.getElementById("plan_type").value.trim();
	var plan_type_week = document.getElementById("plan_type_week").value.trim();
	var package_feature = document.getElementById("package_feature").value.trim();
	var cost_plan_package_feature = document.getElementById("cost_plan_package_feature").value.trim();
	var cost_plan = document.getElementById("cost_plan").value.trim();
	
	

	if(plan_name=="")
	{
	document.getElementById('plan_name').style.border='1px solid #ff0000';
	document.getElementById("plan_name").focus();
	$('#plan_name').val('');
	$('#plan_name').attr("placeholder", "Please enter plan name");
	$("#plan_name").addClass( "errors" );
	return false;
	}
	else
	{
	document.getElementById("plan_name").style.border = "";   
	}

	if(macros_carb_pro=="-1")
	{
	document.getElementById('macros-carb-pro').style.border='1px solid #ff0000';
	document.getElementById("macros-carb-pro").focus();
	$("#macros-carb-pro").addClass( "errors" );
	return false;
	}
	else
	{
	document.getElementById("macros-carb-pro").style.border = "";   
	}

	if(macros_carb_pro=='YES')
	{

	if(min_carb_macros_yes=="")
	{
	document.getElementById('min_carb_macros_yes').style.border='1px solid #ff0000';
	document.getElementById("min_carb_macros_yes").focus();
	$('#min_carb_macros_yes').val('');
	$('#min_carb_macros_yes').attr("placeholder", "Please enter min carb");
	$("#min_carb_macros_yes").addClass( "errors" );
	return false;
	}
	else
	{
	document.getElementById("min_carb_macros_yes").style.border = "";   
	}

	if(max_carb_macros_yes=="")
	{
	document.getElementById('max_carb_macros_yes').style.border='1px solid #ff0000';
	document.getElementById("max_carb_macros_yes").focus();
	$('#max_carb_macros_yes').val('');
	$('#max_carb_macros_yes').attr("placeholder", "Please enter max carb");
	$("#max_carb_macros_yes").addClass( "errors" );
	return false;
	}
	else
	{
	document.getElementById("max_carb_macros_yes").style.border = "";   
	}
	if(min_protien_macros_yes=="")
	{
	document.getElementById('min_protien_macros_yes').style.border='1px solid #ff0000';
	document.getElementById("min_protien_macros_yes").focus();
	$('#min_protien_macros_yes').val('');
	$('#min_protien_macros_yes').attr("placeholder", "Please enter min protein");
	$("#min_protien_macros_yes").addClass( "errors" );
	return false;
	}
	else
	{
	document.getElementById("min_protien_macros_yes").style.border = "";   
	}
	if(max_protien_macros_yes=="")
	{
	document.getElementById('max_protien_macros_yes').style.border='1px solid #ff0000';
	document.getElementById("max_protien_macros_yes").focus();
	$('#max_protien_macros_yes').val('');
	$('#max_protien_macros_yes').attr("placeholder", "Please enter max protein");
	$("#max_protien_macros_yes").addClass( "errors" );
	return false;
	}
	else
	{
	document.getElementById("max_protien_macros_yes").style.border = "";   
	}

	if(macros_yes_plan=="-1")
	{
	document.getElementById('macros_yes_plan').style.border='1px solid #ff0000';
	document.getElementById("macros_yes_plan").focus();
	$("#macros_yes_plan").addClass( "errors" );
	return false;
	}
	else
	{
	document.getElementById("macros_yes_plan").style.border = "";   
	}
	}
	else if(macros_carb_pro=='NO')
	{


	if(max_carb_macros_no=="")
	{
	document.getElementById('max_carb_macros_no').style.border='1px solid #ff0000';
	document.getElementById("max_carb_macros_no").focus();
	$('#max_carb_macros_no').val('');
	$('#max_carb_macros_no').attr("placeholder", "Please enter max carb");
	$("#max_carb_macros_no").addClass( "errors" );
	return false;
	}
	else
	{
	document.getElementById("max_carb_macros_no").style.border = "";   
	}

	if(max_protein_macros_no=="")
	{
	document.getElementById('max_protein_macros_no').style.border='1px solid #ff0000';
	document.getElementById("max_protein_macros_no").focus();
	$('#max_protein_macros_no').val('');
	$('#max_protein_macros_no').attr("placeholder", "Please enter max protein");
	$("#max_protein_macros_no").addClass( "errors" );
	return false;
	}
	else
	{
	document.getElementById("max_protein_macros_no").style.border = "";   
	}

	}

	if(gender=="-1")
	{
	document.getElementById('gender').style.border='1px solid #ff0000';
	document.getElementById("gender").focus();
	$("#gender").addClass( "errors" );
	return false;
	}
	else
	{
	document.getElementById("gender").style.border = "";   
	}
	if(user_plan_pause=="-1")
	{
	document.getElementById('user_plan_pause').style.border='1px solid #ff0000';
	document.getElementById("user_plan_pause").focus();
	$("#user_plan_pause").addClass( "errors" );
	return false;
	}
	else
	{
	document.getElementById("user_plan_pause").style.border = "";   
	}

	if(plan_category=="-1")
	{
	document.getElementById('plan-category').style.border='1px solid #ff0000';
	document.getElementById("plan-category").focus();
	$("#plan-category").addClass( "errors" );
	return false;
	}
	else
	{
	document.getElementById("plan-category").style.border = "";   
	}   

	if(plan_sub_category=="-1")
	{
	document.getElementById('plan-sub-category').style.border='1px solid #ff0000';
	document.getElementById("plan-sub-category").focus();
	$("#plan-sub-category").addClass( "errors" );
	return false;
	}
	else
	{
	document.getElementById("plan-sub-category").style.border = "";   
	} 

	if(plan_type=="-1")
	{
	document.getElementById('plan_type').style.border='1px solid #ff0000';
	document.getElementById("plan_type").focus();
	$("#plan_type").addClass( "errors" );
	return false;
	}
	else
	{
	document.getElementById("plan_type").style.border = "";   
	}   


	if(plan_type=='WEEKLY')
	{
		if(plan_type_week=="-1")
		{
		document.getElementById('plan_type_week').style.border='1px solid #ff0000';
		document.getElementById("plan_type_week").focus();
		$("#plan_type_week").addClass( "errors" );
		return false;
		}
		else
		{
		document.getElementById("plan_type_week").style.border = "";   
		}  

		if(plan_type_week=='ONEWEEK')
		{
			if(package_feature=="-1")
		{
		document.getElementById('package_feature').style.border='1px solid #ff0000';
		document.getElementById("package_feature").focus();
		$("#package_feature").addClass( "errors" );
		return false;
		}
		else
		{
		document.getElementById("package_feature").style.border = "";   
		}  

		}
		else if(plan_type_week=='TWOWEEK')
		{
			if(package_feature=="-1")
		{
		document.getElementById('package_feature').style.border='1px solid #ff0000';
		document.getElementById("package_feature").focus();
		$("#package_feature").addClass( "errors" );
		return false;
		}
		else
		{
		document.getElementById("package_feature").style.border = "";   
		}  
		
			if(cost_plan_package_feature=="")
			{
			document.getElementById('cost_plan_package_feature').style.border='1px solid #ff0000';
			document.getElementById("cost_plan_package_feature").focus();
			$('#cost_plan_package_feature').val('');
			$('#cost_plan_package_feature').attr("placeholder", "Please enter cost of plan");
			$("#cost_plan_package_feature").addClass( "errors" );
			return false;
			}
			else
			{
			document.getElementById("cost_plan_package_feature").style.border = "";   
			}
		}
	}

	if(plan_duration=="")
	{
	document.getElementById('plan-duration').style.border='1px solid #ff0000';
	document.getElementById("plan-duration").focus();
	$('#plan-duration').val('');
	$('#plan-duration').attr("placeholder", "Please enter plan duration");
	$("#plan-duration").addClass( "errors" );
	return false;
	}
	else
	{
	document.getElementById("plan-duration").style.border = "";   
	}           
	if(off_days=="-1")
	{
	document.getElementById('off_days').style.border='1px solid #ff0000';
	document.getElementById("off_days").focus();
	$("#off_days").addClass( "errors" );
	return false;
	}
	else
	{
	document.getElementById("off_days").style.border = "";   
	}   

	if(cost_plan=="")
	{
	document.getElementById('cost_plan').style.border='1px solid #ff0000';
	document.getElementById("cost_plan").focus();
	$('#cost_plan').val('');
	$('#cost_plan').attr("placeholder", "Please enter cost of plan");
	$("#cost_plan").addClass( "errors" );
	return false;
	}
	else
	{
	document.getElementById("cost_plan").style.border = "";   
	}

	if(custom_fixed_menu=="-1")
	{
	document.getElementById('custom_fixed_menu').style.border='1px solid #ff0000';
	document.getElementById("custom_fixed_menu").focus();
	$("#custom_fixed_menu").addClass( "errors" );
	return false;
	}
	else
	{
	document.getElementById("custom_fixed_menu").style.border = "";   
	}

	// if(custom_fixed_menu=='CUSTOMMENU')
	// {

	// if(custom_menu_list=="-1")
	// {
	// document.getElementById('custom_menu_list').style.border='1px solid #ff0000';
	// document.getElementById("custom_menu_list").focus();
	// $("#custom_menu_list").addClass( "errors" );
	// return false;
	// }
	// else
	// {
	// document.getElementById("custom_menu_list").style.border = "";   
	// }

	// }

	var form = new FormData(); 
	form.append('plan_name', plan_name); 
	form.append('meal_count', meal_count); 
	form.append('snack_count', snack_count); 
	form.append('macros_carb_pro', macros_carb_pro);    
	form.append('min_carb_macros_yes', min_carb_macros_yes); 
	form.append('max_carb_macros_yes', max_carb_macros_yes); 
	form.append('min_protien_macros_yes', min_protien_macros_yes); 
	form.append('max_protien_macros_yes', max_protien_macros_yes); 
	form.append('macros_yes_plan', macros_yes_plan); 
	form.append('max_carb_macros_no', max_carb_macros_no); 
	form.append('max_protein_macros_no', max_protein_macros_no);  
	form.append('gender', gender);  
	form.append('vendor_plan_pause', user_plan_pause); 
	form.append('plan_category', plan_category); 
	form.append('plan_sub_category', plan_sub_category); 
	form.append('plan_duration', plan_duration);  
	form.append('off_days', off_days); 
	form.append('custom_fixed_menu', custom_fixed_menu); 
//	form.append('custom_menu_list', custom_menu_list); 
	form.append('updateid', updateid); 
	form.append('plan_type_week', plan_type_week); 
	form.append('plan_type', plan_type); 
	form.append('package_feature', package_feature); 
	form.append('cost_plan_package_feature', cost_plan_package_feature); 
	form.append('cost_plan', cost_plan); 
	
	

	$.ajax({    
	headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
	type: 'POST',
	url: "{{url('/vendor/save_plan')}}",
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


	function change_sub_cat()
	{  
		
	 var plan_category = $('#plan-category').val(); 
	var subcatid = '{{$lr_plan_subcat_id}}';
	var sweta = '';
	
	var form = new FormData(); 
	form.append('plan_categoryid', plan_category); 
	$.ajax({    
	headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
	type: 'POST',
	url: "{{url('/vendor/changeplan_sub_cat')}}",
	data:form,
	contentType: false,
	processData: false,
	success:function(response) 
	{   //console.log(response); return false;
	
	var status = response.status;
	if(status=='200')
	{ 
	var list_subcat = response.list_subcat; 
	var count_list_subcat = Object.keys(list_subcat).length;  
	$("#plan-sub-category option").remove();
	$('#plan-sub-category')
	.append($("<option></option>")
	.attr("value",'-1')
	.text('Please Select'));  
	if(subcatid!='')
	{
		for(var i=0; i<count_list_subcat; i++)
	{
	if(list_subcat[i].lr_plan_subcat_id==subcatid)
	{
		sweta = 'selected';
		renu = 'ed'
	}
	else
	{
		sweta = '';
		renu = ''
	}
		
	$('#plan-sub-category')
	.append($("<option></option>")
	.attr("value",list_subcat[i].lr_plan_subcat_id)
	.attr('select'+renu,sweta)
	.text(list_subcat[i].lr_plan_subcat_name));
	}
	}
	else
	{  
		for(var i=0; i<count_list_subcat; i++)
	{
		
		
	$('#plan-sub-category')
	.append($("<option></option>")
	.attr("value",list_subcat[i].lr_plan_subcat_id)
	.text(list_subcat[i].lr_plan_subcat_name));
	}
	}
	
	}
	}
	});
	return false;
	}      

    <?php
       if(isset($data) && count($data)>0)
	{ ?>

		if($('#macros-carb-pro').val()=='YES')
		{
		$('#macros-yes').css('display','block');
		$('#macros-no').css('display','none');
		}
		else if($('#macros-carb-pro').val()=='NO')
		{
		$('#macros-no').css('display','block');
		$('#macros-yes').css('display','none');
		}
		else if($('#macros-carb-pro').val()=='-1')
		{
		$('#macros-no').css('display','none');
		$('#macros-yes').css('display','none');
		}
		else
		{
		alert("Something went wrong.");
		}

		change_sub_cat();
		//show_custommenu();
		changeplan();
		changeplan_type_week();

	 <?php
		}
	  ?>

	</script>