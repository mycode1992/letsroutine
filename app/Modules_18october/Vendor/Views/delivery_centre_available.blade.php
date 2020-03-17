

@include('Vendor::include.header')
@include('Website::include.error')
@php
if(count($data)>0)
{
    $lr_delivery_status   = $data[0]->lr_delivery_status;
    $lr_delivery_status_available_after   = $data[0]->lr_delivery_status_available_after;
}
else
{
    $lr_delivery_status   = '';
    $lr_delivery_status_available_after   = '';
}

@endphp

<section class="myDashboard">
    <div class="container">
        <div class="row">
            @include('Vendor::include.sidebar')
            <div class="col-md-9">
                <div class="rightBox">

                    <h3 class="formTitle">Diet center Availability status</h3> 
                    <form onsubmit="return submit_dietavailablestatus()">
                       <div class="sub-heading">Diet center Availability status</div>

                    <div class="col-md-6">
                         <div class="coustam-checkbox">
                        <input type="radio" id="test1" onclick="return availablehoursblock('hide')" name="avalability_status" class="avalability_status" <?php if($lr_delivery_status=='AVAILABLE'){echo 'checked=true';} ?> value="AVAILABLE">
                        <label for="test1">Available</label>
                    </div>

                        <!--   Available <input type="radio" onclick="return availablehoursblock('hide')" name="avalability_status" class="avalability_status" <?php if($lr_delivery_status=='AVAILABLE'){echo 'checked=true';} ?> value="AVAILABLE"> -->
                     </div>   
                    
                    <div class="col-md-6">
                         <div class="coustam-checkbox">
                     <input type="radio" id="test2" name="avalability_status" <?php if($lr_delivery_status=='BUSY'){echo 'checked=true';} ?> onclick="return availablehoursblock('hide')" class="avalability_status" value="BUSY">
                     <label for="test2">Busy</label>
                        </div>

                      <!--  Busy <input type="radio" name="avalability_status" <?php if($lr_delivery_status=='BUSY'){echo 'checked=true';} ?> onclick="return availablehoursblock('hide')" class="avalability_status" value="BUSY">  -->
                    </div>

 <div class="clearfix"></div>
                    <div class="col-md-6">
                        <div class="coustam-checkbox">
                        <input type="radio" id="test3"  class="avalability_status" <?php if($lr_delivery_status=='AVAILABLE AFTER X HOURS'){echo 'checked=true';} ?> onclick="return availablehoursblock('show')" name="avalability_status" value="AVAILABLE AFTER X HOURS"> 
                     <label for="test3"> Available after x hours</label>
                </div>

                   <!--     Available after x hours<input type="radio" class="avalability_status" <?php if($lr_delivery_status=='AVAILABLE AFTER X HOURS'){echo 'checked=true';} ?> onclick="return availablehoursblock('show')" name="avalability_status" value="AVAILABLE AFTER X HOURS">  -->
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-6">

                        <div class="form-group"  id="availablehoursblock" style="display:none">
                            <label for=""> Available after :</label>
                           <input type="text" name="available_after" id="available_after" value="{{$lr_delivery_status_available_after}}">
                        </div>
<!-- 
                       <div id="availablehoursblock" style="display:none">
                        Available after :   <input type="text" name="available_after" id="available_after" value="{{$lr_delivery_status_available_after}}">
                        </div> -->
                    </div>    

                    <div>
                         <div class="clearfix"></div>
                        <div class="form-group">
                            <div id="wordCnt" style="color:red"></div>
                        </div>
                        <!-- <input type="submit"  value="Submit" /> -->
                        <div class="col-md-6">
                            <div class="submitButton">
                                <div id="wordCnt" style="color:red"></div>
                                <button type="submit" class="sbmtbtn">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</section>

@include('Vendor::include.footer')

<script>
$(document).ready()
{
    var avalability_status  = $('.avalability_status:checked').val();
    if(avalability_status=='AVAILABLE AFTER X HOURS'){
        availablehoursblock('show');
    }
}

function availablehoursblock(status)
{
    if(status=='show')
    {
        $('#availablehoursblock').css('display','block');
    }
    else if(status=='hide')
    {
        $('#availablehoursblock').css('display','none');
    }
    else
    {
        alert("Something went wrong, please try again later.");
    }

}

function submit_dietavailablestatus()
{   
    var avalability_status  = $('.avalability_status:checked').val();
    var available_after = '';

    if(avalability_status==null)
    {
        alert("Please select your availability status.");
        return false;
    }   
    if(avalability_status=='AVAILABLE AFTER X HOURS')
    {
        available_after = $('#available_after').val();
        if(available_after=="")
        {
            document.getElementById('available_after').style.border='1px solid #ff0000';
            document.getElementById("available_after").focus();
            $('#available_after').val('');
            $('#available_after').attr("placeholder", "Please enter");
            $("#available_after").addClass( "errors" );
            return false;
        }
        else
        {
            document.getElementById("available_after").style.border = "";   
        }
    }
    document.getElementById("wordCnt").style.color = "#333333";
    document.getElementById("wordCnt").innerHTML="Please wait..." ;

    var form = new FormData();     
    form.append('avalability_status',avalability_status);
    form.append('available_after',available_after);

    $.ajax(
    {
     headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
     type: 'POST',
     url: "{{url('/vendor/save_vendor_availability_status')}}",
     data:form,
     contentType: false,
     processData: false,
     success:function(response) 
     {
            console.log(response); // return false;   
            document.getElementById("wordCnt").innerHTML="" ; 
            document.getElementById("wordCnt").style.color = "#ff0000"; 

            var status = response.status;       
            var msg = response.msg;                     

            if(status=='200')
            {
             document.getElementById("wordCnt").style.color = "green";
             document.getElementById("wordCnt").innerHTML=msg;
             setTimeout(function(){
                window.location.reload();
            },3000);

         }
         else if(status=='401')
         {
          document.getElementById("wordCnt").style.color = "#ff0000";
          document.getElementById("wordCnt").innerHTML=msg;
      }

  }
});

return false;
}



</script>

<style type="text/css">
    .coustam-checkbox [type="radio"]:checked,
[type="radio"]:not(:checked) {
    position: absolute;
    left: -9999px;
}
.coustam-checkbox [type="radio"]:checked + label,
[type="radio"]:not(:checked) + label
{
    position: relative;
    padding-left: 28px;
    cursor: pointer;
    line-height: 20px;
    display: inline-block;
    color: #666;
}
.coustam-checkbox [type="radio"]:checked + label:before,
[type="radio"]:not(:checked) + label:before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    width: 18px;
    height: 18px;
    border: 1px solid #ddd;
    border-radius: 100%;
    background: #fff;
}
.coustam-checkbox [type="radio"]:checked + label:after,
[type="radio"]:not(:checked) + label:after {
    content: '';
    width: 12px;
    height: 12px;
    background: #458aff;
    position: absolute;
    top: 3px;
    left: 3px;
    border-radius: 100%;
    -webkit-transition: all 0.2s ease;
    transition: all 0.2s ease;
}
.coustam-checkbox [type="radio"]:not(:checked) + label:after {
    opacity: 0;
    -webkit-transform: scale(0);
    transform: scale(0);
}
.coustam-checkbox [type="radio"]:checked + label:after {
    opacity: 1;
    -webkit-transform: scale(1);
    transform: scale(1);
}

.sub-heading {
    padding: 10px;
    color: #3d75f8;
    font-size: 15px;
    font-weight: 500;
}
</style>