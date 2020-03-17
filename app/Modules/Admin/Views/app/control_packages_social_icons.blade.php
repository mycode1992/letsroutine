@include('Admin::common.header')
@include('Admin::common.sidebar')
@include('Admin::common.error')
  <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Customer Service
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/lradmin/app/customer-service')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">App</a></li>
        <li class="active">Control Packages & Social Icons</li>
      </ol>
    </section>

    @php

        $success='btn-success';
        $butttext='ACTIVE';

        $package_status = $data[0]->app_control_status;
        $social_status = $data[1]->app_control_status; 

        if($package_status==1)
        {
        $package_success='btn-success';
        $package_butttext='ACTIVE';
        }
        else
        {
        $package_success='btn-danger';
        $package_butttext='DEACTIVE';
        }

         if($social_status==1)
        {
        $social_success='btn-success';
        $social_butttext='ACTIVE';
        }
        else
        {
        $social_success='btn-danger';
        $social_butttext='DEACTIVE';
        } 

    @endphp

    <!-- Main content -->
     <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">Control Packages & Social Icons
                <!-- <small>Advanced and full of features</small> -->
              </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body pad">
                    Packages
                      <div id="1" >
                      
                        <a href="javascript:void(0);"  class="btn btn-block {{$package_success}}  btn-flat" onclick="return changestatus( 1 , <?php echo $package_status;?>)">
                            {{$package_butttext}}
                            </a>
                   </div>
                

            Social Icons
            <div id="2" >
                <a href="javascript:void(0);"  class="btn btn-block {{$social_success}}  btn-flat" onclick="return changestatus( 2 , <?php echo $social_status;?>)">
                        {{$social_butttext}}
                        </a>
            </div>
           
            </div>
          </div>
          <!-- /.box -->

        </div>
        <!-- /.col-->
      </div>
      <!-- ./row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @include('Admin::common.footer')

<script>
    function changestatus(id,status)
    {
        var tblname = 'tbl_app_control';
        var status_val;
        var colwhere = 'app_control_id';
        var colstatus = 'app_control_status';
        if(status==0)
        {
        status_val=1;
        }
        else
        {
            status_val=0;
        }

        $.ajax({
        headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
        method: "POST",
        url:"{{url('/lradmin/changestatus')}}",
        data: { id:id, status:status_val,tblname:tblname,colwhere:colwhere,colstatus:colstatus}

        })
        .done(function( msg ) {
        console.log(msg); //return false;
		var tempst=0;
		var tempstr="";
		if(status==0)
		{
		  tempst=1;
		  tempstr="ACTIVE";
		  color="btn-success";
		}

		if(status==1)
		{
		  tempst=0;
		  tempstr="DEACTIVE";
		  color="btn-danger";
		}

		$("#"+id).html("<a href='javascript:void(0);' class='btn btn-block btn-flat  "+color+"' onclick='changestatus("+id+","+tempst+")'>"+tempstr+"</a>");


		   });
        }
</script>
