<!DOCTYPE html>
<?php
     $segment = Request::segment(1); 
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
	<link rel="stylesheet" type="text/css" href="{{url('/public/website/css')}}css/animate.css">
	<link rel="stylesheet" type="text/css" href="{{url('/public/website/css/bootstrap-datepicker.css')}}">
	<link rel="stylesheet" type="text/css" href="{{url('/public/website/css/slick.css')}}">
	
	<link rel="stylesheet" type="text/css" href="{{url('/public/website/css/slick-theme.css')}}">
	
 	<link href="https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,500,600,700" rel="stylesheet">
	<meta name="google" content="notranslate">
	
</head>
<body>
<section class="tl-nav">
	<nav class="navbar navbar-fixed-top activebg">
	      <div class="container">
	        <div class="navbar-header">
	          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
	            <span class="sr-only">Toggle navigation</span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </button>
	         
	        </div>
	        <div id="navbar" class="navbar-collapse collapse">
	          <ul class="nav navbar-nav navbar-right">
	            <li><a href="{{url('/')}}" <?php if($segment==''){ echo 'class="active"'; }?>>HOME</a></li>
	            <li><a href="{{url('/about')}}" <?php if($segment=='about'){ echo 'class="active"'; }?>>ABOUT</a></li>
	            <li><a href="{{url('/terms-condition')}}" <?php if($segment=='terms-condition'){ echo 'class="active"'; }?>>TERMS AND CONDITIONS</a></li>
	            <li><a href="{{url('/privacy-policy')}}" <?php if($segment=='privacy-policy'){ echo 'class="active"'; }?>>PRIVACY POLICY</a></li>
	          
							<li><a href="{{url('/faq')}}" <?php if($segment=='faq'){ echo 'class="active"'; }?>>FAQs</a></li>
							  <li><a href="{{url('/contact')}}" <?php if($segment=='contact'){ echo 'class="active"'; }?>>CONTACT US</a></li>
							<?php if(isset($sessionuserid) && $sessionuserid !=''){ ?>
								<li><a href="{{url('/vendor/myprofile')}}" <?php if($segment=='signup'){ echo 'class="active"'; }?>>MY PROFILE</a></li>
							<?php }else{ ?>
								<li><a href="{{url('/signup')}}" <?php if($segment=='signup'){ echo 'class="active"'; }?>>SIGN UP </a></li>
							<li><a href="{{url('/login')}}" <?php if($segment=='login'){ echo 'class="active"'; }?>>LOGIN</a></li>
							<?php } ?>
	          </ul>
	        </div><!--/.nav-collapse -->
	      </div>
	</nav>
</section>