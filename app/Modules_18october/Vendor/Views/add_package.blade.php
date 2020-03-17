

@include('Vendor::include.header')
@include('Website::include.error')

@php
 if(isset($data) && count($data)>0)
 {
	 $updateid = $data[0]->lr_package_id;
	 $package_name = $data[0]->package_name;
	 $vendor_plan_id = $data[0]->vendor_plan_id;
	 $package_description = $data[0]->package_description;
	 $package_gender = $data[0]->package_gender;
	 $package_price = $data[0]->package_price;
	 $butttext = 'Update';
	 $page_name = 'Edit Package';
 }
 else
 {
     $updateid = '';
	 $package_name = '';
	 $vendor_plan_id = '';
	 $package_description = '';
	 $package_gender = '';
	 $package_price = '';
	 $butttext = 'Add';
	 $page_name = 'Add Package';
 }
@endphp

	<section class="myDashboard">
	<div class="container">
	<div class="row">
	@include('Vendor::include.sidebar')
	<div class="col-md-9">
            <div class="rightBox">
                <h3 class="formTitle">{{$page_name}}</h3>
                <form onsubmit="return save_package()">
                <input type="hidden" value="{{$updateid}}" name="updateid" id="updateid">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Package Name<span>*</span></label>
                        <input type="text" id="package_name" value="{{$package_name}}" name="package_name" class="form-control">
                        </div>
                    </div>
                     <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Plan Name<span>*</span></label>
                            <select name="planid" id="planid" class="form-control">
                                <option value="-1">Please Select</option>
                                @foreach($plan_list AS $val)
                            <option value="{{$val->vendor_plan_id}}" <?php if($vendor_plan_id==$val->vendor_plan_id){echo 'selected';} ?> >{{$val->vendor_plan_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Package Description<span>*</span></label>
                            <textarea name="package_description" id="package_description" cols="10" rows="4" class="form-control" spellcheck="false"><?php echo $package_description; ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Package For Gender<span>*</span></label>
                            <select name="gender" id="gender" class="form-control">
                                <option value="-1">Please Select</option>
                                <option value="MALE" <?php if($package_gender=='MALE'){echo 'selected';} ?> >Male</option>
                                <option value="FEMALE" <?php if($package_gender=='FEMALE'){echo 'selected';} ?>>Female</option>
                                <option value="BOTH" <?php if($package_gender=='BOTH'){echo 'selected';} ?>>Both  </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Package Price<span>*</span></label>
                        <input type="text" value="{{$package_price}}"  name="package_price" id="package_price" class="form-control">
                        </div>
                    </div>




                    <div class="col-md-6">
                        <div class="submitButton">
                            	<div id="wordCnt" style="color:red"></div>
                            <button type="submit" class="sbmtbtn">{{$butttext}}</button>
                        </div>
                    </div>

                    <div class="col-md-6">
                    <div class="submitButton">
                    <button type="button" onclick="window.history.back()" class="sbmtbtn">Goback</button>
                    </div>
                    </div>
                    
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
	</div>
	</div>
	</section>
@include('Vendor::include.footer')
<script>
        function save_package()
        {
            var updateid = document.getElementById("updateid").value.trim();
            var package_name = document.getElementById("package_name").value.trim();
            var planid = document.getElementById("planid").value.trim();
            var package_description = document.getElementById("package_description").value.trim();
            var gender = document.getElementById("gender").value.trim();
            var package_price = document.getElementById("package_price").value.trim();
          
    
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

             if(planid=="-1")
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

            document.getElementById("wordCnt").style.color = "#333333";
            document.getElementById("wordCnt").innerHTML="Please wait..." ;
    
            var form = new FormData(); 
            form.append('package_name',package_name);
            form.append('planid',planid);
            form.append('package_description',package_description);
            form.append('gender',gender);
            form.append('package_price',package_price);
            form.append('updateid',updateid);
    
                $.ajax(
                {
                headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
                type: 'POST',
                url: "{{url('/vendor/save_package')}}",
                data:form,
                contentType: false,
                processData: false,
                success:function(response) 
                {
                console.log(response);  //return false;
                document.getElementById("wordCnt").innerHTML="" ; 
                document.getElementById("wordCnt").style.color = "#ff0000"; 
    
                var status = response.status;       
                var msg = response.msg;                     
    
                if(status=='200')
                {	 	
    
                    document.getElementById("wordCnt").style.color = "green";
                     document.getElementById("wordCnt").innerHTML=msg;
                     setTimeout(function() { location.reload(true) }, 1000);
                 }
                 else if(status=='401')
                 {
    
                     document.getElementById("wordCnt").style.color = "#ff0000";
                     document.getElementById("wordCnt").innerHTML=msg;
                 }
    
             }
                });
    
            return false;
            
        }
    </script>