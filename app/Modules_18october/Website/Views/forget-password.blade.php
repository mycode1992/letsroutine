<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Routine</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
	<!-- <link rel="icon" href="img/favicon.ico" type="image/x-icon"> -->
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/responsive.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/animate.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap-datepicker.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css">
	
	<link rel="stylesheet" type="text/css" href="https://mreq.github.io/slick-lightbox/gh-pages/bower_components/slick-carousel/slick/slick-theme.css">
 	<link href="https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,500,600,700" rel="stylesheet">
	<meta name="google" content="notranslate">
	<!--[if lt IE 9]>
	<script src="js/html5.js"></script>
	<![endif]-->
	<!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
  <![endif]-->
</head>
<body>

<!-- nav-start -->

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
	            <li><a href="index.html">HOME</a></li>
	            <li><a href="about.html">ABOUT</a></li>
	            <li><a href="terms-condition.html">TERMS AND CONDITIONS</a></li>
	            <li><a href="privacy-policy.html">PRIVACY POLICY</a></li>
	            <li><a href="contact.html" >CONTACT US</a></li>
	            <li><a href="faq.html">FAQs</a></li>
	           <li><a href="signup.html">SIGN UP </a></li>
	            <li><a href="login.html"  class="active" >LOGIN</a></li>
	          </ul>
	        </div><!--/.nav-collapse -->
	      </div>
	</nav>
</section>

<!-- nav-end -->

<!-- banner-content-start -->

<!-- <div class="tl-banner">
	<div class="tl-parallax jarallax" data-jarallax='{"speed": 0.2}' style=""></div>

</div>
 -->


<section class="health-routine-banner health-routine-contact-sec health-routine-signup-sec">
	<div class="container">
		<div class="health-routine-contact-container health-routine-signup-container">	
			<h2>Forgot Password</h2>
			<form  class="health-routine-contact-form health-routine-sinup-form">
				 <div class="form-row">	
				
				<div class="form-group col-md-7">
					<label class="form-title">Email </label>
					<input type="email" class="form-control" id="" placeholder="" name="email">
				</div>
				
			
				<div class="clearfix"></div>
			</div>	
			<button type="button" class="btn btn-default"  data-toggle="modal" data-target="#myModal">Submit</button>
			
			</form>		
		</div>

	</div>
</section>

<!-- <section class="contact-info-sec">
	<div class="contact-info-container">
		<div class="container">
				<div class="contact-info-area">
					<div class="contact-us-heading wow fadeIn" data-wow-duration="0.6s" data-wow-delay="0.6s">Contact Us</div>	
					<div class="contact-us-icons wow fadeIn" data-wow-duration="0.7ds" data-wow-delay="0.7s">
							<span><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></span>
							<span><a href="#"><i class="fa fa-phone" aria-hidden="true"></i></a></span>
							<span><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></span>
					</div>
					<div class="contact-us-email wow fadeIn" data-wow-duration="0.8s" data-wow-delay="0.8s"><a href="mailto:info@letsroutine.com">Email: info@letsroutine.com</a></div>
					<div class="contact-us-copyright wow fadeIn" data-wow-duration="0.9s" data-wow-delay="0.9s">© 2023 by Mobile App. Proudly created with Wix.com </div>
				</div>
		</div>
	</div>
</section>
 -->
<!-- <a href="#" class="scrollToTop"><i class="fa fa-angle-up" aria-hidden="true"></i> top </a>
 -->


  <!-- Modal -->
  <div class="modal fade forget-pwd-msg-modal" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        
        </div>
        <div class="modal-body">
          <div class="forgt-pwd-msg">
          <p>A reset link was sent to your email, click link and reset your password.</p>
        </div>	
        </div>
    </div>
      
    </div>
  </div>
<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script src="http://karmatechprojects.com/msgLandingpage/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js"></script>
<script src="js/wow.min.js"></script>
<script src="js/jarallax.js"></script>
<script>
 new WOW().init();
</script> 

<script type="text/javascript">

$( window ).scroll(function() {
  
  if($(this).scrollTop()>=100){
    $('.scrollToTop').fadeIn(500);
  }else{
    $('.scrollToTop').fadeOut(500);
  }
  //$( "span" ).css( "display", "inline" ).fadeOut( "slow" );
});
</script>

<script>
$(document).ready(function(){
var str = document.location.href;
var str1 = str.split("#");
var ot;
if(str1[1]=='works'){
  ot = document.getElementById('works').offsetTop;
  $('html, body').animate({ scrollTop: ot - 85 }, 1000);
}
  $('.downArrow').click(function() {
    var target = $(this.hash);
    console.log(target);
    var dd = document.getElementById('works').offsetTop
    console.log("dd:  "+dd)
    console.log("target.offset().top: "+target.offset().top)
    if (target.length == 0) target = $('a[name="' + this.hash.substr(1) + '"]');
    $('html, body').animate({ scrollTop: target.offset().top - 85 }, 1000);
    return false;
      }); 
});
$(document).ready(function(){
  $(window).scroll(function(){
  	var scroll = $(window).scrollTop();
	  if (scroll > 0) {
	  $(".activebg").addClass("active-white");
	  }

	  else{
	  $(".activebg").removeClass("active-white");
	  }
  });
});

</script>
<script type="text/javascript">
$('.slider-for').slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  fade: true,
  asNavFor: '.slider-nav'
});
$('.slider-nav').slick({
  slidesToShow: 5,
  slidesToScroll: 1,
  asNavFor: '.slider-for',
  dots: false,
  centerMode: true,
  focusOnSelect: true,
  initialSlide: 2,
  arrows: true,
 responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 3
       
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ]
});


</script>



<style type="text/css">
	
</style>
</body>
</html>