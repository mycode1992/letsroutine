<?php

namespace App\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Admin extends Model {

    public function login($email,$password,$role_id,$session)
    {
		$pass=md5($password);
		$sql1=DB::table('tbl_lr_user')->select('lr_user_userid','lr_user_name','lr_user_email','lr_user_roleid')
				->where('lr_user_email','=',$email)                        
				->where('lr_user_password','=',$pass)
				->where('lr_user_roleid','=',$role_id)
				->limit(1)
				->get();

        if(count($sql1))
        {
			
        $sql_admin_status=DB::table('tbl_lr_user')->where('lr_user_admin_status','=','1')->where('lr_user_userid',$sql1[0]->lr_user_userid)->get();

        $sql_verify_email = DB::table('tbl_lr_user')->where('lr_user_email_verifystatus','=','1')->where('lr_user_userid',$sql1[0]->lr_user_userid)->get();
        if(count($sql_verify_email)>0)
        {
        if(count($sql_admin_status))
        {
        $userid=$sql1[0]->lr_user_userid;
        $name=$sql1[0]->lr_user_name;
        $email=$sql1[0]->lr_user_email;
        $role_id=$sql1[0]->lr_user_roleid;

        $data=
        [
        'userid'=>$userid,
        'role_id'=>$role_id,
        'name'=>$name,
        'email'=>$email
        ];
        Session::put($session, $data);
        return response()->json(
        [
        'status' =>'200',
        'msg' => 'Thank you! Successfully logged in, Redirecting...'
        ]); 
		}
        else
        {
        return response()->json(
        [
        'status' =>'401',
        'msg' => 'Sorry! Your account has been deactivated, Please contact to our support team.'
        ]);
        }
        }
        else
        {
        return response()->json(
        [
        'status' =>'401',
        'msg' => 'Your email id is not verified,Please check your inbox and verify your account.'
        ]);
        }
		}
        else
        {
        return response()->json(
        [
        'status' =>'401',
        'msg' => 'Sorry! Entered E-Mail or Password is incorrect.'
        ]);
		}
       
    }
    
    public function forgot_email($email,$role_id)
    {
    $sql=DB::table('tbl_lr_user')
    ->where([
            ['lr_user_email','=',$email],
            ['lr_user_roleid','=',$role_id]
        ])
    ->select('lr_user_userid','lr_user_name')
    ->get();
    if(count($sql)>0)
    {
    $sql_admin_status=DB::table('tbl_lr_user')->where('lr_user_admin_status','=','1')->where('lr_user_userid','=',$sql[0]->lr_user_userid)->get();
    if(count($sql_admin_status)>0)
    {
    $verify_token=getRandomString(20);
    $sql1= DB::table('tbl_lr_user')
            ->where('lr_user_userid', $sql[0]->lr_user_userid)
            ->update(['lr_user_token' =>$verify_token,'lr_user_token_status' => '1']);
        
    if($sql1==true)
    { 
    $name=$sql[0]->lr_user_name; 
    $sendemail = ForgotPasswordEmail($name,$email,$verify_token,$role_id);
    
    return response()->json(
    [
    'status' =>'200',
    'msg' => 'Please check your inbox and get a new password'
    ]);  
    }
				}
				else{
					return response()->json(
						[
						'status' =>'401',
						'msg' => 'Sorry! Your account has been deactivated, Please contact to our support team.'
						]);
				}


			 }
		  else
			{
			  
				 return response()->json(
				  [
				  'status' =>'401',
				  'msg' => 'E- mail id does not exist'
				  ]);
			}


	  
 }

 function changepassword($password,$token,$role_id){
                  
	if($token!=''){
		$sql_validtoken = DB::table('tbl_lr_user')->select('lr_user_userid')
						->where('lr_user_token', $token)
						->where('lr_user_roleid',$role_id)->get();
	if(count($sql_validtoken)>0)
	{
	   $sql_chgpass = DB::table('tbl_lr_user')
					  ->where([
							['lr_user_token',$token],
							['lr_user_roleid',$role_id]
						  ])
					  ->update([
						'lr_user_password'=> md5($password),
						'lr_user_token_status'=>'0'
						]); 
		
		if($sql_chgpass==true)
		{
			return response()->json(
				[
				'status' =>'200',
				'msg' => 'your password has been successfully changed.'
				]);
		}
		else
		{
			return response()->json(
				[
				'status' =>'401',
				'msg' => 'Something went wrong'
				]);
		}
	}
	else  
	{
		return response()->json(
		[
		'status' =>'401',
		'msg' => 'Sorry! invalid token'
		]); 
	}// check for invalid token
	}

}

public function register($diet_centre_name,$fname,$lname,$phone,$email,$password,$diet_centre_addr,$imageidd,$role_id)
{
    $ip_address =  \Request::ip(); 
    $curDate = new \DateTime();
    $userid = date('Ymdhis');
    $name = $fname." ".$lname;
  
    $email_exist = isemail_exist('tbl_lr_user','lr_user_email',$email); 
    if($email_exist > 0){
    return response()->json(
      [
      'status' =>'401',
      'msg' => 'E-mail already registered'
      ]);
    }
    else{
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
        else
        {
        return response()->json(
        [
        'status' =>'401',
        'msg' => 'Please select image.'
        ]);
        }

    $verify_token = getRandomString(20); 
    DB::beginTransaction();
    try 
    { 
    $sql=DB::table('tbl_lr_user')
    ->insert([
    'lr_user_userid'=>$userid,
    'lr_user_name'=>$name,    
    'lr_user_email'=>$email,    
    'lr_user_password'=>md5($password),    
    'lr_user_roleid'=>$role_id, 
    'lr_user_email_verifytoken'=> $verify_token ,     
	'lr_user_email_verifystatus'=>'0',   
    'lr_user_admin_status'=>'0'
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

    DB::commit();
    
    $sendemail = WelcomeEmail($name,$email,$verify_token);
    return response()->json(
      [
      'status' =>'200',
      'msg' => 'Successfully registered,Please check your inbox and verify your E-mail address'
      ]);

    } catch (\Exception $e)
    {
    DB::rollback();
    return response()->json(
    [
    'status' =>'401',
    'msg' => 'Something went wrong,please try again later.'
    ]);
    }

    }   
    }

}
