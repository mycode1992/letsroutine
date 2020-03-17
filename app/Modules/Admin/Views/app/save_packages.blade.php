
@include('Admin::common.header')
@include('Admin::common.sidebar')
@include('Admin::common.error')

@php
    if(isset($data)&&count($data)>0)    
    {   
    $package_name                 = $data[0]->package_name;
    $package_description                 = $data[0]->package_description;
    $package_gender                 = $data[0]->package_gender;
    $package_price                 = $data[0]->package_price;
    $package_type                 = $data[0]->package_type;
    $delivery_time                 = $data[0]->delivery_time;
    $lr_governorate_area_id                 = $data[0]->lr_governorate_area_id;
    $image                 = $data[0]->image;
    $updateid                 =   $data[0]->lr_package_id;
    $buttontext               =   'Update';
    $pagename                 =   'Edit Packages'; 
  
    }   
    else 
    {
    $package_name   = '';
    $package_description   = '';
    $package_gender  = '';
    $package_price  = '';
    $delivery_time = '';
    $image   = '';
    $updateid           =   '';
    $buttontext               =   'Submit';
    $pagename               =   'Add Packages';
     $lr_governorate_area_id  = '';
    $package_type = '';
    $package_detail_sql = array();
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
<form id="formData">
<input type="hidden" name="updateid" id="updateid"  value="{{$updateid}}">

    <div class="box-body vendor-form">
        <div class="col-md-12">
        <div class="form-row">
        <label for="inputPassword3" class="control-label">Image</label>
        <span class="error-msg" id="errorMsg"></span> 
            <input type="hidden" id="image_name" name="image_name" value="">
            <input type="hidden" name="imagePath" id="imagePath" value="" >
        <span id="error17" style="color:red"></span>
        <div class="useredit-img" id="imgTest"><img src="{{url('/')}}/public/admin/upload/package/{{$image}}" alt="" class="img-responsive"></div>
        <input type="file" id="coverimage" name="coverimage" onchange="uploadimg()" >
        </div>
        </div>
    </div>

    <div class="box-body vendor-form">
        <div class="col-md-12">
        <div class="form-row">
        <label for="inputPassword3" class="control-label">Package Name</label>
        <input type="text" class="form-control" value="{{$package_name}}"  id="package_name" name="package_name" placeholder="Plan Name" maxlength="50">
        </div>
        </div>
    </div>

    <div class="box-body vendor-form">
        <div class="col-md-12">
        <div class="form-row">
        <label for="inputPassword3" class="control-label">Package Description</label>
        <textarea name="package_description" id="package_description" cols="10" rows="4" class="form-control" spellcheck="false"><?php echo $package_description; ?></textarea>
        </div>
        </div>
    </div>

    <div class="box-body vendor-form">
        <div class="col-md-12">
        <div class="form-row">
        <label for="inputPassword3" class="control-label">Package For Gender</label>
        <select name="gender" id="gender" class="form-control">
            <option value="-1">Please Select</option>
            <option value="MALE" <?php if($package_gender=='MALE'){echo 'selected';} ?> >Male</option>
            <option value="FEMALE" <?php if($package_gender=='FEMALE'){echo 'selected';} ?>>Female</option>
            <option value="BOTH" <?php if($package_gender=='BOTH'){echo 'selected';} ?>>Both  </option>
        </select>
        </div>
        </div>
    </div>

    <div class="box-body vendor-form">
        <div class="col-md-12">
        <div class="form-row">
        <label for="inputPassword3" class="control-label">Delievery Time</label>
        <select name="delivery_time" id="delivery_time" class="form-control">
            <option value="-1">Please Select</option>
            <option value="ONE" <?php if($delivery_time=='ONE'){echo 'selected';} ?> >ONE</option>
            <option value="ALL" <?php if($delivery_time=='ALL'){echo 'selected';} ?>>ALL</option>
        </select>
        </div>
        </div>
    </div>

     <div class="box-body vendor-form">
        <div class="col-md-12">
        <div class="form-row">
        <label for="inputPassword3" class="control-label">Package Price</label>
        <input type="text" class="form-control" value="{{$package_price}}"  onkeypress="return isNumberKey(event)" maxlength="4" name="package_price" id="package_price" placeholder="Package Price" maxlength="50">
        </div>
        </div>
    </div>

     <div class="box-body vendor-form">
        <div class="col-md-12">
        <div class="form-row">
        <label for="inputPassword3" class="control-label">Does the package follow a custom menu where users can choose from or a fixed menu?</label>
       <select id="custom_fixed_menu" name="custom_fixed_menu" class="form-control">
        <option value="-1" >Please select</option>
        <option value="FIXEDMENU" <?php if($package_type=='FIXEDMENU'){echo 'selected';} ?>>Fixed menu</option>
        <option value="CUSTOMMENU" <?php if($package_type=='CUSTOMMENU'){echo 'selected';} ?> >Custom menu</option>
    </select>
        </div>
        </div>
    </div>

     <div class="box-body vendor-form">
        <div class="col-md-12">
        <div class="form-row">
        <label for="inputPassword3" class="control-label">Select Area</label>
       <select id="governorate_area" name="governorate_area" onchange="return change_planlisting(this.value,'')" class="form-control">
        <option value="-1" >Please select</option>
        @foreach($area as $val)
            <option value="{{$val->lr_governorate_area_id}}"  <?php if($lr_governorate_area_id == $val->lr_governorate_area_id){echo 'selected';} ?> >{{$val->lr_governorate_area_name}}</option>
        @endforeach
      
    </select>
        </div>
        </div>
    </div>

     <div class="box-body vendor-form">
        <div class="col-md-12">
        <div class="form-row">
        <label for="inputPassword3" class="control-label">Plan Falls Under Package</label>
      
        <select name="planid" id="planid" multiple onchange="return set_priority()" data-placeholder="Please Select" class="form-control select2">
         <?php  if(isset($plan_list)&&count($plan_list)>0)    
        { foreach($plan_list as $val){ ?>
            <option value="{{$val->vendor_plan_id}}" <?php if(in_array_r( $val->vendor_plan_id,$package_detail_sql,$strict = false )){echo 'selected';} ?> > {{$val->vendor_plan_name}} </option>
        <?php } } ?>a
        </select>
       
        </div>
        </div>
    </div>

     <div class="box-body vendor-form" id="priority-block" style="display:none" >
        <div class="col-md-12">
        <div class="form-row">
        <label for="inputPassword3" class="control-label">Set Priority</label>
          <div id="priority-element" >
              
          </div>
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
    $(document).ready( function(){
        var updateid = "{{$updateid}}";
        if( updateid != '' )
        {
           // change_planlisting($('#governorate_area').val(),updateid);
            edit_set_priority(updateid);
           // $('#planid').val(3);
          
        }

    } );


    $('#formData').submit(function(evt) {  
        evt.preventDefault();

        var formData = new FormData(this);  
        var updateid = document.getElementById("updateid").value.trim();
        var package_name = document.getElementById("package_name").value.trim();
        var planid = document.getElementById("planid").value.trim();
        var package_description = document.getElementById("package_description").value.trim();
        var gender = document.getElementById("gender").value.trim();
        var delivery_time = document.getElementById("delivery_time").value.trim();
        var package_price = document.getElementById("package_price").value.trim();

        var custom_fixed_menu = document.getElementById("custom_fixed_menu").value.trim();  

        var governorate_area = document.getElementById("governorate_area").value.trim();


        var  coverimage = $('#coverimage')[0].files[0];

        if(updateid=='')
        {
            if(coverimage==null)
            {
                alert('Add package image'); return false;
            }
        }
    
        if(package_name=="")
        {
        document.getElementById('package_name').style.border='1px solid #ff0000';
        document.getElementById("package_name").focus();
        $('#package_name').val('');
        $('#package_name').attr("placeholder", "Please enter  package name");
        $("#package_name").addClass( "errors" );
        return false;
        }
        else
        {
        document.getElementById("package_name").style.border = "";   
        }

        if(package_description=="")
        {
        document.getElementById('package_description').style.border='1px solid #ff0000';
        document.getElementById("package_description").focus();
        $('#package_description').val('');
        $('#package_description').attr("placeholder", "Please enter description");
        $("#package_description").addClass( "errors" );
        return false;
        }
        else
        {
        document.getElementById("package_description").style.border = "";   
        }   

         if(gender=="-1")
        {
        document.getElementById('gender').style.border='1px solid #ff0000';
        document.getElementById("gender").focus();
        $("#gender").addClass( "errors" );
        return false;
        }
        else
        {
        document.getElementById("gender").style.border = "";   
        }   

         if(delivery_time=="-1")
        {
        document.getElementById('delivery_time').style.border='1px solid #ff0000';
        document.getElementById("delivery_time").focus();
        $("#delivery_time").addClass( "errors" );
        return false;
        }
        else
        {
        document.getElementById("delivery_time").style.border = "";   
        }

         if(package_price=="")
        {
        document.getElementById('package_price').style.border='1px solid #ff0000';
        document.getElementById("package_price").focus();
        $('#package_price').val('');
        $('#package_price').attr("placeholder", "Please enter  package price");
        $("#package_price").addClass( "errors" );
        return false;
        }
        else
        {
        document.getElementById("package_price").style.border = "";   
        }

        if(custom_fixed_menu=="-1")
        {
            document.getElementById('custom_fixed_menu').style.border='1px solid #ff0000';
            document.getElementById("custom_fixed_menu").focus();
            $("#custom_fixed_menu").addClass( "errors" );
            return false;
        }
        else
        {
            document.getElementById("custom_fixed_menu").style.border = "";   
        } 

        if(governorate_area=="-1")
        {
            document.getElementById('governorate_area').style.border='1px solid #ff0000';
            document.getElementById("governorate_area").focus();
            $("#governorate_area").addClass( "errors" );
            return false;
        }
        else
        {
            document.getElementById("governorate_area").style.border = "";   
        } 


         if(planid=="")
        {
        document.getElementById('planid').style.border='1px solid #ff0000';
        document.getElementById("planid").focus();
        $("#planid").addClass( "errors" );
        return false;
        }
        else
        {
        document.getElementById("planid").style.border = "";   
        }

        var plan_sel_count = $("#planid option:selected").length;
       
        if(plan_sel_count!="2" && plan_sel_count!="4")
        {
            alert("Please select either 2 or 4 plan");
            return false;
        }

                document.getElementById("errormsg1").style.color = "#333333";
                document.getElementById("errormsg1").innerHTML="Please wait..." ;
    
               $.ajax({    
                    headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
                    type: 'POST',
                    url: "{{url('/lradmin/app/save_packages')}}",
                    data:formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success:function(response) 
                    {
                          //  console.log(response); return false;
                    document.getElementById("errormsg1").innerHTML="" ; 
                    $('#errormsg1').css('color','green')
                    var status = response.status;
                    if(status=='200')
                    {  
                    document.getElementById("errormsg1").style.color = "green";
                    document.getElementById("errormsg1").innerHTML=response.msg;
                    setTimeout(function() { location.reload(true) }, 1000);
                    }
                    else if(status=='401')
                    {
                    document.getElementById("errormsg1").style.color = "#ff0000";
                    document.getElementById("errormsg1").innerHTML=response.msg;
                    }
                    }
             });
            return false;
       });

    function set_priority()
    {
         $('#priority-element').html('');
         $('#planid :selected').each(function(i, selected){
                valuetext = $(selected).text();
                value = $(selected).val();
             $('#priority-element').append(valuetext+'<input type="text"  onkeypress="return isNumberKey(event)" name="priority[]"><input type="hidden" name="plan_id[]" value="'+value+'" > </br>');
         });
       
        $('#priority-block').css('display','block');
        return false;
    }

    function change_planlisting(areaid,updateid)
    {
       var custom_fixed_menu =  $('#custom_fixed_menu').val();
       var gender =  $('#gender').val();

       if(custom_fixed_menu=="-1")
        {
            document.getElementById('custom_fixed_menu').style.border='1px solid #ff0000';
            document.getElementById("custom_fixed_menu").focus();
            $("#custom_fixed_menu").addClass( "errors" );
            return false;
        }
        else
        {
            document.getElementById("custom_fixed_menu").style.border = "";   
        }

        var form = new FormData(); 
            form.append('custom_fixed_menu',custom_fixed_menu);
            form.append('gender',gender);
            form.append('areaid',areaid);

             $.ajax(
            {
                headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
                type: 'POST',
                url: "{{url('/lradmin/app/package_planlisting')}}",
                data:form,
                contentType: false,
                processData: false,
                success:function(response) 
                {
                 
                var status = response.status;       
                var data = response.data;
               // console.log(data); return false;
                   
                    
                if(status=='200')
                {  
                    var count_data = Object.keys(data).length; 
                    $("#planid option").remove();
                    $('#planid')
                    .append($("<option></option>")
                    .attr("value",'-1')
                    .text('Please Select')); 

                  for(var i=0; i<count_data; i++)
                    {
                        
                        
                    $('#planid')
                    .append($("<option></option>")
                    .attr("value",data[i].vendor_plan_id)
                    .text(data[i].vendor_plan_name));
                    }
                    // if(updateid!='')
                    // { 
                    //     var form1 = new FormData(); 
                    //     form1.append('updateid',updateid);

                    //      $.ajax(
                    //      {
                    //         headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
                    //         type: 'POST',
                    //         url: "{{url('/lradmin/app/package_editplanlisting')}}",
                    //         data:form1,
                    //         contentType: false,
                    //         processData: false,
                    //         success:function(response1) 
                    //         {
                             
                    //         var status1 = response1.status;       
                    //         var data1 = response1.data;
                               
                    //         if(status1=='200')
                    //         {  
                    //             var count_data1 = Object.keys(data1).length; 

                    //             for(var j=0; j<count_data1; j++)
                    //             { 
                    //             //  alert(data1[j].vendor_plan_id);
                                  
                    //                 $('#planid')                                    .val(data1[0].vendor_plan_id);
                    //             }
                                
                    //         }
                    //         }
                    //        });  
                    // }
                   
                    }
                    else
                    {
                        $("#planid option").remove();
                        $('#planid')
                        .append($("<option></option>")
                        .attr("value",'-1')
                        .text('Please Select')); 
                        }
                    
                    }
                });  

    }

    function edit_set_priority(updateid)
    {
       
         $('#planid :selected').each(function(i, selected)
         {
            valuetext = $(selected).text();
            plan_id = $(selected).val();  
           // alert(valuetext+'-'+plan_id); 

           var form = new FormData(); 
            form.append('package_id',updateid);
            form.append('plan_id',plan_id);

            // console.log(updateid); 
            // console.log(plan_id);

             $.ajax(
            {
                headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
                type: 'POST',
                url: "{{url('/lradmin/app/edit_package_priority')}}",
                data:form,
                contentType: false,
                processData: false,
                success:function(response) 
                {
                 
                var status = response.status;       
                var data = response.data;    
                
                    if(status=='200')
                    {  
                    $('#priority-element').append(data[0].vendor_plan_name+'<input type="text"  onkeypress="return isNumberKey(event)" value="'+data[0].week_sequence+'" name="priority[]"><input type="hidden" name="plan_id[]" value="'+data[0].vendor_plan_id+'" > </br>');
                   
                    }
                    else
                    {
                        alert('Something went wrong.');
                    }
                    
                    }
                });  
            $('#priority-block').css('display','block'); 
    
           

             
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
            var e = document.getElementById("coverimage"),
            t = e.value,
            n = $("#coverimage")[0].files[0].size / 1024;
            if (n > 2048) return document.getElementById("image_name").value = " ", document.getElementById("coverimage").value = "", document.getElementById("errorMsg").style.color = "#ff0000", document.getElementById("errorMsg").innerHTML = "Image size should be less than 2mb", !1;
            var m = document.getElementById("coverimage").value,
            m = m.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, "_");
            m = m.replace(/[^a-zA-Z0-9]/g, "_");
            var l = m.split("_"),
            d = t.substring(t.lastIndexOf(".") + 1).toLowerCase(),
            r = l[3] + "." + d;
            if ("png" != d && "jpeg" != d && "jpg" != d) return document.getElementById("image_name").value = "", document.getElementById("errorMsg").style.color = "#ff0000", document.getElementById("errorMsg").innerHTML = "Image only allows file types of PNG,JPG,JPEG", !1;
            if (document.getElementById("errorMsg").style.color = "", document.getElementById("errorMsg").innerHTML = "", filesSelected = document.getElementById("coverimage").files, filesSelected.length > 0) {
            var g = filesSelected[0],
            a = new FileReader;
            a.onload = function(e) {
            var t = e.target.result,
            n = t.split(",");
            document.getElementById("imagePath").value = n[1];
            var m = document.createElement("img");

            m.src = t, m.className = "img-responsive", document.getElementById("imgTest").innerHTML = m.outerHTML, document.getElementById("image_name").value = r, Image_64byte = document.getElementById("imgTest").innerHTML
            //  document.getElementById('edit_image').style.display='none';

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