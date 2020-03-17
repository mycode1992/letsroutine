<?php

	namespace App\Modules\Websrvc\Models;

	use Illuminate\Database\Eloquent\Model;
	use DB;
	class Websrvc extends Model {

	public function AreaList()
	{
		
        $arealistSql = DB::table('tbl_lr_governorate_area')
      				->where('admin_status',1)
      				->get(['lr_governorate_area_id','lr_governorate_area_name']);
      				
      	$arealist = [];
      	foreach ($arealistSql as $value) 
      	{
      		$lr_governorate_area_id = $value->lr_governorate_area_id;
      		$lr_governorate_area_name = $value->lr_governorate_area_name;
      		$arealist[] = [
      					"area_id" => $lr_governorate_area_id,
      					"area_name" => $lr_governorate_area_name
      					];
      	}

      return ([
		      	"status" => 200,
		      	"msg" => 'Successfully Retrieve Information.',
		      	"arealist" => $arealist     
		      ]);

	}// end of AreaList function

	public function RegisterUser($request) // start of RegisterUser function
	{
		$first_name = $request->first_name; 
		$last_name = $request->last_name; 
        $password = $request->password; 
        $email = $request->email; 
        $gender = $request->gender; 
        $dob = $request->dob; 
		$area_id = $request->area_id; 
		$userid = date('Ymdhis');
		$curDate = new \DateTime();
		
		$email_exist = isemail_exist('tbl_app_user','app_user_email',$email); 
		if($email_exist > 0){
			return ([
			'status' =>'401',
			'msg' => 'E-mail already registered'
			]);
		}
		else
		{
		if($first_name!='' && $last_name!='' && $password!='' && $email!='' && $gender!='' && $dob!='' && $area_id!='')
		{
		$sql=DB::table('tbl_app_user')
		->insert([
		'user_uniqueid'=>$userid,
		'app_user_fname'=>$first_name,    
		'app_user_lname'=>$last_name,    
		'app_user_email'=>$email,    
		'app_user_password'=>md5($password), 
		'app_user_gender'=> $gender ,     
		'app_user_dob'=>$dob,      
		'lr_governorate_area_id'=>$area_id,
		'admin_status'=>1,
		'app_user_created_time'=>$curDate,
		'app_user_updated_time'=>$curDate
		]);
		
		if($sql==true)
		{
			return ([
			'status' =>'200',
			'msg' => 'You have been successfully registered.'
			]);
		}
		else
		{
			return ([
			'status' =>'401',
			'msg' => 'Something went wrong, Please try again later.'
			]);
		}
	}
	else
	{
		return ([
			'status' =>'401',
			'msg' => 'All fields are required.'
			]);
	}
		} 
	}   // end of RegisterUser function

	public function LoginUser($request) // start of LoginUser function
	{
		$email = $request->email;
		$password = $request->password;
		$device_type = $request->device_type;
		$device_token = $request->device_token;
		if($email!='' && $password!='' && $device_type!='' && $device_token!='')
		{
			$sql1=DB::table('tbl_app_user')
			->where('app_user_email','=',$email)                        
			->where('app_user_password','=',md5($password))
			->get();
			if(count($sql1) > 0)
        	{
				$user_uniqueid  =  $sql1[0]->user_uniqueid;
				$app_user_fname = $sql1[0]->app_user_fname;
				$app_user_lname = $sql1[0]->app_user_lname;
				$app_user_email = $sql1[0]->app_user_email;
				$app_user_gender = $sql1[0]->app_user_gender;
				$app_user_dob = $sql1[0]->app_user_dob;
				$lr_governorate_area_id = $sql1[0]->lr_governorate_area_id;
				$app_user_phone = $sql1[0]->app_user_phone;
				$admin_status = $sql1[0]->admin_status;

				if($admin_status == 1)
				{
					return ([
					'status' =>'200',
					'msg' => 'Login successfully.',
					'user_data' =>[
					'user_uniqueid' => $user_uniqueid,
					'user_first_name' => $app_user_fname,
					'user_last_name' => $app_user_lname,
					'user_email' => $app_user_email,
					'user_gender' => $app_user_gender,
					'user_dob' => $app_user_dob,
					'user_area' => $lr_governorate_area_id,
					'user_phone' => $app_user_phone
					]
					
					]);
				
				 }
				 else
				 {
					return ([
					'status' =>'401',
					'msg' => 'Sorry! Your account has been deactivated, Please contact to our support team.'
					]);
				 }
			}
			else
			{
				return ([
				'status' =>'401',
				'msg' => 'Sorry! Entered E-Mail or Password is incorrect.'
				]);
			}
		}
		else
		{
			return ([
				'status' =>'401',
				'msg' => 'All fields are required.'
				]);
		}

	}  // end of LoginUser function 

	public function ForgotPassword($email) // start of ForgotPassword function
	{
		$sql=DB::table('tbl_app_user')
		->where('app_user_email','=',$email)
		->get(['admin_status','user_uniqueid','app_user_fname','app_user_lname']);

			if(count($sql) > 0)
        	{
				$admin_status = $sql[0]->admin_status;
				if($admin_status == 1)
				{
					$verify_token=getRandomString(20);
					$sql1= DB::table('tbl_app_user')
					->where('user_uniqueid', $sql[0]->user_uniqueid)
					->update(['app_user_forgot_token' =>$verify_token,'app_user_forgot_token_status' =>1]);

					$name = $sql[0]->app_user_fname.' '.$sql[0]->app_user_lname; 
					$sendemail = ForgotPasswordEmail($name,$email,$verify_token,'App');
					
					return ([
					'status' =>'200',
					'msg' => 'Check your email inbox to change your password.'
					]);  

				 }
				 else
				 {
					return ([
					'status' =>'401',
					'msg' => 'Sorry! Your account has been deactivated, Please contact to our support team.'
					]);
				 }
			}
			else
			{
			
				return ([
				'status' =>'401',
				'msg' => 'E-mail id does not exist'
				]);
			}
		

	}  // end of ForgotPassword function 

	public function changepassword($token) // start of changepassword function 
	{
		$sql_expiretoken = DB::table('tbl_app_user')
		->where([
			['app_user_forgot_token',$token],
			['app_user_forgot_token_status',0]
			])->get();
		$sql_validtoken = DB::table('tbl_app_user')->select('user_uniqueid')
				->where('app_user_forgot_token', $token)
				->where('app_user_forgot_token_status',1)->get();
		if(count($sql_validtoken)>0)
		{
		$token_status = '1';
		}
		else{
		$token_status = '3';
		}
		if(count($sql_expiretoken)>0)
		{
		$token_status = '2'; 
		}
		return view("Websrvc::changepassword")->with('token_status',$token_status)->with('token',$token);
	}  // end of changepassword function 

	public function changepasswordinsert($password,$token) // start of changepasswordinsert function 
	{
		if($token!=''){
			$sql_validtoken = DB::table('tbl_app_user')->select('user_uniqueid')
							->where('app_user_forgot_token', $token)->get();
		if(count($sql_validtoken)>0)
		{
			try
			{
				$sql_chgpass = DB::table('tbl_app_user')
				->where('app_user_forgot_token',$token)
				->update([
				'app_user_password'=> md5($password),
				'app_user_forgot_token_status'=>0
				]); 

				return ([
				'status' =>'200',
				'msg' => 'your password has been successfully changed.'
				]);
			}
			catch(Exception $e)
			{
			    return ([
				'status' =>'401',
				'msg' => 'Something went wrong, Please try again later.'
				]);
			}
		}
		else  
		{
			return ([
			'status' =>'401',
			'msg' => 'Sorry! invalid token'
			]); 
		}// check for invalid token
		}
		else
		{
			return ([
				'status' =>'401',
				'msg' => 'Something went wrong,Please try again later.'
				]); 
		}
	}  // end of changepasswordinsert function 

	public function GetPageLinks()  // start of GetPageLinks function 
	{

		return ([
			'status' =>'200',
			'msg' => 'Successfully Retrieve Information.',
			'aboutus' => $about_us[0]->app_cms_desp
			]);
	} // end of GetPageLinks function 

	public function Aboutus() // start of aboutus function 
    {
	  $about_us = DB::table('tbl_app_cms')->where('app_cms_id',1)->get(['app_cms_desp']);
	  return view("Websrvc::Aboutus")->with('about_us',$about_us[0]->app_cms_desp);
    }  // end of aboutus function 


	public function UserLogin($mobile,$password,$dt)
	{
		
		return ([
	        	"status" => "200",
	        	"msg" => "Successfully retrieve information!",
	        	"mobile" => $mobile,
	        	"password" => $password
	        	]);



	}// end of user login function
	

	}// end of class
