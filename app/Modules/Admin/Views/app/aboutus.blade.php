@include('Admin::common.header')
@include('Admin::common.sidebar') 
@include('Admin::common.error')
  <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        About Us
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/lradmin/app/about-us')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">App</a></li>
        <li class="active">About Us</li>
      </ol>
    </section>

    <!-- Main content -->
     <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">Description
                <!-- <small>Advanced and full of features</small> -->
              </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body pad">
              <form method="post" action=""  onsubmit="return updateaboutus();" id="aboutusform" name="aboutusform">
                    <textarea id="editor1" name="editor1" rows="10" cols="80"><?php echo $data[0]->app_cms_desp; ?></textarea>
                      <span  id="wordCnt"></span>                  
                 <div class="box-footer text-center">
                  <input type="submit" class="btn btn-sm btn-info btn-flat pull-right uppercase" value="Update">
                </div>
                
              </form>
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
function updateaboutus()
{
  var aboutus = CKEDITOR.instances.editor1.getData();
    if(aboutus =='')
    {
    document.getElementById("wordCnt").style.color = "red";
    document.getElementById("wordCnt").innerHTML="Please enter Description." ;
    return false;
    }
    document.getElementById("wordCnt").style.color = "#333333";
    document.getElementById("wordCnt").innerHTML="Please wait..." ;

    var form = new FormData();
    form.append('aboutus', aboutus);

		$.ajax({
			headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
			type:'POST',
			url: "{{url('/lradmin/app/update_aboutus')}}",
			data:form, 
			contentType: false,
      processData: false,
			success:function(data){
         var status = data.status;
         var msg = data.msg;
				console.log(data);
			//	return false;
				if(status=="200"){
					 document.getElementById("wordCnt").innerHTML="" ; 
		         document.getElementById("wordCnt").style.color = "#ff0000";
				//		console.log('sweta'); return false;	
					document.getElementById("wordCnt").style.color = "#278428";
					document.getElementById("wordCnt").innerHTML=msg;
				
					setTimeout(function() { location. reload(true); }, 2000);
				} else if(status=="401"){
					document.getElementById("wordCnt").style.color = "#ff0000";
         			document.getElementById("wordCnt").innerHTML=msg ;
				}
			}
	    });	

			return false;
  }// end of function

  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('editor1')
    
  })

</script>