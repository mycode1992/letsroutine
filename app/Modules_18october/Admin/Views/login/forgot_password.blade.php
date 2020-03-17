<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Let's Routine | Login</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{url('/public')}}/admin/js/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{url('/public')}}/admin/js/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{url('/public')}}/admin/js/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{url('/public')}}/admin/js/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{url('/public')}}/admin/js/plugins/iCheck/square/blue.css">

  
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  @include('Admin::common.error')
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="{{url('/')}}"><img src="{{url('/public/admin/js/dist/img/Routine_logo.png')}}" class="img-responsive"></a>
  </div>
 
  <div class="login-box-body">
    <form id="userloginadmin" onsubmit="return loginFunction();">
      <div class="form-group has-feedback">
        <label class="form-title">Enter Your E-mail</label>
        <input type="text" class="form-control" id="email" name="email" placeholder="Enter Your E-mail">
      </div>
      
          <button type="submit" class="btn btn-primary btn-block btn-flat signIn-btn">Submit</button>
       <div class="form-group msg-admin">
          <div id="loginerror" style="color:#ff0000;text-align: center;">
            </div>
      </div>  
       
   
    </form>
    
  </div>

</div>

<script src="{{url('/public')}}/admin/js/bower_components/jquery/dist/jquery.min.js"></script>

<script src="{{url('/public')}}/admin/js/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<script src="{{url('/public')}}/admin/js/plugins/iCheck/icheck.min.js"></script>
<script>
    $(function () {
      $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
      });
    });

    function loginFunction()
        {
           
            var email =document.getElementById("email").value.trim();
            var strUserEml=email.toLowerCase();
            var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
         
        
            if(email=="")
            {
              document.getElementById('email').style.borderColor='#ff0000';
                document.getElementById("email").focus();
                $('#email').attr("placeholder", "Enter Your E-mail");
                $("#email").addClass( "errors" );
                return false;
            }
           else if(!filter.test(strUserEml)) 
            {
                document.getElementById('email').style.borderColor='#ff0000';
                document.getElementById("email").focus();
                $('#email').val('');
                $('#email').attr("placeholder", "Invalid E-mail");
                $("#email").addClass( "errors" );
                return false;
            }
          else
            {
                document.getElementById("email").style.borderColor = "";     
                   
            }
            
            var loginformdata = new FormData($('#userloginadmin')[0]);
                loginformdata.append('email', email);
                 document.getElementById("loginerror").innerHTML="<i class='fa fa-spinner fa-spin' style='font-size:24px;color: #1a4f52;'></i>";
                   console.log(loginformdata);
                  
            
            $.ajax({
                  headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
                  type: 'POST',
                  url: "{{ url('/lradmin/forgot-password') }}",
                  data:loginformdata ,
                  cache: false,
                  contentType: false,
                  processData: false,  
                  success:function(response) 
                  {
                    console.log(response);
                    var status=response.status;
                    var msg=response.msg;
                    if(status=='200')
                    {
                    $('#loginerror').css('color','green');
                    document.getElementById("loginerror").innerHTML=response.msg;
                    var path="{{url('/iladmin/dashboard')}}";
                 }
                 else if(status=='401')
                {
                    $('#loginerror').css('color','red');
                    document.getElementById("loginerror").innerHTML=msg;
                }
                  else {
        
                  }
              }
        
        
            });
            
           
          return false;
        }
</script>
</body>
</html>
