@include('Vendor::include.header')


<section class="myDashboard">
	<div class="container">
		<div class="row">
				@include('Vendor::include.sidebar')
			<div class="col-md-9">
				<div class="rightBox">
					<h3 class="formTitle">offers</h3>
					<form>
						<div class="col-md-6">
							<div class="form-group">
								<label for="">Name of plan<span>*</span></label>
								<select name="" id="" class="selectBox form-control">
									<option value=""></option>
									<option value=""></option>
									<option value=""></option>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="">Discount Rate<span>*</span></label>
								<input type="text" value="" name="" id="" class="form-control">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="">Start Date<span>*</span></label>
								<div class="input-group date" id="offerStartDate">
									<input type="text" class="form-control serch-form-input">
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="">End Date<span>*</span></label>
								<div class="input-group date" id="offerEndDate">
									<input type="text" class="form-control serch-form-input">
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
								</div>
							</div>
						</div>


						<div class="clearfix"></div>
						<div class="col-md-6">
							<div class="submitButton">
									<div id="wordCnt" style="color:red"></div>
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


<section class="inner-footer">
	<div class="inner-footer-contaienr">
		<div class="container">
				copyright @ 2019 letsroutine.com All rights reserved. <span><a href="#">Privacy Plicy</a><a href="#">Terms and conditions</a></span>
		</div>
	</div>
</section>






@include('Vendor::include.footer')

<link rel="stylesheet" href="{{url('/public/website')}}/css/datetimepicker.css"></script>
<script src="{{url('/public/website')}}/js/date-picker.js"></script>


<!-- datepiker-js-scrpit-sart -->
<script type="text/javascript">
  $(function () {
    $('#offerStartDate').datepicker();
  });
</script>
<script type="text/javascript">
  $(function () {
    $('#offerEndDate').datepicker();
  });
</script>
<!-- datepiker-js-scrpit-end-->