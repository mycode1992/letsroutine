@include('Admin::common.header')
@include('Admin::common.sidebar')
@include('Admin::common.error')
  <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Customer Service
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/lradmin/app/customer-service')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">App</a></li>
        <li class="active">Customer Service</li>
      </ol>
    </section>

    <!-- Main content -->
     <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">Customer Service
                <!-- <small>Advanced and full of features</small> -->
              </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body pad">
              <form method="post" action=""  onsubmit="return updateaboutus();" id="aboutusform" name="aboutusform">
                <label>Phone Number</label><br>
                    <input id="phone" class="col-lg-4" name="phone" rows="10" cols="80" value="<?=$data[0]->phone_no?>" maxlength="10">

                      <span  id="wordCnt"></span>
                    <br><br>
                    <label>Email Address</label><br>
                    <input id="email" class="col-lg-4" name="email" rows="10" cols="80" value="<?=$data[0]->app_customer_service_email?>" >
                    <span  id="sp_email"></span>
                    <label></label><br><br>
                     <input type="submit" class="btn btn-sm btn-info btn-flat pull-left uppercase" value="Update">
                    



              </form>
            </div>
          </div>
          <!-- /.box -->

        </div>
        <!-- /.col-->
      </div>
      <!-- ./row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @include('Admin::common.footer')
<script>
  $(document).ready(function(){

        function testInput(event) {
            var value = String.fromCharCode(event.which);
            var pattern = new RegExp(/[0-9]/i);
            if(!pattern.test(value))
            {
              ///alert("Numbers Only");
              return false;
            }
            return pattern.test(value);
        }

        $('#phone').bind('keypress', testInput);
    });

function updateaboutus()
{
  var aboutus = $('#phone').val();
  var email = $('#email').val();
  var strUserEml=email.toLowerCase();
  var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
    if(aboutus =='')
    {
    document.getElementById("wordCnt").style.color = "red";
    document.getElementById("wordCnt").innerHTML="Please enter phone no." ;
    return false;
    }
    else if(aboutus.length!=10)
    {
    document.getElementById("wordCnt").style.color = "red";
    document.getElementById("wordCnt").innerHTML="phone no must be 10 digits." ;
    return false;
    }

    else if(email =='')
    {
    document.getElementById("sp_email").style.color = "red";
    document.getElementById("sp_email").innerHTML="Please enter email address." ;
    return false;
    }
    else if(!filter.test(strUserEml))
    {
    document.getElementById("sp_email").style.color = "red";
    document.getElementById("sp_email").innerHTML="Invalid e-mail address" ;
    return false;
    }
    document.getElementById("sp_email").style.color = "#333333";
    document.getElementById("sp_email").innerHTML="Please wait..." ;



		$.ajax({
			headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
			type:'POST',
			url: "{{url('/lradmin/app/update_customer_service')}}",
			data:{'phone':aboutus,'email':email},
			success:function(data){
         var status = data.status;
         var msg = data.msg;
				console.log(data);
			//	return false;
				if(status=="200"){
					 document.getElementById("sp_email").innerHTML="" ;
		         document.getElementById("sp_email").style.color = "#ff0000";
				//		console.log('sweta'); return false;
					document.getElementById("sp_email").style.color = "#278428";
					document.getElementById("sp_email").innerHTML=msg;

					setTimeout(function() { location. reload(true); }, 2000);
				} else if(status=="401"){
					document.getElementById("sp_email").style.color = "#ff0000";
         			document.getElementById("sp_email").innerHTML=msg ;
				}
			}
	    });

			return false;
  }// end of function



</script>
