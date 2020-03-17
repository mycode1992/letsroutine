
@include('Admin::common.header')
@include('Admin::common.sidebar')

@php
    if($page_name=='all_vendor')
    {
        $pagename = 'All Vendor';
        $total_user = 'Total User';
    }
    else
    if($page_name=='active_vendor')
    {
        $pagename = 'Active Vendor';
        $total_user = 'Total Active User';
    }
    else
    if($page_name=='deactive_vendor')
    {
        $pagename = 'Deactive Vendor';
        $total_user = 'Total Deactive User';
    }
    
@endphp

<div class="content-wrapper">
  <section class="content-header">
    <h1>
     {{$pagename}}
      <small>{{$total_user}} :- <?php echo count($data);?></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/lradmin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active">{{$pagename}}</li>
    </ol>
  </section>

  <!-- Main content -->
   <section class="content">
    <div class="row">
      <div class="col-md-12">

         <div class="box">
     
         
          <div class="box-header">
          <a href="{{url('/lradmin/export/exportvendor')}}/{{$page_name}}"> <button id="editable-sample_new" class="btn btn-warning btn-flat text-uppercase pull-right" onclick="exportoffercategory()">
          <i class="fa fa-file-excel-o"></i> <b>Export Data</b>
          </button></a>
          </div>


          <!-- /.box-header -->
<div class="box-body table-responsive">
<table id="example1" class="table table-bordered table-striped">
    <thead>
    <tr>
    <th>S.No</th>
    <th>Name</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Diet Centre Logo</th>
    <th>Diet Centre name</th>
    <th>Diet Centre Address</th>
    <th>Plan Details</th>
   
    <th>Meal Details</th>
    <th>Menu Details</th>
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
    $lr_user_id =$data_val->lr_user_id;
    $lr_user_userid =$data_val->lr_user_userid;
    $lr_user_name =$data_val->lr_user_name;
    $lr_user_email =$data_val->lr_user_email;
    $lr_userdetail_phone =$data_val->lr_userdetail_phone;
    $lr_userdetail_centrename =$data_val->lr_userdetail_centrename;
    $lr_userdetail_centreaddr =$data_val->lr_userdetail_centreaddr;
    $lr_userdetail_logo =$data_val->lr_userdetail_logo;
    $lr_user_admin_status=$data_val->lr_user_admin_status;

    $count_plan = DB::table('tbl_lr_vendor_plan')->where('admin_status','!=','2')->where('lr_user_id',$lr_user_userid)->count();

     

      $count_meal = DB::table('tbl_lr_meal')->where('admin_status','!=','2')->where('lr_user_userid',$lr_user_userid)->count();

       $count_menu = DB::table('tbl_lr_vendor_menu')->where('admin_status','!=','2')->where('lr_user_id',$lr_user_userid)->distinct('lr_unique_id')->select('lr_unique_id')->get();
     
    if($lr_user_admin_status=='1')
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
    <tr id="table_<?php echo $lr_user_id;?>">
    <td>{{$q}}</td>
    <td> @php echo ucfirst($lr_user_name); @endphp</td>
    <td>{{$lr_user_email}}</td>
    <td>{{$lr_userdetail_phone}}</td>
    <td><img style="cursor:pointer" src="{{url('/public')}}/vendor/upload/logo/{{$lr_userdetail_logo}}"  width="100px" height="100px" onClick="return openImgModal('<?php echo url('/public')."/vendor/upload/logo/$lr_userdetail_logo";?>');"></td>
    <td>{{$lr_userdetail_centrename}}</td>
    <td>{{$lr_userdetail_centreaddr}}</td>     
    <td><a href="{{url('lradmin/vendor/view-plan')}}/{{$lr_user_userid}}"><button class="btn btn-warning btn-flat text-uppercase pull-right">{{$count_plan}}<i class="fa fa-eye"></i><b> View Details</b></button></a></td>
    

    <td><a href="{{url('lradmin/vendor/view-meal')}}/{{$lr_user_userid}}"><button class="btn btn-warning btn-flat text-uppercase pull-right">{{$count_meal}}<i class="fa fa-eye"></i><b> View Details</b></button></a></td>     

    <td><a href="{{url('lradmin/vendor/view-menu')}}/{{$lr_user_userid}}"><button class="btn btn-warning btn-flat text-uppercase pull-right">{{count($count_menu)}}<i class="fa fa-eye"></i><b> View Details</b></button></a></td> 

    <td>
      <a href="{{url('lradmin/vendor/edit-vendor')}}/{{$lr_user_id}}">
          <i class="fa fa-pencil"></i>
      </a>
              
      
      </td>
    <td id="{{$lr_user_id}}">

            <a href="javascript:void(0);"  class="btn btn-block {{$success}} btn-flat" onclick="return changestatus(<?php echo $lr_user_id.','.$lr_user_admin_status;?>)">                    
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

         function openImgModal(path)
        {
          $("#readmoremsg").html("<img src='"+path+"' style='width: 100%;'>");
          $('#myModal').modal('show');
        }

        function readmore(id){
        var tblname='tbl_lr_contactus';
        var colnamewhere = 'lr_contactus_id';
        var colmsg = 'lr_contactus_message';
            
        $.ajax({
        headers: {'X-CSRF-Token':'{{ csrf_token() }}'}, 
        method: "POST",
        url: "{{url('/iladmin/readmore')}}",
        data: { id:id, colnamewhere:colnamewhere,tblname:tblname,colmsg:colmsg}

        })
        .done(function( response ) {
        console.log(response);
        document.getElementById("readmoremsg").innerHTML = response;
            $('#myModal').modal('show');
        });
        }

         function changestatus(id,status){
            var tblname='tbl_lr_user';
         var status_val;
         var colwhere = 'lr_user_id';
         var colstatus = 'lr_user_admin_status';
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

