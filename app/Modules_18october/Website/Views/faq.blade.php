@include('Website::include.header')


<section class="health-routine-banner MT-120">
	<div class="container">
			<!-- <div class="routine-logo  wow fadeIn" data-wow-duration="0.4s" data-wow-delay="0.4s">
					<img src="img/Routine-logo.webp" class="img-responsive">
				</div> -->

				<div class="routine-banner-social-area">
					<div class="routine-banner-title  wow fadeIn" data-wow-duration="0.6s" data-wow-delay="0.6s">FAQs</div>	
			 	<!-- <div class="routine-banner-subtitle wow fadeIn" data-wow-duration="0.7s" data-wow-delay="0.7s">
						<?php echo $data[0]->lr_cms_description; ?>

				</div> -->
				

			<div class="faq-container">
				<div class="faq-accordian-container">

					<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
						<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="headingOne">
								<h4 class="panel-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
										What is Routine?
									</a>
								</h4>

							</div>
							<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
								<div class="panel-body">Routine is a platform that provides healthy solutions for anyone seeking weight loss, bodybuilding or a healthy lifestyle. Our digital market place will connect customers looking for health services with multiple diet centers by just one click. Our in-app built features thrive to enhance customers experience by supporting individuals to reach their targeted goal and ensure that all orders made reach customers doors step in a timely fashion. </div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="headingTwo">
								<h4 class="panel-title">
									<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
										What services does Routine offer?
									</a>
								</h4>

							</div>
							<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
								<div class="panel-body">
									Routine is the solution to any individual seeking weight loss, bodybuilding or maintaining a healthy lifestyle. We offer a wide range of subscription options customized to each person needs.<br>
									The diet centers partnering with routine provide distinctive subscription options that are either calories/macros based or customized macros based plans. 
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="headingThree">
								<h4 class="panel-title">
									<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
										How can I order from Routine?
									</a>
								</h4>

							</div>
							<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
								<div class="panel-body">You can order through Routine app, available on IOS and Andriod.</div>
							</div>
						</div>

						<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="headingFour">
								<h4 class="panel-title">
									<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
										How can I place an order through Routine app?
									</a>
								</h4>

							</div>
							<div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
								<div class="panel-body">
									<div class="accordian-container-list-contaienr">
										<ul>

											<li>1- Open Routine app, register, and insert your height and weight through my nutritionist page.</li>
											<li>2- Choose your subscription type ( Weekly, Monthly, Packages ) and choose a plan from the ones listed. </li>
											<li>3- Choose your start date from the calendar displayed, and ensure that you input your allergies/dislikes.</li> 
											<li>4- Select your meals by clicking on any category of the ones listed ( breakfast, lunch, dinner) and ensure that you choose all the meals for the selected day. Press submit and move to the next day from the calendar.</li>
											<li>5- Repeat the same steps of point 4, and choose your meals for at least the first seven days.</li>
											<li>6- Checkout and complete the rest of your meals selection after payment through current orders tab listed in the toolbar.</li>
										</ul>
									</div>	
								</div>
							</div>
						</div>

						<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="headingFive">
								<h4 class="panel-title">
									<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
										What are the differences between the weekly, monthly, and packages plans type?
									</a>
								</h4>

							</div>
							<div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
								<div class="panel-body">
									<div class="accordian-container-list-contaienr">
										<ul>
											<li>- Weekly plans indicate that the diet centers listed offer a 1-week subscription only.</li>
											<li>- Monthly plans mean that the diet centers listed offer a 1-month subscription only.</li>
											<li>- Packages plans indicate that multiple diet centers are under one package for a subscription duration of 1-month only. The packages feature offer two subscription options,  either two diet centers, two weeks each, or four diet centers, one week each.</li> 
										</ul>
									</div>
								</div>
							</div>
						</div>

						<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="headingSix">
								<h4 class="panel-title">
									<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
										What is my nutritionist page?
									</a>
								</h4>

							</div>
							<div id="collapseSix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSix">
								<div class="panel-body">
									It is a page where you can insert your height and weight to observe your BMI status. It guides you in learning the number of calories or macros your body acquire to reach your desired goal of weight loss, bodybuilding, or maintaining a healthy lifestyle.
									The page is also supported by a weight chart that will help you track your progress by updating your weight status weekly.
								</div>
							</div>
						</div>

						<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="headingSeven">
								<h4 class="panel-title">
									<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
										What is Fitness page and how it works?
									</a>
								</h4>

							</div>
							<div id="collapseSeven" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSeven">
								<div class="panel-body">
									Fitness Page will provide you with your daily activity status along with calories burned on each day. This page will be dependent upon connecting the smartwatch with your mobile phone. 
								</div>
							</div>
						</div>

						<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="headingEight">
								<h4 class="panel-title">
									<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
										What is my wallet page?
									</a>
								</h4>

							</div>
							<div id="collapseEight" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingEight">
								<div class="panel-body">
									My wallet page will collect any refunds issued by the diet centers, in which you can use either as a credit when placing another order or as a reimbursement to your bank account. Add credit feature will also be applicable under this page.
								</div>
							</div>
						</div>

						<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="headingNine">
								<h4 class="panel-title">
									<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
										What is the notifications page?
									</a>
								</h4>

							</div>
							<div id="collapseNine" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingNine">
								<div class="panel-body">All the announcements and offers will be displayed under this page.</div>
							</div>
						</div>

						<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="headingTen">
								<h4 class="panel-title">
									<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
										Does all diet centers provide a menu in which I can choose meals from?
									</a>
								</h4>

							</div>
							<div id="collapseTen" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTen">
								<div class="panel-body">No, it is dependent upon the diet center. Some diet centers provide a pre-set fixed menu in which you are not allowed to customize your meals selections. Other diet centers will offer a menu where you can customize your daily meal choices.</div>
							</div>
						</div>

						<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="headingEleven">
								<h4 class="panel-title">
									<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseEleven" aria-expanded="false" aria-controls="collapseEleven">
										What are the forms of payment?
									</a>
								</h4>

							</div>
							<div id="collapseEleven" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingEleven">
								<div class="panel-body">To provide you with the highest quality service, we only accept payments through Visa/Mastercard and K-Net.</div>
							</div>
						</div>

						<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="headingTweleve">
								<h4 class="panel-title">
									<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTweleve" aria-expanded="false" aria-controls="collapseTweleve">
										Why should I order through Routine and not by visiting the diet center branch?
									</a>
								</h4>

							</div>
							<div id="collapseTweleve" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTweleve">
								<div class="panel-body">Routine aims to facilitate your ordering experience by collecting all the info needed from diet centers and brings it all straight to your hands. With routine, you will save your valuable time and effort by just a click.</div>
							</div>
						</div>

						<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="headingThirteen">
								<h4 class="panel-title">
									<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThirteen" aria-expanded="false" aria-controls="collapseThirteen">
										What if I want to pause my subscription, is it possible?
									</a>
								</h4>

							</div>
							<div id="collapseThirteen" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThirteen">
								<div class="panel-body">Pausing your subscription will be dependent on the diet center. Some diet centers allow you to pause your subscription for a specific period. If your diet center provides a pause feature, you can select the pausing days either when ordering or through current orders page after checkout. 
									p.s: you can only place a pausing request if the desired day to pause is greater the 48 hours of the time you set the pause. </div>
								</div>
							</div>

							<div class="panel panel-default">
								<div class="panel-heading" role="tab" id="headingFourteen">
									<h4 class="panel-title">
										<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFourteen" aria-expanded="false" aria-controls="collapseFourteen">
											Can I select my meals choices after placing an order?
										</a>
									</h4>

								</div>
								<div id="collapseFourteen" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFourteen">
									<div class="panel-body">
										Yes, but to provide you with the best possible experience, choosing your meals for the first seven days before checking out is required. After placing your order, you can select the rest of the meals through my current order page.
									</div>
								</div>
							</div>

							<div class="panel panel-default">
								<div class="panel-heading" role="tab" id="headingFifteen">
									<h4 class="panel-title">
										<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFifteen" aria-expanded="false" aria-controls="collapseFifteen">
											How are the meals delivered to me?
										</a>
									</h4>

								</div>
								<div id="collapseFifteen" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFifteen">
									<div class="panel-body">Once you place your order, the diet center you are subscribed with is responsible for delivering your meals based on the delivery period you selected.</div>
								</div>
							</div>

							<div class="panel panel-default">
								<div class="panel-heading" role="tab" id="headingSixteen">
									<h4 class="panel-title">
										<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseSixteen" aria-expanded="false" aria-controls="collapseSixteen">
											What can i do if there is a mistake in my order?
										</a>
									</h4>

								</div>
								<div id="collapseSixteen" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSixteen">
									<div class="panel-body">
										Since our primary goal is enhancing your experience with our services, It is unlikely that you will experience that issue with Routine. But in case it happens, you can reach us through the customer care page.
									</div>
								</div>
							</div>



						</div>

					</div>
				</div>


			</div>
		</div>
	</section>




	<style type="text/css">
	.faq-accordian-container .panel-title > a:before {
		float: right !important;
		font-family: FontAwesome;
		content:"\f068";
		padding-right: 5px;
	}
	.faq-accordian-container .panel-title > a.collapsed:before {
		float: right !important;
		content:"\f067";
	}

	.faq-accordian-container .panel-default>.panel-heading{
		color: #fff;
		background: rgba(158, 212, 233, 0.71);
		padding: 0;
	}

	.faq-accordian-container .panel-title > a:hover, 
	.faq-accordian-container .panel-title > a:active, 
	.faq-accordian-container .panel-title > a:focus  {
		text-decoration:none;
	}
	.faq-accordian-container h4.panel-title a {
		padding:10px; 
		display: block;
	}
	.faq-accordian-container .panel-body {
		padding: 15px;
		font-size: 14px;
	}
	.accordian-container-list-contaienr ul {
		list-style: none;
		margin: 0;
		padding: 0;
	}
	.accordian-container-list-contaienr ul li {
		padding: 5px 0;
	}
	</style>
	@include('Website::include.footer')