
@include('Admin::common.header')
@include('Admin::common.sidebar')
@include('Admin::common.error')

@php
    if(isset($data)&&count($data)>0)
    {  
    $lr_user_id                 =   $data[0]->lr_user_id;
    $lr_user_name             =   $data[0]->lr_user_name;
    $lr_userdetail_fname      =   $data[0]->lr_userdetail_fname;
    $lr_userdetail_lname      =   $data[0]->lr_userdetail_lname;
    $lr_user_email            =   $data[0]->lr_user_email;
    $lr_userdetail_phone      =   $data[0]->lr_userdetail_phone;
    $lr_userdetail_centrename =   $data[0]->lr_userdetail_centrename;
    $lr_userdetail_centreaddr =   $data[0]->lr_userdetail_centreaddr;
    $lr_userdetail_logo       =   $data[0]->lr_userdetail_logo;
    $lr_user_admin_status     =   $data[0]->lr_user_admin_status;  
    $updateid                 =   $data[0]->lr_user_userid;
    $buttontext               =   'Update';
    $pagename                 =   'Edit Vendor';
    $header                   =   $data[0]->lr_user_name.' (Vendor)';

    }
    else 
    {
    $lr_user_id                 =   '';
    $lr_user_name             =   '';
    $lr_userdetail_fname      =   '';
    $lr_userdetail_lname      =   '';
    $lr_user_email            =   '';
    $lr_userdetail_phone      =   '';
    $lr_userdetail_centrename =   '';
    $lr_userdetail_centreaddr =   '';
    $lr_userdetail_logo       =   '';
    $lr_user_admin_status     =   '';
    $updateid           =   '';
    $buttontext               =   'Submit';
    $pagename               =   'Add Vendor';
    $header               =   'Vendor';
    }
@endphp

<div class="content-wrapper">
<section class="content-header">
<h1>
{{$header}}
</h1>
<ol class="breadcrumb">
<li><a href="{{url('/lradmin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
<li>Vendor</a></li>
<li class="active">{{$header}}</li>
</ol>
</section>

<!-- Main content -->
<section class="content">
<div class="row">
<div class="col-md-12">

<div class="box">
<div class="box-body">
<div class="box-header with-border">
<h3 class="box-title">{{$pagename}}</h3>
</div>
<form action="#" enctype="multipart/form-data" method="POST" onsubmit="return addvendor();">
<input type="hidden" name="updateid" id="updateid" value="{{$updateid}}">   
<div class="box-body vendor-form">
<div class="col-md-12">
<div class="form-row">
<div class="form-group col-md-6">
<label for="inputPassword3" class="control-label">Diet Center Name</label>
<input type="text" class="form-control" value="{{$lr_userdetail_centrename}}" onkeypress="return isChar(event) ;" id="diet_centre_name" name="diet_centre_name" placeholder="Diet Center Name" maxlength="50">
</div>


</div>
<div class="clearfix"></div>
<div class="form-row">
<div class="form-group col-sm-6">
<label for="inputPassword3" class="control-label">First Name</label>
<input type="text" class="form-control" value="{{$lr_userdetail_fname}}" onkeypress="return isChar(event) ;" id="fname" name="fname" placeholder="First Name" maxlength="50">
</div>
<div class="form-group col-sm-6">
<label for="inputPassword3" class="control-label">Last Name</label>
<input type="text" class="form-control" value="{{$lr_userdetail_lname}}" onkeypress="return isChar(event) ;" id="lname" name="lname" placeholder="Last Name" maxlength="50">
</div>
</div>   

<div class="form-row">
<div class="form-group col-sm-6">
<label for="inputPassword3" class="control-label">Phone Number</label>
<input type="text" class="form-control" value="{{$lr_userdetail_phone}}" onkeypress="return isNumberKey(event)"  id="phone" name="phone" placeholder="Phone Number" maxlength="10">
</div> 
<div class="form-group col-sm-6">
<label for="inputPassword3" class="control-label">Email Address</label>
<input type="text" class="form-control" value="{{$lr_user_email}}" id="email" name="email" placeholder="Email Address" maxlength="50">
</div>
</div>

<div class="form-row"> 
<div class="form-group col-sm-6">
<label for="inputPassword3" class="control-label">Password</label>
<input type="password" class="form-control"   id="password" name="password" placeholder="Password" maxlength="50">
</div> 
<div class="form-group col-sm-6">
<label for="inputPassword3" class="control-label">Confirm Password</label>
<input type="password" class="form-control"   id="con_password" name="con_password" placeholder="Confirm Password" maxlength="50">
</div>        
</div>   
<div class="form-row">
<div class="form-group col-sm-12">
<label for="inputPassword3"  class="control-label">Diet Center Address</label>
<textarea id="diet_centre_addr" name="diet_centre_addr" placeholder="Diet Center Address" class="form-control"><?php echo $lr_userdetail_centreaddr; ?></textarea>
{{-- <input type="text" class="form-control" value="{{$lr_userdetail_centreaddr}}"  maxlength="50"> --}}
</div>
</div>  

<div class="form-row">
<div class="form-group col-sm-6">
<label for="">Diet Center Logo<span class="astric">*</span></label>
<label for="" class="al-uploadfile">
<span class="error-msg" id="errorMsg"></span>
<span class="error-msg" id="errorMessage"></span>
<div class="adminUploadbtn">
<!-- <button class="btn">Choose Image</button> -->
<input type="file" id="imageidd" name="imageidd" onchange="uploadimg()" >
</div>
<!-- <span class="al-choosefile">Choose file</span> -->
<input type="hidden" id="image_name" name="image_name" value="">     
<input type="hidden" name="imagePath" id="imagePath" value="" >
<span id="error17" style="color:red"></span>

</label>
<br>
<?php if($lr_userdetail_logo!=''){ ?>
<div id="edit_image">
<img src="{{url('/')}}/public/vendor/upload/logo/{{$lr_userdetail_logo}}"  width="200px" height="150px">
</div>
<?php } ?>
<p class="package uploadedImage captonpic" id="imgTest"> </p>
</div>  
</div>

<div class="col-sm-12-col-md-12 col-xs-12 pd-left0"><span id="errormsg1"></span></div>
<div class="col-sm-12-col-md-12 col-xs-12 ">
<div class="box-footer">
<button type="submit" class="btn btn-info btn-flat pull-left">{{$buttontext}}</button>
</div>
</div>

</form>       
</div>

</div>

</div>

</div>

</section>

</div>

@include('Admin::common.footer')

<script language="javascript">
</script> 
<script>
function addvendor() 
{  
    var updateid =document.getElementById("updateid").value;
var diet_centre_name =document.getElementById("diet_centre_name").value;
var fname =document.getElementById("fname").value;
var lname =document.getElementById("lname").value;
var phone =document.getElementById("phone").value;
var email =document.getElementById("email").value;
var password =document.getElementById("password").value;
var con_password =document.getElementById("con_password").value;
var diet_centre_addr =document.getElementById("diet_centre_addr").value;

var imageidd =document.getElementById("imageidd").value.trim();
var  imageidd = $('#imageidd')[0].files[0];

var strUserEml=email.toLowerCase();
var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;  


if(diet_centre_name == "")
{
document.getElementById('diet_centre_name').style.borderColor='#ff0000';
document.getElementById("diet_centre_name").focus();
$('#diet_centre_name').attr("placeholder", "Please enter diet centre name");
$( "#diet_centre_name").addClass( "errors" );
return false;
}
else
{
document.getElementById('diet_centre_name').style.borderColor=' ';
}

if(fname == "")
{
document.getElementById('fname').style.borderColor='#ff0000';
document.getElementById("fname").focus();
$('#fname').attr("placeholder", "Please enter first name");
$( "#fname").addClass( "errors" );
return false;
}
else
{
document.getElementById('fname').style.borderColor=' ';
}

if(lname == "")
{
document.getElementById('lname').style.borderColor='#ff0000';
document.getElementById("lname").focus();
$('#lname').attr("placeholder", "Please enter last name");
$( "#lname").addClass( "errors" );
return false;
}
else
{
document.getElementById('lname').style.borderColor=' ';
}

if(phone=="")
{

document.getElementById('phone').style.border='1px solid #ff0000';
document.getElementById("phone").focus();
$('#phone').attr("placeholder", "Please enter your phone no");
$("#phone").addClass( "errors" );

return false;
}
else if(phone.length <=9 || phone.length >=11)
{
document.getElementById('phone').style.border='1px solid #ff0000';
document.getElementById("phone").focus();
$("#phone").val('');
$('#phone').attr("placeholder", "Phone no should be 10 digits");
$("#phone").addClass( "errors" );

return false;
}
else
{
document.getElementById("phone").style.borderColor = "";     

}

if(email=="")
{

document.getElementById('email').style.border='1px solid #ff0000';
document.getElementById("email").focus();
$('#email').attr("placeholder", "Please enter your e-mail");
$("#email").addClass( "errors" );

return false;
}
else if(!filter.test(strUserEml)) 
{

document.getElementById('email').style.border='1px solid #ff0000';
document.getElementById("email").focus();
$('#email').val('');
$('#email').attr("placeholder", "Invalid e-mail address");
$("#email").addClass( "errors" );

return false;
}
else
{
document.getElementById("email").style.borderColor = "";     

}

if(updateid=='' || password!='')
{   
    if(password=="")
{
document.getElementById('password').style.border='1px solid #ff0000';
document.getElementById("password").focus();
$('#password').val('');
$('#password').attr("placeholder", "Please enter  password");
$("#password").addClass( "errors" );
return false;
}
else if (password.length<=5 || password.length>=51) 
{   
document.getElementById('password').style.borderColor='#ff0000';
document.getElementById("password").focus();
$('#password').val('');
$('#password').attr("placeholder", "Password Must Be Between 6-50 Char");
$("#password").addClass( "errors" );
return false;
}
else
{
document.getElementById("password").style.border = "";   
}

if(con_password=="")
{
document.getElementById('con_password').style.border='1px solid #ff0000';
document.getElementById("con_password").focus();
$('#con_password').val('');
$('#con_password').attr("placeholder", "Please enter confirm password");
$("#con_password").addClass( "errors" );
return false;
}
else
{
document.getElementById("con_password").style.border = "";   
}

if(password != con_password){
document.getElementById("errormsg1").style.color = "#ff0000";
document.getElementById("errormsg1").innerHTML="Password does not match" ; 
return false;
}
else
{
document.getElementById("errormsg1").style.color = "";
document.getElementById("errormsg1").innerHTML="" ; 
}
}


if(diet_centre_addr == "")
{
document.getElementById('diet_centre_addr').style.borderColor='#ff0000';
document.getElementById("diet_centre_addr").focus();
$('#diet_centre_addr').attr("placeholder", "Please enter diet centre address");
$( "#diet_centre_addr").addClass( "errors" );
return false;
}
else
{
document.getElementById('diet_centre_addr').style.borderColor=' ';
}

var form = new FormData();          
form.append('updateid',updateid);
form.append('diet_centre_name',diet_centre_name);
form.append('fname',fname);
form.append('lname',lname);
form.append('phone',phone);
form.append('email',email);
form.append('password',password);
form.append('diet_centre_addr',diet_centre_addr);
form.append('imageidd',$('#imageidd')[0].files[0]);

    $.ajax({
    headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
    type:"POST",
    url:"{{url('/lradmin/vendor/save_sender')}}",
    data: form,
    contentType: false,
    cache: false,
    processData:false,
    success:function(response) 
    {      console.log(response); // return false;

     var status = response.status;
     var msg = response.msg;
    if(status=='200')
    {  
    $("#errormsg1").css("color","green");
    document.getElementById('errormsg1').innerHTML=msg;
    setTimeout(function() { location.reload(true) }, 3000);
    return false;
    }
    else if(status == '401')
    {
    $("#errormsg1").css("color","red");
    document.getElementById('errormsg1').innerHTML="Updated  Successfully.";
    setTimeout(function() { location.reload(true) }, 3000);
    }
    }
    });
    return false;
    }

    var Image_64byte="";
    var filesSelected ="";
    function uploadimg() 
    {
    document.getElementById('error17').innerHTML="";
    var image_name =document.getElementById("image_name").value;

    if(image_name!="")
    {

    document.getElementById('edit_image').style.display='none';
    }

    //$("#hidetxt").css("display", "none");
    var e = document.getElementById("imageidd"),
    t = e.value,
    n = $("#imageidd")[0].files[0].size / 1024;
    if (n > 2048) return document.getElementById("image_name").value = " ", document.getElementById("imageidd").value = "", document.getElementById("errorMsg").style.color = "#ff0000", document.getElementById("errorMsg").innerHTML = "Image size should be less than 2mb", !1;
    var m = document.getElementById("imageidd").value,
    m = m.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, "_");
    m = m.replace(/[^a-zA-Z0-9]/g, "_");
    var l = m.split("_"),
    d = t.substring(t.lastIndexOf(".") + 1).toLowerCase(),
    r = l[3] + "." + d;
        if ("png" != d && "jpeg" != d && "jpg" != d) return document.getElementById("image_name").value = "", document.getElementById("errorMsg").style.color = "#ff0000", document.getElementById("errorMsg").innerHTML = "Image only allows file types of PNG,JPG,JPEG", !1;
    if (document.getElementById("errorMsg").style.color = "", document.getElementById("errorMsg").innerHTML = "", filesSelected = document.getElementById("imageidd").files, filesSelected.length > 0) {
    var g = filesSelected[0],
    a = new FileReader;
    a.onload = function(e) {
    var t = e.target.result,
    n = t.split(",");
    document.getElementById("imagePath").value = n[1];
    var m = document.createElement("img");

    m.src = t, m.className = "img-responsive", document.getElementById("imgTest").innerHTML = m.outerHTML, document.getElementById("image_name").value = r, Image_64byte = document.getElementById("imgTest").innerHTML
    document.getElementById('edit_image').style.display='none';

    }, a.readAsDataURL(g)
    }




    }

    </script>
    <style>

    .vendor-form .form-control {
    border: solid 1px #ccc;
    height: 45px;
    color:#000 ;
    }
    </style>