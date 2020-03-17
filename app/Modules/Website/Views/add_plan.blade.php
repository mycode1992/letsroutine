
<span style="display:none;">
@include('Website::include.header')
</span>
<section class="dashboard-header">
	<div class="dashboard-header-container">
		<div class="container">
			<div class="dasboard-heder-area">
			<div class="dashboard-header-logo"><img src="{{url('/')}}/public/website/img/dashboard-logo.png" alt="" class="img-responsive"></div>
			<div class="dashboard-loing-img">
				<div class="dropdown ti-navdropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><img src="{{url('/')}}/public/website/img/user.jpg" alt="" class="img-responsive img-circle"><span class="caret-icon"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></span></a>
					<ul class="dropdown-menu">
						<li><a href="#">My profile</a></li>
						<li><a href="#">Sign out</a></li>
					</ul>
				</div>
			</div>
			</div>

		</div>
	</div>
</section>
<section class="myDashboard">
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<div class="leftBox">
					<div class="left">
						<div class="userProfilePicBox">
							<div class="userUplodImg">
								<form action="#" method="POST" id="form_user_profile_change">
									<div class="gfuserUploadImg">
										<img src="{{url('/')}}/public/website/img/user.jpg" alt="" class="profile_thumb">
									</div>
									<div type="button" class="btn">
										<label for="a"><i class="fa fa-pencil"></i></label>
										<input id="" name="profilepic" type="file" class="profileUplod">
									</div>
								</form>
							</div>
							<h4 class="text-uppercase white">John Doe</h4>
						</div>
					</div>
					<div class="leftLinks" id="MainMenu">
						<ul>
							<li>
								<a href="#" class="">
									<img src="{{url('/')}}/public/website/img/my_profile.png" alt=""> My Profile
								</a>
							</li>
							<li>
								<a href="#" class="active">
									<img src="{{url('/')}}/public/website/img/Current_orders.png" alt=""> Current Orders
								</a>
							</li>
							<li>
								<a href="#demo3" class="" data-toggle="collapse" data-parent="#MainMenu">
									<img src="{{url('/')}}/public/website/img/Menu.png" alt=""> Menu <span> <i class="fa fa-caret-down"></i></span>
								</a>
								<div class="collapse" id="demo3">
									<a href="#" class="list-group-item" data-parent="#SubMenu1">Subitem 1 a</a>
									<a href="#" class="list-group-item" data-parent="#SubMenu1">Subitem 2 b</a>
								</div>
							</li>
							<li>
								<a href="#demo4" class="" data-toggle="collapse" data-parent="#MainMenu">
									<img src="{{url('/')}}/public/website/img/Menu.png" alt=""> Meal <span> <i class="fa fa-caret-down"></i></span>
								</a>
								<div class="collapse" id="demo4">
									<a href="#" class="list-group-item" data-parent="#SubMenu1">Add Meal</a>
									<a href="#" class="list-group-item" data-parent="#SubMenu1">Meal List</a>
								</div>
							</li>
							<li>
								<!-- <a href="#demo4" class=""  data-toggle="collapse" data-parent="#MainMenu"> -->
								<a href="#" class=""  data-toggle="" data-parent="#">
									<img src="{{url('/')}}/public/website/img/Plans.png" alt=""> Plans
								</a>
								<!-- <div class="collapse" id="demo4">
									<a href="" class="list-group-item">Subitem 1</a>
									<a href="" class="list-group-item">Subitem 2</a>
									<a href="" class="list-group-item">Subitem 3</a>
								</div> -->
							</li>
							<li>
								<a href="#" class="">
									<img src="{{url('/')}}/public/website/img/Packages_info.png" alt=""> Package Info
								</a>
							</li>
							<li>
								<a href="#" class="">
									<img src="{{url('/')}}/public/website/img/Orders_history.png" alt=""> Order History
								</a>
							</li>
							<li>
								<a href="#" class="">
									<img src="{{url('/')}}/public/website/img/Offers.png" alt=""> Offers
								</a>
							</li>
							<li>
								<a href="#" class="">
									<img src="{{url('/')}}/public/website/img/Notifications.png" alt=""> Notifications and announcement
								</a>
							</li>
							<li>
								<a href="#" class="">
									<img src="{{url('/')}}/public/website/img/Settings.png" alt=""> settings
								</a>
							</li>
							<li>
								<a href="#" class="">
									<img src="{{url('/')}}/public/website/img/report.png" alt=""> Report a problem
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-md-9">
				<div class="rightBox">
					<h3 class="formTitle">Add Plan</h3>
					<form action="">
						<div class="col-md-6">
							<div class="form-group">
								<label for="">What is the Plan name?<span>*</span></label>
								<input type="text" class="form-control">
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="">Meals <span>*</span></label>
								<input type="text" class="form-control">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="">Snacks <span>*</span></label>
								<input type="text" class="form-control">
							</div>
						</div>
							<div class="col-md-6">
							<div class="form-group">
								<label for="">Macros (Carb, Protein) <span>*</span></label>
								<select class="form-control">
									<option>Yes</option>
									<option>No</option>
								</select>
							</div>


						</div>


							<div class="clearfix"></div>
						
							<div class="col-md-6">
							<div class="form-group">
								<label for="">Min carb <span>*</span></label>
								<input type="text" class="form-control">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="">Max carb <span>*</span></label>
								<input type="text" class="form-control">
							</div>
						</div>
							<div class="col-md-6">
							<div class="form-group">
								<label for="">Min Protein <span>*</span></label>
								<input type="text" class="form-control">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="">Max Protein <span>*</span></label>
								<input type="text" class="form-control">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="">per meal or once for the whole plan period?<span>*</span></label>
								<select class="form-control">
									<option>Per meal</option>
									<option>Once for the whole plan period</option>
								</select>
							</div>
						</div>
							<div class="col-md-6">
							<div class="form-group">
								<label for="">Min carb </label>
								<input type="text" class="form-control">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="">Max protien </label>
								<input type="text" class="form-control">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label for="">Which gender does the plan serve? </label>
								<select class="form-control">
									<option>Male</option>
									<option>Female</option>
									<option>Both</option>
								</select>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="">What is the maximum number of days users can pause their plan? <span>*</span></label>
								<select class="form-control">
									<option>None</option>
									<option>1</option>
									<option>2</option>
									<option>3</option>
									<option>4</option>
									<option>5</option>
									<option>6</option>
									<option>7</option>
									<option>8</option>
									<option>9</option>
									<option>10</option>
									<option>unlimited</option>
								</select>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="">Which of the following categories does the plan fall under? <span>*</span></label>
								<select class="form-control">
									<option>Weight loss</option>
									<option>Body building</option>
									<option>lifestyle</option>
									<option>Atkins</option>
									<option>Vegetarian</option>
									<option>Vegan</option>
									<option>Diabetes</option>
									<option>Gluten free</option>
									<option>Cholesterol</option>
									<option>Detox</option>
								</select>
							</div>
						</div>

						<div class="col-md-12">
							<div class="form-group">
								<label for="">Which of the following subcategory does the plan fall under? <span>*</span></label>
								<select class="form-control">
									<option>None</option>
									<option>Keto</option>
									<option>Paleo</option>
								</select>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="">What is the plan type?<span>*</span></label>
								<select class="form-control">
									<option>Monthly</option>
									<option>Weekly</option>
									<option>one week</option>
									<option>two week</option>
									<option>three week</option>
								</select>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="">Routine is providing a package feature which combines multiple diet centers plans under one package, are you interested in including the current plan under both the packages feature and weekly plans feature ?<span>*</span></label>
								<select class="form-control">
									<option>Weekly plans feature only</option>
									<option>Packages plan feature only</option>
									<option>Both weekly and packages</option>
								</select>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label for="">What is the cost of the plan per week in the packages feature? <span>*</span></label>
								<input type="text" class="form-control">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label for="">What is the plan duration in terms of days (excluding the off days) ? <span>*</span></label>
								<input type="text" class="form-control">
							</div>
						</div>

					<div class="col-md-12">
						<div class="form-group">
								<label for="">What are the off days for the current plan ? <span>*</span></label>
									<select class="form-control">
									<option>None</option>
									<option>Weekend</option>
									<option>Thursday</option>
									<option>Friday</option>
									<option>Saturday</option>
									<option>Sunday</option>
									<option>Monday</option>
									<option>Tuesday</option>
									<option>Wednesday</option>
								</select>
							</div>
					</div>
					<div class="col-md-6">
								<label for="">What is the cost of the plan? <span>*</span></label>
							<div class="form-group">
								<input type="text" class="form-control">
							</div>
						</div>

						<div class="col-md-12">
						<div class="form-group">
								<label for="">Does the plan follow a custom menu where users can choose from or a fixed Menu? <span>*</span></label>
									<select class="form-control">
									<option>Fixed menu</option>
									<option>Custom menu</option>
								</select>
							</div>
					</div>

					<div class="col-md-12">
						<div class="form-group">
								<label for="">Select the menu that represents the current plan? <span>*</span></label>
									<select class="form-control">
									<option>Menu 1</option>
									<option>Menu 2</option>
									<option>Menu 3</option>
									<option>Create a new menu</option>
								</select>
							</div>
					</div>





						<div class="col-md-6">
							<div class="submitButton">
								<button type="submit" class="sbmtbtn">Submit</button>
							</div>
						</div>
						
						<div class="clearfix"></div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>

@include('Website::include.footer')