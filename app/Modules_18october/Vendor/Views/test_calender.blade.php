@include('Vendor::include.header')
	@include('Website::include.error')
        <link rel="stylesheet" type="text/css" href="{{url('/public/dncalender/css/dncalendar-skin.min.css')}}">

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
		<div id="dncalendar-container">
        </div>

        <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Modal Header</h4>
               
                <h4>Meals</h4>
                <form onsubmit="return submit_plandetail()" id="formData" >
                <input type="text" name="date" id="date" value="" >
                <input type="hidden" value="{{$planid}}" id="planid" name="planid">
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
                    <div id="menu_block">
        
                    </div>
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
                    <div id="menu_block_snacks">
        
                    </div>
                    </div>
                </div>
        
                <div id="meal_block_snacks">
        
                </div>
        
               
                <div class="col-md-6">
                        <div class="form-group">
                        <div class='input-group date'>
                            <div id="wordCnt" style="color:red"></div>
                            <input type='submit' id="submit_button" value="Submit" class="btn btn-success"  />
                            
                        </div>
                        </div>
                </div>
            </form>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" id="closemodal" onclick="return clearform_data()" class="btn btn-default"  data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
        </div>
        
		<script src="{{url('/')}}/public/website/js/jquery-2.2.4.min.js"></script>
      
        <script type="text/javascript" src="{{url('/public/dncalender/js/dncalendar.min.js')}}"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        
		<script type="text/javascript">
		$(document).ready(function() {
            var defaul_date = '{{$date_start}}';
            var defaul_end_date ='{{$defaul_end_date}}';
            var planid = '{{$planid}}';
            if(defaul_date=='' && defaul_end_date=='')
            {
                var startDate = new Date();
                var numberOfDaysToAdd = 2;
                startDate.setDate(startDate.getDate() + numberOfDaysToAdd); 
                var dd = startDate.getDate();
                var mm = startDate.getMonth() + 1;
                var y = startDate.getFullYear();
                var startdate = y + '-' + mm + '-' + dd;

                var endDate = new Date();
                var numberOfendDaysToAdd = 122;
                endDate.setDate(endDate.getDate() + numberOfendDaysToAdd); 
                var dd = endDate.getDate();
                var mm = endDate.getMonth() + 1;
                var y = endDate.getFullYear();
                var enddate = y + '-' + mm + '-' + dd;
            }
            else
            {
                var startdate = defaul_date;
                var enddate = defaul_end_date;
            }
           

           
        
            
			var my_calendar = $("#dncalendar-container").dnCalendar({
				minDate: startdate,
				maxDate: enddate,
				defaultDate: startdate,
				monthNames: [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ], 
				monthNamesShort: [ 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' ],
				dayNames: [ 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                dayNamesShort: [ 'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat' ],
                dataTitles: { defaultDate: 'default', today : 'hari ini' },
                notes: [
                		// { "date": "2017-01-01", "note": ["Natal"] },
                		// { "date": "2017-05-12", "note": ["Tahun Baru"] }
                		],
                showNotes: true,
                startWeek: 'monday',
                dayClick: function(date, view) {
                   var selecteddate = date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate();
                    $('#date').val(selecteddate);
                    $.ajax(
                    {
                    headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
                    type: 'POST',
                    url: "{{url('/vendor/plan/edit-plan-detail')}}",
                    data:{selecteddate:selecteddate,planid:planid},
                    success:function(response) 
                    {
                    var status = response.status; 
                    if(status=='200')
                    {  
                        $('#vendor_menu_name').val(response.menuname_meal[0]. vendor_menu_id);
                        $('#vendor_menu_name_snacks').val(response.menuname_snacks[0]. vendor_menu_id);
                        $('#submit_button').val('Update');
                       
                       for(var i = 0; i < response.menu_category_meal.length; i++)
                       {
                        $('#menu_block').append('<input type="checkbox" name="" class="menucheckbox" onclick="return showmeal(this.value)" checked value="'+response.menu_category_meal[i].lr_category_id+'"> '+response.menu_category_meal[i].lr_category_name+'<br>');

                        $('#meal_block')
                          .append('<div id="'+response.menu_category_meal[i].lr_category_id+'" class="fornone_lr fornone" > <label for="">'+response.menu_category_meal[i].lr_category_name+' </label> </div>');
                         
                         var menu_id = response.menu_category_meal[i].lr_category_id;
                        
                         callagainajax1(menu_id); 

                        function callagainajax1(menu_id)
                        { 
                         var form = new FormData(); 
                        form.append('date', response.date); 
                        form.append('menucatid', menu_id); 
                        form.append('type', 'MEAL');
                        $.ajax({    
                        headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
                        type: 'POST',
                        url: "{{url('/vendor/plan/get_meal_edit')}}",
                        data:form,
                        contentType: false,
                        processData: false,
                        success:function(response1) 
                        {   
                         
                        var status1 = response1.status;
                        if(status1=='200')
                        {
                            var meal_list = response1.meal_list;
                            for(var j=0; j<meal_list.length;j++)
                            {  
                               
                                $('#'+response1.menu_id)
                                .append(' <input type="checkbox" checked name="mealcheckbox['+menu_id+'][]" class="mealcheckbox" value="'+meal_list[j].lr_meal_id+'"> '+meal_list[j].lr_meal_name);

                            } 

                           
                        }
                        }
                        });
                        }

                       }

                        for(var i = 0; i < response.menu_category_snacks.length; i++)
                       {
                        $('#menu_block_snacks').append('<input type="checkbox" name="" class="menusnackscheckbox" checked onclick="return showmeal_snacks(this.value)" value="'+response.menu_category_snacks[i].lr_category_id+'"> '+response.menu_category_snacks[i].lr_category_name+'<br>');

                        $('#meal_block_snacks')
                          .append('<div id="snacks_'+response.menu_category_snacks[i].lr_category_id+'" class="fornone_lr fornone"> <label for="">'+response.menu_category_snacks[i].lr_category_name+' </label> </div>');
                         
                         var menu_id = response.menu_category_snacks[i].lr_category_id;
                         callagainajax2(menu_id); 

                        function callagainajax2(menu_id)
                        { 
                         var form = new FormData(); 
                        form.append('date', response.date); 
                        form.append('menucatid', menu_id); 
                        form.append('type', 'SNACKS');

                        $.ajax({    
                        headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
                        type: 'POST',
                        url: "{{url('/vendor/plan/get_meal_edit')}}",
                        data:form,
                        contentType: false,
                        processData: false,
                        success:function(response1) 
                        {
                           
                        var status1 = response1.status;
                        if(status1=='200')
                        {
                            var meal_list = response1.meal_list;
                             
                        
                            for(var j=0; j<meal_list.length;j++)
                            { 
                                $('#snacks_'+menu_id)
                                .append(' <input type="checkbox" name="mealsnackscheckbox['+menu_id+'][]" class="mealsnackscheckbox" checked value="'+meal_list[j].lr_meal_id+'"> '+meal_list[j].lr_meal_name); 
                            }  
                        }
                        }
                        });
                        }
                       }
                  
                       
                    }
                    else if(status=='401')
                    {

                    }

                }
			});
                   

                    $('#myModal').modal('show');
                }
			});

			my_calendar.build();

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
                
            var status = response.status;
            if(status=='200')
            {
                var data = response.data;
                
                $('#uniqueid').val(response.uniqueid);
                $('#menu_block').html('');
                $('#meal_block').html('');
                for(var i=0; i<Object.keys(data).length;i++)
                {  // console.log('sweta'+i); // return false;
                $('#menu_block').append('<input type="checkbox" name="" class="menucheckbox" onclick="return showmeal(this.value)" value="'+Object.keys(response.data)[i]+'"> '+Object.values(response.data)[i]+'<br>');

                $('#meal_block')
                .append('<div id="'+Object.keys(response.data)[i]+'" class="fornone_lr fornone" style="display:none" > <label for="">'+Object.values(response.data)[i]+' </label> </div>');
               // console.log('swetaa'+i); // return false;
                 var uniqueid = $('#uniqueid').val();
                var menuid   = Object.keys(response.data)[i];
                callagainajax1(menuid); 

                function callagainajax1(menuid)
                { 
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
                       
                  
                    for(var j=0; j<Object.keys(data1).length;j++)
                    {  
                        $('#'+menuid)
                        .append(' <input type="checkbox" name="mealcheckbox['+menuid+'][]" class="mealcheckbox" value="'+data1[j].lr_meal_id+'"> '+data1[j].lr_meal_name);
                    }  
                }
                }
                });
             }
              


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

       

        function clearform_data()
        { 
           $('#vendor_menu_name,#vendor_menu_name_snacks').val('');
           $('#submit_button').val('Submit');
          // $('input:checkbox[class=mealcheckbox],input:checkbox[class=menucheckbox],input:checkbox[class=menusnackscheckbox],input:checkbox[class=mealsnackscheckbox]').removeAttr('checked'); 
           $('#menu_block,#meal_block,#menu_block_snacks,#meal_block_snacks').html('');  
         //  $('').removeAttr('checked');
          
          // $('.mealcheckbox,.menusnackscheckbox,.mealsnackscheckbox').val('');
           return false;
        }   


        function showmeal(menuid)
		{  
            $("input:checkbox[class=menucheckbox]").each(function () 
            {
                
                if($(this).prop("checked") == true)
                {
                $('#'+$(this).val()).css('display','block');
                }
                else if($(this).prop("checked") == false)
                {
                $('#'+$(this).val()).css('display','none');
                $('#'+$(this).val()).find('input:checkbox[class=mealcheckbox]').removeAttr('checked');
                }
                else
                {
                    alert('Something went wrong, Please try again later');
                }
            });
		}

       function showmeal_snacks(menuid)
		{  
            $("input:checkbox[class=menusnackscheckbox]").each(function () 
            {
                
                if($(this).prop("checked") == true)
                {
                $('#snacks_'+$(this).val()).css('display','block');
                }
                else if($(this).prop("checked") == false)
                {
                $('#snacks_'+$(this).val()).css('display','none');
                $('#snacks_'+$(this).val()).find('input:checkbox[class=mealsnackscheckbox]').removeAttr('checked');
                }
                else
                {
                    alert('Something went wrong, Please try again later');
                }
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
                 $('#menu_block_snacks').html('');
                 $('#meal_block_snacks').html('');

                 for(var i=0; i<Object.keys(data).length;i++)
                 { 
                    $('#menu_block_snacks').append('<input type="checkbox" name="" class="menusnackscheckbox" onclick="return showmeal_snacks(this.value)" value="'+Object.keys(response.data)[i]+'"> '+Object.values(response.data)[i]+'<br>');

                    $('#meal_block_snacks')
                    .append('<div id="snacks_'+Object.keys(response.data)[i]+'" class="fornone_lr fornone" style="display:none" > <label for="">'+Object.values(response.data)[i]+' </label> </div>');

                    var uniqueid_snacks = $('#uniqueid_snacks').val();
                    var menuid = Object.keys(response.data)[i];
                    callagainajax2(menuid); 

                    function callagainajax2(menuid)
                    { 
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

                        for(var i=0; i<Object.keys(data).length;i++)
                        { 
                        $('#snacks_'+menuid)
                        .append(' <input type="checkbox" name="mealsnackscheckbox['+menuid+'][]" class="mealsnackscheckbox" value="'+data1[i].lr_meal_id+'"> '+data1[i].lr_meal_name); 

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
            var request_for = $('#submit_button').val();
            if(request_for =='Submit')
            {
                request_for = '/save_plan_detail';
            }
            else if(request_for =='Update')
            {
                request_for = '/update_plan_detail';
            }  

            $('#wordCnt').css('color','black').css('display','block');
            document.getElementById("wordCnt").innerHTML="Please wait..." ; 
               
           $.ajax({    
                headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
                type: 'POST',
                url: "{{url('/vendor/plan/')}}"+request_for,
                data : $("#formData").serialize(),
                success:function(response) 
                {
                  // console.log(response);   return false;
                document.getElementById("wordCnt").innerHTML="" ; 
                $('#wordCnt').css('color','green')
                var status = response.status;
                if(status=='200')
                {  
                document.getElementById("wordCnt").style.color = "green";
                document.getElementById("wordCnt").innerHTML=response.msg;
                setTimeout(function() { location.reload(true) }, 2000);
                }
                else if(status=='401')
                {
                document.getElementById("wordCnt").style.color = "#ff0000";
                document.getElementById("wordCnt").innerHTML=response.msg;
                }
                }
                });
                return false;
              }

        </script>
       
	</body>
</html>