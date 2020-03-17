	@include('Vendor::include.header')


	<section class="myDashboard">
	<div class="container">
	<div class="row">
	@include('Vendor::include.sidebar')
	<div class="col-md-9">
	<div class="rightBox">
	<div class="headFlex">
	<h3 class="formTitle">Plans</h3>
	<div class="addBtn">
	<a href="{{url('/vendor/add-plan')}}"><i class="fa fa-plus"></i> Add plan</a>
	</div>
	</div>


	<div class="current-order-table">

	<div class="table-responsive">          
	<table class="table">
	<thead>
	<tr>
	<th>S.No</th>
	<th>Name</th>
	<th>View Detail</th>
	<th>Calender</th>
	<th>Action</th>
	<th>Status</th>

	</tr>
	</thead>
	<tbody>
	@php $sn = 0;  @endphp
	@foreach($data AS $data_val)
	@php 
	$sn++;  
	$admin_status=$data_val->admin_status; 
	if($admin_status=='1')
    {
    $checked='checked';
    }
    else
    {
	$checked='';
	} 
	@endphp
	<tr class="even-row">
	<td>{{$sn}}.</td>
	<td>{{$data_val->vendor_plan_name}}</td>
	<td>
	<span class="infoIcon">
	<a href="{{url('/vendor/view-detail/plan')}}/{{$data_val->vendor_plan_id}}"><img src="{{url('/')}}/public/website/img/info.png" alt=""></a>
	</span>
	</td>
	<td><a href="{{url('/vendor/plan/calender')}}/{{$data_val->vendor_plan_id}}"><img src="{{url('/')}}/public/website/img/info.png" alt="">Calender</a></td>
	<td>
	<div class="editDeleteBtns">
	<a href="{{url('/vendor/edit-plan')}}/{{$data_val->vendor_plan_id}}">
	<img src="{{url('/')}}/public/website/img/edit_1.png" alt="">
	</a>
	<a href="javascript:void(0);" onclick="return deletebtnrow({{$data_val->vendor_plan_id}})">
	<img src="{{url('/')}}/public/website/img/delete.png" alt="">
	</a>
	</div>
	</td>
	<td id="{{$data_val->vendor_plan_id}}">
	<div class="switchBtn" onclick="return changestatus(<?php echo $data_val->vendor_plan_id.','.$admin_status;?>)">
	<label class="switch"  >
	<input type="checkbox" {{$checked}} >
	<span class="slider round"></span>
	</label>
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

	@include('Vendor::include.footer')	
	<script>
		 function changestatus(id,status){
            var tblname='tbl_lr_vendor_plan';
         var status_val;
         var colwhere = 'vendor_plan_id';
         var colstatus = 'admin_status';
		  if(status==0)
		  {
		  status_val="1";
		  }
		  else
		  {
		     status_val="0";
		  }

		  $.ajax({
            headers: {'X-CSRF-Token':'{{ csrf_token() }}'}, 
            method: "POST",
            url:"{{url('/lradmin/changestatus')}}",
            data: { id:id, status:status_val,tblname:tblname,colwhere:colwhere,colstatus:colstatus}

            })
		  .done(function( msg ) {
           console.log(msg); //return false;
		var tempst=0;
		var tempstr="";
		if(status==0)
		{
		  tempst=1;
		  tempstr="checked";
		}

		if(status==1)
		{
		  tempst=0;
		  tempstr="";
		}
      
	

		$("#"+id).html("<div class='switchBtn' onclick='return changestatus("+id+","+tempst+")' > <label class='switch'><input type='checkbox' "+tempstr+" ><span class='slider round'></span></label></div>");

		

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
				var tblname = 'tbl_lr_vendor_plan';
				var colwhere = 'vendor_plan_id';
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