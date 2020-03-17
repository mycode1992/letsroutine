
@include('Admin::common.header')
@include('Admin::common.sidebar')



<div class="content-wrapper">
  <section class="content-header">
    <h1>
    {{$governorate_name[0]->lr_governorate_name}}'s area
      <small>Total Area :- <?php echo count($data);?></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/lradmin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active">{{$governorate_name[0]->lr_governorate_name}}'s area</li>
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
        <a href="{{url('/lradmin/cms/add-area')}}/{{$governorate_name[0]->lr_governorate_id}}"> <button id="editable-sample_new" class="btn btn-warning btn-flat text-uppercase pull-right">
                        <i class="fa fa-plus"></i> <b>Add Area</b>
                </button></a>
                </div>
<table id="example1" class="table table-bordered table-striped">
    <thead>
    <tr>
    <th>S.No</th>
    <th>Name</th>
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
    $lr_governorate_area_id =$data_val->lr_governorate_area_id;
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
    <tr id="table_<?php echo $lr_governorate_area_id;?>">
    <td>{{$q}}</td>
    <td> @php echo ucfirst($lr_governorate_area_name); @endphp</td>
    <td>
    <a href="{{url('lradmin/cms/edit-area')}}/{{$governorate_name[0]->lr_governorate_id}}/{{$lr_governorate_area_id}}">
          <i class="fa fa-pencil"></i>
      </a>
      </td>
    <td id="{{$lr_governorate_area_id}}">

            <a href="javascript:void(0);"  class="btn btn-block {{$success}} btn-flat" onclick="return changestatus(<?php echo $lr_governorate_area_id.','.$admin_status;?>)">                    
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

    
      @include('Admin::common.footer')
    <script language="javascript">

         function changestatus(id,status){
            var tblname='tbl_lr_governorate_area';
         var status_val;
         var colwhere = 'lr_governorate_area_id';
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

