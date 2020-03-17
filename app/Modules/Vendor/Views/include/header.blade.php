<!DOCTYPE html>
<?php
     $segment = Request::segment(1); 
       global $z;
         $z = 'abc';   
?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Routine</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
	<link rel="shortcut icon" href="{{url('/public')}}/admin/img/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="{{url('/public/website/css/bootstrap.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{url('/public/website/css/style.css')}}">
	<link rel="stylesheet" type="text/css" href="{{url('/public/website/css/responsive.css')}}">
	<link rel="stylesheet" type="text/css" href="{{url('/public/website/css/font-awesome.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{url('/public/website/css')}}/animate.css">

	<link rel="stylesheet" type="text/css" href="{{url('/public/website/css/slick.css')}}">
	
    <link rel="stylesheet" type="text/css" href="{{url('/public/website/css/slick-theme.css')}}">
    
    <link rel="stylesheet" href="{{url('/public')}}/admin/css/select2.min.css">
	
 	<link href="https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,500,600,700" rel="stylesheet">
	<meta name="google" content="notranslate">
	
</head>
<body class="bgNone">
    <section class="dashboard-header">
        <div class="dashboard-header-container">
            <div class="container">
                <div class="dasboard-heder-area">
                <div class="dashboard-header-logo"> <a href="{{url('/')}}"> <img src="{{url('/')}}/public/website/img/dashboard-logo.png" alt="" class="img-responsive"></a></div>
                <div class="dashboard-loing-img">
                    <div class="dropdown ti-navdropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <?php if($sql_sel[0]->lr_userdetail_profile!=''){?>
                            <img src="{{url('/')}}/public/vendor/upload/profile/{{$sql_sel[0]->lr_userdetail_profile}}" alt="" class="img-responsive img-circle">
                            <?php }else{ ?>
                                <img src="{{url('/')}}/public/vendor/upload/profile/my_profile.png" alt="" class="img-responsive img-circle">
                            <?php } ?> 
                            
                            <span class="caret-icon"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></span></a>
                        <ul class="dropdown-menu">
                        <li><a href="{{url('/vendor/myprofile')}}">My profile</a></li>
                            <li><a href="{{url('/vendor/logout')}}">Sign out</a></li>
                            
                        </ul>
                    </div>
                </div>
                </div>
    
            </div>
        </div>
    </section>