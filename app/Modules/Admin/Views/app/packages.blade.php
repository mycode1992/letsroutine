
@include('Admin::common.header')
@include('Admin::common.sidebar')



<div class="content-wrapper">
  <section class="content-header">
    <h1>
     Packages
      <small>Total Packages :- <?php echo count($data);?></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/lradmin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active">Packages</li>
    </ol>
  </section>

  <!-- Main content -->
   <section class="content">
    <div class="row">
      <div class="col-md-12">

         <div class="box">
          <!-- /.box-header -->
<div class="box-body">
        <div class="box-header">
                <a href="{{url('/lradmin/app/add-packages')}}"> <button id="editable-sample_new" class="btn btn-warning btn-flat text-uppercase pull-right">
                        <i class="fa fa-plus"></i> <b>Add Packages</b>
                </button></a>
        </div>
<table id="example1" class="table table-bordered table-striped">
    <thead>
    <tr>
    <th>S.No</th>
    <th>Name</th>
    <th>Description</th>
    <th>Gender</th>
    <th>Delivery Time</th>
    <th>Price</th>
    <th>Plan Details</th>
    <th>Action</th>
    <th>Status</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $q=0;
    foreach($data as $data_val)
    {
    $q++;           
    $lr_package_id =$data_val->lr_package_id;
    $package_name =$data_val->package_name;
    $package_description =$data_val->package_description;
    $package_gender =$data_val->package_gender;
    $delivery_time =$data_val->delivery_time;
    $package_price =$data_val->package_price;
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
    <tr id="table_<?php echo $lr_package_id;?>">
    <td>{{$q}}</td>
    <td> @php echo ucfirst($package_name); @endphp</td>
    <td> {{$package_description}} </td>
    <td> {{$package_gender}} </td>
    <td> {{$delivery_time}} </td>
    <td> {{$package_price}} </td>
    <td> View Details </td>
    <td>
      <a href="{{url('/lradmin/app/edit-plan-filter')}}/{{$lr_package_id}}">
          <i class="fa fa-pencil"></i>
      </a>
      </td>
    <td id="{{$lr_package_id}}">

            <a href="javascript:void(0);"  class="btn btn-block {{$success}} btn-flat" onclick="return changestatus(<?php echo $lr_package_id.','.$admin_status;?>)">                    
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
              <p id="readmoremsg"></p>
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
            var tblname='tbl_lr_package';
         var status_val;
         var colwhere = 'lr_package_id';
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

    </script> 

