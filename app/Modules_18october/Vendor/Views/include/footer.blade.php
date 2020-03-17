
<section class="inner-footer">
  <div class="inner-footer-contaienr">
  <div class="container">
  copyright @ <?php echo date('Y'); ?> <a href="{{url('/')}}">letsroutine.com</a> All rights reserved. <span>
    <a href="{{url('/privacy-policy')}}">Privacy Policy</a>
    <a href="{{url('/terms-condition')}}">Terms and conditions</a>
  </span>
  </div>
  </div>
  </section>

<script src="{{url('/public/website')}}/js/jquery-2.2.4.min.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
	var counter = 2;
 
	$(".addMorePopIcon").click(function () {
	if(counter>10){ 
    $('#alertmsg').text("Only 10 textboxes allow.");
    $('#alertmodal').modal('show');
  	return false;
	}
	   
    $('#TextBoxesGroup').append('<div id="removediv'+ counter+'" ><div><div class="col-sm-5 col-xs-12"><label for=""><input type="text" name="from[]" id="from'+ counter+'" onclick="return fortimepicker(this.id);" placeholder="From" maxlength="10" class="form-control timepick" value=""></label></div><div class="col-sm-5 col-xs-12">	<label for=""><input type="text" name="to[]" id="to'+ counter+'" onclick="return fortimepicker(this.id);" placeholder="To" maxlength="10" class="form-control timepick" value=""></label></div></div></div>');
  
    counter++;
   
	});

	$(".removeMorePopIcon").click(function () {
    counter--; 
  if(counter==1)
  {
    $('#alertmsg').text("No more textbox to remove.");
    $('#alertmodal').modal('show');
    counter++; 
	  return false;
	}
  $("#removediv" + counter).remove();
 
	});
	});
  </script>
  
	<script>
	$(document).ready(function() {
//	for( i = 0; i < $('#timepick1').length; i++ ) {
	$('.timepick').timepicker({
	format: 'hh:MM TT'
	});
//	}
	});
	// $(document).ready(function() {
	// for( i = 0; i < $('#timepick2').length; i++ ) {
	// $('#timepick2').eq(i).timepicker({
	// format: 'hh:MM TT'
	// });
	// }
	// });
	// $(document).ready(function() {
	// for( i = 0; i < $('#timepick3').length; i++ ) {
	// $('#timepick3').eq(i).timepicker({
	// format: 'hh:MM TT'
	// });
	// }
	// });
	// $(document).ready(function() {
	// for( i = 0; i < $('#timepick4').length; i++ ) {
	// $('#timepick4').eq(i).timepicker({
	// format: 'hh:MM TT'
	// });
	// }
	// });

    function fortimepicker(id)
    { 
      $('#'+id).timepicker({
        format: 'hh:MM TT'
      });
    
    }

	

	</script>
<script src="{{url('/public/website')}}/js/bootstrap.min.js"></script>
<script type="text/javascript" src="{{url('/public/website')}}/js/slick.min.js"></script>
<script src="{{url('/public/website')}}/js/wow.min.js"></script>
<script src="{{url('/public/website')}}/js/jarallax.js"></script>
<script src="{{url('/public')}}/admin/js/bower_components/select2/dist/js/select2.full.min.js"></script>
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

function uploadprofile()
{
  
  var  profilepic = $('#profilepic')[0].files[0];
  	var form = new FormData();
    form.append('profilepic', profilepic); 

		$.ajax({    
		headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
		type: 'POST',
		url: "{{url('/vendor/profilepic')}}",
		data:form,
		contentType: false,
		processData: false,
		success:function(response) 
		{
			console.log(response);//  return false;
			document.getElementById("wordCnt").innerHTML="" ; 
			$('#wordCnt').css('color','green')
		  var status = response.status;       
		  var msg = response.msg;       
		  
		  if(status=='200')
		  { 
			  setTimeout(function() { location.reload(true) }, 1000);
		  }
		  else if(status=='401')
		  {
		
		  }
		 
		 
		}
	
		 });
		 return false;
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

<script>
    $('.select2').select2();
   $(document).ready(function() {
     $('#example1').DataTable({
       "language": {
     "lengthMenu": '<div> <select class="troopets_selectbox">'+
       '<option value="10">10</option>'+
       '<option value="20">20</option>'+
       '<option value="30">30</option>'+
       '<option value="40">40</option>'+
       '<option value="50">50</option>'+
       '<option value="60">60</option>'+
   
       '<option value="-1">All</option>'+
       '</select> <span class="record">Records Per Page </span></div>'
     }
     });
     soTable = $('#example1').DataTable();
     $('#srch-term').keyup(function(){
        soTable.search($(this).val()).draw() ;
      });
   
   $('.something').click( function () {
   var ddval = $('.something option:selected').val();
   console.log(ddval);
   var oSettings = oTable.fnSettings();
   oSettings._iDisplayLength = ddval;
   oTable.fnDraw();
   });
   oTable = $('#example1').dataTable();
   
   } );
   
   </script>


</body>
</html>