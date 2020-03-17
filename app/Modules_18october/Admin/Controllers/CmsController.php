<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;
use App\Modules\Admin\Models\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use DB;
use Session;

class CmsController extends Controller
{
    public function about_us()
    {
        $session_all=Session::get('sessionadmin');
        if($session_all==false)
        {
        return Redirect::to('/lradmin');
        exit();
        } 
        $data = DB::table('tbl_lr_cms')->select('lr_cms_description')
        ->where('lr_cms_id',1)->get();
        return view("Admin::cms.aboutus",compact('data'));
    }

    public function update_aboutus(Request $request){
        if($request->isMethod('post')){
        $aboutus = addslashes($request->aboutus);
        try
        {
        $sql=DB::table('tbl_lr_cms')
            ->where('lr_cms_id', '=','1')
            ->update([
            'lr_cms_description'=>$aboutus    
        ]);

        return response()->json(
        [
        'status' =>'200',
        'msg' => 'About Us Content Updated Successfully.'
        ]);
            
        }
        catch(\Exception $e){
        return response()->json(
        [
        'status' =>'401',
        'msg' => 'Something went wrong,please try again'
        ]);
        }

        }
        else
        {
        return response()->json(
        [
        'status' =>'401',
        'msg' => 'Invalid Request'
        ]);
        }
    }

    public function terms_condition()
    {
        $session_all=Session::get('sessionadmin');
        if($session_all==false)
        {
        return Redirect::to('/lradmin');
        exit();
        } 
        $data = DB::table('tbl_lr_cms')->select('lr_cms_description')
        ->where('lr_cms_id',2)->get();
        return view("Admin::cms.terms_condition",compact('data'));
    }

    public function update_terms(Request $request){
        if($request->isMethod('post')){
        $terms_condition = addslashes($request->terms_condition);
        try
        {
        $sql=DB::table('tbl_lr_cms')
            ->where('lr_cms_id', '=','2')
            ->update([
            'lr_cms_description'=>$terms_condition    
        ]);
       
        return response()->json(
        [
        'status' =>'200',
        'msg' => 'Terms & Condition Content Updated Successfully.'
        ]);
            
        }
        catch(\Exception $e){
        return response()->json(
        [
        'status' =>'401',
        'msg' => 'Something went wrong,please try again'
        ]);
        }

        }
        else
        {
        return response()->json(
        [
        'status' =>'401',
        'msg' => 'Invalid Request'
        ]);
        }
    }
    public function privacy_policy()
    {
        $session_all=Session::get('sessionadmin');
        if($session_all==false)
        {
        return Redirect::to('/lradmin');
        exit();
        } 
        $data = DB::table('tbl_lr_cms')->select('lr_cms_description')
        ->where('lr_cms_id',3)->get();
        return view("Admin::cms.privacy_policy",compact('data'));
    }
    public function update_policy(Request $request){
        if($request->isMethod('post')){
        $policy = addslashes($request->policy);
        try
        {
        $sql=DB::table('tbl_lr_cms')
            ->where('lr_cms_id', '=','3')
            ->update([
            'lr_cms_description'=>$policy    
        ]);
       
        return response()->json(
        [
        'status' =>'200',
        'msg' => 'Privacy Policy Content Updated Successfully.'
        ]);
            
        }
        catch(\Exception $e){
        return response()->json(
        [
        'status' =>'401',
        'msg' => 'Something went wrong,please try again'
        ]);
        }

        }
        else
        {
        return response()->json(
        [
        'status' =>'401',
        'msg' => 'Invalid Request'
        ]);
        }
    }


    public function faq()
    {
        $session_all=Session::get('sessionadmin');
        if($session_all==false)
        {
        return Redirect::to('/lradmin');
        exit();
        } 
        $data = DB::table('tbl_lr_cms')->where('lr_cms_name','Faq')->select('lr_cms_id','lr_cms_title','lr_cms_description','status')->get();

        return view("Admin::cms.faq",compact('data'));
    }

    

    public function governorate()
    {
        $session_all=Session::get('sessionadmin');
        if($session_all==false)
        {
        return Redirect::to('/lradmin');
        exit();
        } 
        $data = DB::table('tbl_lr_governorate')->select('lr_governorate_id','lr_governorate_name','admin_status')
        ->orderBy('lr_governorate_id','desc')->get();
        return view("Admin::cms.governorate",compact('data'));
    }

    public function add_governorate($id=null)
    {
        $session_all=Session::get('sessionadmin');
        if($session_all==false)
        {
        return Redirect::to('/lradmin');
        exit();
        }
        if($id=='')
        {
        return view("Admin::cms.save_governorate",compact('data'));
        }
        else
        {
        $data = DB::table('tbl_lr_governorate')->select('lr_governorate_name','lr_governorate_id')->where('lr_governorate_id',$id)->get();
        return view("Admin::cms.save_governorate",compact('data'));
        }
       
    }

    public function save_governorate(Request $request)
    {
        if($request->ismethod('post'))
        {
           $governorate_name = $request->governorate_name;
           $updateid = $request->updateid;
           if($updateid!='')
           {
            if($governorate_name!='')
            {
            $is_governorate_exists = DB::table('tbl_lr_governorate')->where('lr_governorate_name',$governorate_name)->where('lr_governorate_id','!=',$updateid)->count();
            if($is_governorate_exists>0)
            {
            return response()->json([
            'status'=>'401',
            'msg'=>'Governorate already exists.'
            ]);
            }

            try{
            $sql_update = DB::table('tbl_lr_governorate')->where('lr_governorate_name',$governorate_name)->update([
                'lr_governorate_name' => ucfirst($governorate_name) 
            ]);
           
            return response()->json([
            'status'=>'200',
            'msg'=>'Updated Successfully.'
            ]);
            }
            catch(Exception $e)
            {
            return response()->json([
            'status'=>'200',
            'msg'=>'Something went wrong, Please try again later.'
            ]);
            }
           
            }
            else
            {
            return response()->json([
            'status'=>'401',
            'msg'=>'All fields are required.'
            ]); 
            }
           } // end if for update id not blank
           else
           {
            if($governorate_name!='')
            {
            $is_governorate_exists = DB::table('tbl_lr_governorate')->where('lr_governorate_name',$governorate_name)->count();
            if($is_governorate_exists>0)
            {
            return response()->json([
            'status'=>'401',
            'msg'=>'Governorate already exists.'
            ]);
            }
           

            $sql_insert = DB::table('tbl_lr_governorate')->insert([
            'lr_governorate_name' => ucfirst($governorate_name),
            'admin_status' => '1'
            ]);
            if($sql_insert==true)
            {
            return response()->json([
            'status'=>'200',
            'msg'=>'Data inserted successfully.'
            ]);
            }
            else
            {
            return response()->json([
            'status'=>'401',
            'msg'=>'Something went wrong,Please try again  later.'
            ]);
            }
            }
            else
            {
            return response()->json([
            'status'=>'401',
            'msg'=>'All fields are required.'
            ]);
            }
        }
        } // end if for request check
        else
        {
            return response()->json([
                'status'=>'401',
                'msg'=>'Inavalid Request.'
            ]);
        }
    }

    public function view_area($id)
    {   
        $session_all=Session::get('sessionadmin');
        if($session_all==false)
        {
        return Redirect::to('/lradmin');
        exit();
        }
       
        $governorate_name = DB::table('tbl_lr_governorate')->where('lr_governorate_id',$id)->select('lr_governorate_id','lr_governorate_name')->get();
      
        $data = DB::table('tbl_lr_governorate_area')->where('lr_governorate_id',$id)->select('lr_governorate_area_id','lr_governorate_area_name','admin_status')->orderBy('lr_governorate_area_id','desc')->get();

        

        return view("Admin::cms.governorate_area",compact('data'))->with('governorate_name',$governorate_name);
    }
    public function add_area($governorateid,$governorateareaid=null)
    {  
        $session_all=Session::get('sessionadmin');
        if($session_all==false)
        {
        return Redirect::to('/lradmin');
        exit();
        }

        if($governorateid!='')
        {
            if($governorateareaid=='')
            {
                return view("Admin::cms.add_area")->with('governorateid',$governorateid);
            }
            else
            {
                $data = DB::table('tbl_lr_governorate_area')->select('lr_governorate_area_id','lr_governorate_id','lr_governorate_area_name')->where('lr_governorate_area_id',$governorateareaid)->get();
                return view("Admin::cms.add_area",compact('data'))->with('governorateid',$governorateid);
            }
           
        }
        else
        {
            return Redirect::to('/lradmin/dashboard'); 
        }

    }

    public function save_area(Request $request)
    {
        if($request->ismethod('post'))
        {
           $governorate = $request->governorate;
           $area_name = $request->area_name;
           $updateid = $request->updateid;
          
           if($updateid!='')
           {
            if($governorate!='' && $area_name!='')
            {
            $is_area_exists = DB::table('tbl_lr_governorate_area')->where('lr_governorate_area_name',$area_name)->where('lr_governorate_area_id','!=',$updateid)->count();
            if($is_area_exists>0)
            {
            return response()->json([
            'status'=>'401',
            'msg'=>'Area already exists.'
            ]);
            }

            try{
            $sql_update = DB::table('tbl_lr_governorate_area')->where('lr_governorate_area_id',$updateid)->update([
                'lr_governorate_id' => $governorate, 
                'lr_governorate_area_name' => ucfirst($area_name)
            ]);
           
            return response()->json([
            'status'=>'200',
            'msg'=>'Updated Successfully.'
            ]);
            }
            catch(Exception $e)
            {
            return response()->json([
            'status'=>'200',
            'msg'=>'Something went wrong, Please try again later.'
            ]);
            }
           
            }
            else
            {
            return response()->json([
            'status'=>'401',
            'msg'=>'All fields are required.'
            ]); 
            }
           } // end if for update id not blank
           else
           {
            if($governorate!='' && $area_name!='')
            {
            $is_governorate_area = DB::table('tbl_lr_governorate_area')->where('lr_governorate_area_name',$area_name)->count();
            if($is_governorate_area>0)
            {
            return response()->json([
            'status'=>'401',
            'msg'=>'Area already exists.'
            ]);
            }
           

            $sql_insert = DB::table('tbl_lr_governorate_area')->insert([
            'lr_governorate_id' => $governorate,
            'lr_governorate_area_name' => ucfirst($area_name),
            'admin_status' => '1'
            ]);
            if($sql_insert==true)
            {
            return response()->json([
            'status'=>'200',
            'msg'=>'Data inserted successfully.'
            ]);
            }
            else
            {
            return response()->json([
            'status'=>'401',
            'msg'=>'Something went wrong,Please try again  later.'
            ]);
            }
            }
            else
            {
            return response()->json([
            'status'=>'401',
            'msg'=>'All fields are required.'
            ]);
            }
        }
        } // end if for request check
        else
        {
            return response()->json([
                'status'=>'401',
                'msg'=>'Inavalid Request.'
            ]);
        }
    }

    public function add_faq()  
    {
        $session_all=Session::get('sessionadmin');
        if($session_all==false)
        {
        return Redirect::to('/lradmin');
        exit();
        }

        return view("Admin::cms.save_faq");
    }

    public function submit_faq(Request $request) // start of submit_faq function
    {
        if($request->ismethod('post'))
        {
         $faq_title = $request->faq_title;
         $faq = $request->faq;
         $sql_insert = DB::table('tbl_lr_cms')->insert([
             'lr_cms_name' => 'Faq',
             'lr_cms_title' => $faq_title,
             'lr_cms_description' => $faq,
             'status' => '1'
         ]);
         if($sql_insert==true)
         {
            return response()->json([
                'status'=>'200',
                'msg'=>'Faq Added Successfully.'
            ]);
         }
         else
         {
            return response()->json([
                'status'=>'401',
                'msg'=>'Something went wrong, Please try again later.'
            ]);
         }
        } 
        else
        {
            return response()->json([
                'status'=>'401',
                'msg'=>'Inavalid Request.'
            ]);
        }
    }  // end of submit_faq function
}
