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
        <li class="treeview <?php if($url  =="add-vendor" || $url1  =="all_vendor" || $url1  =="active_vendor" || $url1  =="deactive_vendor" || $url  =="menu-category" || $url  =="notification-announcement" ||  $url  =="view-packages" || $url  =="view-meal" ){echo 'active';}?>">

            <a href="#"><i class="fa fa-folder"></i> <span>VENDOR MODULE</span>
              <span class="pull-right-container">
                  <i class="fa fa-angle-right pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
               <li <?php if($url  =="add-vendor"){echo 'class="active"';}?>><a href="{{url('lradmin/vendor/add-vendor')}}"><i class="fa fa-chevron-right"></i> <span>Add Vendor </span></a></li>

               <li <?php if($url1  =="all_vendor" ||   $url  =="view-packages" || $url  =="view-meal"){echo 'class="active"';}?>><a href="{{url('lradmin/vendor/manage-vendor')}}/all_vendor"><i class="fa fa-chevron-right"></i> <span>All Vendor</span></a></li>

               <li <?php if($url1  =="active_vendor"){echo 'class="active"';}?>><a href="{{url('lradmin/vendor/manage-vendor')}}/active_vendor"><i class="fa fa-chevron-right"></i> <span>Active Vendor</span></a></li>

               <li <?php if($url1  =="deactive_vendor"){echo 'class="active"';}?>><a href="{{url('lradmin/vendor/manage-vendor')}}/deactive_vendor"><i class="fa fa-chevron-right"></i> <span>Deactive Vendor</span></a></li>

               <li <?php if($url  =="menu-category"){echo 'class="active"';}?>><a href="{{url('lradmin/vendor/menu-category')}}"><i class="fa fa-chevron-right"></i> <span>Menu Category</span></a></li>

               <li <?php if($url  =="notification-announcement"){echo 'class="active"';}?>><a href="{{url('lradmin/vendor/notification-announcement')}}"><i class="fa fa-chevron-right"></i> <span>Notification & Announcement</span></a></li>

               <li <?php if($url  =="report-problem"){echo 'class="active"';}?>><a href="{{url('lradmin/vendor/report-problem')}}"><i class="fa fa-chevron-right"></i> <span>Report Problem</span></a></li>

            </ul>
          </li>
          
          <li class="treeview <?php if($url1  =="all_user" || $url1  =="active_user" || $url1  =="deactive_user" || $url=="about-us" || $url=="customer-service" || $url=="user_orders" || $url=="user_report_problem" || $url=="user" || $url=="allergy" || $url=="dislike" || $url=="promo-code" || $url=="plan-filter" || $url  == "packages"){echo 'active';}?>">

              <a href="#"><i class="fa fa-folder"></i> <span>APP MODULE</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-right pull-right"></i>
                  </span>
              </a>
              <ul class="treeview-menu">

                 <li <?php if($url  =="about-us"){echo 'class="active"';}?>><a href="{{url('lradmin/app/about-us')}}"><i class="fa fa-chevron-right"></i> <span>About-Us </span></a></li>

                <li <?php if($url1  =="all_user"){echo 'class="active"';}?>><a href="{{url('lradmin/app/user-list')}}/all_user"><i class="fa fa-chevron-right"></i> <span>All User</span></a></li>

               <li <?php if($url1  =="active_user"){echo 'class="active"';}?>><a href="{{url('lradmin/app/user-list')}}/active_user"><i class="fa fa-chevron-right"></i> <span>Active User</span></a></li>

               <li <?php if($url1  =="deactive_user"){echo 'class="active"';}?>><a href="{{url('lradmin/app/user-list')}}/deactive_user"><i class="fa fa-chevron-right"></i> <span>Deactive User</span></a></li>

               <li <?php if($url  =="customer-service"){echo 'class="active"';}?>><a href="{{url('lradmin/app/customer-service')}}"><i class="fa fa-chevron-right"></i> <span>Customer Service </span></a></li>

                <li <?php if($url  =="user_report_problem"){echo 'class="active"';}?>><a href="{{url('lradmin/app/user_report_problem')}}"><i class="fa fa-chevron-right"></i> <span>Report & problem </span></a></li>

                <li <?php if($url  =="allergy"){echo 'class="active"';}?>><a href="{{url('lradmin/app/allergy')}}"><i class="fa fa-chevron-right"></i> <span>Allergy</span></a></li>

                <li <?php if($url  =="dislike"){echo 'class="active"';}?>><a href="{{url('lradmin/app/dislike')}}"><i class="fa fa-chevron-right"></i> <span>Dislike</span></a></li>
             
                <li <?php if($url  =="plan-filter"){echo 'class="active"';}?>><a href="{{url('/lradmin/app/plan-filter')}}"><i class="fa fa-chevron-right"></i> <span>Plan Filter</span></a></li>
                <li <?php if($url  =="promo-code"){echo 'class="active"';}?>><a href="{{url('/lradmin/app/promo-code')}}"><i class="fa fa-chevron-right"></i> <span>Promo Code</span></a></li>
                
                <li <?php if($url  == "control-packages-social-icons"){echo 'class="active"';}?>><a href="{{url('lradmin/app/control-packages-social-icons')}}"><i class="fa fa-chevron-right"></i> <span>Control Packages & Social Icons </span></a></li>

                <li <?php if($url  == "advertisement"){echo 'class="active"';}?>><a href="{{url('lradmin/app/advertisement')}}"><i class="fa fa-chevron-right"></i> <span> Advertisement </span></a></li>

                 <li <?php if($url  == "packages"){echo 'class="active"';}?>><a href="{{url('lradmin/app/packages')}}"><i class="fa fa-chevron-right"></i> <span> Packages </span></a></li>

              </ul>
            </li>

        <li ><a href="{{url('lradmin/contact-query')}}"><i class="fa fa-dashboard"></i> <span>CONTACT QUERY</span></a></li>
      </ul>
    </section>

  </aside>
