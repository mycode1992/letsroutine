<script src="{{url('/public/website')}}/js/jquery-2.2.4.min.js"></script>
<script src="{{url('/public/website')}}/js/bootstrap.min.js"></script>
<script type="text/javascript" src="{{url('/public/website')}}/js/slick.min.js"></script>
<script src="{{url('/public/website')}}/js/wow.min.js"></script>
<script src="{{url('/public/website')}}/js/jarallax.js"></script>
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

function isChar(evt)
{

var iKeyCode = (evt.which) ? evt.which : evt.keyCode
           
if (iKeyCode != 46 && iKeyCode > 31 && iKeyCode > 32 && (iKeyCode < 65 || iKeyCode > 90)&& (iKeyCode < 97 || iKeyCode > 122))
{
  return false;
}
else if(iKeyCode == 46)
{
  return false;
}
else
{
 return true;
 
}
}
function isNumber(evt) 
{
    var iKeyCode = (evt.which) ? evt.which : evt.keyCode
    if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57))
        return false;
    return true;
}

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
// $(document).ready(function(){
//   $(window).scroll(function(){
//   	var scroll = $(window).scrollTop();
// 	  if (scroll > 0) {
// 	  $(".activebg").addClass("active-white");
// 	  }

// 	  else{
// 	  $(".activebg").removeClass("active-white");
// 	  }
//   });
// });

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
</body>
</html>