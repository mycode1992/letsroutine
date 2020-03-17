<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;
use App\Modules\Admin\Models\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use DB;
use Session;

class LoginController extends Controller
{
    //login functions

    public function get_login()
    {
       
        return view("Admin::login.login");
    }

    public function login(Request $request)
    {
        if($request->isMethod('POST'))
        {
        $email = trim($request->email);
        $password = trim($request->password);
        if($email !='' && $password !='')
        {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return response()->json(
        [
        'status' =>'401',
        'msg' => 'Invalid E-mail'
        ]);
        }
                
        $Iladmin=new Admin;
        $role_id = '1';
        $session = 'sessionadmin';
        $dtl = $Iladmin->login($email,$password,$role_id,$session);        
        return $dtl;
        }
        else
        {
        return response()->json(
        [
        'status' =>'401',
        'msg' => 'All field are required'
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

    public function logout(){
        Session::forget('sessionadmin','userid','role_id','email','name');
        return Redirect::to('/lradmin');
        exit();
    }
   
    public function dashboard()
    {
        $session_all=Session::get('sessionadmin');
        if($session_all==false)
        {
            return Redirect::to('/lradmin');
            exit();
        } 
        return view("Admin::dashboard");
    }

    public function edit_profile(){
        $session_all=Session::get('sessionadmin');

        if($session_all==false)
        {
            return Redirect::to('/lradmin');
            exit();
        } 

        $admin_userid = $session_all['userid']; 

        $data = DB::table('tbl_lr_user AS t1')
        ->join('tbl_lr_userdetail AS t2','t2.lr_user_userid','t1.lr_user_userid')
        ->select('t1.lr_user_email','t2.lr_userdetail_fname','t2.lr_userdetail_lname','lr_userdetail_profile','t2.lr_userdetail_phone')
        ->where('t1.lr_user_roleid','1')
        ->where('t1.lr_user_userid',$admin_userid)
        ->get();

      
        return view('Admin::login.edit_profile',compact('data'));
    }

    public function remove_profile(Request $request)
    {
        $session_all=Session::get('sessionadmin');
        if($session_all==false)
        {
        return Redirect::to('/lradmin');
        exit();
        } 
        $admin_userid = $session_all['userid'];
        $removeimage = $request->removeimage; 
        if($removeimage=='removeimage'){
        try
        {  
        $sql = DB::table('tbl_lr_userdetail')->where('lr_user_userid',$admin_userid)
        ->update([
            'lr_userdetail_profile' => ''
        ]);

        return response()->json([
            'status'=> '200',
            'msg' => 'Profile removed successfully.'
        ]);
        }
        catch(\Exception $e){
        return response()->json([
        'status'=> '401',
        'msg' => 'Something went wrong, Please try again later'
        ]);
        }
        }
    }   

    public function update_profile(Request $request)
    {
        $session_all=Session::get('sessionadmin');
        if($session_all==false)
        {
        return Redirect::to('/lradmin');
        exit();
        } 

        $admin_userid = $session_all['userid']; 
        if($request->isMethod('post'))
        {
        $fname = ucfirst($request->fname); 
        $lname = ucfirst($request->lname); 
        $email = $request->email;
        $name = ucfirst($fname).' '.ucfirst($lname);
        $imageidd = $request->file('imageidd');
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
        $dir = public_path().'/admin/upload/admin_profile/';
        $filename = uniqid().'_'.time().'_'.date('Ymd');
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
        else
        {
        $profile_image = DB::table('tbl_lr_userdetail')->select('lr_userdetail_profile')->where('lr_user_userid',$admin_userid)->get();
        $filename = $profile_image[0]->lr_userdetail_profile;
        }           
        try
        {
        $sql1 = DB::table('tbl_lr_user')->where('lr_user_userid',$admin_userid)
            ->update([
            'lr_user_name' =>  $name,
            'lr_user_email' =>  $email
            ]);
        $sql2 = DB::table('tbl_lr_userdetail')->where('lr_user_userid',$admin_userid)
            ->update([
            'lr_userdetail_fname' =>  $fname,
            'lr_userdetail_lname' =>  $lname,
            'lr_userdetail_profile' =>  $filename
        ]);

        return response()->json([
        'status'=> '200',
        'msg' => 'Profile updated successfully.'
        ]);
        }
        catch(\Exception $e){
        return response()->json([
        'status'=> '401',
        'msg' => 'Something went wrong, Please try again later'
        ]);
        }       
        }
        else
        {
        return response()->json([
        'status'=> '401',
        'msg' => 'Invalid Request'
        ]);
        }
    }

    public function change_password(Request $request)
    {
        $session_all=Session::get('sessionadmin');
        if($session_all==false)
        {
        return Redirect::to('/lradmin');
        exit();
        } 
        $admin_userid = $session_all['userid']; 
        if($request->isMethod('post')){
        $password = $request->password;   
        $old_password = $request->old_password;
        if($old_password!='')
        {
        $old_password = md5($old_password);
        $sql1 = DB::table('tbl_lr_user')
                ->select('lr_user_password')
                ->where('lr_user_roleid','1')
                ->where('lr_user_userid',$admin_userid)
                ->where('lr_user_password',$old_password)->get();
        if(count($sql1)>0){
        $password = md5($password);
        $sql2 = DB::table('tbl_lr_user')
            ->where('lr_user_roleid','1')
            ->where('lr_user_userid',$admin_userid)
            ->update([
                'lr_user_password'=>$password
                ]);
        if($sql2==true)
        {
        return response()->json(
        [
        'status' =>'200',
        'msg' => 'Password change successfully'
        ]);
        }
        else
        {
        return response()->json(
        [
        'status' =>'401',
        'msg' => 'Something went wrong, please try again later'
        ]);
        }
        }
        else
        {
        return response()->json(
        [
        'status' =>'401',
        'msg' => 'Old password does not match'
        ]); 
        }
        }
        else
        {
        return response()->json(
        [
        'status' =>'401',
        'msg' => 'Please enter old password'
        ]); 
        }
        }
        else
        {
        return response()->json(
        [
        'status' =>'401',
        'msg' => 'Invalid request'
        ]); 
        }
    }

    public function forgot_password(){
        return view('Admin::login.forgot_password');
    }

    public function forgotpassword(Request $request){
        if($request->isMethod('POST'))
        {
        $email = trim($request->email); 
        $role_id = '1'; 
        if($email!="")
        {

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return response()->json(
                [
                'status' =>'401',
                'msg' => 'Invalid E-mail'
                ]);
        }

        $objforgot_email = new Admin();
        $data = $objforgot_email->forgot_email($email,$role_id);
        return $data;
        }
        else
        {
        return response()->json(
        [
        'status' =>'401',
        'msg' => 'All fileds required.'
        ]);// all fileds required;
        }
        }
        else
        {
        return response()->json(
        [
        'status' =>'401',
        'msg' => 'Invalid Request.'
        ]);// all fileds required;
        }
    }

    public function changepassword($id=null)
    {
        if($id!='')
        {
           $sql_expiretoken = DB::table('tbl_lr_user')
                                     ->where([
                                         ['lr_user_token',$id],
                                         ['lr_user_token_status','0']
                                         ])->get();
           $sql_validtoken = DB::table('tbl_lr_user')->select('lr_user_userid')
                                       ->where('lr_user_token', $id)
                                       ->where('lr_user_roleid','1')->get();
            if(count($sql_validtoken)>0)
               {
                  $token = '1';
               }
               else{
                $token = '3';
               }
            if(count($sql_expiretoken)>0)
               {
                  $token = '2'; 
               }
        return view("Admin::login.resetpassword")->with('token',$token);
        }
        else
        {
            $token = '3';
            return view("Admin::login.resetpassword")->with('token',$token);
        }
    }

    public function changepasswordinsert(Request $request)
    {
        if($request->isMethod('POST'))
        {
        $password = $request->password;
        $token = $request->user_id;
        $role_id='1';
        $objchange_password = new Admin();
        $data = $objchange_password->changepassword($password,$token,$role_id);
        return $data;
        } // check for method post
        else
        {
        return response()->json(
        [
        'status' =>'401',
        'msg' => 'Invalid Request'
        ]); 
        }
    }
}
