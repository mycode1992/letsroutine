<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;
use App\Modules\Admin\Models\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use DB;
use Session;

class VendorController extends Controller
{
    public function add_vendor($id=null)
    {
        $session_all=Session::get('sessionadmin');
        if($session_all==false)
        {
            return Redirect::to('/lradmin');
            exit();
        }
        if($id!='')
        {
            $data = DB::table('tbl_lr_user AS t1')
            ->join('tbl_lr_userdetail AS t2','t1.lr_user_userid','t2.lr_user_userid')
            ->where('t1.lr_user_roleid','2')->where('t1.lr_user_id',$id)->select('t1.lr_user_id','t1.lr_user_userid','t1.lr_user_name','t1.lr_user_email','t2.lr_userdetail_fname','t2.lr_userdetail_lname','t2.lr_userdetail_phone','t2.lr_userdetail_centrename','t2.lr_userdetail_centreaddr','t2.lr_userdetail_logo','t1.lr_user_admin_status')->get();
            return view("Admin::vendor.add_vendor",compact('data'));
        }
        else
        {
            return view("Admin::vendor.add_vendor");
        }
        
    }

    public function save_sender(Request $request)
    {
        if($request->isMethod('POST'))
        {
            $ip_address =  \Request::ip(); 
            $curDate = new \DateTime();
            $userid = date('Ymdhis');
            $updateid =  $request->updateid;
            $diet_centre_name =  ucfirst($request->diet_centre_name);
            $fname =  ucfirst($request->fname);
            $lname =  ucfirst($request->lname);
            $phone =  $request->phone;
            $email =  $request->email;
            $password =  $request->password;
            $diet_centre_addr =  ucfirst($request->diet_centre_addr);
            $imageidd = $request->file('imageidd'); 
            $name = $fname." ".$lname;
            $role_id = '2';
            if($updateid=='')
            {
            if($imageidd!="")
            {
            $filename = $imageidd->getClientOriginalName();
            $extension = $imageidd->getClientOriginalExtension();
            $filesize  =  $imageidd->getClientSize(); 
            if($extension!='jpg' && $extension!='jpeg' && $extension!='png')
            {
            return response()->json(
            [
            'status' =>'401',
            'msg' => 'Upload only jpeg,jpg or png file'
            ]);
            }
            if($filesize>='2048000')
            {
            return response()->json(
            [
            'status' =>'401',
            'msg' => 'Image size should be less than 2mb'
            ]);
            }
            $dir = public_path().'/vendor/upload/logo/'; 
            $filename = uniqid().'_'.time().'_'.date('Ymd').'.'.$extension;
            $upload_image = $imageidd->move($dir, $filename);  
            if($upload_image==false)
            {
            return response()->json(
                [
                'status' =>'401',
                'msg' => 'Unable to upload image, please try again'
                ]);
            }
            try
            {
            $sql=DB::table('tbl_lr_user')
                  ->insert([
                  'lr_user_userid'=>$userid,
                  'lr_user_name'=>$name,    
                  'lr_user_email'=>$email,    
                  'lr_user_password'=>md5($password),    
                  'lr_user_roleid'=>$role_id,  
                  'lr_user_email_verifystatus'=>'1',  
                  'lr_user_admin_status'=>'1'
              ]);
              $sql1=DB::table('tbl_lr_userdetail')
                  ->insert([
                  'lr_user_userid'=>$userid,
                  'lr_userdetail_fname'=>$fname,    
                  'lr_userdetail_lname'=>$lname,    
                  'lr_userdetail_phone'=>$phone,    
                  'lr_userdetail_centrename'=>$diet_centre_name,    
                  'lr_userdetail_centreaddr'=>$diet_centre_addr,    
                  'lr_userdetail_logo'=>$filename,    
                  'lr_userdetail_ip'=>$ip_address,
                  'lr_userdetail_createdate'=>$curDate
              ]);
              $sendemail = sendlogindetails($name,$email,$password);
              return response()->json(
                [
                'status' =>'200',
                'msg' => 'Vendor added successfully.'
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
             'msg' => 'Please select image.'
             ]);
             }
             }
             else
             {  
                if($imageidd!="")
                {
                $filename = $imageidd->getClientOriginalName();
                $extension = $imageidd->getClientOriginalExtension();
                $filesize  =  $imageidd->getClientSize(); 
                if($extension!='jpg' && $extension!='jpeg' && $extension!='png')
                {
                return response()->json(
                [
                'status' =>'401',
                'msg' => 'Upload only jpeg,jpg or png file'
                ]);
                }
                if($filesize>='2048000')
                {
                    return response()->json(
                        [
                        'status' =>'401',
                        'msg' => 'Image size should be less than 2mb'
                        ]);
                }
                $dir = public_path().'/vendor/upload/logo/'; 
                $filename = uniqid().'_'.time().'_'.date('Ymd').'.'.$extension;
                $upload_image = $imageidd->move($dir, $filename);  
                if($upload_image==false)
                {
                    return response()->json(
                        [
                        'status' =>'401',
                        'msg' => 'Unable to upload image, please try again'
                        ]);
                }
                }
                
                if($imageidd!="")
                {
                try
                {
                if($password!='')
                {
                $query=DB::table('tbl_lr_user')
                    ->where('lr_user_userid',$updateid)
                    ->update([
                    'lr_user_password'=>md5($password)
                ]);
                }
                $sql=DB::table('tbl_lr_user')
                        ->where('lr_user_userid',$updateid)
                        ->update([
                        'lr_user_name'=>$name,    
                        'lr_user_email'=>$email,
                    ]);
                    $sql1=DB::table('tbl_lr_userdetail')
                    ->where('lr_user_userid',$updateid)
                        ->update([
                        'lr_userdetail_fname'=>$fname,    
                        'lr_userdetail_lname'=>$lname,    
                        'lr_userdetail_phone'=>$phone,    
                        'lr_userdetail_centrename'=>$diet_centre_name,    
                        'lr_userdetail_centreaddr'=>$diet_centre_addr,    
                        'lr_userdetail_logo'=>$filename,    
                        'lr_userdetail_ip'=>$ip_address,
                        'lr_userdetail_updatedat'=>$curDate
                    ]);
                    return response()->json(
                    [
                    'status' =>'200',
                    'msg' => 'Vendor Updated successfully.'
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
                try
                {   
                if($password!='')
                {
                $query=DB::table('tbl_lr_user')
                    ->where('lr_user_userid',$updateid)
                    ->update([
                    'lr_user_password'=>md5($password)
                ]);
                }

                $sql=DB::table('tbl_lr_user')
                        ->where('lr_user_userid',$updateid)
                        ->update([
                        'lr_user_name'=>$name,    
                        'lr_user_email'=>$email,
                    ]);
                    $sql1=DB::table('tbl_lr_userdetail')
                    ->where('lr_user_userid',$updateid)
                        ->update([
                        'lr_userdetail_fname'=>$fname,    
                        'lr_userdetail_lname'=>$lname,    
                        'lr_userdetail_phone'=>$phone,    
                        'lr_userdetail_centrename'=>$diet_centre_name,    
                        'lr_userdetail_centreaddr'=>$diet_centre_addr,
                        'lr_userdetail_ip'=>$ip_address,
                        'lr_userdetail_updatedat'=>$curDate
                    ]);
                    return response()->json(
                    [
                    'status' =>'200',
                    'msg' => 'Vendor Updated successfully.'
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
            }
        }
        else
        {
        return response()->json(
        [
        'status' =>'401',
        'msg' => 'Invalid Request.'
        ]);
        }
    }

    public function manage_vendor($id)
    {
        $session_all=Session::get('sessionadmin');
        if($session_all==false)
        {
            return Redirect::to('/lradmin');
            exit();          
        }
        if($id=='all_vendor')           
        {
            $data = DB::table('tbl_lr_user AS t1')
            ->join('tbl_lr_userdetail AS t2','t1.lr_user_userid','t2.lr_user_userid')
            ->where('t1.lr_user_roleid','2')->select('t1.lr_user_id','t1.lr_user_userid','t1.lr_user_name','t1.lr_user_email','t2.lr_userdetail_fname','t2.lr_userdetail_lname','t2.lr_userdetail_phone','t2.lr_userdetail_centrename','t2.lr_userdetail_centreaddr','t2.lr_userdetail_logo','t1.lr_user_admin_status')->orderBy('t1.lr_user_id','desc')->get();
        }
        else
        if($id=='active_vendor')
        {
            $data = DB::table('tbl_lr_user AS t1')
            ->join('tbl_lr_userdetail AS t2','t1.lr_user_userid','t2.lr_user_userid')
            ->where('t1.lr_user_roleid','2')->where('t1.lr_user_admin_status','1')->select('t1.lr_user_id','t1.lr_user_userid','t1.lr_user_name','t1.lr_user_email','t2.lr_userdetail_fname','t2.lr_userdetail_lname','t2.lr_userdetail_phone','t2.lr_userdetail_centrename','t2.lr_userdetail_centreaddr','t2.lr_userdetail_logo','t1.lr_user_admin_status')->orderBy('t1.lr_user_id','desc')->get();
        }
        else
        if($id=='deactive_vendor')
        {
            $data = DB::table('tbl_lr_user AS t1')
            ->join('tbl_lr_userdetail AS t2','t1.lr_user_userid','t2.lr_user_userid')
            ->where('t1.lr_user_roleid','2')->where('t1.lr_user_admin_status','0')->select('t1.lr_user_id','t1.lr_user_userid','t1.lr_user_name','t1.lr_user_email','t2.lr_userdetail_fname','t2.lr_userdetail_lname','t2.lr_userdetail_phone','t2.lr_userdetail_centrename','t2.lr_userdetail_centreaddr','t2.lr_userdetail_logo','t1.lr_user_admin_status')->orderBy('t1.lr_user_id','desc')->get();
        }
        else
        {
            return view("Admin::dashboard",compact('data'));
        }
        return view("Admin::vendor.manage_vendor",compact('data'))->with('page_name',$id);
    }

    public function exportvendor($id)
    {

        $session_all=Session::get('sessionadmin');
        if($session_all==false)
        {
            return Redirect::to('/lradmin');
            exit();          
        }
        if($id=='all_vendor')           
        {
            $data = DB::table('tbl_lr_user AS t1')
            ->join('tbl_lr_userdetail AS t2','t1.lr_user_userid','t2.lr_user_userid')
            ->where('t1.lr_user_roleid','2')->select('t1.lr_user_id','t1.lr_user_name','t1.lr_user_email','t2.lr_userdetail_fname','t2.lr_userdetail_lname','t2.lr_userdetail_phone','t2.lr_userdetail_centrename','t2.lr_userdetail_centreaddr','t2.lr_userdetail_logo','t1.lr_user_admin_status')->get();
        }
        else
        if($id=='active_vendor')
        {
            $data = DB::table('tbl_lr_user AS t1')
            ->join('tbl_lr_userdetail AS t2','t1.lr_user_userid','t2.lr_user_userid')
            ->where('t1.lr_user_roleid','2')->where('t1.lr_user_admin_status','1')->select('t1.lr_user_id','t1.lr_user_name','t1.lr_user_email','t2.lr_userdetail_fname','t2.lr_userdetail_lname','t2.lr_userdetail_phone','t2.lr_userdetail_centrename','t2.lr_userdetail_centreaddr','t2.lr_userdetail_logo','t1.lr_user_admin_status')->get();
        }
        else
        if($id=='deactive_vendor')
        {
            $data = DB::table('tbl_lr_user AS t1')
            ->join('tbl_lr_userdetail AS t2','t1.lr_user_userid','t2.lr_user_userid')
            ->where('t1.lr_user_roleid','2')->where('t1.lr_user_admin_status','0')->select('t1.lr_user_id','t1.lr_user_name','t1.lr_user_email','t2.lr_userdetail_fname','t2.lr_userdetail_lname','t2.lr_userdetail_phone','t2.lr_userdetail_centrename','t2.lr_userdetail_centreaddr','t2.lr_userdetail_logo','t1.lr_user_admin_status')->get();
        }
        else
        {
            return view("Admin::dashboard",compact('data'));
        }
        return view("Admin::export.exportvendor",compact('data'))->with('page_name',$id); 
        
    }
    public function menu_category()
    {
        $session_all=Session::get('sessionadmin');
        if($session_all==false)
        {
            return Redirect::to('/lradmin');
            exit();          
        }

        $data = DB::table('tbl_lr_menu_category')
       ->select('lr_category_id','lr_category_name','lr_category_type','admin_status')->orderBy('lr_category_id','desc')->get();

        return view("Admin::vendor.menu_category",compact('data'));
    }

    public function add_menu_category($id=null)
    {
        $session_all=Session::get('sessionadmin');
        if($session_all==false)
        {
            return Redirect::to('/lradmin');
            exit();          
        }
        if($id!='')
        {
            $data = DB::table('tbl_lr_menu_category')->where('lr_category_id',$id)->select('lr_category_id','lr_category_name','lr_category_description','lr_category_type')->get();
           
            return view("Admin::vendor.add_menu_category",compact('data'));
        }
        else
        {
            return view("Admin::vendor.add_menu_category");
        }
        
    }

    public function save_menu_category(Request $request)
    {
        if($request->isMethod('POST'))
        {
           
            $updateid =  $request->updateid;
            $category_name =  ucfirst($request->category_name);
            $description =  ucfirst($request->description);
            $category_type = $request->category_type;
           
            if($updateid=='')
            {
                $is_menu_cat_exists = DB::table('tbl_lr_menu_category')->where('lr_category_name',$category_name)->count();
                if($is_menu_cat_exists>0)
                {
                return response()->json([
                'status'=>'401',
                'msg'=>'Category already exists.'
                ]);
                }
           
             $sql_insert = DB::table('tbl_lr_menu_category')
                  ->insert([
                  'lr_category_name'=>$category_name,
                  'lr_category_description'=>$description,
                  'lr_category_type'=>$category_type,
                  'admin_status'=>'1'
              ]);
              
              if($sql_insert==true)
              {
                return response()->json(
                    [
                    'status' =>'200',
                    'msg' => 'Category added successfully.'
                    ]);
              }
              else
              {
                return response()->json(
                    [
                    'status' =>'401',
                    'msg' => 'Something went wrong,Please try again later.'
                    ]);
              }
             }
             else
             {
                try
                {
                    $is_menu_cat_exists = DB::table('tbl_lr_menu_category')->where('lr_category_name',$category_name)->where('lr_category_id','!=',$updateid)->count();
                    
                    if($is_menu_cat_exists>0)
                    {
                    return response()->json([
                    'status'=>'401',
                    'msg'=>'Category already exists.'
                    ]);
                    }

                    $sql=DB::table('tbl_lr_menu_category')
                        ->where('lr_category_id',$updateid)
                        ->update([
                        'lr_category_name'=>$category_name,
                        'lr_category_description'=>$description,
                        'lr_category_type'=>$category_type
                    ]);
                    
                    return response()->json(
                    [
                    'status' =>'200',
                    'msg' => 'Category Updated successfully.'
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
        }
        else
        {
        return response()->json(
        [
        'status' =>'401',
        'msg' => 'Invalid Request.'
        ]);
        }
    }

    public function notification_announcement()
    {
        $session_all=Session::get('sessionadmin');
        if($session_all==false)
        {
            return Redirect::to('/lradmin');
            exit();          
        }

       $data = DB::table('tbl_lr_notifi_announc')->select('lr_notifi_announc_id','lr_user_id','lr_notifi_announc_name','lr_notifi_announc_desp','lr_notifi_announc_date','admin_status')->get();

        return view("Admin::vendor.notification_announcement",compact('data'));
    }

    public function add_notifi_ann($id=null)
    {
        $session_all=Session::get('sessionadmin');
        if($session_all==false)
        {
            return Redirect::to('/lradmin');
            exit();          
        }
        $vendor_list = DB::table('tbl_lr_user')->select('lr_user_userid','lr_user_name')->where('lr_user_roleid','2')->get();

        if($id!='')
        {
         $data = DB::table('tbl_lr_notifi_announc')->where('lr_notifi_announc_id',$id)->select('lr_notifi_announc_id','lr_user_id','lr_notifi_announc_name','lr_notifi_announc_desp','lr_notifi_announc_date','admin_status')->get();
         return view("Admin::vendor.add_notifi_ann",compact('vendor_list','data'));
        }
        else
        {
            return view("Admin::vendor.add_notifi_ann",compact('vendor_list'));
        }
    }

    public function save_noti_ann(Request $request)
    {
        if($request->isMethod('POST'))   
        {   
            $curdate  = new \DateTime();
            $updateid = $request->updateid;
            $name = $request->name;
            $description = $request->description;
            $select_vendor = $request->select_vendor;
            if($name!='' && $description!='')
            {

               if($updateid=='')
               {
                $is_notification_exists = DB::table('tbl_lr_notifi_announc')->where('lr_notifi_announc_name',$name)->count();
                if($is_notification_exists>0)
                {
                return response()->json([
                'status'=>'401',
                'msg'=>'Notification already exists.'
                ]);
                }
                 
                $sql_insert = DB::table('tbl_lr_notifi_announc')->insert([
                    'lr_user_id' => $select_vendor,
                    'lr_notifi_announc_name' => $name,
                    'lr_notifi_announc_desp' => $description,
                    'lr_notifi_announc_date' => $curdate,
                    'admin_status' => '1'
                ]);

                if($sql_insert==true)
                {
                    return response()->json(
                        [
                        'status' =>'200',
                        'msg' => 'Data inserted successfully.'
                        ]);
                }
                else
                {
                    return response()->json([
                        'status' => '401',
                        'msg' => 'Something went wrong, Please try again later.'
                    ]);
                }
               }
               else
               {
                $is_notification_exists = DB::table('tbl_lr_notifi_announc')->where('lr_notifi_announc_name',$name)->where('lr_notifi_announc_id','!=',$updateid)->count();
                if($is_notification_exists>0)
                {
                return response()->json([
                'status'=>'401',
                'msg'=>'Notification already exists.'
                ]);
                }
                 
                try{
                    $sql_update = DB::table('tbl_lr_notifi_announc')->where('lr_notifi_announc_id',$updateid)->update([
                        'lr_user_id' => $select_vendor,
                        'lr_notifi_announc_name' => $name,
                        'lr_notifi_announc_desp' => $description,
                        'lr_notifi_announc_date' => $curdate,
                        'admin_status' => '1'
                    ]);

                    return response()->json(
                        [
                        'status' =>'200',
                        'msg' => 'Data updated successfully.'
                        ]);

                }
                catch(Exception $e)
                {
                    return response()->json([
                        'status' => '401',
                        'msg' => 'Something went wrong, Please try again later.'
                    ]);
                }
               
               }
               
            }
            else
            {
                return response()->json(
                    [
                    'status' =>'401',
                    'msg' => 'All fields are required.'
                    ]);
            }
        }
        else
        {
        return response()->json(
        [
        'status' =>'401',
        'msg' => 'Invalid Request.'
        ]);
        } 
    }
    public function view_plan($id)
    {
        $session_all=Session::get('sessionadmin');
        if($session_all==false)
        {
            return Redirect::to('/lradmin');
            exit();          
        }
        $vendorname = DB::table('tbl_lr_user')->where('lr_user_userid',$id)->select('lr_user_name')->get();

        $data = DB::table('tbl_lr_vendor_plan')->where('admin_status','!=','2')->where('lr_user_id',$id)->get();

        return view("Admin::vendor.view_plan",compact('data'))->with('vendor_name',$vendorname[0]->lr_user_name);
    }  

    public function view_packages($id)
    {
        $session_all=Session::get('sessionadmin');
        if($session_all==false)
        {
            return Redirect::to('/lradmin');
            exit();          
        }
        $vendorname = DB::table('tbl_lr_user')->where('lr_user_userid',$id)->select('lr_user_name')->get();

        $data = DB::table('tbl_lr_vendor_package')->where('admin_status','!=','2')->where('lr_user_id',$id)->get();

        return view("Admin::vendor.view_packages",compact('data'))->with('vendor_name',$vendorname[0]->lr_user_name);
    }   

    public function view_meal($id)
    {
        $session_all=Session::get('sessionadmin');
        if($session_all==false)
        {
            return Redirect::to('/lradmin');
            exit();          
        }
        $vendorname = DB::table('tbl_lr_user')->where('lr_user_userid',$id)->select('lr_user_name')->get();

        $data = DB::table('tbl_lr_meal')->where('admin_status','!=','2')->where('lr_user_userid',$id)->get();

    //  echo '<pre>';  print_r($data); exit;

        return view("Admin::vendor.view_meal",compact('data'))->with('vendor_name',$vendorname[0]->lr_user_name);
    }            

    public function view_menu($id)
    {
        $session_all=Session::get('sessionadmin');
        if($session_all==false)
        {
            return Redirect::to('/lradmin');
            exit();          
        }
        $vendorname = DB::table('tbl_lr_user')->where('lr_user_userid',$id)->select('lr_user_name')->get();

        $data = DB::table('tbl_lr_vendor_menu')->where('admin_status','!=','2')->where('lr_user_id',$id)->distinct('lr_unique_id')->select('vendor_menu_name','lr_unique_id','admin_status')->get();

    //  echo '<pre>';  print_r($data); exit;

        return view("Admin::vendor.view_menu",compact('data'))->with('vendor_name',$vendorname[0]->lr_user_name);
    }

    public function report_problem()
    {
        $session_all=Session::get('sessionadmin');
        if($session_all==false)
        {
            return Redirect::to('/lradmin');
            exit();          
        }
        $data = DB::table('tbl_lr_report_prbl')->select('lr_id','lr_user_userid','lr_name','lr_title','lr_problem','lr_date')->get();

        return view("Admin::vendor.report_problem",compact('data'));
    }

}
