
@include('Admin::common.header')
@include('Admin::common.sidebar')

@php

    $page_name = 'User Orders';
    $total_user = 'Total Orders';
@endphp

<div class="content-wrapper">
  <section class="content-header">
    <h1>
     {{$page_name}}  ({{ $fullname }})
      <small>{{$total_user}} :- <?php echo count($data);?></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/lradmin/app/user_orders/'.$id)}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active">{{$page_name}}</li>
    </ol>
  </section>

  <!-- Main content -->
   <section class="content">
    <div class="row">
      <div class="col-md-12">

         <div class="box">


          <div class="box-header">
          <a href="{{url('lradmin/app/user-list/all_user')}}"> <button id="editable-sample_new" class="btn btn-warning btn-flat text-uppercase pull-right">
          <i class="fa fa-user"></i> <b>Back</b>
          </button></a>
          </div>


          <!-- /.box-header -->
<div class="box-body table-responsive">
<table id="example1" class="table table-bordered table-striped">
    <thead>
    <tr>
    <th>S.No</th>
    <th align="center">Order Id</th>
    <th align="center">User Id </th>
    <th align="center">Report & Problem</th>
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
    <td>{{ $value->app_order_unique_id }}</td>
    <td>{{ $value->user_uniqueid }}</td>
    <td><a href="{{ url('lradmin/app/user_report_problem/'.$id.'/'.$value->app_order_unique_id) }}"><button class="btn btn-warning btn-flat text-uppercase pull-left">{{ user_reportproblem_count($id,$value->app_order_unique_id) }}<i class="fa fa-eye"></i><b> View Details</b></button></a></td>
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
  @include('Admin::common.footer')
