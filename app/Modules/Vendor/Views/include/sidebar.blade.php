
   <div class="col-md-3">
    <div class="leftBox">
    <div class="left">
    <div class="userProfilePicBox">
    <div class="userUplodImg">
    <form action="#" method="POST" id="form_user_profile_change">
    <div class="gfuserUploadImg">
    <?php if($sql_sel[0]->lr_userdetail_profile!=''){?>
    <img src="{{url('/')}}/public/vendor/upload/profile/{{$sql_sel[0]->lr_userdetail_profile}}" alt="" class="profile_thumb">
    <?php }else{ ?>
    <img src="{{url('/')}}/public/vendor/upload/profile/my_profile.png" alt="" class="img-responsive img-circle">
    <?php } ?> 
    </div>
    <div type="button" class="btn">
    <label for="a"><i class="fa fa-pencil"></i></label>
    <input  name="profilepic" id="profilepic" type="file" onchange="uploadprofile()" class="profileUplod">
    </div>
    </form>
    </div>
    <h4 class="text-uppercase white">{{$sql_name[0]->lr_user_name}}</h4>
    </div>
    </div>
    <div class="leftLinks" id="MainMenu">  
    <ul>
    <li>
    <a href="{{url('/vendor/myprofile')}}"  <?php if($last_url=='myprofile'){echo "class='active'";}?> >
    <img src="{{url('/')}}/public/website/img/my_profile.png" alt=""> My Profile
    </a>
    </li>
    <li>
    <a href="{{url('/vendor/current-order')}}"  <?php if($last_url=='current-order'){echo "class='active'";}?>>
    <img src="{{url('/')}}/public/website/img/Current_orders.png" alt=""> Current Orders
    </a>
    </li>
    <li>
    <a href="#demo3"  data-toggle="collapse" data-parent="#MainMenu">
    <img src="{{url('/')}}/public/website/img/Menu.png" alt=""> Menu <span> <i class="fa fa-caret-down"></i></span>
    </a>
    <div class="collapse <?php if($last_url=='menu-list' || $last_url=='add-menu'){echo "in";}?>" id="demo3">
    <a href="{{url('/vendor/menu-list')}}" class="list-group-item <?php if($last_url=='menu-list'){echo "active";}?>" data-parent="#SubMenu1">Menu List</a>

    <a href="{{url('/vendor/add-menu')}}" class="list-group-item <?php if($last_url=='add-menu'){echo "active";}?>" data-parent="#SubMenu1">Add Menu</a>
    </div>
    </li>

    <li>
    <a href="#demo4" class="" data-toggle="collapse" data-parent="#MainMenu">
    <img src="{{url('/')}}/public/website/img/Menu.png" alt=""> Meal <span> <i class="fa fa-caret-down"></i></span>
    </a>
    <div class="collapse <?php if($last_url=='add-meal' || $last_url=='meal-list'){echo "in";}?>" id="demo4">
    <a href="{{url('/vendor/meal-list')}}" class="list-group-item <?php if($last_url=='meal-list'){echo "active";}?>" data-parent="#SubMenu1">Meal List</a>

    <a href="{{url('/vendor/add-meal')}}" class="list-group-item <?php if($last_url=='add-meal'){echo "active";}?>" data-parent="#SubMenu1">Add Meal</a>
    </div>
    </li>

    <li>     

    <a href="{{url('/vendor/plan-listing')}}" <?php if($last_url=='plan-listing' || $last_url=='add-plan'){echo "class='active'";}?>  data-toggle="" data-parent="#">
    <img src="{{url('/')}}/public/website/img/Plans.png" alt=""> Plans
    </a>

    </li>
    <li>
    <a href="{{url('/vendor/package-info')}}" <?php if($last_url=='package-info' || $last_url=='add-package'){echo "class='active'";}?>>
    <img src="{{url('/')}}/public/website/img/Packages_info.png" alt=""> Package Info
    </a>
    </li>
    <li>
    <a href="{{url('/vendor/order-history')}}" class="">
    <img src="{{url('/')}}/public/website/img/Orders_history.png" alt=""> Order History
    </a>
    </li>
    <li>
    <a href="{{url('/vendor/offer')}}" <?php if($last_url=='offer'){echo "class='active'";}?>>
    <img src="{{url('/')}}/public/website/img/Offers.png" alt=""> Offers
    </a>
    </li>
  
    <li>
    <a href="{{url('/vendor/notification_and_announcement')}}" <?php if($last_url=='notification_and_announcement'){echo "class='active'";}?>>
    <img src="{{url('/')}}/public/website/img/Notifications.png" alt=""> Notifications and announcement
    </a>
    </li>
    <li>
    <a href="{{url('/vendor/setting')}}" <?php if($last_url=='setting'){echo "class='active'";}?>>
    <img src="{{url('/')}}/public/website/img/Settings.png" alt=""> settings
    </a>
    </li>
    <li>
    <a href="{{url('/vendor/delivery-area-info')}}" <?php if($last_url=='delivery-area-info'){echo "class='active'";}?>>
    <img src="{{url('/')}}/public/website/img/Offers.png" alt="">Delivery Area Info
    </a>
    </li>

    <li>
        <a href="{{url('/vendor/delivery-centre-available')}}" <?php if($last_url=='delivery-centre-available'){echo "class='active'";}?>>
        <img src="{{url('/')}}/public/website/img/Offers.png" alt="">Diet Center Availability
        </a>
    </li>

    <li>
    <a href="{{url('vendor/report-problem')}}" <?php if($last_url=='report-problem'){echo "class='active'";}?>>
    <img src="{{url('/')}}/public/website/img/report.png" alt=""> Report a problem
    </a>
    </li>
    </ul>
    </div>
    </div>
    </div>