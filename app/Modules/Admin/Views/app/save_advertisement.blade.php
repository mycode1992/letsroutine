
@include('Admin::common.header')
@include('Admin::common.sidebar')
@include('Admin::common.error')

@php
    if(isset($data)&&count($data)>0)    
    {   
    $image                 = $data[0]->image;
    $title                 = $data[0]->title;
    $description           = $data[0]->description;
    $updateid              =   $data[0]->id;
    $buttontext            =   'Update';
    $pagename              =   'Edit Advertisement';
    }
    else 
    {
    $image                 = '';
    $title                 = '';
    $description           = '';
    $updateid           =   '';
    $buttontext               =   'Submit';
    $pagename               =   'Add Advertisement';
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
<form onsubmit="return form_advertisement();">
<input type="hidden" name="updateid" id="updateid" value="{{$updateid}}">

<div class="box-body vendor-form">
	<div class="col-md-12">
	<div class="form-row">

	<span class="error-msg" id="errorMsg"></span>
	<input type="hidden" id="image_name" name="image_name" value="">
	<input type="hidden" name="imagePath" id="imagePath" value="" >
	<span id="error17" style="color:red"></span>
	<div class="useredit-img" id="imgTest">
	<img src="{{url('/')}}/public/admin/upload/advertisement/{{$image}}" alt="" class="img-responsive">
	</div>

	<label for="">Image<span>*</span></label> 
	<input type="file" id="adv_image" onchange="uploadimg()" name="adv_image">
	</div>
	</div>
</div>

<div class="box-body vendor-form">
	<div class="col-md-12">
	<div class="form-row">
	<label for="inputPassword3" class="control-label">Title</label>
	<input type="text" class="form-control" value="{{$title}}" onkeypress="return isChar(event) ;" id="title" name="title" placeholder="Enter Title" maxlength="50">
	</div>
	</div>
</div>

<div class="box-body vendor-form">
	<div class="col-md-12">
	<div class="form-row">
	<label for="" class="control-label">Description</label>
	 <textarea id="description" rows="10" cols="80">
	 <?php  echo $description; ?></textarea>
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
function form_advertisement() 
{ 
	var description = $('#description').val();
	var updateid =document.getElementById("updateid").value;
	var title =document.getElementById("title").value;
	var  adv_image = $('#adv_image')[0].files[0];

	if(updateid=='')
	{
		if(adv_image == null)
		{
			document.getElementById("errormsg1").style.color = "red";
		    document.getElementById("errormsg1").innerHTML="Please select image.";
		    return false;
		}
		else
		{
			document.getElementById("errormsg1").style.color = "";
		    document.getElementById("errormsg1").innerHTML="" ;
		    
		}
	}
	
	if(title == "")
	{
	document.getElementById('title').style.borderColor='#ff0000';
	document.getElementById("title").focus();
	$('#title').attr("placeholder", "Please enter title");
	$( "#title").addClass( "errors" );
	return false;
	}
	else
	{
	document.getElementById('title').style.borderColor=' ';
	}

    if(description =='')
    {
	    document.getElementById("errormsg1").style.color = "red";
	    document.getElementById("errormsg1").innerHTML="Please enter Description." ;
	    return false;
    }

    document.getElementById("errormsg1").style.color = "#333333";
	document.getElementById("errormsg1").innerHTML="Please wait..." ;

	

	var form = new FormData();            
	form.append('updateid',updateid);
	form.append('adv_image',adv_image);  
	form.append('title',title);  
	form.append('description',description);  

    $.ajax({
    headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
    type:"POST",
    url:"{{url('/lradmin/app/save_advertisement')}}",
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

	 var Image_64byte="";
	var filesSelected ="";
	function uploadimg() 
	{
		document.getElementById('error17').innerHTML="";
		var image_name =document.getElementById("image_name").value;

		if(image_name!="")
		{

		//document.getElementById('edit_image').style.display='none';
		}

		//$("#hidetxt").css("display", "none");
		var e = document.getElementById("adv_image"),
		t = e.value,
		n = $("#adv_image")[0].files[0].size / 1024;
		if (n > 2048) return document.getElementById("image_name").value = " ", document.getElementById("adv_image").value = "", document.getElementById("errorMsg").style.color = "#ff0000", document.getElementById("errorMsg").innerHTML = "Image size should be less than 2mb", !1;
		var m = document.getElementById("adv_image").value,
		m = m.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, "_");
		m = m.replace(/[^a-zA-Z0-9]/g, "_");
		var l = m.split("_"),
		d = t.substring(t.lastIndexOf(".") + 1).toLowerCase(),
		r = l[3] + "." + d;
		if ("png" != d && "jpeg" != d && "jpg" != d) return document.getElementById("image_name").value = "", document.getElementById("errorMsg").style.color = "#ff0000", document.getElementById("errorMsg").innerHTML = "Image only allows file types of PNG,JPG,JPEG", !1;
		if (document.getElementById("errorMsg").style.color = "", document.getElementById("errorMsg").innerHTML = "", filesSelected = document.getElementById("adv_image").files, filesSelected.length > 0) {
		var g = filesSelected[0],
		a = new FileReader;
		a.onload = function(e) {
		var t = e.target.result,
		n = t.split(",");
		document.getElementById("imagePath").value = n[1];
		var m = document.createElement("img");

		m.src = t, m.className = "img-responsive", document.getElementById("imgTest").innerHTML = m.outerHTML, document.getElementById("image_name").value = r, Image_64byte = document.getElementById("imgTest").innerHTML
		//	document.getElementById('edit_image').style.display='none';

		}, a.readAsDataURL(g)
		}

	}

	$(function () {
       CKEDITOR.replace('editor1')
    
    })


    </script>
    <style>

    .vendor-form .form-control {
    border: solid 1px #ccc;
    height: 45px;
    color:#000 ;
    }


    </style>