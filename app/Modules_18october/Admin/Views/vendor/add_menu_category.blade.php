
@include('Admin::common.header')
@include('Admin::common.sidebar')
@include('Admin::common.error')

@php
    if(isset($data)&&count($data)>0)    
    {   
    $lr_category_name                 = $data[0]->lr_category_name;
    $lr_category_type                 = $data[0]->lr_category_type; 
    $updateid                 =   $data[0]->lr_category_id;
    $buttontext               =   'Update';
    $pagename                 =   'Edit Menu Category';
    }
    else 
    {
    $lr_category_type                 = '';
    $lr_category_name                 =   '';
    $updateid           =   '';
    $buttontext               =   'Submit';
    $pagename               =   'Add Menu category';
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
<form action="#" enctype="multipart/form-data" method="POST" onsubmit="return add_menu_category();">
<input type="hidden" name="updateid" id="updateid" value="{{$updateid}}"> 
<div class="box-body vendor-form">
<div class="col-md-12">
<div class="form-row">
<label for="inputPassword3" class="control-label">Category Name</label>
<select name="category_type" id="category_type">
    <option value="-1">Please Select</option>
    <option value="MEAL" <?php if($lr_category_type=='MEAL'){echo 'selected';} ?> >Meal</option>
    <option value="SNACKS" <?php if($lr_category_type=='SNACKS'){echo 'selected';} ?> >Snacks</option>
</select>


</div>
</div>
</div>  
<div class="box-body vendor-form">
<div class="col-md-12">
<div class="form-row">
<label for="inputPassword3" class="control-label">Category Name</label>
<input type="text" class="form-control" value="{{$lr_category_name}}" onkeypress="return isChar(event) ;" id="category_name" name="category_name" placeholder="category Name" maxlength="50">
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

<script language="javascript">
</script> 
<script>
function add_menu_category() 
{  
var updateid =document.getElementById("updateid").value;
var category_name =document.getElementById("category_name").value;
var category_type =document.getElementById("category_type").value;

if(category_type == "-1")
{
document.getElementById('category_type').style.borderColor='#ff0000';
document.getElementById("category_type").focus();
$( "#category_type").addClass( "errors" );
return false;
}
else
{
document.getElementById('category_type').style.borderColor=' ';
}


if(category_name == "")
{
document.getElementById('category_name').style.borderColor='#ff0000';
document.getElementById("category_name").focus();
$('#category_name').attr("placeholder", "Please enter category name");
$( "#category_name").addClass( "errors" );
return false;
}
else
{
document.getElementById('category_name').style.borderColor=' ';
}


var form = new FormData();          
form.append('updateid',updateid);
form.append('category_name',category_name);  
form.append('category_type',category_type);

    $.ajax({
    headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
    type:"POST",
    url:"{{url('/lradmin/vendor/save_menu_category')}}",
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