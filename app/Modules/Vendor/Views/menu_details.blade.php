
		@include('Vendor::include.header')

		<section class="myDashboard">
		<div class="container">
		<div class="row">
		@include('Vendor::include.sidebar')

		<div class="col-md-9">
		<div class="rightBox">
		<div class="headFlex">
		<h3 class="formTitle">Menu name - {{$menuname[0]->vendor_menu_name}}</h3>
		 <div class="addBtn">
		 <a href="{{url('/vendor/menu-list')}}"></i>Go Back</a>
		</div> 
		</div>


		<div class="current-order-table">

		<div class="table-responsive">          
		<table class="table">
		<thead>
		<tr>
		<th>S.No</th>
		<th>Meal category</th>
		<th>Meal name</th>
		<th>Calories</th>
		<th>Fat</th>
		<th>Carb</th>
		<th>Protien</th>
		</tr>
		</thead>
		<tbody>
		@php $sn = 0;  @endphp
		@foreach($data AS $data_val)
		@php
		$category_name = DB::table('tbl_lr_menu_category')->where('lr_category_id',$data_val->vendor_menu_category)->select('lr_category_name')->get();  

		$meal_name = DB::table('tbl_lr_meal')->where('lr_meal_id',$data_val->vendor_menu_category_meal)->select('lr_meal_name','lr_meal_calories','lr_meal_fat','lr_meal_carb','lr_meal_protein')->get(); 
		
		@endphp
		@php $sn++;  @endphp
		<tr class="even-row">
		<td>{{$sn}}.</td>
		<td>{{$category_name[0]->lr_category_name}}</td>
		<td>{{$meal_name[0]->lr_meal_name}}</td>
		<td>{{$meal_name[0]->lr_meal_calories}}</td>
		<td>{{$meal_name[0]->lr_meal_fat}}</td>
		<td>{{$meal_name[0]->lr_meal_carb}}</td>
		<td>{{$meal_name[0]->lr_meal_protein}}</td>
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
