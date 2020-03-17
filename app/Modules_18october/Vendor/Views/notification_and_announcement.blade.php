

		@include('Vendor::include.header')
		<section class="myDashboard">
		<div class="container">
		<div class="row">
		@include('Vendor::include.sidebar')
		<div class="col-md-9">
		<div class="rightBox">
		<div class="headFlex">
		<h3 class="formTitle"> Notifications and Announcement</h3>
		<div class="addBtn">
				<a href="javascript:void(0);" onclick="return deletebtnallrow()"><i class="fa fa-trash"></i> Clear All</a>
		</div>
		</div>


		<div class="current-order-table">

		<div class="table-responsive">          
		<table class="table">
		<thead>
		<tr>
		<th>S.No</th>
		<th>Name</th>

		<th style="width:50%;">Description</th>
		<th>Date</th>




		<th>Action</th>

		</tr>
		</thead>
		<tbody>
		@php $sn = 0;  @endphp
		@foreach($data AS $data_val)
		@php
		//	
		@endphp
		@php $sn++;  @endphp
		<tr class="even-row">
		<td>{{$sn}}.</td>
		<td>{{$data_val->lr_notifi_announc_name}}</td>
		<td class="meal-description">
		<span>
				
				<?php $string = $data_val->lr_notifi_announc_desp;
				if (strlen($string) > 100) {
				 $stringCut = substr($string, 0, 100);
				 $endPoint = strrpos($stringCut, ' ');
			 
				 //if the string doesn't contain any space then it will cut without word basis.
				 $string = $endPoint? substr($stringCut, 0, $endPoint):substr($stringCut, 0);
				 $string .= '... <a href="JavaScript:void(0)" onclick="return readmore('.$data_val->lr_notifi_announc_id.')">Read More</a>';
				 }
				 echo $string; 
			 ?>
		</span>
		</td>
		<td>{{$data_val->lr_notifi_announc_date}}</td>
		<td>
		<div class="editDeleteBtns">

		<a href="javascript:void(0);" onclick="return deletebtnrow({{$data_val->lr_notifi_announc_id}})">
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


		<!-- Modal -->
		<input type="hidden" id="rowidd" value="" name="rowidd" />
		<div id="deletebtn" class="modal fade readmore-modal-area" role="dialog">
		<div class="modal-dialog">
		<div class="modal-content">
		<div class="modal-header">
				<h4 class="modal-title">Are you sure you want to delete ?</h4>
		<button type="button" class="close" data-dismiss="modal">&times;</button>
	
		</div>
		<div class="modal-body">
		<button type="button" class="btn btn-danger btn-sx" onclick=" return deleterow()" >Delete</button>&nbsp;&nbsp;&nbsp;&nbsp;
		<button type="button" id="cancelbutton" class="btn btn-success btn-sx" data-dismiss="modal">Cancel</button>
		</div>
	
		</div>
	
		</div>
	
		</div>

		
		<div id="deleteallbtn" class="modal fade readmore-modal-area" role="dialog">
		<div class="modal-dialog">
		<div class="modal-content">
		<div class="modal-header">
				<h4 class="modal-title">Are you sure you want to delete all ?</h4>
		<button type="button" class="close" data-dismiss="modal">&times;</button>
	
		</div>
		<div class="modal-body">
		<button type="button" class="btn btn-danger btn-sx" onclick=" return deleteallrow()" >Delete</button>&nbsp;&nbsp;&nbsp;&nbsp;
		<button type="button" id="cancelbutton" class="btn btn-success btn-sx" data-dismiss="modal">Cancel</button>
		</div>
	
		</div>
	
		</div>
	
		</div>

		</section>
		@include('Vendor::include.footer')

		<script>
			function deletebtnrow(rowid)
			{
			$("#rowidd").val(rowid);
            $("#deletebtn").modal("show");
			}

			function deletebtnallrow()
			{
			
            $("#deleteallbtn").modal("show");
			}

			function deleterow()
			{
				var rowidd =$("#rowidd").val();
				var tblname = 'tbl_lr_notifi_announc';
				var colwhere = 'lr_notifi_announc_id';
				$.ajax({
				headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
				method: "POST",
				url: "{{url('/deleterow')}}",
				data: { id: rowidd,tblname: tblname,colwhere: colwhere}
				
				})
				.done(function( response ) {
				setTimeout(function() { location. reload(true); }, 1000);
				});
				return false;
			}

			function deleteallrow()
			{
				var rowidd =$("#rowidd").val();
				var tblname = 'tbl_lr_notifi_announc';
				$.ajax({
				headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
				method: "POST",
				url: "{{url('/deleteallrow')}}",
				data: {tblname: tblname}
				
				})
				.done(function( response ) {
				setTimeout(function() { location. reload(true); }, 1000);
				});
				return false;
			}

			function readmore(id)
			{
			
			var tblname='tbl_lr_notifi_announc';
			var colnamewhere = 'lr_notifi_announc_id';
			var colmsg = 'lr_notifi_announc_desp';

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

		</script>

