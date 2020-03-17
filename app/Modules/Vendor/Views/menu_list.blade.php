
	@include('Vendor::include.header')



	<section class="myDashboard">
	<div class="container">
	<div class="row">
	@include('Vendor::include.sidebar')
	<div class="col-md-9">
	<div class="rightBox">
	<div class="headFlex">
	<h3 class="formTitle">Menu List</h3>
	<div class="addBtn">
	<a href="{{url('/vendor/add-menu')}}"><i class="fa fa-plus"></i> Add menu</a>
	</div>
	</div>


	<div class="current-order-table">

	<div class="table-responsive">          
	<table class="table">
	<thead>
	<tr>
	<th>S.No</th>
	<th>Menu name</th>
	<th>View meal details</th>
	<th>Action</th>
	</tr>
	</thead>
	<tbody>
	@php $sn = 0;  @endphp
	@foreach($data AS $data_val)
	@php $sn++;  @endphp
	<tr class="even-row">
	<td>{{$sn}}.</td>
	<td>{{$data_val->vendor_menu_name}}</td>
	<td>
	<span class="infoIcon">
	<a href="{{url('/vendor/menu-details')}}/{{$data_val->lr_unique_id}}"><img src="{{url('/')}}/public/website/img/info.png" alt=""></a>
	</span>
	</td>

	<td>
	<div class="editDeleteBtns">
	<a href="{{url('/vendor/edit-menu')}}/{{$data_val->lr_unique_id}}">
	<img src="{{url('/')}}/public/website/img/edit_1.png" alt="">
	</a>
	<a href="javascript:void(0);" onclick="return deletebtnrow({{$data_val->lr_unique_id}})">
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

	<input type="hidden" id="rowidd" value="" name="rowidd" />
	<div id="deletebtn" class="modal fade readmore-modal-area" role="dialog">
	<div class="modal-dialog">
	<div class="modal-content">
	<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>


	</div>

	<div class="modal-body">
		<div class="modal-delete-container">	
			
				<h4 class="modal-title">Are you sure you want to delete ?</h4>
			<div class="delete-modal-btn">		
				<button type="button" class="delte-btn-first" onclick=" return deleterow()" >Yes</button>&nbsp;&nbsp;&nbsp;&nbsp;
				<button type="button" id="cancelbutton" class="delte-btn-first" data-dismiss="modal">No</button>
			</div>
		</div>
	</div>

	</div>

	</div>

	</div>

	@include('Vendor::include.footer')
	<script>
		
		function deletebtnrow(rowid)
			{
				 $("#rowidd").val(rowid);
            $("#deletebtn").modal("show");
			}

			function deleterow()
			{
				var rowidd =$("#rowidd").val();
				var tblname = 'tbl_lr_vendor_menu';
				var colwhere = 'lr_unique_id';
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
	</script>


	<style type="text/css">
	
	</style>