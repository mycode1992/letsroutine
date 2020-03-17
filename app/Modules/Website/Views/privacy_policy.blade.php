@include('Website::include.header')


<section class="health-routine-banner MT-120">
	<div class="container">
			<!-- <div class="routine-logo  wow fadeIn" data-wow-duration="0.4s" data-wow-delay="0.4s">
					<img src="img/Routine-logo.webp" class="img-responsive">
			</div> -->
			
			<div class="routine-banner-social-area">
				<div class="routine-banner-title  wow fadeIn" data-wow-duration="0.6s" data-wow-delay="0.6s">Privacy Policy</div>	
				<div class="routine-banner-subtitle wow fadeIn" data-wow-duration="0.7s" data-wow-delay="0.7s">
					<?php echo $data[0]->lr_cms_description; ?>

				</div>
				
			</div>
	</div>
</section>

@include('Website::include.footer')