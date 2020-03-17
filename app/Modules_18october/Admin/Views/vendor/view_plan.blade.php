
@include('Admin::common.header')
@include('Admin::common.sidebar')


<div class="content-wrapper">
  <section class="content-header">
    <h1>
     {{$vendor_name}}'s
      <small>Total Plan:- <?php echo count($data);?></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/lradmin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active"> {{$vendor_name}}</li>
    </ol>
  </section>

  <!-- Main content -->
   <section class="content">
    <div class="row">
      <div class="col-md-12">

         <div class="box">
     
          <div class="box-header">
          <a href="#"> <button id="editable-sample_new" class="btn btn-warning btn-flat text-uppercase pull-right" onclick="goBack()">
         <b>Go Back</b>
          </button></a>
          </div>
         

          <!-- /.box-header -->
<div class="box-body table-responsive">
<table id="example1" class="table table-bordered table-striped">
    <thead>
    <tr>
    <th>S.No</th>
    <th>Name</th>
    <th>Meals</th>
		<th>Snacks</th>
		<th>Macros (Carb, Protein)</th>
		<th>Min carb</th>
		<th>Max carb</th>
		<th>Min Protein</th>
        <th>Max Protein</th>     
        <th>Max carb</th> 
        <th>Max protien</th> 
		<th>Per meal or once for the whole plan period</th>
		<th>Gender</th>
		<th>Maximum number of days users can pause their plan</th>
		<th>Categories</th>
        <th>Subcategory</th>
        <th>Plan duration in terms of days</th>
		<th>Off days for the current plan</th>
		<th>Does the plan follow a custom menu where users can choose from or a fixed Menu</th>
		<th>Menu that represents the current plan</th>
    <th>Status</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $q=0;
    foreach($data as $data_val)
    {            
    $q++;           
    $vendor_plan_id = $data_val->vendor_plan_id;
    $vendor_plan_name = $data_val->vendor_plan_name;
    $admin_status =$data_val->admin_status;
  
    if($data[0]->macros_yes_plan=='-1')
            {
                $data[0]->macros_yes_plan = 'N/A';
            }
            $category = $data[0]->lr_plancategory_id;
            $category =  DB::table('tbl_lr_plancategory')->where('lr_plancategory_id',                      $category)->select('lr_plancategory_name')->get();
            $subcategory = $data[0]->lr_plan_subcat_id;
            $subcategory =  DB::table('tbl_lr_plansubcategory')->where('lr_plan_subcat_id',                      $subcategory)->select('lr_plan_subcat_name')->get();

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
    <tr id="table_<?php echo $vendor_plan_id;?>">
    <td>{{$q}}</td>
    <td> @php echo ucfirst($vendor_plan_name); @endphp</td>
    <td>{{$data[0]->vendor_plan_meals}}</td>
		<td>{{$data[0]->vendor_plan_snacks}}</td>
		<td>{{$data[0]->vendor_plan_macros}}</td>
		<td>{{$data[0]->macros_yes_min_carb}}</td>
        <td>{{$data[0]->macros_yes_max_carb}}</td>
        <td>{{$data[0]->macros_yes_min_protein}}</td>
        <td>{{$data[0]->macros_yes_max_protein}}</td>
        <td>{{$data[0]->macros_no_max_carb}}</td>
        <td>{{$data[0]->macros_no_max_protein}}</td>
        <td>{{$data[0]->macros_yes_plan}}</td>
        <td>{{$data[0]->vendor_plan_gendor}}</td>
        <td>{{$data[0]->vendor_plan_pause}}</td>
        <td>{{$category[0]->lr_plancategory_name}}</td>
        <td>{{$subcategory[0]->lr_plan_subcat_name}}</td>
        <td>{{$data[0]->vendor_plan_duration}}</td>
        <td>{{$data[0]->vendor_plan_offdays}}</td>
        <td>{{$data[0]->vendor_plan_menu_type}}</td>
        <td>{{$data[0]->custom_menu_vendor_menu_id}}</td>
    <td id="{{$vendor_plan_id}}">

            <a href="javascript:void(0);"  class="btn btn-block {{$success}} btn-flat" onclick="return changestatus(<?php echo $vendor_plan_id.','.$admin_status;?>)">                    
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

<script>
    function goBack() {
      window.history.back();
    }
    </script>

