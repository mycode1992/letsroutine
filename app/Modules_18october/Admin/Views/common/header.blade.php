
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Let's Routine | Admin</title>
  <link rel="shortcut icon" href="{{url('/public')}}/admin/img/favicon.ico" type="image/x-icon">
  
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
 
  <link rel="stylesheet" href="{{url('/public')}}/admin/js/bower_components/bootstrap/dist/css/bootstrap.min.css">
  
  <link rel="stylesheet" href="{{url('/public')}}/admin/js/bower_components/font-awesome/css/font-awesome.min.css">
 
  <link rel="stylesheet" href="{{url('/public')}}/admin/js/bower_components/Ionicons/css/ionicons.min.css">

  <link rel="stylesheet" href="{{url('/public')}}/admin/js/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
 
  <link rel="stylesheet" href="{{url('/public')}}/admin/js/dist/css/AdminLTE.min.css">
 
  <link rel="stylesheet" href="{{url('/public')}}/admin/js/dist/css/skins/_all-skins.min.css">


  <link rel="stylesheet" href="{{url('/public')}}/admin/css/bootstrap-datepicker.min.css">
  <link rel="stylesheet" href="{{url('/public')}}/admin/css/select2.min.css">
  
  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">

 
    <a href="{{url('/lradmin/dashboard')}}" class="logo">
     
      <span class="logo-mini"><b>L</b>R</span>
     
      <span class="logo-lg"><b>Let's</b> Routine</span>
    </a>

  
    <nav class="navbar navbar-static-top">
    
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
     
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
         <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{url('/public')}}/admin/img/Routine_logo_white.png" class="user-image" alt="User Image">
              <span class="hidden-xs">Admin <i class="fa fa-angle-down"></i></span>
            </a>
            <ul class="dropdown-menu">
         
              <li class="user-header">
                <img src="{{url('/public')}}/admin/img/Routine_logo_white.png" class="img-circle" alt="User Image">

                <p>Admin</p>
              </li>
           
              <li class="user-footer">
                <div class="pull-left">
                  <a href="{{url('/lradmin/edit_profile')}}" class="btn btn-default btn-flat">Edit Profile</a>
                </div>
                <div class="pull-right">
                  <a href="{{url('/lradmin/logout')}}" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
         </ul>
      </div>

    </nav>
  </header>