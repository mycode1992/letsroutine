	@include('Vendor::include.header')
	@include('Website::include.error')


	<section class="myDashboard">
	<div class="container">
	<div class="row">
	@include('Vendor::include.sidebar')
	<div class="col-md-9">
	<div class="rightBox">
	<div class="headFlex">
	<h3 class="formTitle">Report A Problem</h3>
	<div class="addBtn">
	<a href="#" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Add Report</a>
	</div>
	</div>


	<div class="current-order-table">

	<div class="table-responsive">          
	<table class="table">
	<thead>
	<tr>
	<th>S.No</th>
	<th>Name</th>
	<th>Title</th>
	<th style="width:50%;">Description</th>
	<th>Date</th>
	</tr>
	</thead>
	<tbody>
	@php $sn = 0;  @endphp
	@foreach($data AS $data_val)
	@php $sn++;  @endphp
	<tr class="even-row">
	<td>{{$sn}}</td>
	<td>{{$data_val->lr_name}}</td>
	<td>{{$data_val->lr_title}}</td>									
	<td class="meal-description">
	<?php $string = $data_val->lr_problem;
	if (strlen($string) > 100) {
	 $stringCut = substr($string, 0, 100);
	 $endPoint = strrpos($stringCut, ' ');
 
	 //if the string doesn't contain any space then it will cut without word basis.
	 $string = $endPoint? substr($stringCut, 0, $endPoint):substr($stringCut, 0);
	 $string .= '... <a href="JavaScript:void(0)" onclick="return readmore('.$data_val->lr_id.')">Read More</a>';
 	}
 	echo $string; 
 ?>
	</td>
	<td><?php echo date(date('Y-m-d',strtotime($data_val->lr_date))); ?></td>
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

	<div id="myModal" class="modal fade readmore-modal-area" role="dialog">
		<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>

		</div>
		<div class="modal-body">
		<div class="report-problem-modal">
		<h3 class="formTitle">Report A Problem</h3>
		<div class="add-problem-form">
		<form onsubmit="return save_problem()">
		<div class="col-md-12">
		<div class="form-group">
		<label for="">Name<span>*</span></label>
		<input type="text" name="name" id="name" class="form-control">
		</div>
		</div>
		<div class="col-md-12">
		<div class="form-group">
		<label for="">Title<span>*</span></label>
		<input type="text" name="title" id="title" class="form-control">
		</div>
		</div>

		<div class="col-md-12">
		<div class="form-group">
		<label for="">Description<span>*</span></label> 
		<textarea name="report_problem" id="report_problem" cols="5" rows="5" class="form-control"></textarea>
		</div>
		</div>

		<div class="col-md-6">
		<div class="submitButton">
		<div class="form-group">
		<div id="wordCnt" style="color:red"></div>
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


	<style type="text/css">

	</style>
	@include('Vendor::include.footer')	
	<script>

	function readmore(id)
	{
	
	var tblname='tbl_lr_report_prbl';
	var colnamewhere = 'lr_id';
	var colmsg = 'lr_problem';

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


	function save_problem()
	{    
		var name = document.getElementById("name").value.trim();
		var title = document.getElementById("title").value.trim();
		var description = document.getElementById("report_problem").value.trim();
		if(name=="")
			{
				document.getElementById('name').style.border='1px solid #ff0000';
				document.getElementById("name").focus();
				$('#name').val('');
				$('#name').attr("placeholder", "Please enter  name");
				$("#name").addClass( "errors" );
				return false;
			}
			else
			{
				document.getElementById("name").style.border = "";   
			}

		if(title=="")
			{
				document.getElementById('title').style.border='1px solid #ff0000';
				document.getElementById("title").focus();
				$('#title').val('');
				$('#title').attr("placeholder", "Please enter  title");
				$("#title").addClass( "errors" );
				return false;
			}
			else
			{
				document.getElementById("title").style.border = "";   
			}
			if(description=="")
			{
				document.getElementById('report_problem').style.border='1px solid #ff0000';
				document.getElementById("report_problem").focus();
				$('#report_problem').val('');
				$('#report_problem').attr("placeholder", "Please enter description");
				$("#report_problem").addClass( "errors" );
				return false;
			}
			else
			{
				document.getElementById("report_problem").style.border = "";   
			}
		
	
		var form = new FormData();
		form.append('name',name);
		form.append('title',title);
		form.append('description',description);
		$('#wordCnt').css('color','#333333');
		$('#wordCnt').text('Please wait');  	
		$.ajax({
			headers: {'X-CSRF-Token' : '{{ csrf_token() }}'},
			type: 'POST',
			url: "{{url('/vendor/save_problem')}}",
			data: form,
			contentType: false,
			processData: false,
			success:function(response)
			{
				
				$('#wordCnt').text('');
				if(response.status=='200')
				{
					$('#wordCnt').css('color','green');
					$('#wordCnt').text(response.msg);   
					setTimeout(function(){
						location.reload(true) 
					},2000);
				}
				else if(response.status=='401')
				{
					$('#wordCnt').css('color','red');
					$('#wordCnt').text(response.msg);
				}
			}
		}); 

		return false;
	}
	</script>