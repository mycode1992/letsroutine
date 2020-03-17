<?php

namespace App\Modules\Website\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Admin\Models\Admin;
use DB;

class LoginController extends Controller
{
    public function login()
    {
        return view("Website::login");
    }

    public function login_check(Request $request){
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
                $role_id = '2';
                $session = 'sessionvendor';
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

    public function forgot_password(){
        return view('Website::forgot_password');
    }

    public function post_forgot_password(Request $request)
    {
        if($request->isMethod('POST'))
        { 
        $email = trim($request->email); 
        $role_id = '2'; 
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
        ]);  // all fileds required;
        }
        }
        else
        {
        return response()->json(
        [
        'status' =>'401',
        'msg' => 'Invalid Request.'
        ]);  // all fileds required;
        }
    }

    public function changepassword($id)
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
                                       ->where('lr_user_roleid','2')->get();
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
        return view("Website::resetpassword")->with('token',$token);
        }
        else
        {
            $token = '3';
            return view("Website::resetpassword")->with('token',$token);
        }
    }

    public function changepasswordinsert(Request $request)
    {
        if($request->isMethod('POST'))
        {       
        $password = $request->password;
        $token = $request->user_id;
        $role_id='2';
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

    public function verify_email($id=null){
         
        if(!$id)
        {
            return view("Website::verify_email")->with('token','3');
        }
        else
        {
           
            $verifydata = DB::table('tbl_lr_user')->where('lr_user_email_verifytoken', '=',$id)->get(['lr_user_email_verifystatus','lr_user_userid']); 

            if(count($verifydata)>0)
            {
                $email_verify_status=$verifydata[0]->lr_user_email_verifystatus;
                $userid=$verifydata[0]->lr_user_userid;

                if($email_verify_status=='0')
                {
                    
                    $sql=DB::table('tbl_lr_user')
                            ->where('lr_user_userid','=',$userid)
                            ->update(array(
                                'lr_user_email_verifystatus' => '1'
                            ));
                     $token_status='1';// verifed token
                }
                else
                {
                    $token_status='2';// already verified
                    
                }


            }
            else
            {
                $token_status='3';// Invalid Token
            }

           
            return view("Website::verify_email")->with('token',$token_status);
        }

       
    }
    
}
