
@include('Vendor::include.header')



<section class="myDashboard">
	<div class="container">
		<div class="row">
				@include('Vendor::include.sidebar')
		
			<div class="col-md-9">
				<div class="rightBox">
					<h3 class="formTitle">Current orders</h3>
						
					<div class="current-order-table">
						                       
						<div class="table-responsive">          
							<table class="table">
								<thead>
									<tr>
										<th>S.No</th>
										<th>Order number</th>
										<th>User name</th>
										<th>Order date</th>
										<th>Order detials</th>
									</tr>
								</thead>
								<tbody>
									<tr class="even-row">
										<td>1.</td>
										<td>0006</td>
										<td>Fallon</td>
										<td>16/04/2019</td>
										<td><span class="order-detail-icon"><a href="#"><i class="fa fa-angle-right"></i></a></span></td>
									</tr>
									<tr class="odd-row">
										<td>2.</td>
										<td>0007</td>
										<td>Art</td>
										<td>16/04/2019</td>
										<td><span class="order-detail-icon"><a href="#"><i class="fa fa-angle-right"></i></a></span></td>
									</tr>
									<tr class="even-row">
										<td>3.</td>
										<td>0008</td>
										<td>Jeffery</td>
										<td>16/04/2019</td>
										<td><span class="order-detail-icon"><a href="#"><i class="fa fa-angle-right"></i></a></span></td>
									</tr>
									<tr class="odd-row">
										<td>4.</td>
										<td>0009</td>
										<td>Raymond</td>
										<td>16/04/2019</td>
										<td><span class="order-detail-icon"><a href="#"><i class="fa fa-angle-right"></i></a></span></td>
									</tr>
								</tbody>
							</table>
						</div>	
					</div>

				</div>
			</div>
		</div>
	</div>
</section>

@include('Vendor::include.footer')