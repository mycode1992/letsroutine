<?php  
  $url = Request::segment(3);
  $url1 = Request::segment(4);
 ?> 
<aside class="main-sidebar">
    <section class="sidebar">
   
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{url('/public')}}/admin/img/Routine_logo_white.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Admin</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
    
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN MENU</li>
         <li ><a href="{{url('lradmin/dashboard')}}"><i class="fa fa-dashboard"></i> <span>DASHBOARD</span></a></li>
         <li class="treeview <?php if($url  =="about-us" || $url  =="terms-condition"  || $url  =="privacy-policy" || $url  =="faq" || $url  =="governorate"){echo 'active';}?>">

          <a href="#"><i class="fa fa-folder"></i> <span>CMS MANAGEMENT</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-right pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
             <li <?php if($url  =="about-us"){echo 'class="active"';}?>><a href="{{url('lradmin/cms/about-us')}}"><i class="fa fa-chevron-right"></i> <span>About-Us </span></a></li>
             <li <?php if($url  =="terms-condition"){echo 'class="active"';}?>><a href="{{url('lradmin/cms/terms-condition')}}"><i class="fa fa-chevron-right"></i> <span>Terms & Condition </span></a></li>   
             <li <?php if($url  =="privacy-policy"){echo 'class="active"';}?>><a href="{{url('/lradmin/cms/privacy-policy')}}"><i class="fa fa-chevron-right"></i> <span>PRIVACY POLICY</span></a></li> 
             <li <?php if($url  =="faq"){echo 'class="active"';}?>><a href="{{url('/lradmin/cms/faq')}}"><i class="fa fa-chevron-right"></i> <span>FAQ</span></a></li> 
             <li <?php if($url  =="governorate"){echo 'class="active"';}?>><a href="{{url('/lradmin/cms/governorate')}}"><i class="fa fa-chevron-right"></i> <span>Governorate</span></a></li> 
          </ul>
        </li>
        <li class="treeview <?php if($url  =="add-vendor" || $url1  =="all_vendor" || $url1  =="active_vendor" || $url1  =="deactive_vendor" || $url  =="menu-category" || $url  =="notification-announcement"){echo 'active';}?>">

            <a href="#"><i class="fa fa-folder"></i> <span>VENDOR MODULE</span>
              <span class="pull-right-container">
                  <i class="fa fa-angle-right pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
               <li <?php if($url  =="add-vendor"){echo 'class="active"';}?>><a href="{{url('lradmin/vendor/add-vendor')}}"><i class="fa fa-chevron-right"></i> <span>Add Vendor </span></a></li>

               <li <?php if($url1  =="all_vendor"){echo 'class="active"';}?>><a href="{{url('lradmin/vendor/manage-vendor')}}/all_vendor"><i class="fa fa-chevron-right"></i> <span>All Vendor</span></a></li>

               <li <?php if($url1  =="active_vendor"){echo 'class="active"';}?>><a href="{{url('lradmin/vendor/manage-vendor')}}/active_vendor"><i class="fa fa-chevron-right"></i> <span>Active Vendor</span></a></li>

               <li <?php if($url1  =="deactive_vendor"){echo 'class="active"';}?>><a href="{{url('lradmin/vendor/manage-vendor')}}/deactive_vendor"><i class="fa fa-chevron-right"></i> <span>Deactive Vendor</span></a></li>

               <li <?php if($url  =="menu-category"){echo 'class="active"';}?>><a href="{{url('lradmin/vendor/menu-category')}}"><i class="fa fa-chevron-right"></i> <span>Menu Category</span></a></li>

               <li <?php if($url  =="notification-announcement"){echo 'class="active"';}?>><a href="{{url('lradmin/vendor/notification-announcement')}}"><i class="fa fa-chevron-right"></i> <span>Notification & Announcement</span></a></li>

               <li <?php if($url  =="report-problem"){echo 'class="active"';}?>><a href="{{url('lradmin/vendor/report-problem')}}"><i class="fa fa-chevron-right"></i> <span>Report Problem</span></a></li>

            </ul>
          </li>

          <li class="treeview <?php if($url  =="user-list"){echo 'active';}?>">

              <a href="#"><i class="fa fa-folder"></i> <span>APP MODULE</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-right pull-right"></i>
                  </span>
              </a>
              <ul class="treeview-menu">
                 <li <?php if($url  =="user-list"){echo 'class="active"';}?>><a href="{{url('lradmin/app/user-list')}}"><i class="fa fa-chevron-right"></i> <span>User List </span></a></li>
  
              </ul>
            </li>

        <li ><a href="{{url('lradmin/contact-query')}}"><i class="fa fa-dashboard"></i> <span>CONTACT QUERY</span></a></li>
      </ul>
    </section>
  
  </aside>
