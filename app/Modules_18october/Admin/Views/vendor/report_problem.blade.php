
@include('Admin::common.header')
@include('Admin::common.sidebar')

<div class="content-wrapper">
  <section class="content-header">
    <h1>
     Report Problem
      <small>Total Problem :- <?php echo count($data);?></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/lradmin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active">Report Problem</li>
    </ol>
  </section>

  <!-- Main content -->
   <section class="content">
    <div class="row">
      <div class="col-md-12">
         <div class="box">
          <!-- /.box-header -->
          <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>S.No</th>
                <th>Name</th>
                <th>Title</th>
                <th>Description</th>
                <th>Date</th>
              </tr>
              </thead>
              <tbody>
                        <?php
                        $q=0;
                        foreach($data as $data_val)
                        {
                        $q++;  
                     
                        
                        ?>
                        <tr id="table_<?php echo $data_val->lr_id;?>">
                        <td>{{$q}}</td>
                        <td>{{$data_val->lr_name}}</td>
                        <td>{{$data_val->lr_title}}</td>
                        <td>
                          <?php
                              $string = $data_val->lr_problem; 
                              if(strlen($string) > 100){
                                  $stringCut = substr($string, 0, 100);
                                  $endPoint = strrpos($stringCut, ' ');
                                  $string = $endPoint? substr($stringCut, 0, $endPoint):substr($stringCut, 0);
                                  $string .= '... <a href="JavaScript:void(0)" onclick="return readmore('.$data_val->lr_id.')">Read More</a>';
                                  echo $string;
                              }
                              else{
                                  echo  $string;
                              }
        
                           ?>
                           
                      </td>
                      <td><?php echo date(date('Y-m-d',strtotime($data_val->lr_date))); ?></td>
                         
                    
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
    var tblname='tbl_lr_report_prbl';
    var colnamewhere = 'lr_id';
    var colmsg = 'lr_problem';
        
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

