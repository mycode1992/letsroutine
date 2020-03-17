<footer class="main-footer">
  
    <strong>Copyright &copy; <?php echo date('Y');?> <a href="#">Let's Routine</a>.</strong> All rights
    reserved.
  </footer>

  

</div>
<style type="text/css">
	#example1 tr td {
    vertical-align: middle;
}
</style>

<script src="{{url('/public')}}/admin/js/bower_components/jquery/dist/jquery.min.js"></script>

<script src="{{url('/public')}}/admin/js/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>


<script src="{{url('/public')}}/admin/js/bower_components/fastclick/lib/fastclick.js"></script>


<script src="{{url('/public')}}/admin/js/dist/js/adminlte.min.js"></script>


<script src="{{url('/public')}}/admin/js/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>



<script src="{{url('/public')}}/admin/js/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{url('/public')}}/admin/js/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<script src="{{url('/public')}}/admin/js/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>


<script src="{{url('/public')}}/admin/js/dist/js/pages/dashboard2.js"></script>

<script src="{{url('/public')}}/admin/js/dist/js/demo.js"></script>


<script src="{{url('/public')}}/admin/js/bower_components/ckeditor/ckeditor.js"></script>

<script src="{{url('/public')}}/admin/js/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="{{url('/public')}}/admin/js/bootstrap-datepicker.min.js"></script>

<script>
  $(function () {
  	 $('#example1').DataTable()
   /* $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })*/
  })
</script>
<script type="text/javascript">

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
function isNumberKey(evt) 
{
    var iKeyCode = (evt.which) ? evt.which : evt.keyCode
    if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57))
        return false;
    return true;
}
</script>
<script type="text/javascript">
$(function(){
  $('.start').datepicker(
    {
        todayHighlight: true,
        format: 'dd/mm/yyyy',
        //endDate: "today"
    })
    $('.end, .cs_date_to, .os_date_from, .os_date_to').datepicker(
    {
        todayHighlight: true,
        format: 'dd/mm/yyyy'
    })
});
$(function () {
    //Initialize Select2 Elements
    $('.select2').select2({ placeholder : ''})

  })


<script>
    $('.select2').select2();
   $(document).ready(function() {
     $('#example1').DataTable({
       "language": {
     "lengthMenu": '<div> <select class="troopets_selectbox">'+
       '<option value="10">10</option>'+
       '<option value="20">20</option>'+
       '<option value="30">30</option>'+
       '<option value="40">40</option>'+
       '<option value="50">50</option>'+
       '<option value="60">60</option>'+
   
       '<option value="-1">All</option>'+
       '</select> <span class="record">Records Per Page </span></div>'
     }
     });
     soTable = $('#example1').DataTable();
     $('#srch-term').keyup(function(){
        soTable.search($(this).val()).draw() ;
      });
   
   $('.something').click( function () {
   var ddval = $('.something option:selected').val();
   console.log(ddval);
   var oSettings = oTable.fnSettings();
   oSettings._iDisplayLength = ddval;
   oTable.fnDraw();
   });
   oTable = $('#example1').dataTable();
   
   } );
   
   </script>

</script>
</body>
</html>
