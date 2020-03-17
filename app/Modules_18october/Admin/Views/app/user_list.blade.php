
@include('Admin::common.header')
@include('Admin::common.sidebar')

@php
    $page_name = 'User List';
    $total_user = 'Total User';
@endphp

<div class="content-wrapper">
  <section class="content-header">
    <h1>
     {{$page_name}}
      <small>{{$total_user}} :- <?php echo count($user_list);?></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/lradmin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active">{{$page_name}}</li>
    </ol>
  </section>

  <!-- Main content -->
   <section class="content">
    <div class="row">
      <div class="col-md-12">

         <div class="box">
     
         
          <div class="box-header">
          <a href="{{url('/lradmin/export/exportuser')}}/{{$page_name}}"> <button id="editable-sample_new" class="btn btn-warning btn-flat text-uppercase pull-right">
          <i class="fa fa-file-excel-o"></i> <b>Export Data</b>
          </button></a>
          </div>


          <!-- /.box-header -->
<div class="box-body table-responsive">
<table id="example1" class="table table-bordered table-striped">
    <thead>
    <tr>
    <th>S.No</th>
    <th>First Name</th>
    <th>Last Name</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Gender</th>
    <th>Date Of Birth</th>
    <th>Area</th>
    <th>Address Detail</th>
    <th>Status</th>
    </tr>
    </thead>
    <tbody>
    <?php  
    $q=0;
    foreach($user_list as $data_val)
    {
    $q++;            
    $user_uniqueid =$data_val->user_uniqueid;
    $app_user_fname =$data_val->app_user_fname;
    $app_user_lname =$data_val->app_user_lname;
    $app_user_phone =$data_val->app_user_phone;
    $app_user_email =$data_val->app_user_email;
    $app_user_gender =$data_val->app_user_gender;
    $app_user_dob =$data_val->app_user_dob;
    $lr_governorate_area_name =$data_val->lr_governorate_area_name;
    $admin_status =$data_val->admin_status;

    if($admin_status=='1')
    {
    $success='btn-success';
    $butttext='ACTIVE';
    }
    else
    {
    $success='btn-danger';
    $butttext='DEACTIVE';
    }
    
    ?>
    <tr id="table_<?php echo $user_uniqueid;?>">
    <td>{{$q}}</td>
    <td> @php echo ucfirst($app_user_fname); @endphp</td>
    <td> @php echo ucfirst($app_user_lname); @endphp</td>
    <td>{{$app_user_email}}</td>
    <td>{{$app_user_phone}}</td>
    <td>{{$app_user_gender}}</td>
    <td>{{$app_user_dob}}</td>
    <td>{{$lr_governorate_area_name}}</td>
    <td> <a href="javascript:void(0);"  onclick="return get_user_address_detail('<?php echo $user_uniqueid?>')">
          View Detail
            </a> </td>
    <td id="{{$user_uniqueid}}">

            <a href="javascript:void(0);"  class="btn btn-block {{$success}} btn-flat" onclick="return changestatus(<?php echo $user_uniqueid.','.$admin_status;?>)">                    
                    {{$butttext}}
                    </a> 
        </td>        
    </tr>
    <?php   }  ?>

                     

                       
                        
                      </tbody>
            </table>
          </div>
          <!-- /.box-body -->
        </div>

      </div>
      <!-- /.col-->
    </div>
    <!-- ./row -->
  </section>
  <!-- /.content -->
</div>
 <!-- Modal -->

 <div class="modal" id="myModal" role="dialog">
        <div class="modal-dialog">
        
          <!-- Modal content-->
          <div class="modal-content">
            
            <div class="modal-body">
              <p id="readmoremsg">
                 <div id="addr_title" ></div>
                  <div id="addr_block" ></div>
                  <div id="addr_street" ></div>
                  <div id="addr_avenue" ></div>
                 <div id="addr_house" ></div>
                 <div id="addr_phone" ></div>
              </p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
          
        </div>
      </div>
      <!-- /.modal -->
      @include('Admin::common.footer')
    <script language="javascript">
         
         function changestatus(id,status){
         var tblname='tbl_app_user';
         var status_val;
         var colwhere = 'user_uniqueid	';
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
		  tempstr="ACTIVE";
		  color="btn-success";
		}

		if(status==1)
		{
		  tempst=0;
		  tempstr="DEACTIVE";
		  color="btn-danger";
		}
      
		$("#"+id).html("<a href='javascript:void(0);' class='btn btn-block "+color+"' onclick='changestatus("+id+","+tempst+")'>"+tempstr+"</a>");


		   });
        }

        function get_user_address_detail(user_uniqueid)
        {
            var form = new FormData();          
            form.append('user_uniqueid',user_uniqueid);

            $.ajax({
            headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
            type:"POST",
            url:"{{url('/lradmin/app/get_user_address_detail')}}",
            data: form,
            contentType: false,
            cache: false,
            processData:false,
            success:function(response) 
            {     // console.log();  return false;

            var status = response.status;
            if(status=='200')
            {  
                $('#addr_title').text("Address Title - "+response.user_address_detail[0].app_user_add_title);
                $('#addr_block').text("Address Block - "+response.user_address_detail[0].app_user_add_block);
                $('#addr_street').text("Address Street - "+response.user_address_detail[0].app_user_add_street);
                $('#addr_avenue').text("Address Avenue - "+response.user_address_detail[0].app_user_add_avenue);
                $('#addr_house').text("Address House - "+response.user_address_detail[0].app_user_add_house);
                $('#addr_phone').text("Address Phone - "+response.user_address_detail[0].app_user_add_phone);
                $('#myModal').modal('show');
            
            return false;
            }
            else if(status == '401')
            {
            alert(response.msg);
            setTimeout(function() { location.reload(true) }, 1000);
            }
            }
            });
        }

    </script> 

