
@include('Admin::common.header')
@include('Admin::common.sidebar')



<div class="content-wrapper">
  <section class="content-header">
    <h1>
     Promo Code
      <small>Total Promo Code :- <?php echo count($data);?></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/lradmin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active">Promo Code</li>
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
                <a href="{{url('/lradmin/app/add-promo-code')}}"> <button id="editable-sample_new" class="btn btn-warning btn-flat text-uppercase pull-right">
                        <i class="fa fa-plus"></i> <b>Add Promo Code</b>
                </button></a>
                </div>
<table id="example1" class="table table-bordered table-striped">
    <thead>
    <tr>
    <th>S.No</th>
    <th>Price</th>
    <th>Promo Code</th>
    <th>User</th>
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
    $promocode_id =$data_val->promocode_id;
    $promocode =$data_val->promocode;
    $promocode_user =$data_val->promocode_user;
    $amount =$data_val->amount;
    $admin_status =$data_val->promocode_status;

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
    <tr id="table_<?php echo $promocode_id;?>">
    <td>{{$q}}</td>
    <td> {{$amount}}</td>
    <td> {{$promocode}}</td>
    <td> {{$promocode_user}}</td>
    <td>
      <a href="{{url('/lradmin/app/add-promo-code')}}/{{$promocode_id}}">
          <i class="fa fa-pencil"></i>
      </a>
      </td>
    <td id="{{$promocode_id}}">

            <a href="javascript:void(0);"  class="btn btn-block {{$success}} btn-flat" onclick="return changestatus(<?php echo $promocode_id.','.$admin_status;?>)">                    
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
            var tblname='tbl_app_promocode';
         var status_val;
         var colwhere = 'promocode_id';
         var colstatus = 'promocode_status';
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