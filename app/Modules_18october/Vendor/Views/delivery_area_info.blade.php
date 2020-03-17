@include('Vendor::include.header')

	<section class="myDashboard">
	<div class="container">
	<div class="row">
	@include('Vendor::include.sidebar')
	<div class="col-md-9">
	<div class="rightBox">
	<div class="headFlex">
	<h3 class="formTitle">Governorate info</h3>
	<div class="addBtn">
	<a href="#" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Add Governorate</a>
	</div>
	</div>


	<div class="current-order-table delivery-info-table ">

	<div class="table-responsive">          
	<table class="table">
	<tbody>
	<div>
		
		@foreach($governorateid AS $governorateid_val)
		@php
		   $govername = DB::table('tbl_lr_governorate')->select('lr_governorate_name')->where('lr_governorate_id',$governorateid_val)->get();
		@endphp
		<tr class="delivery-info-row">
		<td colspan="3">{{$govername[0]->lr_governorate_name}}</td>
		</tr>
		<tr>
		@foreach($vendor_governorate AS $area_val)
		<?php
			if($governorateid_val==$area_val->lr_governorate_id)
			{
		?>
		<tr>
		<td>{{$area_val->lr_governorate_area_name}}</td>
		<?php
			$delverytime = DB::table('tbl_lr_vendor_deleverytime')->where('vendor_areaid',$area_val->lr_governorate_area_id)->select('id','from','to')->get();
		?>

		<td><div>
			<?php if(count($delverytime)>0){ ?>
			@foreach($delverytime AS $del_val)
			{{$del_val->from}} - {{$del_val->to}} <button type="button" class="close" onclick=" return deletebtnrow({{$del_val->id}})">×</button> <br/>
			@endforeach
			<?php }else{ ?>
				00:00 AM - 00:00 PM
			<?php } ?>
		</div></td>
		<td class="delivery-timer">
			<div>
				<a href="javascript:void(0)" onclick="return updatetimeModal({{$area_val->lr_governorate_area_id}})" class="add-time-btn"><span class="glyphicon glyphicon-time"></span>Add Time</a>
			</div>
		</td>
		</tr>
		<?php } ?>
		@endforeach
	
		</tr>
		@endforeach
	</div>
	</tbody>
	</table>
	</div>	
	</div>

	</div>
	</div>
	</div>
	</div>
	</section>

	<!--  -->
	<div id="myModal" class="modal fade readmore-modal-area diet-center-modal" role="dialog">
	<div class="modal-dialog">

	<!-- Modal content-->
	<div class="modal-content">
	<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>

	</div>
	<div class="modal-body">
	<div class="diet-center-header">
	<h3 class="formTitle">Governorate Listing</h3>
	<div class="diet-center-form">
	<div class="col-sm-12 col-md-12 col-xs-12">	
	<div class="service-checkbox">
	<form onsubmit="return save_governorate();" id="areaform" >
	<div class="all-area-chceckbox-row">
	<div class="all-area-chceckbox-heading">	
	<div class="form-group">
	<input type="checkbox" id="all-area-checkbox">
	<label for="all-area-checkbox">All areas</label>
	</div>
	</div>	
	</div>


	
	<div class="all-area-chceckbox-row">
		@foreach($data AS $data_val)
		@php
			$area = DB::table('tbl_lr_governorate_area')->where('lr_governorate_id',$data_val->lr_governorate_id)->where('admin_status','1')->select('lr_governorate_id','lr_governorate_area_id','lr_governorate_area_name')->get();
		@endphp
		<div class="all-area-chceckbox-heading">	
		<div class="padding0 form-group">
		<input type="checkbox" id="maincheck_{{$data_val->lr_governorate_id}}" onclick="return maincheckbox(this.id)" class="allcheckbox">
		<label for="maincheck_{{$data_val->lr_governorate_id}}">{{$data_val->lr_governorate_name}}</label>
		</div>
		</div>
		@foreach($area AS $area_val)
		<div class="all-area-chceckbox-subheading">	
		<div class="form-group ">
				
		<input type="checkbox" name="governorate_area[]" value="{{$area_val->lr_governorate_area_id}}" id="{{$area_val->lr_governorate_area_name}}" class="checkBoxClass allcheckbox maincheck_{{$data_val->lr_governorate_id}}" <?php if(isset($arr_area)){ if(in_array($area_val->lr_governorate_area_id,$arr_area)){   echo 'checked';}} ?> >
		<label for="{{$area_val->lr_governorate_area_name}}" class="">{{$area_val->lr_governorate_area_name}}</label>
		</div>
		</div>
		@endforeach
		@endforeach
	</div>
	<div class="col-md-6">
	<div class="submitButton">
	<div class="form-group">
	<div id="wordCnt" style="color:red"></div>
	</div>
	<button type="submit" class="sbmtbtn">Submit</button>
	</form>
	</div>
	</div>
	</div>

	</div>

	</div>
	</div>

	</div>
	<div class="clearfix"></div>
	</div>

	</div>
	</div>

	<!--  -->












	<!-- update-time-modal-start -->

	<!--  -->
	<div id="updatetimeModal" class="modal fade readmore-modal-area diet-center-modal" role="dialog">
	<div class="modal-dialog">

	<!-- Modal content-->
	<div class="modal-content">
	<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>

	</div>
	<div class="modal-body">
	<div class="update-time-container">


	<div class="form-group" >
	<form  id="delverytime" onsubmit="return add_deliverytime()">
		<input type="hidden" name="vendor_area_id" id="vendor_area_id" value="">
	<div id="TextBoxesGroup">
	<div id="removediv1" >
		<div class="col-sm-5 col-xs-12">
		<label for="">
		<input type="text" name="from[]"  id="from1" onclick="return fortimepicker(this.id);" placeholder="From" maxlength="10" class="form-control from" value="">
		</label>
		</div>
		<div class="col-sm-5 col-xs-12">
		<label for="">
		<input type="text" name="to[]" id="to1" onclick="return fortimepicker(this.id);" placeholder="To" maxlength="10" class="form-control" value="">
		</label>
		</div>
	</div>
	

	<div class="col-sm-2">
	<a title="Add more" href="javascript:void(0);">
	<img src="{{url('/')}}/public/website/img/Add_icon.png" alt="" class="addMorePopIcon">
	</a>
	<a title="Remove" href="javascript:void(0);">
	<img src="{{url('/')}}/public/website/img/cancel2.png" alt="" class="removeMorePopIcon">
	</a>
	</div>
	</div>
	
	<div class="col-md-6">
	<div class="submitButton">
	<div class="form-group">
	<div id="wordCnt1" style="color:red"></div>
	</div>
	
	<button type="submit" class="sbmtbtn">Submit</button>
	</div>
</form>
	</div>
	</div>
	<div class="clearfix"></div>
	</div>
	</div>
	<div class="clearfix"></div>
	</div>

	</div>

	<div id="alertmodal" class="modal fade readmore-modal-area diet-center-modal" role="dialog">
		<div class="modal-dialog">
	
		<!-- Modal content-->
		<div class="modal-content">
		<div class="modal-header">
		<button type="button" class="close" onclick="return hidemodal('alertmodal')">&times;</button>
	
		</div>
		<div class="modal-body">
		<div class="update-time-container" id="alertmsg">
	
	   
		
		</div>
		
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

	<!--  -->
	<!-- update-time-modal-end -->
	@include('Vendor::include.footer')



	<style type="text/css">
	.gj-textbox-md{
	border: none;
	max-width: 120px;
	color: rgb(0, 146, 247);
	}
	.gj-timepicker-md [role=right-icon] {
	cursor: pointer;
	position: absolute;
	right: 0;
	top: 7px;
	color: #0092f7;
	font-size: 20px;
	}
	.update-time-container {
	padding: 40px 0;
	}
	.update-time-container input {
	max-width: 100%;
	border-radius: 0;
	outline: none;
	color: #0092f7;
	border: none;
	border-bottom: solid 1px #0098f9;
	}
	a.add-time-btn {
	display: inline-block;
	background: #5cc0dc;
	padding: 7px 15px;
	color: #fff;
	text-decoration: none;
	}
	a.add-time-btn span {
	padding: 4px;
	}
	</style>




	

	<script>
		function maincheckbox(id)
		{
			if($('#'+id).prop("checked") == true){
				$('.'+id).prop('checked','checked');
            }
            else if($('#'+id).prop("checked") == false){
				$('.'+id).prop('checked',false);
            }

			// $('.'+id).prop('checked','checked');
		}

		$('#all-area-checkbox').click(function(){
			if($(this).prop("checked") == true){
				$('.allcheckbox').prop('checked','checked');
            }
            else if($(this).prop("checked") == false){
                $('.allcheckbox').prop('checked',false);
            }

	
		});

		function save_governorate()
			{    
				$.ajax({    
					headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
					type: 'POST',
					url: "{{url('/vendor/save_governorate_area')}}",
					data:$("#areaform").serialize(),
					success:function(response) 
					{
						console.log(response); // return false;
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

		function updatetimeModal(id)
		{
			$('#vendor_area_id').val('');
			$('#vendor_area_id').val(id);
			$('#updatetimeModal').modal('show');
		}

		function add_deliverytime()
		{   
			 $.ajax({    
			headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
			type: 'POST',
			url: "{{url('/vendor/save_deliverytime')}}",
			data : $("#delverytime").serialize(),
			success:function(response) 
			{
			console.log(response); // return false;
			document.getElementById("wordCnt1").innerHTML="" ; 
			$('#wordCnt1').css('color','green')
			var status = response.status;
			if(status=='200')
			{  
			document.getElementById("wordCnt1").style.color = "green";
			document.getElementById("wordCnt1").innerHTML=response.msg;
			setTimeout(function() { location.reload(true) }, 1000);
			}
			else if(status=='401')
			{
			document.getElementById("wordCnt1").style.color = "#ff0000";
			document.getElementById("wordCnt1").innerHTML=response.msg;
			}
			}
			});
			return false;
			
		}

		function hidemodal(id)
		{
			$('#'+id).modal('hide');	
		}

			function deletebtnrow(rowid)
        {
            $("#rowidd").val(rowid);
            $("#deletebtn").modal("show");
        }

        function deleterow()
        {
            var rowidd =$("#rowidd").val();
            var tblname = 'tbl_lr_vendor_deleverytime';
            var colwhere = 'id';
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

	






	
<link href="https://cdn.rawgit.com/atatanasov/gijgo/master/dist/combined/css/gijgo.min.css" rel="stylesheet" type="text/css" />

<script src="http://personalinjuryinvestigators.com/beta/assets/js/gijgo.js"></script>



	
<style>
	.delivery-timer div {
		margin: 5px 0;
	}
</style>



	