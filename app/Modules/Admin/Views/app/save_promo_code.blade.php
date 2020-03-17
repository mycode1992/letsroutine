
@include('Admin::common.header')
@include('Admin::common.sidebar')
@include('Admin::common.error')

@php
    if(isset($data)&&count($data)>0)    
    {   
    $amount                 = $data[0]->amount;
    $promocode_user                 = $data[0]->promocode_user;
    $updateid                 =   $data[0]->promocode_id;
    $buttontext               =   'Update';
    $pagename                 =   'Edit Promo Code';
    }
    else 
    {
    $amount                 = '';
    $promocode_user                 = '';
    $updateid           =   '';
    $buttontext               =   'Submit';
    $pagename               =   'Add Promo Code';
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
<form onsubmit="return form_Promo_Code();">
<input type="hidden" name="updateid" id="updateid" value="{{$updateid}}">

<div class="box-body vendor-form">
    <div class="col-md-12">
    <div class="form-row">
    <label for="inputPassword3" class="control-label">Amount</label>
    <input type="text" class="form-control" value="{{$amount}}" onkeypress="return isNumberKey(event) ;" id="amount" name="amount" placeholder="Amount" maxlength="5">
    </div>
    </div>
</div>

<div class="box-body vendor-form">
    <div class="col-md-12">
    <div class="form-row">
    <label for="inputPassword3" class="control-label">User Type</label>
   <select name="user_type" id="user_type">
     <option value="-1">Please select</option>
     <option value="All" @if($promocode_user=='All') selected @endif >All User</option>
     <option value="top-100" @if($promocode_user=='top-100') selected @endif >Top 100</option>
   </select>
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
function form_Promo_Code() 
{   
    var updateid =document.getElementById("updateid").value;
    var amount =document.getElementById("amount").value;
    var user_type =document.getElementById("user_type").value;


    if(amount == "")
    {
    document.getElementById('amount').style.borderColor='#ff0000';
    document.getElementById("amount").focus();
    $('#amount').attr("placeholder", "Please enter amount");
    $( "#amount").addClass( "errors" );
    return false;
    }
    else
    {
    document.getElementById('amount').style.borderColor=' ';
    }

     if(user_type == "-1")
    {
    document.getElementById('user_type').style.borderColor='#ff0000';
    document.getElementById("user_type").focus();
    $( "#user_type").addClass( "errors" );
    return false;
    }
    else
    {
    document.getElementById('user_type').style.borderColor=' ';
    }

    var form = new FormData();            
    form.append('updateid',updateid);
    form.append('amount',amount);  
    form.append('user_type',user_type);  

    $.ajax({
    headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
    type:"POST",
    url:"{{url('/lradmin/app/save_promo_code')}}",
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