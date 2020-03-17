
		@include('Vendor::include.header')

		<section class="myDashboard">
		<div class="container">
		<div class="row">
		@include('Vendor::include.sidebar')

		<div class="col-md-9">
		<div class="rightBox">
		<div class="headFlex">
		<h3 class="formTitle">Plan Name - {{$data[0]->vendor_plan_name}}  </h3>
		 <div class="addBtn">
		<a href="{{url('vendor/plan-listing')}}">Go Back</a>
		</div> 
		</div>


		<div class="current-order-table">

		<div class="table-responsive">          
		<table class="table">
		<thead>
		<tr>
		<th>S.No</th>
		<th>Meals</th>
		<th>Snacks</th>
		<th>Macros (Carb, Protein)</th>
		<th>Min carb</th>
		<th>Max carb</th>
		<th>Min Protein</th>
        <th>Max Protein</th>     
        <th>Max carb</th> 
        <th>Max Protein</th> 
		<th>Per meal or once for the whole plan period</th>
		<th>Gender</th>
		<th>Maximum number of days users can pause their plan</th>
		<th>Categories</th>
        <th>Subcategory</th>
        <th>Plan duration in terms of days</th>
		<th>Off days for the current plan</th>
		<th>Does the plan follow a custom menu where users can choose from or a fixed Menu</th>
		<th>Menu that represents the current plan</th>
		</tr>
		</thead>
		<tbody>
		@php $sn = 0;  @endphp
		@foreach($data AS $data_val)
		@php
            if($data[0]->macros_yes_plan=='-1')
            {
                $data[0]->macros_yes_plan = 'N/A';
            }
            $category = $data[0]->lr_plancategory_id;
            $category =  DB::table('tbl_lr_plancategory')->where('lr_plancategory_id',                      $category)->select('lr_plancategory_name')->get();
            $subcategory = $data[0]->lr_plan_subcat_id;
            $subcategory =  DB::table('tbl_lr_plansubcategory')->where('lr_plan_subcat_id',                      $subcategory)->select('lr_plan_subcat_name')->get();

		@endphp
		@php $sn++;  @endphp
		<tr class="even-row">
		<td>{{$sn}}.</td>
		<td>{{$data[0]->vendor_plan_meals}}</td>
		<td>{{$data[0]->vendor_plan_snacks}}</td>
		<td>{{$data[0]->vendor_plan_macros}}</td>
		<td>{{$data[0]->macros_yes_min_carb}}</td>
        <td>{{$data[0]->macros_yes_max_carb}}</td>
        <td>{{$data[0]->macros_yes_min_protein}}</td>
        <td>{{$data[0]->macros_yes_max_protein}}</td>
        <td>{{$data[0]->macros_no_max_carb}}</td>
        <td>{{$data[0]->macros_no_max_protein}}</td>
        <td>{{$data[0]->macros_yes_plan}}</td>
        <td>{{$data[0]->vendor_plan_gendor}}</td>
        <td>{{$data[0]->vendor_plan_pause}}</td>
        <td>{{$category[0]->lr_plancategory_name}}</td>
        <td>{{$subcategory[0]->lr_plan_subcat_name}}</td>
        <td>{{$data[0]->vendor_plan_duration}}</td>
        <td>{{$data[0]->vendor_plan_offdays}}</td>
        <td>{{$data[0]->vendor_plan_menu_type}}</td>
        <td>{{$data[0]->custom_menu_vendor_menu_id}}</td>
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

		@include('Vendor::include.footer')
