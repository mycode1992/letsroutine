
@include('Admin::common.header')
@include('Admin::common.sidebar')
@include('Admin::common.error')

@php
    $lr_governorate_name      =   null;
    $description              =   null;
    $updateid                 =   null;
    $buttontext               =   null;
    $pagename                 =   null;
    if(isset($data)&&count($data)>0)
    {  
    $lr_governorate_name      =  $data[0]->lr_cms_title;
    $description              =   $data[0]->lr_cms_description;
    $updateid                 =   $data[0]->lr_cms_id;
    $buttontext               =   'Update';
    $pagename                 =   'Edit Faq';
    }
    else 
    {
    $lr_governorate_name                 =   '';
    $updateid           =   '';
    $buttontext               =   'Submit';
    $pagename               =   'Add Faq';
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
<form action="#" enctype="multipart/form-data" method="POST" onsubmit="return submit_faq();">
<input type="hidden" name="updateid" id="updateid" value="{{$updateid}}">   
<div class="box-body vendor-form">
<div class="col-md-12">
<div class="form-row">
<label for="inputPassword3" class="control-label">Faq's Question</label>
<input type="text" class="form-control" value="{{$lr_governorate_name}}" id="faq_title" name="faq_title" placeholder="Faq Title" maxlength="50">
</div>
</div>
</div>

<div class="box-body vendor-form">
<div class="col-md-12">
<div class="form-row">
<label for="inputPassword3" class="control-label">Faq's Answer</label>
<textarea id="editor1" name="editor1" rows="10" cols="80"><?php echo $description;  ?></textarea>
</div>
</div>
</div>



<div class="col-sm-12-col-md-12 col-xs-12 pd-left0"><span id="errormsg1"></span></div>
<div class="col-sm-12-col-md-12 col-xs-12 ">
<div class="box-footer">
<a class="btn btn-warning btn-flat pull-left" href="{{ url('lradmin/cms/faq') }}">Back</a> 
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
     $(function () {
       CKEDITOR.replace('editor1')
     })
</script> 
<script>
function submit_faq() 
{  
var updateid =document.getElementById("updateid").value;
var faq_title =document.getElementById("faq_title").value;
var faq = CKEDITOR.instances.editor1.getData();

if(faq_title == "")
{
document.getElementById('faq_title').style.borderColor='#ff0000';
document.getElementById("faq_title").focus();
$('#faq_title').attr("placeholder", "Please enter faq title");
$( "#faq_title").addClass( "errors" );
return false;
}
else
{
document.getElementById('faq_title').style.borderColor=' ';
}

    if(faq =='')
    {
    document.getElementById("errormsg1").style.color = "red";
    document.getElementById("errormsg1").innerHTML="Please enter Description." ;
    return false;
    }
    document.getElementById("errormsg1").style.color = "#333333";
    document.getElementById("errormsg1").innerHTML="Please wait..." ;


var form = new FormData();          
form.append('updateid',updateid);
form.append('faq_title',faq_title);
form.append('faq',faq);

    $.ajax({
    headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
    type:"POST",
    url:"{{url('/lradmin/cms/submit_faq')}}",
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
    document.getElementById('errormsg1').innerHTML=msg;
    //setTimeout(function() { location.reload(true) }, 3000);
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