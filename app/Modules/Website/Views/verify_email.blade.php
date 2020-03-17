@include('Website::include.header')
@include('Website::include.error')
    <?php 
        $segment =Request::segment(3); 
        if($segment==''){
        $segment='';
        }
    ?>

<section class="health-routine-banner health-routine-contact-sec health-routine-signup-sec">
	<div class="container">
		<div class="health-routine-contact-container health-routine-signup-container">	
			
				 <div class="form-row verified-email-contaienr" >	
				
                    @if($token=='1')
                    <div class="form-title form-title-extra red green">Thanks!</div>
                    <p class="text-center">You have successfully verified your email-id.</p>
                    <div class="verify_login">
                    <a href="{{url('/login')}}"> Login Now </a>
                    </div>
                  @endif
    
                  @if($token=='2')
                  <div class="form-title form-title-extra red">Sorry!</div>
                  <p class="text-center">Your email-id is already verified.</p>
    
                 @endif
                 @if($token=='3')
                    <div class="form-title form-title-extra red">Sorry!</div>
                    <p class="text-center">Your Token has been expired.</p>
                    @endif
				<div class="clearfix"></div>
				
			</div>	
			
			
			
		</div>

	</div>
</section>


<style type="text/css">
  .health-routine-signup-container {
    padding: 40px 0;
    border: solid 1px #fff;
    margin: 50px auto;
    background: rgba(255, 255, 255, 0.23);
  }
  .health-routine-signup-container .form-title.form-title-extra.red {
    text-align: center;
    color: #fff;
    font-size: 34px;
    font-weight: 600;

}
.health-routine-signup-container .text-center {
  font-size:26px;
  color: #fff; 
}
.verify_login a {
  background: #5ec2cc;
    color: #fff;
    border: none;
    border-radius: 0;
    padding: 15px 150px;
    font-weight: 400;
    font-size: 15px;
    margin-top: 30px;
    cursor: pointer;
    margin: auto;
}
</style>
@include('Website::include.footer')