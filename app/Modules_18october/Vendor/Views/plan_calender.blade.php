
	@include('Vendor::include.header')
    @include('Website::include.error')
   

    @php
        if(isset($data) && count($data)>0)
        {
            $vendor_plan_meals = $data[0]->vendor_plan_meals;
            $vendor_plan_snacks = $data[0]->vendor_plan_snacks;

            if($data[0]->vendor_plan_menu_type=='CUSTOMMENU')
            {
              $plan_type = 'Custom Menu (No.of.meals-'.$vendor_plan_meals.', No.of.snacks-'.$vendor_plan_snacks.')';
            }
            else if($data[0]->vendor_plan_menu_type=='FIXEDMENU')
            {
                $plan_type = 'Fixed Menu (No.of.meals-'.$vendor_plan_meals.', No.of.snacks-'.$vendor_plan_snacks.')';
            }
            
        }
        
    @endphp
	<section class="myDashboard">
	<div class="container">
	<div class="row">
	@include('Vendor::include.sidebar')
	
    <div class="col-md-9">
        <div class="rightBox">
        <h3 class="formTitle">{{$plan_type}}</h3>
        <h4>Meals</h4>
        <form onsubmit="return submit_plandetail()" >
        <div class="col-md-12">
            <div class="form-group">
            <label for="">Select Menu<span>*</span></label>
            <select name="vendor_menu_name" id="vendor_menu_name" onchange="return changemenucategory(this.value)" data-placeholder="Select Menu"  class="form-control select2">
            <option value="-1">Please select</option>
            @foreach($vendor_menu_category AS $val)
            <option value="{{$val->lr_unique_id}}">{{$val->vendor_menu_name}}</option>
            @endforeach
        
            </select>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
            <label for="">Select Menu Category<span>*</span></label>
            <input type="hidden" name="uniqueid" id="uniqueid" value="">
            <select name="vendor_menu_category" id="vendor_menu_category" onchange="return showmeal_menu1(this.value)" data-placeholder="Select Menu Category" multiple  class="form-control select2">
             <option value="-1">Please select</option>
            </select>
            </div>
        </div>

        <div id="meal_block">

        </div>
        <hr/>
        <h4>Snacks</h4>
        <div class="col-md-12">
            <div class="form-group">
            <label for="">Select Menu<span>*</span></label>
            <select name="vendor_menu_name_snacks" id="vendor_menu_name_snacks" onchange="return changemenucategory_snacks(this.value)" data-placeholder="Select Menu"  class="form-control select2">
            <option value="-1">Please select</option>
            @foreach($vendor_menu_name_snacks AS $val)
            <option value="{{$val->lr_unique_id}}">{{$val->vendor_menu_name}}</option>
            @endforeach
        
            </select>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
            <label for="">Select Menu Category<span>*</span></label>
            <input type="hidden" name="uniqueid_snacks" id="uniqueid_snacks" value="">
            <select name="vendor_menu_category_snacks" id="vendor_menu_category_snacks" onchange="return showmeal_menu2(this.value)" data-placeholder="Select Menu Category" multiple  class="form-control select2">
             <option value="-1">Please select</option>
            </select>
            </div>
        </div>

        <div id="meal_block_snacks">

        </div>

        <div class="col-md-6">
            <div class="form-group">
            <label for="">Select Date<span>*</span></label>
            <div class='input-group date' id='datetimepicker2'>
                <input type='text' id="datepicker" class="form-control" />
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
            </div>
        </div>
        
        <div class="col-md-6">
                <div class="form-group">
                <div class='input-group date' id='datetimepicker2'>
                    <input type='submit'  />
                    
                </div>
                </div>
        </div>

    <div class="clearfix"></div>
    </div>
	</div>
	</div>
	</section>




  
<!--only datepicker-js-css-library end -->


<!-- datepiker-js-scrpit-sart -->

       

@include('Vendor::include.footer')     
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
 <script src="https://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript">
            $(function () {
                $('#datetimepicker2').datetimepicker({
                   
                });
            });
</script>

   


	<script>

        function changemenucategory(value)
        {
            var form = new FormData(); 
        	form.append('uniqueid', value); 

            $.ajax({    
            headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
            type: 'POST',
            url: "{{url('/vendor/plan/changemenucategory')}}",
            data:form,
            contentType: false,
            processData: false,
            success:function(response) 
            {
           // console.log(response);
            var status = response.status;
            if(status=='200')
            {
                 var data = response.data;
                    $('#uniqueid').val(response.uniqueid);
                     $('#vendor_menu_category')
                        .find('option')
                        .remove()
                        .end()
                        .append('<option value="-1">Please Select</option>');
                     for(var i=0; i<Object.keys(data).length;i++)
                     { 
                        $('#vendor_menu_category')
                        .append($("<option></option>")
                        .attr("value",Object.keys(response.data)[i])
                        .text(Object.values(response.data)[i])); 

                         $('#meal_block')
                        .append('<div id="'+Object.keys(response.data)[i]+'" class="fornone_lr fornone" style="display:none" > <div class="col-md-6"> <div class="form-group">  <label for="">'+Object.values(response.data)[i]+' <span>*</span></label> <select name="mealname['+Object.keys(response.data)[i]+'][]" id="mealname_'+Object.keys(response.data)[i]+'" data-placeholder="Select Meal" multiple class="form-control select2">   </select> </div> </div> </div>');

                            var uniqueid = $('#uniqueid').val();
                            var menuid   = Object.keys(response.data)[i];
                            var form = new FormData(); 
                            form.append('menuid', menuid); 
                            form.append('uniqueid', uniqueid); 
                            $.ajax({    
                            headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
                            type: 'POST',
                            url: "{{url('/vendor/plan/changemeal')}}",
                            data:form,
                            contentType: false,
                            processData: false,
                            success:function(response1) 
                            {
                          
                            var status1 = response1.status;
                            if(status1=='200')
                            {
                                var data1 = response1.data;
                                 console.log(data1); // return false;
                                $('#mealname_'+menuid)
                                    .find('option')
                                    .remove()
                                    .end()
                                    .append('<option value="-1">Please Select</option>');
                                for(var j=0; j<Object.keys(data1).length;j++)
                                {     
                                   
                                    $('#mealname_'+menuid)
                                    .append($("<option></option>")
                                    .attr("value",data1[j].lr_meal_id)
                                    .text(data1[j].lr_meal_name)); 

                                }  
                            }
                            }
                            });

                        

                     }
            }
            else
            {
              alert("Something went wrong, please try again later");  
            }
            }
            });
            return false;
	
        }

        function showmeal_menu1(id)
		{

            $(".fornone").css("display","none")
            $('#vendor_menu_category :selected').each(function(i, selected) {
            var dataid = $(selected).val();
            $("#"+dataid).css("display","block");
            }); 
		}

        function showmeal_menu2(id)
		{

            $(".fornonesnacks").css("display","none")
            $('#vendor_menu_category_snacks :selected').each(function(i, selected) {
            var dataid = $(selected).val();
            $("#snacks_"+dataid).css("display","block");
            }); 
		}

        function changemenucategory_snacks(value)
        {
            var form = new FormData(); 
        	form.append('uniqueid', value); 

            $.ajax({    
            headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
            type: 'POST',
            url: "{{url('/vendor/plan/changemenucategory_snacks')}}",
            data:form,
            contentType: false,
            processData: false,
            success:function(response) 
            {
            console.log(response);
            var status = response.status;
            if(status=='200')
            {
                 var data = response.data;
                 $('#uniqueid_snacks').val(response.uniqueid);
                 $('#vendor_menu_category_snacks')
                    .find('option')
                    .remove()
                    .end()
                    .append('<option value="-1">Please Select</option>');
                 for(var i=0; i<Object.keys(data).length;i++)
                 { 
                    $('#vendor_menu_category_snacks')
                    .append($("<option></option>")
                    .attr("value",Object.keys(response.data)[i])
                    .text(Object.values(response.data)[i])); 

                      $('#meal_block_snacks')
                    .append('<div id="snacks_'+Object.keys(response.data)[i]+'" class="fornone_lr fornone_snacks" style="display:none" > <div class="col-md-6"> <div class="form-group">  <label for="">'+Object.values(response.data)[i]+' <span>*</span></label> <select name="mealnamesnacks['+Object.keys(response.data)[i]+'][]" id="mealnamesnacks_'+Object.keys(response.data)[i]+'" data-placeholder="Select Meal" multiple class="form-control select2">   </select> </div> </div> </div>');

                    var uniqueid_snacks = $('#uniqueid_snacks').val();
                    var menuid = Object.keys(response.data)[i];
                    var form = new FormData(); 
                    form.append('menuid', menuid); 
                    form.append('uniqueid', uniqueid_snacks); 

                    $.ajax({    
                    headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
                    type: 'POST',
                    url: "{{url('/vendor/plan/changemeal_snacks')}}",
                    data:form,
                    contentType: false,
                    processData: false,
                    success:function(response1) 
                    {
                    console.log(response1);
                    var status1 = response1.status;
                    if(status1=='200')
                    {
                        var data1 = response1.data;
                        // console.log(data[0].lr_meal_id); return false;
                        $('#mealnamesnacks_'+menuid)
                            .find('option')
                            .remove()
                            .end()
                            .append('<option value="-1">Please Select</option>');
                        for(var i=0; i<Object.keys(data).length;i++)
                        { 
                            $('#mealnamesnacks_'+menuid)
                            .append($("<option></option>")
                            .attr("value",data1[i].lr_meal_id)
                            .text(data1[i].lr_meal_name)); 
                        }
                    }
                    else
                    {
                    alert("Something went wrong, please try again later");  
                    }
                   
                    }
                    });

                 }  
            }
            else
            {
              alert("Something went wrong, please try again later");  
            }
            }
            });
            return false;
        }

        function changemeal_snacks(menuid)
        {
            var uniqueid_snacks = $('#uniqueid_snacks').val();
            var form = new FormData(); 
        	form.append('menuid', menuid); 
        	form.append('uniqueid', uniqueid_snacks); 

            $.ajax({    
            headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
            type: 'POST',
            url: "{{url('/vendor/plan/changemeal_snacks')}}",
            data:form,
            contentType: false,
            processData: false,
            success:function(response) 
            {
            console.log(response);
            var status = response.status;
            if(status=='200')
            {
                 var data = response.data;
                // console.log(data[0].lr_meal_id); return false;
                 $('#vendor_plan_meal_snacks')
                    .find('option')
                    .remove()
                    .end()
                    .append('<option value="-1">Please Select</option>');
                 for(var i=0; i<Object.keys(data).length;i++)
                 { 
                    $('#vendor_plan_meal_snacks')
                    .append($("<option></option>")
                    .attr("value",data[i].lr_meal_id)
                    .text(data[i].lr_meal_name)); 

                 }  
            }
            else
            {
              alert("Something went wrong, please try again later");  
            }
            }
            });
            return false;
        }

        function submit_plandetail()
        {
           var vendor_menu_name =  $('#vendor_menu_name').val();
           var vendor_menu_category =  $('#vendor_menu_category').val();
           var vendor_plan_meal =  $('#vendor_plan_meal').val();
           var vendor_menu_name_snacks =  $('#vendor_menu_name_snacks').val();
           var vendor_menu_category_snacks =  $('#vendor_menu_category_snacks').val();
           var vendor_plan_meal_snacks =  $('#vendor_plan_meal_snacks').val();
           var datepicker =  $('#datepicker').val();

           var form = new FormData(); 
        	form.append('vendor_menu_name', vendor_menu_name); 
        	form.append('vendor_menu_category', vendor_menu_category); 
        	form.append('vendor_plan_meal', vendor_plan_meal); 
        	form.append('vendor_menu_name_snacks', vendor_menu_name_snacks); 
        	form.append('vendor_menu_category_snacks', vendor_menu_category_snacks); 
        	form.append('vendor_plan_meal_snacks', vendor_plan_meal_snacks); 
        	form.append('datepicker', datepicker); 

            $.ajax({    
            headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
            type: 'POST',
            url: "{{url('/vendor/plan/save_plan_detail')}}",
            data : form,
            success:function(response) 
            {
            console.log(response); // return false;
            document.getElementById("wordCnt").innerHTML="" ; 
            $('#wordCnt').css('color','green')
            var status = response.status;
            if(status=='200')
            {  
            document.getElementById("wordCnt").style.color = "green";
            document.getElementById("wordCnt").innerHTML=response.msg;
            setTimeout(function() { location.reload(true) }, 1000);
            }
            else if(status=='401')
            {
            document.getElementById("wordCnt").style.color = "#ff0000";
            document.getElementById("wordCnt").innerHTML=response.msg;
            }
            }
            });
        }

      

    </script>
    <!-- only datepicker-js-css-library start -->
  
