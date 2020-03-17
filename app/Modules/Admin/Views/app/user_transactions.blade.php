
@include('Admin::common.header')
@include('Admin::common.sidebar')

@php

    $page_name = 'User Wallet';
    $total_user = 'Total Transactions';
@endphp

<div class="content-wrapper">
  <section class="content-header">
    <h1>
     {{$page_name}} ({{ $fullname }})
      <small>{{$total_user}} :- <?php echo count($data);?></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/lradmin/app/user/transactions/'.$id)}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active">{{$page_name}}</li>
    </ol>
  </section>

  <!-- Main content -->
   <section class="content">
    <div class="row">
      <div class="col-md-12">
          <?php
          $app_wallet=user_appwallet_get($id);
          $app_wallet_amount=0;
          foreach($app_wallet as $val)
          {
            $app_wallet_amount = $val->app_user_wallet_amount;
          }

          ?>

         <div class="box">
           <div class="" style="margin-left:15px;">
           <h3 class="text-primary">Wallet Balance: <?=$app_wallet_amount;?></h3>
         </div>

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
    <th align="center">Transaction Amount</th>
    <th align="center">Transaction Date</th>
    <th align="center">Transaction Status</th>
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
    <td align="center"><center>{{ $value->app_user_wallet_txn_amount }}</center></td>
    <td align="center">{{ date('Y-m-d', strtotime($value->app_user_wallet_txn_created_time)) }}</td>
    <td align="center">
      <center>
    @if($value->app_user_wallet_txn_staus=='DEBIT')
    <button class="btn btn-info btn-flat text-uppercase pull-right"><b>DEBIT</b></button>
    @elseif($value->app_user_wallet_txn_staus=='CREDIT')
    <button class="btn btn-warning btn-flat text-uppercase pull-right"><b>DEBIT</b></button>
    @else
  <button class="btn btn-danger btn-flat text-uppercase pull-right"><b>RECHEARGE</b></button>
    @endif
  </center>
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
  @include('Admin::common.footer')
