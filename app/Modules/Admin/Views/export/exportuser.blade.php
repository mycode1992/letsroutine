
<?php 
$da = date_default_timezone_set('Asia/Kolkata');
$date=$page_name.'-'.date('Y-m-d-G.i');
header("Content-type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: attachment; filename=$date.xls");
header("Pragma: no-cache");

?>
    
<table cellpadding="1" cellspacing="1" border="1" class="display table table-bordered" id="hidden-table-info"  >
  <thead>
    <tr>
            <th>S.No</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Gender</th>
            <th>Date Of Birth</th>
            <th>Area</th>
            <th>Status</th>
    </tr>
  </thead>
  <tbody>
<?php 

 if(count($data)>0)
    {

     $q=0;
         foreach($data as $data_val)
            {
                    $q++;
                    $user_uniqueid =$data_val->user_uniqueid;
                    $app_user_fname =$data_val->app_user_fname;
                    $app_user_lname =$data_val->app_user_lname;
                    $app_user_phone =$data_val->app_user_phone;
                    $app_user_email =$data_val->app_user_email;
                    $app_user_gender =$data_val->app_user_gender;
                    $app_user_dob =$data_val->app_user_dob;
                    $lr_governorate_area_name =$data_val->lr_governorate_area_name;
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

        <tr>
        <td>{{$q}}</td>
        <td> @php echo ucfirst($app_user_fname); @endphp</td>
        <td> @php echo ucfirst($app_user_lname); @endphp</td>
        <td>{{$app_user_email}}</td>
        <td>{{$app_user_phone}}</td>
        <td>{{$app_user_gender}}</td>
        <td>{{$app_user_dob}}</td>
        <td>{{$lr_governorate_area_name}}</td>
        <td id="{{$user_uniqueid}}">
    
                <a href="javascript:void(0);"  class="btn btn-block {{$success}} btn-flat">{{$butttext}} </a> 
            </td>        
        </tr>
            <?php
            	 }          
              } 

            ?>        
  </tbody>
</table>
