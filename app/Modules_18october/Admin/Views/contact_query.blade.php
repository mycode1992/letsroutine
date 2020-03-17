
@include('Admin::common.header')
@include('Admin::common.sidebar')

<div class="content-wrapper">
  <section class="content-header">
    <h1>
     Contact Query
      <small>Total Query :- <?php echo count($data);?></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/lradmin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active">Contact Query</li>
    </ol>
  </section>

  <!-- Main content -->
   <section class="content">
    <div class="row">
      <div class="col-md-12">

         <div class="box">
     
         
          <div class="box-header">
          <a href="{{url('/export/exportcon_queries')}}"> <button id="editable-sample_new" class="btn btn-warning btn-flat text-uppercase pull-right" onclick="exportoffercategory()">
          <i class="fa fa-file-excel-o"></i> <b>Export Data</b>
          </button></a>
          </div>


          <!-- /.box-header -->
          <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>S.No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
                <th>Date</th>
              </tr>
              </thead>
              <tbody>
                        <?php
                        $q=0;
                        foreach($data as $data_val)
                        {
                        $q++;  
                        $lr_contactus_id =$data_val->lr_contactus_id;
                        $lr_contactus_name =$data_val->lr_contactus_name;
                        $lr_contactus_email =$data_val->lr_contactus_email;
                        $lr_contactus_message =$data_val->lr_contactus_message;
                        $lr_contactus_created_at =$data_val->lr_contactus_created_at;
                        
                        ?>
                        <tr id="table_<?php echo $lr_contactus_id;?>">
                        <td>{{$q}}</td>
                        <td>{{$lr_contactus_name}}</td>
                        <td>{{$lr_contactus_email}}</td>
                        <td>
                          <?php
                              $string = $lr_contactus_message; 
                              if(strlen($string) > 100){
                                  $stringCut = substr($string, 0, 100);
                                  $endPoint = strrpos($stringCut, ' ');
                                  $string = $endPoint? substr($stringCut, 0, $endPoint):substr($stringCut, 0);
                                  $string .= '... <a href="JavaScript:void(0)" onclick="return readmore('.$lr_contactus_id.')">Read More</a>';
                                  echo $string;
                              }
                              else{
                                  echo  $string;
                              }
        
                           ?>
                           
                      </td>
                      <td>{{$lr_contactus_created_at}}</td>
                         
                    
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
    function readmore(id){
    var tblname='tbl_lr_contactus';
    var colnamewhere = 'lr_contactus_id';
    var colmsg = 'lr_contactus_message';
        
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

