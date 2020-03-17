
<?php 
$da = date_default_timezone_set('Asia/Kolkata');
$date='Contact_queries-'.date('Y-m-d-G.i');
header("Content-type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: attachment; filename=$date.xls");
header("Pragma: no-cache");

?>
    
<table cellpadding="1" cellspacing="1" border="1" class="display table table-bordered" id="hidden-table-info"  >
  <thead>
    <tr>
      <th class="center hidden-phone">Sr.No.</th>
      <th class="center hidden-phone">Name</th>
      <th class="center hidden-phone">Email</th>
      <th class="center hidden-phone">Message</th>
      <th class="center hidden-phone">Date</th>
    </tr>
  </thead>
  <tbody>
<?php 


 $data = DB::table('tbl_lr_contactus')->select('lr_contactus_id','lr_contactus_name','lr_contactus_email','lr_contactus_message','lr_contactus_created_at')->orderBy('lr_contactus_id','desc')->get();

 if(count($data)>0)
    {

     $q=0;
         foreach($data as $data_val)
            {
                    $q++;
			$id = $data_val->lr_contactus_id;
			$lr_contactus_name = $data_val->lr_contactus_name;
			$lr_contactus_email = $data_val->lr_contactus_email;
			$lr_contactus_message = $data_val->lr_contactus_message;
			$lr_contactus_created_at = $data_val->lr_contactus_created_at;
          
          ?>

        <tr>
                              <td><?php echo $q ?></td>
                              <td><?php echo $lr_contactus_name;?></td>                           
                              <td><?php echo $lr_contactus_email;?></td>
                              <td> <?php echo $lr_contactus_message;?></td>
                              <td><?php echo $lr_contactus_created_at; ?></td>
                             
                          </tr>
            <?php
            	 }          
              } 

            ?>        
  </tbody>
</table>
