
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
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Diet Centre name</th>
            <th>Diet Centre Address</th>
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
                    $lr_user_id =$data_val->lr_user_id;
                        $lr_user_name =$data_val->lr_user_name;
                        $lr_user_email =$data_val->lr_user_email;
                        $lr_userdetail_phone =$data_val->lr_userdetail_phone;
                        $lr_userdetail_centrename =$data_val->lr_userdetail_centrename;
                        $lr_userdetail_centreaddr =$data_val->lr_userdetail_centreaddr;
                        $lr_user_admin_status=$data_val->lr_user_admin_status;

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

        <tr>
            <td><?php echo $q ?></td>
            <td> @php echo ucfirst($lr_user_name); @endphp</td>
            <td>{{$lr_user_email}}</td>
            <td>{{$lr_userdetail_phone}}</td>
            <td>{{$lr_userdetail_centrename}}</td>
            <td>{{$lr_userdetail_centreaddr}}</td>
            <td id="{{$lr_user_id}}">
            <a href="javascript:void(0);"  class="btn btn-block {{$success}} btn-flat" onclick="return changestatus(<?php echo $lr_user_id.','.$lr_user_admin_status;?>)">                    
            {{$butttext}}
            </a> 
                </td>
        </tr>
            <?php
            	 }          
              } 

            ?>        
  </tbody>
</table>
