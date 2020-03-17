
@include('Admin::common.header')
@include('Admin::common.sidebar')
@include('Admin::common.error')

@php
    if(isset($data)&&count($data)>0)    
    {   
    $app_dislike_name                 = $data[0]->app_dislike_name;
    $updateid                 =   $data[0]->app_dislike_id;
    $buttontext               =   'Update';
    $pagename                 =   'Edit Dislike';
    }
    else 
    {
    $app_dislike_name                 = '';
    $updateid           =   '';
    $buttontext               =   'Submit';
    $pagename               =   'Add Dislike';
    }
@endphp

<div class="content-wrapper">
<section class="content-header">
<h1>
{{$pagename}}
</h1>
<ol class="breadcrumb">
<li><a href="{{url('/lradmin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
<li>Cms</a></li>
<li class="active">{{$pagename}}</li>
</ol>
</section>

<!-- Main content -->
<section class="content">
<div class="row">
<div class="col-md-12">

<div class="box">
<div class="box-body">
<div class="box-header with-border">

</div>
<form onsubmit="return form_dislike();">
<input type="hidden" name="updateid" id="updateid" value="{{$updateid}}">
<div class="box-body vendor-form">
<div class="col-md-12">
<div class="form-row">
<label for="inputPassword3" class="control-label">Dislike</label>
<input type="text" class="form-control" value="{{$app_dislike_name}}" onkeypress="return isChar(event) ;" id="dislike" name="dislike" placeholder="dislike" maxlength="50">
</div>
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


<script>
function form_dislike() 
{ 
var updateid =document.getElementById("updateid").value;
var dislike =document.getElementById("dislike").value;


if(dislike == "")
{
document.getElementById('dislike').style.borderColor='#ff0000';
document.getElementById("dislike").focus();
$('#dislike').attr("placeholder", "Please enter dislike");
$( "#dislike").addClass( "errors" );
return false;
}
else
{
document.getElementById('dislike').style.borderColor=' ';
}

var form = new FormData();            
form.append('updateid',updateid);
form.append('dislike',dislike);  
    $.ajax({
    headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
    type:"POST",
    url:"{{url('/lradmin/app/save_dislike')}}",
    data: form,
    contentType: false,
    cache: false,
    processData:false,
    success:function(response) 
    {      console.log(response);  

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
    document.getElementById('errormsg1').innerHTML=msg;
    setTimeout(function() { location.reload(true) }, 3000);
    }
    }
    });
    return false;
    }

    </script>
    <style>

    .vendor-form .form-control {
    border: solid 1px #ccc;
    height: 45px;
    color:#000 ;
    }
    </style>