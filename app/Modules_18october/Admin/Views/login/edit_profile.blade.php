
  @include('Admin::common.header')
  @include('Admin::common.sidebar')
 <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="margin-left:0;">
   <!-- Content Header (Page header) -->
   <section class="content-header">
     <h1>Edit Profile </h1>
     <ol class="breadcrumb">
       <li><a href={{url('/')}};<i class="fa fa-dashboard"></i> Dashboard</a></li>
       <li><a href="{{url('/')}}">Edit Profile</a></li>
     </ol>
   </section>

   <div class="content-wrapper">
  
    <!-- Main content -->
    <section class="content container-fluid">
  
		<div class="tm-editprofile-main">

      <form onsubmit="return update_profile()">
     <div class="tm-uploadprofile">
       <div class="tm-uploadimg" id="imgTest">
            <?php if($data[0]->lr_userdetail_profile==''){ ?>  
                  <img src="{{url('/')}}/public/admin/img/user-profile.png" alt="" class="img-responsive">
            <?php }else{ ?>   
                <img src="{{url('/public')}}/admin/upload/admin_profile/{{$data[0]->lr_userdetail_profile}}" alt="" class="img-responsive">
            <?php } ?>
       </div>
       <div class="tm-uploadntn">
         <div class="tm-btncols">
           <span class="error-msg" id="errorMsg"></span>
					 <span class="error-msg" id="errorMessage"></span>
           <span style="background-color: #eee;" class="removebg">Upload Image</span>
           <input type="file" id="imageidd" disabled="" name="imageidd" class="removedisable" onchange="uploadimg()">
           <input type="hidden" id="image_name" name="image_name" value="">     
            <input type="hidden" name="imagePath" id="imagePath" value="">
           
         </div>
         <div class="tm-btncolss">
           <button disabled="" style="background-color: #eee;" onclick="return removeimage()" class="removedisable removebg">Remove Image</button>
         </div>
       </div>
       <div class="tm-editicon">
         <a href="javascript:void(0)" onclick="return editable()" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>
       </div>
     </div>

     <div class="tm-editform">
       
         <div class="row">
          <div class="col-sm-6 col-md-6 col-xs-12">
            <div class="row">
               <div class="col-sm-12 col-md-12 col-xs-12">
                 <div class="form-group">
                   <label for="">First Name</label>
                 <label for=""><input type="text" id="fname" readonly="" value="{{$data[0]->lr_userdetail_fname}}" class="form-control removeread"></label>
                 </div>
               </div>
               <div class="col-sm-12 col-md-12 col-xs-12">
                 <div class="form-group">
                   <label for="">Last Name</label>
                   <label for=""><input type="text" id="lname" readonly="" value="{{$data[0]->lr_userdetail_lname}}" class="form-control removeread"></label>
                 </div>
               </div>
               <div class="col-sm-12 col-md-12 col-xs-12">
                 <div class="form-group">
                   <label for="">Email</label>
                   <label for=""><input type="text" id="email" readonly="" value="{{$data[0]->lr_user_email}}"class="form-control removeread"></label>
                 </div>
               </div>

               <div class="col-sm-12 col-md-12 col-xs-12">
                 <div class="form-group">
                   <label for=""><a href="#" data-toggle="modal" data-target="#changepassword">Change Password</a></label>
                 </div>
               </div>
               
             </div>
           </div> 
           <div class="col-sm-12 col-md-12 col-xs-12" id="save_button" style="display:none">
             <div class="form-group">
                <div id="wordCnt" style="color:red"></div>
               <button class="tm-editsave">Save</button>
             </div>
           </div>
           
         </div>
        </div>
       </form>
     </div>

     <div class="modal fade tm-changepass in" id="changepassword" role="dialog" >
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">×</button>
              <h4 class="modal-title">Change Password</h4>
            </div>
            <div class="modal-body">
              <form onsubmit="return change_password();">
                <div class="form-group">
                  <label for="">Old Password</label>
                  <label for=""><input type="password" id="old_password" name="old_password" placeholder="******" class="form-control"></label>
                </div>
                <div class="form-group">
                  <label for="">New Passowrd</label>
                  <label for=""><input type="password" id="password" name="password" placeholder="******" class="form-control"></label>
                </div>
                <div class="form-group">
                  <label for="">Confirm Password</label>
                  <label for=""><input type="password" id="con_password" name="con_password" placeholder="******" class="form-control"></label>
                </div>
                <div class="form-group tm-changebtn">
      
                    <div id="wordCnt1" style="color:red"></div>
      
                  <label for=""><button>Submit</button></label>
                  <label for=""><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></label>
                </div>
              </form>
            </div>
          </div>
          
        </div>
      </div>

    </section>
 
  </div>
   
 </div>

 @include('Admin::common.footer')


<script type="text/javascript">

    function editable()
    {
        $('.removeread').removeAttr("readonly"); 
        $('.removedisable').prop('disabled', false);
        $('.removebg').css('background-color','#fff')
            $('#save_button').css('display','block');
    }
    
    function removeimage()
    {
        var removeimage = 'removeimage';
        document.getElementById("wordCnt").style.color = "#333333";
        document.getElementById("wordCnt").innerHTML="Please wait..." ;
        var form = new FormData();
        form.append('removeimage', removeimage);
        $.ajax({
        headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
        type:'POST',
        url: "{{url('/lradmin/remove_profile')}}",
        data:form, 
        contentType: false,
        processData: false,
        success:function(data){
        document.getElementById("wordCnt").innerHTML="" ; 
        document.getElementById("wordCnt").style.color = "#ff0000";
        var status = data.status;
        var msg = data.msg;
        console.log(data);
        // return false;
        if(status=="200")
        {
        document.getElementById("wordCnt").style.color = "#278428";
        document.getElementById("wordCnt").innerHTML=msg;
        setTimeout(function() { location. reload(true); }, 2000);
        }else if(status=="401")
        {
        document.getElementById("wordCnt").style.color = "#ff0000";
        document.getElementById("wordCnt").innerHTML=msg ;
        }
        }
        });	
        return false;	
    }
    
    function update_profile()
    {
        var fname=document.getElementById('fname').value.trim();
        var lname=document.getElementById('lname').value.trim();
        var email=document.getElementById('email').value.trim();
        var imageidd =document.getElementById("imageidd").value.trim();
        var  imageidd = $('#imageidd')[0].files[0];
        var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
        var strUserEml=email.toLowerCase();
        if(fname=="")
        {
        document.getElementById('fname').style.borderColor='#ff0000';
        document.getElementById("fname").focus();
        $('#fname').val('');
        $('#fname').attr("placeholder", "Enter first name");
        $("#fname").addClass( "errors" );
        return false;
        }     
        else
        {
        document.getElementById("fname").style.borderColor = "";   
        }

        if(lname=="")
        {
        document.getElementById('lname').style.borderColor='#ff0000';
        document.getElementById("lname").focus();
        $('#lname').val('');
        $('#lname').attr("placeholder", "Enter last name");
        $("#lname").addClass( "errors" );
        return false;
        }
           
        else
        {
        document.getElementById("lname").style.borderColor = "";   
        }
        if(email=="")
        {
        document.getElementById('email').style.borderColor='#ff0000';
        document.getElementById("email").focus();
        $('#email').attr("placeholder", "Enter E-Mail");
        $("#email").addClass( "errors" );
        return false;
        }
        else if(!filter.test(strUserEml)) 
        {
            document.getElementById('email').style.borderColor='#ff0000';
            document.getElementById("email").focus();
            $('#email').val('');
            $('#email').attr("placeholder", "Invalid E-Mail");
            $("#email").addClass( "errors" );
            return false;
        }
        else
        {
        document.getElementById("email").style.borderColor = ""; 
        }

        document.getElementById("wordCnt").style.color = "#333333";
        document.getElementById("wordCnt").innerHTML="Please wait..." ;  
        var form = new FormData();
        form.append('fname', fname); 
        form.append('lname', lname); 
        form.append('email', email);
        form.append('imageidd', imageidd);
        $.ajax({
        headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
        type:'POST',
        url: "{{url('/lradmin/update_profile')}}",
        data:form, 
        contentType: false,
        processData: false,
        success:function(data){
        document.getElementById("wordCnt").innerHTML="" ; 
        document.getElementById("wordCnt").style.color = "#ff0000";
        var status = data.status;
        var msg = data.msg;
        console.log(data);
        //return false;
        if(status=="200")
        {	
        document.getElementById("wordCnt").style.color = "#278428";
        document.getElementById("wordCnt").innerHTML=msg;
        setTimeout(function() { location. reload(true); }, 2000);
        }else if(status=="401")
        {
        document.getElementById("wordCnt").style.color = "#ff0000";
        document.getElementById("wordCnt").innerHTML=msg ;
        }
        }
        });	
        return false;	
    }
          
       
      var Image_64byte="";
      var filesSelected ="";
      function uploadimg() 
      {
        
         var image_name =document.getElementById("image_name").value;
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
                        //	document.getElementById('edit_image').style.display='none';
              
            }, a.readAsDataURL(g)
        }
    
            
            
        
    }
    
    function change_password()
    {
        var old_password =document.getElementById("old_password").value.trim();
        var password =document.getElementById("password").value.trim();
        var con_password =document.getElementById("con_password").value.trim();
        if(old_password=="")
        {
        document.getElementById('old_password').style.border='1px solid #ff0000';
        document.getElementById("old_password").focus();
        $('#old_password').val('');
        $('#old_password').attr("placeholder", "Please enter old password");
        $("#old_password").addClass( "errors" );
        return false;
        }
        else
        {
        document.getElementById("old_password").style.border = "";   
        }
        if(password=="")
        {
        document.getElementById('password').style.border='1px solid #ff0000';
        document.getElementById("password").focus();
        $('#password').val('');
        $('#password').attr("placeholder", "Please enter  password");
        $("#password").addClass( "errors" );
        return false;
        }
        else if(password.length<=5 || password.length>=51) 
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
        $('#con_password').attr("placeholder", "Please confirm password");
            $("#con_password").addClass( "errors" );
            return false;
        }

        else
        {
            document.getElementById("con_password").style.border = "";   
        }
        if(password != con_password)
        {
        document.getElementById("wordCnt1").innerHTML="Password does not match" ; 
        return false;
        }
        else
        {
        document.getElementById("wordCnt1").innerHTML="" ; 
        }
        document.getElementById("wordCnt1").style.color = "#333333";
        document.getElementById("wordCnt1").innerHTML="Please wait..." ;
        var form = new FormData();
        form.append('password', password);
        form.append('old_password', old_password);
        $.ajax({    
        headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
        type: 'POST',
        url: "{{url('/lradmin/edit-profile/change_password')}}",
        data:form,
        contentType: false,
        processData: false,
        success:function(response) 
        {
        console.log(response);  //return false;
        document.getElementById("wordCnt1").innerHTML="" ; 
        document.getElementById("wordCnt1").style.color = "#ff0000"; 
        var status = response.status;       
        var msg = response.msg;
        if(status=='200')
        {
        document.getElementById("wordCnt1").innerHTML=msg;
        document.getElementById("wordCnt1").style.color = "#278428";
        setTimeout(function() { location.reload(true) }, 3000);
        }
        else if(status=='401')
        {
        document.getElementById("wordCnt1").style.color = "#ff0000";
        document.getElementById("wordCnt1").innerHTML=msg;
        }
        }
        });
         return false;
     
    }// end of function
        </script>


<style type="text/css">

</style>

