
@include('Admin::common.header')
@include('Admin::common.sidebar')

@php

    $page_name = 'User Report & Problems';
    $total_user = 'Total  Problems';
@endphp

<div class="content-wrapper">
  <section class="content-header">
    <h1>
     {{$page_name}}
      <small>{{$total_user}} :- <?php echo count($data);?></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('lradmin/app/user_report_problem/')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active">{{$page_name}}</li>
    </ol>
  </section>

  <!-- Main content -->
   <section class="content">
    <div class="row">
      <div class="col-md-12">

         <div class="box">


          <div class="box-header">
            <a href="{{url('/lradmin/app/export_report_problem')}}"> <button id="editable-sample_new" class="btn btn-warning btn-flat text-uppercase pull-right">
            <i class="fa fa-file-excel-o"></i> <b>Export Data</b>
            </button></a>
          </div>


          <!-- /.box-header -->
<div class="box-body table-responsive">
<table id="example1" class="table table-bordered table-striped">
    <thead>
    <tr>
    <th>S.No</th>
    <th>Order Id</th>
    <th align="center">Name</th>
    <th align="center">Email</th>
    <th align="center">Title</th>
    <th align="center">Comment</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $i=1;
    foreach($data as $value)
    {
    ?>
    <tr>
    <td>{{$i++}}</td>
    <td>{{ $value->app_order_id }}</td>
    <td>{{ $value->app_report_problem_name }}</td>
    <td>{{ $value->app_report_problem_email }}</td>
    <td>{{ $value->app_report_problem_title }}</td>
    <td>
    @php
     $comment=substr($value->app_report_problem_comment,0,40);
    @endphp
    @if(strlen($value->app_report_problem_comment)>40)
  <?=$comment?>...<a href="javascript:void(0);" class="" id="comment"  comm="<?php echo $value->app_report_problem_comment?>">
        <b>Read More</b>
            </a>
    @else
    <?=$value->app_report_problem_comment?>
    @endif
    </td>
  </tr>
  <?php
    }
  ?>
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
<div class="modal" id="myModal" role="dialog">
       <div class="modal-dialog">

         <!-- Modal content-->
         <div class="modal-content">

           <div class="modal-body">
             <p id="readmoremsg">
             </p>
           </div>
           <div class="modal-footer">
             <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
           </div>
         </div>

       </div>
     </div>


  @include('Admin::common.footer')



  <script language="javascript">
  $(document).ready(function(){

  $('#comment').click(function() {
   var comment=$(this).attr('comm');
    $('#readmoremsg').html(comment);

      $('#myModal').modal('show');

  });




    });

  </script>
