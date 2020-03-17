<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;
use App\Modules\Admin\Models\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use DB;
use Session;

class AdminController extends Controller
{

    public function dashboard()
    {
        $session_all=Session::get('sessionadmin');
        if($session_all==false)
        {
            return Redirect::to('/lradmin');
            exit();
        } 
        $all_vendor = DB::table('tbl_lr_user AS t1')
        ->join('tbl_lr_userdetail AS t2','t1.lr_user_userid','t2.lr_user_userid')
        ->where('t1.lr_user_roleid','2')->count();

        $deactive_vendor = DB::table('tbl_lr_user AS t1')
        ->join('tbl_lr_userdetail AS t2','t1.lr_user_userid','t2.lr_user_userid')
        ->where('t1.lr_user_roleid','2')->where('t1.lr_user_admin_status','0')->count();

        $active_vendor = DB::table('tbl_lr_user AS t1')
        ->join('tbl_lr_userdetail AS t2','t1.lr_user_userid','t2.lr_user_userid')
        ->where('t1.lr_user_roleid','2')->where('t1.lr_user_admin_status','1')->count();

        $sql_vendors_latest = DB::table('tbl_lr_user AS t1')
        ->join('tbl_lr_userdetail AS t2','t1.lr_user_userid','t2.lr_user_userid')
        ->where('t1.lr_user_roleid','2')->select('t1.lr_user_id','t1.lr_user_name','t1.lr_user_email','t2.lr_userdetail_fname','t2.lr_userdetail_lname','t2.lr_userdetail_phone','t2.lr_userdetail_centrename','t2.lr_userdetail_centreaddr','t2.lr_userdetail_logo','t1.lr_user_admin_status','t2.lr_userdetail_createdate')->orderBy('t1.lr_user_id','desc')->limit(8)->get();

        $support_query = DB::table('tbl_lr_contactus')->count();



        //getting users info  start
        $all_user = DB::table('tbl_app_user')->count();
        $deactive_user = DB::table('tbl_app_user')->where('admin_status','0')->count();
        $active_user = DB::table('tbl_app_user')->where('admin_status','1')->count();
        $sql_users_latest = DB::table('tbl_app_user')->select('*')->orderBy('app_user_id','desc')->limit(8)->get();  
         //getting users info  close



        return view("Admin::dashboard",compact('all_vendor','deactive_vendor','active_vendor','sql_vendors_latest','support_query','all_user','deactive_user','active_user','sql_users_latest'));
    }

    public function contact_query()
    {
        $session_all=Session::get('sessionadmin');
        if($session_all==false)
        {
            return Redirect::to('/lradmin');
            exit();
        } 
        $data = DB::table('tbl_lr_contactus')->select('lr_contactus_id','lr_contactus_name','lr_contactus_email','lr_contactus_message','lr_contactus_created_at')->orderBy('lr_contactus_id','desc')->get();
        return view("Admin::contact_query",compact('data'));   
    }

    public function readmore(Request $request)
    {  
        if($request->isMethod('POST'))
        {
          $tblname = $request->tblname;
          $id =  $request->id;
          $colnamewhere =  $request->colnamewhere;
          $colmsg =  $request->colmsg; 
          $sql = "select $colmsg from $tblname where $colnamewhere='$id'"; 
          $data = DB::select($sql);
          $data = json_decode(json_encode($data), True);
          if($data==true){ echo $data[0][$colmsg] ;}else{
           echo 'Something went wrong'; 
       }

   }
}

public function exportcon_queries()
{

    $session_all=Session::get('sessionadmin');

    if($session_all==false)
    {
        return Redirect::to('/lradmin');
        exit();
    }
    return view('Admin::export.exportcon_queries'); 

}

public function changestatus(Request $request)
{
    $id = trim($request->id);
    $status = trim($request->status);
    $tblname = trim($request->tblname);
    $colstatus = trim($request->colstatus);
    $colwhere = trim($request->colwhere);


    $sql = "update $tblname set $colstatus='$status' where $colwhere='$id' ";

    $data = DB::select($sql);
    if($data==true){ echo '1';}else{
        echo '2'; 
    }


}



}
