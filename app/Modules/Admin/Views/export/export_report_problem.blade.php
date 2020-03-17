<?php
$da = date_default_timezone_set('Asia/Kolkata');
$date='User_report_problem'.'-'.date('Y-m-d-G.i');
header("Content-type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: attachment; filename=$date.xls");
header("Pragma: no-cache");
?>
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
    <?=$value->app_report_problem_comment?></td>
  </tr>
  <?php
    }
  ?>
            </tbody>
            </table>
