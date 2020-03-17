
@include('Vendor::include.header')



<section class="myDashboard">
	<div class="container">
		<div class="row">
				@include('Vendor::include.sidebar')
		
			<div class="col-md-9">
				<div class="rightBox">
					<h3 class="formTitle">Current orders</h3>
						
					<div class="current-order-table">
						                       
						<div class="table-responsive">          
							<table class="table">
								<thead>
									<tr>
										<th>S.No</th>
										<th>Order number</th>
										<th>User name</th>
										<th>Order date</th>
										<th>Address</th>
										<th>Order detials</th>
									</tr>
								</thead>
								<tbody>
								@php($i = 0)
								@foreach($order_list_sql as $order_list)
                @php
                  $current_order_sql = DB::table('tbl_app_pre_order_calender')
                   ->whereDate('vendor_plandetail_date','>=',$curDate)->where('app_pre_order_id',$order_list->app_pre_order_id)->get();
                  if( count($current_order_sql) > 0 )
                  {
                @endphp
									<tr class="even-row">
										<td>{{++$i}}</td>
										<td>{{$order_list->app_order_unique_id}}</td>
										<td>{{$order_list->app_user_fname}} {{$order_list->app_user_lname}}</td>
										<td>{{$order_list->created_at}}</td>
										<td><a href="javascript:void(0);" class="btn btn-primary btn-flat text-uppercase pull-right"  onclick="return get_user_address_detail('<?php echo $order_list->app_pre_order_id; ?>')" >View Details</a>
	</div></td>
										<td><span class="order-detail-icon"><a href="{{url('/vender/order-detail')}}/{{$order_list->app_pre_order_id}}"><i class="fa fa-angle-right"></i></a></span></td>
									</tr>
                  @php } @endphp
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
 	function get_user_address_detail(app_pre_order_id)
        {
            var form = new FormData();
            form.append('app_pre_order_id',app_pre_order_id);

            $.ajax({
            headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
            type:"POST",
            url:"{{url('/vendor/get_user_address_detail')}}",
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
              for(var i =0;i <response.user_address_detail.length;i++)
              {
    			html+='<b>Address '+(i+1)+'</b><br><div id="addr_title" >'+response.user_address_detail[i].app_pre_order_addr_title+', '+response.user_address_detail[i].app_pre_order_addr_areaname+', '+response.user_address_detail[i].app_pre_order_addr_block+', '+response.user_address_detail[i].app_pre_order_addr_street+', '+response.user_address_detail[i].app_pre_order_addr_avenue+', '+response.user_address_detail[i].app_pre_order_addr_house+', '+response.user_address_detail[i].app_pre_order_addr_phone+'</div><br>';


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