@include('Vendor::include.header')
@include('Website::include.error')


<section class="myDashboard">
	<div class="container">
		<div class="row">
			@include('Vendor::include.sidebar')
			<div class="col-md-9">
				<div class="rightBox">
					<div class="headFlex">
						<h3 class="formTitle">Settings</h3>
					<!-- 	<div class="addBtn">
							<a href="#"><i class="fa fa-plus"></i> Add plan</a>
						</div> -->
					</div>
					

					<div class="current-order-table">
						<div class="seeting-page-container">
							
							
							<form onsubmit="return update_setting();">

								<div class="setting-lenguage-container">
									<div class="setting-header-row">
										Change Language
									</div>

									<div class="setting-colum-box">
										<div class="col-md-6">
											<div class="form-group">
												<label for="">Language<span></span></label>
												<select name="language" id="language" class="selectBox form-control">
													<option value="-1">Select Language</option>
													@foreach($data_lang AS $value)
													<option value="{{$value->language_id}}" <?php if($data[0]->lr_userdetail_lang == $value->language_id){echo 'selected';}  ?> >{{$value->language_name}}</option>
													@endforeach
												</select>
											</div>
										</div>
										<div class="clearfix"></div>
									</div>	

									<div class="setting-header-row chnge-pwd-row" onclick="return showdiv()">
										Change Password
										<span class="chnge-pwd-icon"> <i class="fa fa-caret-down"></i></span>
									</div>

									<div id="changepassdiv" style="display:none">
										<div class="setting-colum-box">	
											<div class="col-md-6">
												<div class="form-group">
													<label for="">Old Password<span></span></label>
													<input type="password" name="old_password" id="old_password" class="form-control">
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
													<label for="">Password<span></span></label>
													<input type="password" name="password" id="password" class="form-control">
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
													<label for="">Confirm Password<span></span></label>
													<input type="password" name="con_password" id="con_password" class="form-control">
												</div>
											</div>
										</div>	
									</div>	

								</div>	

								





								<div class="clearfix"></div>


								<!-- <div class="col-md-12">
									<button type="button" onclick="return showdiv()" class="chnge-pwd-btn" >Change Password</button>
								</div> -->

								



								<div class="clearfix"></div>
								<div class="col-md-6">
									<div class="submitButton">
										<div class="form-group">
											<div id="wordCnt1" style="color:red"></div>
										</div>
										<button type="submit" class="sbmtbtn">Submit</button>
									</div>
								</div>

								<div class="clearfix"></div>
							</form>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</section>

@include('Vendor::include.footer')

<script>

function showdiv()
{
	$('#changepassdiv').slideToggle();
}

function update_setting()
{
	var language =document.getElementById("language").value.trim();
	var old_password =document.getElementById("old_password").value.trim();
	var password =document.getElementById("password").value.trim();
	var con_password =document.getElementById("con_password").value.trim();

	if(language=='-1')
	{
		document.getElementById('language').style.border='1px solid #ff0000';
		document.getElementById("language").focus();
		return false;
	}
	else
	{
		document.getElementById("language").style.border = "";   
	}

	if(old_password!='' || password!='' || con_password!='')
	{
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
		else if (password.length<=5 || password.length>=51) 
		{   
			document.getElementById('password').style.borderColor='#ff0000';
			document.getElementById("password").focus();
			$('#password').val('');
			$('#password').attr("placeholder", "password Must Be Between 6-50 Char");
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



		if(password != con_password){
			document.getElementById("wordCnt1").innerHTML="Password does not match" ; 
			return false;
		}
		else
		{
			document.getElementById("wordCnt1").innerHTML="" ; 
		}
	} 



	document.getElementById("wordCnt1").style.color = "#333333";
	document.getElementById("wordCnt1").innerHTML="Please wait..." ;

	var form = new FormData();
	form.append('password', password);
	form.append('old_password', old_password);
	form.append('con_password', old_password);
	form.append('language', language);




	$.ajax({    
		headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
		type: 'POST',
		url: "{{url('/vendor/change_password')}}",
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

            	document.getElementById("wordCnt1").style.color = "green";
            	document.getElementById("wordCnt1").innerHTML=msg;
            	setTimeout(function() { location.reload(true) }, 1000);
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


      <style>
      .setting-header-row {
      	background: #75cee3;
      	border-radius: 3px;
      	padding: 5px;
      	color: #fff;
      	font-weight: 600;
      	font-size: 15px;
      }
      .setting-colum-box {
      	padding: 20px 0;
      }
      .setting-header-row.chnge-pwd-row {
      	position: relative;
      	cursor: pointer;
      }
      span.chnge-pwd-icon {
      	position: absolute;
      	right: 7px;
      }

      </style>