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
						
                    @if(count($data)>0)     
					@foreach($data as $data)	
						<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="headingOne{{$loop->iteration}}">
								<h4 class="panel-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne{{$loop->iteration}}" aria-expanded="true" aria-controls="collapseOne{{$loop->iteration}}">
										{{ $data->lr_cms_title }}
									</a>
								</h4>

							</div>
							<div id="collapseOne{{$loop->iteration}}" class="panel-collapse collapse @if($loop->iteration==1)  in  @endif" role="tabpanel" aria-labelledby="headingOne{{$loop->iteration}}">
								<div class="panel-body">
									<?php echo str_replace('"', '', $data->lr_cms_description); ?>
								</div>
							</div>
						</div>
	 
                          @endforeach
                          @else 
                           <h3 class="text-danger">No Faq Available</h3>
                          @endif

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