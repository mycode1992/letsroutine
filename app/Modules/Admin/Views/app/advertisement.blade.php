
@include('Admin::common.header')
@include('Admin::common.sidebar')



<div class="content-wrapper">
  <section class="content-header">
    <h1>
     Advertisement
      <small>Total Advertisement :- <?php echo count($data);?></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/lradmin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active">Advertisement</li>
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
                <a href="{{url('/lradmin/app/add-advertisement')}}"> <button id="editable-sample_new" class="btn btn-warning btn-flat text-uppercase pull-right">
                        <i class="fa fa-plus"></i> <b>Add Advertisement</b>
                </button></a>
                </div>
<table id="example1" class="table table-bordered table-striped">
    <thead>
    <tr>
    <th>S.No</th>
    <th>Image</th>
    <th>Title</th>
    <th>Description</th>
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
    $id =$data_val->id;
    $image =$data_val->image;
    $title =$data_val->title;
    $description =$data_val->description;
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
    <tr id="table_<?php echo $id;?>">
    <td>{{$q}}</td>
     <td>
     	<img style="cursor:pointer" src="{{url('/public')}}/admin/upload/advertisement/{{$image}}"  width="100px" height="100px" onClick="return openImgModal('<?php echo url('/public')."/admin/upload/advertisement/$image";?>');">
     </td>

    <td> {{$title}}</td>
    <td>
      <?php
          $string = $description; 
          if(strlen($string) > 100){
              $stringCut = substr($string, 0, 100);
              $endPoint = strrpos($stringCut, ' ');
              $string = $endPoint? substr($stringCut, 0, $endPoint):substr($stringCut, 0);
              $string .= '... <a href="JavaScript:void(0)" onclick="return readmore('.$id.')">Read More</a>';
              echo $string;
          }
          else{
              echo  $string;
          }

       ?>
                           
     </td>
    <td>
      <a href="{{url('/lradmin/app/add-advertisement')}}/{{$id}}">
          <i class="fa fa-pencil"></i>
      </a>
      </td>
    <td id="{{$id}}">

            <a href="javascript:void(0);"  class="btn btn-block {{$success}} btn-flat" onclick="return changestatus(<?php echo $id.','.$admin_status;?>)">                    
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
            var tblname='tbl_app_advertisement';
         var status_val;
         var colwhere = 'id';
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

        function openImgModal(path)
        {
          $("#readmoremsg").html("<img src='"+path+"' style='width: 100%;'>");
          $('#myModal').modal('show');
        }

        function readmore(id)
        {
		    var tblname='tbl_app_advertisement';
		    var colnamewhere = 'id';
		    var colmsg = 'description';
		        
		    $.ajax({
		    headers: {'X-CSRF-Token':'{{ csrf_token() }}'}, 
		    method: "POST",
		    url: "{{url('/lradmin/readmore')}}",
		    data: { id:id, colnamewhere:colnamewhere,tblname:tblname,colmsg:colmsg}

		    })
		    .done(function( response ) {
		    console.log(response);
		    document.getElementById("readmoremsg").innerHTML = response;
		        $('#myModal').modal('show');
		    });
        }

    </script> 