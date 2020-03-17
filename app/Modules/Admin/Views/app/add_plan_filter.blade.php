
@include('Admin::common.header')
@include('Admin::common.sidebar')
@include('Admin::common.error')

@php
    if(isset($data)&&count($data)>0)    
    {   
    $app_planfilter_name                 = $data[0]->app_planfilter_name;
    $updateid                 =   $data[0]->app_planfilter_id;
    $buttontext               =   'Update';
    $pagename                 =   'Edit Menu Category';
    }
    else 
    {
    $app_planfilter_name                 = '';
    $updateid           =   '';
    $buttontext               =   'Submit';
    $pagename               =   'Add Plan Filter';
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
<form onsubmit="return form_plan_filter();">
<input type="hidden" name="updateid" id="updateid" value="{{$updateid}}">
    <div class="box-body vendor-form">
        <div class="col-md-12">
        <div class="form-row">
        <label for="inputPassword3" class="control-label">Plan Filter</label>
        <input type="text" class="form-control" value="{{$app_planfilter_name}}" onkeypress="return isChar(event) ;" id="plan_filter" name="plan_filter" placeholder="Plan Filter" maxlength="50">
        </div>
        </div>
    </div>

    <div class="box-body vendor-form">
        <div class="col-md-12">
        <div class="form-row">
        <label for="inputPassword3" class="control-label">Image</label>
        <input type="file" id="plan_filter_image" name="plan_filter_image">
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
function form_plan_filter() 
{ 
var updateid =document.getElementById("updateid").value;
var plan_filter =document.getElementById("plan_filter").value;
var  plan_filter_image = $('#plan_filter_image')[0].files[0];


    if(plan_filter == "")
    {
    document.getElementById('plan_filter').style.borderColor='#ff0000';
    document.getElementById("plan_filter").focus();
    $('#plan_filter').attr("placeholder", "Please enter plan filter");
    $( "#plan_filter").addClass( "errors" );
    return false;
    }
    else
    {
    document.getElementById('plan_filter').style.borderColor=' ';
    }

    if(plan_filter_image==null)
	{
	  alert("Add plan filter image"); return false;
	}

    var form = new FormData();            
    form.append('updateid',updateid);
    form.append('plan_filter',plan_filter);  
    form.append('plan_filter_image',plan_filter_image);  

    $.ajax({
    headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
    type:"POST",
    url:"{{url('/lradmin/app/save_plan_filter')}}",
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