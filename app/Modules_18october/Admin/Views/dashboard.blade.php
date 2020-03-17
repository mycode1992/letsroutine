
 @include('Admin::common.header')
 @include('Admin::common.sidebar')
  <div class="content-wrapper">
  
    <section class="content-header">
      <h1>
        Dashboard
      
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{url('/lradmin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

 
    <section class="content">
      <div class="row">
       <div class="col-md-3 col-sm-6 col-xs-12">
         <div class="info-box">
           <span class="info-box-icon bg-yellow"><i class="fa fa-users"></i></span>
           <div class="info-box-content">
             <a href="{{url('lradmin/vendor/manage-vendor')}}/all_vendor" class="users-list-name"><span class="info-box-text">Total Vendors</span>
             <span class="info-box-number"><?php echo $all_vendor;?></span></a>
           </div>
         </div>
       </div>
       <div class="col-md-3 col-sm-6 col-xs-12">
         <div class="info-box">
           <span class="info-box-icon bg-red"><i class="fa fa-users"></i></span>

           <div class="info-box-content">
             <a href="{{url('lradmin/vendor/manage-vendor')}}/deactive_vendor" class="users-list-name"><span class="info-box-text">Deactive Vendors</span>
             <span class="info-box-number"><?php echo $deactive_vendor;?></span></a>
           </div>
         </div>
       </div>
       <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-green"><i class="fa fa-users"></i></span>

          <div class="info-box-content">
            <a href="{{url('lradmin/vendor/manage-vendor')}}/active_vendor" class="users-list-name"><span class="info-box-text">Active Vendors</span>
            <span class="info-box-number"><?php echo $active_vendor;?></span></a>
          </div>
        </div>
      </div>
     </div>

     <div class="row">
      <!-- Left col -->
   
          <div class="col-md-8">
            <!-- USERS LIST -->
            <div class="box box-danger">
              <div class="box-header with-border">
                <h3 class="box-title">Latest registered Users</h3>

                <div class="box-tools pull-right">
                  <span class="label label-danger"><?php echo count($sql_vendors_latest);?> New Vendors</span>
                 </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body no-padding">
                <ul class="users-list clearfix">
                  <?php
                  $count =0;
                  foreach ($sql_vendors_latest as $value) 
                  {
                    $lr_user_id                 = $value->lr_user_id;
                    $lr_user_name               = ucwords($value->lr_user_name);
                    $lr_user_email              = $value->lr_user_email;
                    $lr_userdetail_phone        = $value->lr_userdetail_phone;
                    $lr_userdetail_centrename   = $value->lr_userdetail_centrename;
                    $lr_userdetail_centreaddr   = $value->lr_userdetail_centreaddr;
                    $lr_userdetail_logo         = $value->lr_userdetail_logo;
                    $lr_userdetail_createdate = $value->lr_userdetail_createdate;
                    $lr_userdetail_createdate = date('d F Y', strtotime($lr_userdetail_createdate));
                    $lr_userdetail_logo = url('/public/vendor/upload/logo').'/'.$lr_userdetail_logo;
                  ?>

                   <li>
                   <img src="<?php echo $lr_userdetail_logo; ?>" alt="Vendor logo" style="width: 89px;height: 87px;">

                    <a class="users-list-name" href="javascript:void(0)" onclick="return ViewVendorInfo('<?=$lr_user_name?>','<?=$lr_user_email?>','<?=$lr_userdetail_phone?>','<?=$lr_userdetail_centrename?>','<?=$lr_userdetail_centreaddr?>','<?=$lr_userdetail_logo?>');"><?php echo $lr_user_name; ?></a>
                    <span class="users-list-date"><?php echo $lr_userdetail_createdate; ?></span>
                  </li>
                  <?php

                    $count++;
                  }
                  ?>
                </ul>
             
              </div>
        
              <div class="box-footer text-center">
               <a href="{{url('lradmin/vendor/manage-vendor')}}/all_vendor" class="btn btn-sm btn-info btn-flat pull-center uppercase">View All Vendors</a>
              </div>
           
            </div>
    </div>

    <div class="col-md-4">
        <div class="info-box bg-aqua">
          <span class="info-box-icon"><i class="fa fa-volume-up"></i></span>
          <div class="info-box-content">
          <a href="{{url('/lradmin/contact-query')}}" class="users-list-name" style="color: #fff;"><span class="info-box-text">Support Queries</span>
            <span class="info-box-number">{{$support_query}}</span></a>
          </div>
        </div>
    </div>

    </div>
    </section>
  
  </div>
  {{-- modal --}}
  <div class="modal fade" id="modal-default">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title text-center">Vendor Information</h4>
          </div>
          <div class="modal-body" id="modal_body">
          
         
          </div>
        
        </div>
       
      </div>
    
    </div>
  {{-- end modal --}}
  
  @include('Admin::common.footer')

  <script>

    
    function ViewVendorInfo(name,email,phone,centrename,centreaddr,logo)
{
  var modal_body = "<div class='box-body box-profile'><img class='profile-user-img img-responsive img-circle' src='"+logo+"' alt='Vendor logo picture'><h3 class='profile-username text-center'>"+name+"</h3><p class='text-muted text-center'>"+phone+"</p><ul class='list-group list-group-unbordered'><li class='list-group-item'><strong>E-mail</strong> <a class='pull-right'><i class='fa fa-envelope'></i> "+email+"</a></li><li class='list-group-item'><strong>Centre Name</strong> <a class='pull-right'><i class='fa fa-pencil-square' aria-hidden='true'></i> "+centrename+"</a></li><li class='list-group-item'><strong>Centre Address</strong> <a class='pull-right'><i class='fa fa-map-marker' aria-hidden='true'></i> "+centreaddr+"</a></li></ul><div class='box-footer text-center'></div></div>";

  $("#modal_body").html(modal_body);
  $('#modal-default').modal({
    show: 'false'
}); 
  
}
  </script>


  
 
 


     