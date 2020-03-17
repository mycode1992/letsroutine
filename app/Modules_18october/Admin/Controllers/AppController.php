<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;
use App\Modules\Admin\Models\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use DB;
use Session;

class AppController extends Controller
{
    public function user_list()
    {
        $session_all=Session::get('sessionadmin');
        if($session_all==false)
        {
            return Redirect::to('/lradmin');
            exit();
        } 

        $user_list = DB::table('tbl_app_user as t1')
                    ->join('tbl_lr_governorate_area as t2','t1.lr_governorate_area_id','t2.lr_governorate_area_id')->get(['user_uniqueid','app_user_fname','app_user_lname','app_user_phone','app_user_email','app_user_gender','app_user_dob','t1.admin_status','lr_governorate_area_name']);
        return view("Admin::app.user_list",compact('user_list'));
    }

    public function exportuser($id)
    { 
        $session_all=Session::get('sessionadmin');
        if($session_all==false)
        {
            return Redirect::to('/lradmin');
            exit();          
        }
        if($id=='User List')           
        {
            $data = DB::table('tbl_app_user as t1')
            ->join('tbl_lr_governorate_area as t2','t1.lr_governorate_area_id','t2.lr_governorate_area_id')->get(['user_uniqueid','app_user_fname','app_user_lname','app_user_phone','app_user_email','app_user_gender','app_user_dob','t1.admin_status','lr_governorate_area_name']);
        }
        else
        {
            return Redirect::to('/lradmin/dashboard');
        }
        return view("Admin::export.exportuser",compact('data'))->with('page_name',$id); 
        
    }

    public function get_user_address_detail(Request $request)
    {
        $user_uniqueid = $request->user_uniqueid;
        $user_address_detail = DB::table('tbl_app_user_address')->where('user_uniqueid',$user_uniqueid)->get(['app_user_add_title','app_user_add_block','app_user_add_street','app_user_add_avenue','app_user_add_house','app_user_add_phone']);
        if(count($user_address_detail) > 0)
        {
            return response()->json([
                'status' => '200',
                'user_address_detail' => $user_address_detail
            ]);
        }
        else
        {
            return response()->json([
                'status' => '401',
                'msg' => 'Data not found.'
            ]);
        }
       
    }

}
