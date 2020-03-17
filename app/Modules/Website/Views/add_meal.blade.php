
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
					<h3 class="formTitle">Add Meal</h3>
					<form action="">
						<div class="col-md-6">
							<div class="form-group">
								<label for="">Name of meal<span>*</span></label>
								<input type="text" class="form-control">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="">Meal<span>*</span></label>
								<select name="" id="" class="form-control">
									<option value="1"></option>
									<option value="1">Meal</option>
								</select>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="">Calories</label>
								<input type="text" class="form-control">
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="">Fat</label>
								<input type="text" class="form-control">
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="">Carb</label>
								<input type="text" class="form-control">
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="">Protien</label>
								<input type="text" class="form-control">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="">Description<span>*</span></label> 
								<textarea name="" id="" cols="10" rows="10" class="form-control"></textarea>
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