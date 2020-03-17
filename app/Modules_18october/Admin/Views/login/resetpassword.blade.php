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
  @php
  $segment =Request::segment(3); 
    if($segment==''){
    $segment='';
    }
  @endphp
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="{{url('/')}}"><img src="{{url('/public/admin/js/dist/img/Routine_logo.png')}}" class="img-responsive"></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
        @if($token=='1')
    <form id="userloginadmin" onsubmit="return change_password();">
      <input type="hidden" name="user_id" id="user_id" value="<?php echo $segment;?>" >
      <div class="form-group has-feedback">
        <input type="password" class="form-control"  name="password" id="password" placeholder="New password">
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="repassword" id="repassword" class="form-control" placeholder="Re-enter password">
        
      </div>
    
        
       
       
          <button type="submit" class="btn btn-primary btn-block btn-flat signIn-btn">Submit</button>
       <div class="form-group msg-admin">
          <div id="loginerror" style="color:#ff0000;text-align: center;">
            </div>
      </div>  
       
   
    </form>
    @endif
    @if($token=='2')
    <div class="dos-company-info-title" style="color:#FF0000;">Sorry! Your requested token has been expired</div>

     @endif
     @if($token=='3')
                <div class="dos-company-info-title" style="text-align:center;margin: 60px 0 15px;color: #FF0000;">Unauthorized Access</div>

        @endif
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

  
    function change_password()
    {  
         var password =document.getElementById("password").value.trim();
         var user_id =document.getElementById("user_id").value.trim();
         var repassword =document.getElementById("repassword").value.trim();
         var PswFilter = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[^\w\s]).{8,}$/;
         var test=PswFilter.test(password);
        if(password=="")
        {
        document.getElementById('password').style.borderColor='#ff0000';
        document.getElementById("password").focus();
        $('#password').val('');
        $('#password').attr("placeholder", "Enter password");
        $("#password").addClass( "errors" );
        return false;
        }
         else if (password.length<6 || password.length>=51) 
          {   
              document.getElementById('password').style.borderColor='#ff0000';
              document.getElementById("password").focus();
              $('#password').val('');
              $('#password').attr("placeholder", "Password should be at least 6-50 characters");
              $("#password").addClass( "errors" );
              return false;
          }
        
          else
          {
            document.getElementById("password").style.borderColor = "";   
          }
         if(repassword=="")
          {
            document.getElementById('repassword').style.borderColor='#ff0000';
            document.getElementById("repassword").focus();
            $('#repassword').val('');
            $('#repassword').attr("placeholder", "Enter confirm password");
            $("#repassword").addClass( "errors" );
            return false;
          }
        
        else
          {
            document.getElementById("repassword").style.borderColor = "";   
          }
    
        if(password!=repassword)
          {
            document.getElementById('repassword').style.borderColor='#ff0000';
            document.getElementById("repassword").focus();
            $('#repassword').val('');
            $('#repassword').attr("placeholder", "Confirm password does not match");
            $("#repassword").addClass( "errors" );
            return false;
          }
         
    
     
        $.ajax({  
        headers: {'X-CSRF-Token':'{{ csrf_token() }}'},    
        type: 'POST',
        url: "{{url('/lradmin/changepasswordinsert')}}",
        data: {password:password,user_id:user_id}, 
       
        success:function(response) 
        {
          console.log(response);
           var status=response.status;
          var msg=response.msg;
          if(status=='200')
          {
            var path="{{url('/lradmin')}}";
            $("#password,#repassword").removeClass( "errors" );
             $("#password,#repassword").val('');
             document.getElementById("loginerror").innerHTML=msg;
             document.getElementById("loginerror").style.color = "#278428";
             setTimeout(function() { window.location=path; }, 3000);
          }
          else if(status=='401')
          {
             document.getElementById("loginerror").style.color = "#ff0000";
             document.getElementById("loginerror").innerHTML=response.msg ;
          }
        
        }
    
         });
         return false;
     
      }  // end of function
   
</script>
</body>
</html>
