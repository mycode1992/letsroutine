@include('Admin::common.header')
@include('Admin::common.sidebar')
@include('Admin::common.error')
  <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        User Edit
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('lradmin/app/user-list/user_edit/'.'rree') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">App</a></li>
        <li class="active">User Edit</li>
      </ol>
    </section>

    <!-- Main content -->
     <section class="content">

         @if(Session::has('msg'))
         <div class="row">
          <div class="alert alert-success col-lg-6" id="msgdiv">
             {{ Session::get('msg') }}
          </div>
           </div>
         @endif

          <h2></h2>
          <div class="box">
          <div class="box-body">
          <div class="box-header with-border">
          <form action="{{url('/lradmin/app/user_edit/'.$user->user_uniqueid)}}" method="post">
            {{ csrf_field() }}
          <div class="box-body vendor-form">
          <div class="col-md-12">
          <div class="clearfix"></div>
          <div class="form-row">
          <div class="form-group col-sm-6">
          <label for="inputPassword3" class="control-label">First Name</label>
          <input type="text" class="form-control"  onkeypress="return isChar(event) ;" id="fname" name="firstname" placeholder="First Name" maxlength="50"  value="{{$user->app_user_fname}}">
          <em id="faq_question_err" class="text-danger">
            @if ($errors->has('firstname'))
                {{ $errors->first('firstname') }}
            @endif
          </em>
          </div>
          <div class="form-group col-sm-6">
          <label for="inputPassword3" class="control-label">Last Name</label>
          <input type="text" class="form-control"  onkeypress="return isChar(event) ;" id="lname" name="lastname" placeholder="Last Name" maxlength="50" value="{{$user->app_user_lname}}">
          <em id="faq_question_err" class="text-danger">
            @if ($errors->has('lastname'))
                {{ $errors->first('lastname') }}
            @endif
          </em>
          </div>
          </div>

          <div class="form-row">
            <div class="form-group col-sm-6">
            <label for="inputPassword3" class="control-label">Email Address</label>
            <input type="text" class="form-control" value="{{$user->app_user_email}}" readonly="" id="email" name="email" placeholder="Email Address" maxlength="50">
            </div>

          <div class="form-group col-sm-6">
          <label for="inputPassword3" class="control-label">Phone Number</label>
          <input type="text" class="form-control"   id="phone_no" name="phone_no" placeholder="Phone Number" maxlength="10" value="{{$user->app_user_phone }}" maxlength="10">
          <em id="faq_question_err" class="text-danger">
            @if ($errors->has('phone_no'))
                {{ $errors->first('phone_no') }}
            @endif
          </em>
          </div>

          </div>

          <div class="form-row">
          <div class="form-group col-sm-6">
          <label for="inputPassword3" class="control-label">Gender</label>
          <select name="gender" class="form-control">
          <option value="MALE" {{ ($user->app_user_gender=='MALE') ? 'selected' : '' }}>Male</option>
          <option value="FEMALE" {{ ($user->app_user_gender=='FEMALE') ? 'selected' : '' }} >Female</option>
          </select>
         <em id="faq_question_err" class="text-danger">
           @if ($errors->has('gender'))
               {{ $errors->first('gender') }}
           @endif
         </em>
          </div>
          <div class="form-group col-sm-6">
          <label for="inputPassword3" class="control-label">Date Of Birth</label>
            <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" placeholder="Enter Date Of Birth..." value="{{$user->app_user_dob}}">
          </label>
          <em id="faq_question_err" class="text-danger">
            @if ($errors->has('date_of_birth'))
                {{ $errors->first('date_of_birth') }}
            @endif
          </em>
          </div>
          </div>
          <div class="form-row">
          <div class="form-group col-sm-6">
          <label for="inputPassword3"  class="control-label">Area</label>
           <select name="area" class="form-control">
             @foreach($area as $data)
               <option value="{{ $data->lr_governorate_area_id }}" {{ ($data->lr_governorate_area_id==$user->lr_governorate_area_id) ? 'selected' : '' }}>{{ $data->lr_governorate_area_name }}</option>
             @endforeach
           </select>
          <em id="faq_question_err" class="text-danger">
            @if ($errors->has('area'))
                {{ $errors->first('area') }}
            @endif
          </em>

          </div>
          </div>



          <div class="col-sm-12-col-md-12 col-xs-12 pd-left0"><span id="errormsg1"></span></div>
          <div class="col-sm-12-col-md-12 col-xs-12 ">
          <div class="box-footer">
            <a href="{{url('lradmin/app/user-list/all_user')}}" class="btn btn-warning btn-flat pull-left">Back</a> &nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;<button type="Submit" class="btn btn-info btn-flat pull-left" onclick="return form_validation()">Submit</button>
          </div>
          </div>

          </form>
        </div>
        </div>
        </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @include('Admin::common.footer')
<script>
 $(document).ready(function() {

   function isChar(evt)
 {

var iKeyCode = (evt.which) ? evt.which : evt.keyCode

if (iKeyCode != 46 && iKeyCode > 31 && iKeyCode > 32 && (iKeyCode < 65 || iKeyCode > 90)&& (iKeyCode < 97 || iKeyCode > 122))
{
  return false;
}
else if(iKeyCode == 46)
{
  return false;
}
else
{
 return true;

 }
 }

  function testInput(event) {
            var value = String.fromCharCode(event.which);
            var pattern = new RegExp(/[0-9]/i);
            if(!pattern.test(value))
            {
              ///alert("Numbers Only");
              return false;
            }
            return pattern.test(value);
        }

        $('#phone_no').bind('keypress', testInput);
   $('#msgdiv').fadeOut(7000);
 });


</script>
