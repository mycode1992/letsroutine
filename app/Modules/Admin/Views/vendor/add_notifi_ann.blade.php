
        @include('Admin::common.header')
        @include('Admin::common.sidebar')
        @include('Admin::common.error')

        @php
        if(isset($data)&&count($data)>0)
        {  
        $lr_user_id               =   $data[0]->lr_user_id; 
        $lr_notifi_announc_name   =   $data[0]->lr_notifi_announc_name;
        $lr_notifi_announc_desp   =   $data[0]->lr_notifi_announc_desp;
        $updateid                 =   $data[0]->lr_notifi_announc_id;
        $buttontext               =   'Update';
        $pagename                 =   'Notification & Announcement';
        $header                   =   'Edit';
        $exp_vendorid = explode(',',$lr_user_id);
        }
        else 
        {
        $lr_user_id                 =    '';
        $lr_notifi_announc_name             =   '';
        $lr_notifi_announc_desp      =    '';
        $updateid           =   '';
        $exp_vendorid = array();
        $buttontext               =   'Submit';
        $pagename               =   'Notificartion & Announcement';
        $header               =   'Add';
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

        <div class="col-md-12">
        <div class="form-row">
        <div class="form-group col-md-6">
        <label for="">Vendor<span>*</span></label>
        <select name="select_vendor" id="select_vendor" data-placeholder="Select Vendor" multiple class="form-control select2">
        <option value="All" <?php if($lr_user_id=='All'){echo 'selected';} ?> >All</option>
        @foreach($vendor_list AS $val)
        <option value="{{$val->lr_user_userid}}" <?php if(in_array($val->lr_user_userid,$exp_vendorid)){echo 'selected';} ?> >{{$val->lr_user_name}}</option>
        @endforeach

        </select>
        </div>
        </div>
        </div> 

        <div class="box-body vendor-form">
        <div class="col-md-12">
        <div class="form-row">
        <div class="form-group col-md-6">
        <label for="inputPassword3" class="control-label">Name</label>
        <input type="text" class="form-control" value="{{$lr_notifi_announc_name}}" onkeypress="return isChar(event) ;" id="name" name="name" placeholder="Enter Name" maxlength="50">
        </div>
        </div>
        </div>

        

        </div>
        <div class="clearfix"></div>

        <div class="form-row">
        <div class="form-group col-sm-12">
        <label for="inputPassword3"   placeholder="Diet Center Address" class="control-label">Description</label>
        <textarea class="form-control" id="description" name="description" placeholder="Enter decription"><?php echo $lr_notifi_announc_desp; ?></textarea>

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
        var name =document.getElementById("name").value;
        var description =document.getElementById("description").value;
        var select_vendor =document.getElementById("select_vendor").value;

        var select_vendor1 = [];

		$('#select_vendor :selected').each(function(i, selected) {
			select_vendor1[i] = $(selected).val();
		}); 

      
        if(select_vendor == "")
        {
        document.getElementById('select_vendor').style.borderColor='#ff0000';
        document.getElementById("select_vendor").focus();
        $( "#select_vendor").addClass( "error" );
        return false;
        }
        else
        {
        document.getElementById('select_vendor').style.borderColor=' ';
        }

        if(name == "")
        {
        document.getElementById('name').style.borderColor='#ff0000';
        document.getElementById("name").focus();
        $('#name').attr("placeholder", "Please enter name");
        $( "#name").addClass( "error" );
        return false;
        }
        else
        {
        document.getElementById('name').style.borderColor=' ';
        }

        if(description == "")
        {
        document.getElementById('description').style.borderColor='#ff0000';
        document.getElementById("description").focus();
        $('#description').attr("placeholder", "Please enter description");
        $( "#description").addClass( "error" );
        return false;
        }
        else
        {
        document.getElementById('description').style.borderColor=' ';
        }


        var form = new FormData();           
        form.append('updateid',updateid);
        form.append('name',name);
        form.append('description',description);
        form.append('select_vendor',select_vendor1);


        $.ajax({
        headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
        type:"POST",
        url:"{{url('/lradmin/vendor/save_notification_announcement')}}",
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