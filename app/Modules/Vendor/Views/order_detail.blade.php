
@include('Vendor::include.header')



<section class="myDashboard">
	<div class="container">
		<div class="row">
				@include('Vendor::include.sidebar')
		
			<div class="col-md-9">
				<div class="rightBox">
					<h3 class="formTitle">Order Detail</h3>
						
					<div class="current-order-table">
						                       
						<div class="table-responsive">          
							<table class="table">
								<thead>
									<tr>
										<th>S.No</th>
										<th>Date</th>
										<th>Meal detials</th>
									</tr>
								</thead>
								<tbody>
								@php($i = 0)
								@foreach($calender_list_sql as $calender_list)
									<tr class="even-row">
										<td>{{++$i}}</td>
										<td>{{$calender_list->vendor_plandetail_date}}</td>
										
										<td><a href="javascript:void(0);" class="btn btn-primary btn-flat text-uppercase pull-right"  onclick="return get_user_meal_detail('<?php echo $calender_list->pre_order_calender_id; ?>')" >View Details</a>
	               </div></td>	
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

<div class="modal" id="myModal" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">

            <div class="modal-body">
              <p id="readmoremsg">
              </p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>

        </div>
      </div>

@include('Vendor::include.footer')

 <script type="text/javascript">
 	function get_user_meal_detail(pre_order_calender_id)
        {
            var form = new FormData();
            form.append('pre_order_calender_id',pre_order_calender_id);

            $.ajax({
            headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
            type:"POST",
            url:"{{url('/vendor/order/get_user_meal_detail')}}",
            data: form,
            contentType: false,
            cache: false,
            processData:false,
            success:function(response)
            {     // console.log(response);  return false;

            var status = response.status;
            if(status=='200')
            {
              var html='';
              for(var i =0;i <response.user_ordermeal_detail.length;i++)
              {
    			html+='<b>Category Name '+(i+1)+'</b><br><div>'+response.user_ordermeal_detail[i].lr_category_name+', ( Meal Name -'+response.user_ordermeal_detail[i].lr_meal_name+'),( Calories - ) '+response.user_ordermeal_detail[i].lr_meal_calories+' ), ( Fat - '+response.user_ordermeal_detail[i].lr_meal_fat+' ),( Card - ) '+response.user_ordermeal_detail[i].lr_meal_carb+' ),( Protein - ) '+response.user_ordermeal_detail[i].lr_meal_protein+' ),( Max Card -  '+response.user_ordermeal_detail[i].max_meal_carb+'),( Max Protein -  '+response.user_ordermeal_detail[i].max_meal_protein+'</div><br>';


              }

              $('#readmoremsg').html(html);

                $('#myModal').modal('show');

            return false;
            }
            else if(status == '401')
            {
            //alert(response.msg);
            $('#notmsg').html(response.msg);
            $('#alertmyModal').modal('show');

            //setTimeout(function() { location.reload(true) }, 1000);
            }
            }
            });
        }
 </script>