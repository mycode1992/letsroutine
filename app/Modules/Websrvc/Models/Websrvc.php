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
		$userid = uniqid();
		$lng_type = $request->lng_type;
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
		'app_user_lang'=>$lng_type,
		'admin_status'=>1,
		'app_user_created_time'=>$curDate,
		'app_user_updated_time'=>$curDate
		]);

		$sql_getuser_info=DB::table('tbl_app_user')
			->where('app_user_email','=',$email)                        
			->where('app_user_password','=',md5($password))
			->get();

		$user_uniqueid  =  $sql_getuser_info[0]->user_uniqueid;
		$app_user_fname = $sql_getuser_info[0]->app_user_fname;
		$app_user_lname = $sql_getuser_info[0]->app_user_lname;
		$app_user_email = $sql_getuser_info[0]->app_user_email;
		$app_user_gender = $sql_getuser_info[0]->app_user_gender;
		$app_user_dob = $sql_getuser_info[0]->app_user_dob;
		$lr_governorate_area_id = $sql_getuser_info[0]->lr_governorate_area_id;
		$app_user_phone = $sql_getuser_info[0]->app_user_phone;
		$app_user_lang = $sql_getuser_info[0]->app_user_lang;
		$admin_status = $sql_getuser_info[0]->admin_status;

		if($sql==true)
		{
			return ([
			'status' =>'200',
			'msg' => 'You have been successfully registered.',
			'user_data' =>[
				'user_uniqueid' => $user_uniqueid,
				'user_first_name' => $app_user_fname,
				'user_last_name' => $app_user_lname,
				'user_email' => $app_user_email,
				'user_gender' => $app_user_gender,
				'user_dob' => $app_user_dob,
				'user_area' => $lr_governorate_area_id,
				'user_phone' => $app_user_phone,
				'lng_type' => $app_user_lang
				]
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

				$sql2 = DB::table('tbl_app_user_health_detail')
				->where('user_uniqueid','=',$user_uniqueid) 
				->get();
				if(count($sql2) > 0)
        		{
					$user_health_detail_height = $sql2[0]->user_health_detail_height;
					$user_health_detail_weight = $sql2[0]->user_health_detail_weight;
				}
				else
				{
					$user_health_detail_height = '';
					$user_health_detail_weight = '';
				}

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
					'user_phone' => $app_user_phone,
					'height' => $user_health_detail_height,
					'weight' => $user_health_detail_weight
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
		$collect = collect([1, 2, 3]);
		$about_us = DB::table('tbl_lr_cms')->whereIn('lr_cms_id' , $collect)->get();
			$links = [];
		foreach($about_us AS $val)
		{
			$links[] = [
				"title" => $val->lr_cms_name,
				"desc" => $val->lr_cms_description
			];
		}

		
		return ([
			'status' =>'200',
			'msg' => 'Successfully Retrieve Information.',
			'links' => $links
		]);

		
	} // end of GetPageLinks function 

	
	
	public function GetSupport() // start of GetSupport function 
	{
		$GetSupport_sql = DB::table('tbl_app_customer_service')
		->where('id',1)
		->get(['phone_no','app_customer_service_email']); 
		
		if(count($GetSupport_sql) > 0)
		{
			$phone_no = $GetSupport_sql[0]->phone_no;
			$email = $GetSupport_sql[0]->app_customer_service_email;
			return ([
				'status' =>'200',
				'msg' => 'Successfully Retrieve Information.',
				'phone' => $phone_no,
				'email' => $email
				]);
		}
		{
			return ([
				'status' =>'401',
				'msg' => 'Something went wrong, Please try again later.'
				]);
		}
		
		
	}  // end of GetSupport function    

	public function GetUserInfo($user_uniqueid) // start of GetUserInfo function 
	{  

	    $GetUserInfo_sql = DB::table('tbl_app_user')
							->where('user_uniqueid','=',$user_uniqueid)
							->get(['user_uniqueid','app_user_fname','app_user_lname','app_user_email','app_user_gender','app_user_dob','lr_governorate_area_id as user_area','app_user_phone','app_user_lang']);

		if(count($GetUserInfo_sql) > 0)
		{
			$user_uniqueid  =  $GetUserInfo_sql[0]->user_uniqueid;
			$app_user_fname = $GetUserInfo_sql[0]->app_user_fname;
			$app_user_lname = $GetUserInfo_sql[0]->app_user_lname;
			$app_user_email = $GetUserInfo_sql[0]->app_user_email;
			$app_user_gender = $GetUserInfo_sql[0]->app_user_gender;
			$app_user_dob = $GetUserInfo_sql[0]->app_user_dob;
			$lr_governorate_area_id = $GetUserInfo_sql[0]->user_area;
			$app_user_phone = $GetUserInfo_sql[0]->app_user_phone;
			$app_user_lang = $GetUserInfo_sql[0]->app_user_lang;

			$getAreaName = getAreaName($lr_governorate_area_id);

			$GetUseraddrInfo_sql = DB::table('tbl_app_user_address')
							->where('user_uniqueid','=',$user_uniqueid)
							->where('app_user_add_status',1)
							->get(['app_user_add_id','app_user_add_title','lr_governorate_area_id as user_addr_area','app_user_add_block','app_user_add_street','app_user_add_avenue','app_user_add_house','app_user_add_phone']);
	
			if(count($GetUseraddrInfo_sql) > 0)
			{
				$app_user_add_id = $GetUseraddrInfo_sql[0]->app_user_add_id;
				$app_user_add_title = $GetUseraddrInfo_sql[0]->app_user_add_title;
				$user_addr_area = $GetUseraddrInfo_sql[0]->user_addr_area;
				$app_user_add_block = $GetUseraddrInfo_sql[0]->app_user_add_block;
				$app_user_add_street = $GetUseraddrInfo_sql[0]->app_user_add_street;
				$app_user_add_avenue = $GetUseraddrInfo_sql[0]->app_user_add_avenue;
				$app_user_add_house = $GetUseraddrInfo_sql[0]->app_user_add_house;
				$app_user_add_phone = $GetUseraddrInfo_sql[0]->app_user_add_phone;

				$app_getAreaName = getAreaName($user_addr_area);

				return ([
					'status' =>'200',
					'msg' => 'Successfully Retrieve Information.',
					'user_data' =>[
						'user_uniqueid' => $user_uniqueid,
						'user_first_name' => $app_user_fname,
						'user_last_name' => $app_user_lname,
						'user_email' => $app_user_email,
						'user_gender' => $app_user_gender,
						'user_dob' => $app_user_dob,
						'user_area' => $lr_governorate_area_id,
						'add_area_name' => $getAreaName,
						'user_phone' => $app_user_phone,
						'lng_type' => $app_user_lang,
						'user_default_add' =>[   
							'add_id' => $app_user_add_id,
							'add_title' => $app_user_add_title,
							'add_area_id' => $user_addr_area,
							'add_area_name' => $app_getAreaName,
							'add_block' => $app_user_add_block,
							'add_street' => $app_user_add_street,
							'add_avenue' => $app_user_add_avenue,
							'add_house' => $app_user_add_house,
							'add_phone' => $app_user_add_phone
							]
					]
					
					]);
			}
			else
			{
				return ([
					'status' =>'200',
					'msg' => 'Successfully Retrieve Information.',
					'user_data' =>[
						'user_uniqueid' => $user_uniqueid,
						'user_first_name' => $app_user_fname,
						'user_last_name' => $app_user_lname,
						'user_email' => $app_user_email,
						'user_gender' => $app_user_gender,
						'user_dob' => $app_user_dob,
						'user_area' => $lr_governorate_area_id,
						'user_phone' => $app_user_phone,
						'lng_type' => $app_user_lang
					]
					
					]);
			}
			
		}
		{
			return ([
				'status' =>'401',
				'msg' => 'Something went wrong, Please try again later.'
				]);
		}
		
		
	}  // end of GetUserInfo function

	

	public function EditUserInfo($user_uniqueid,$first_name,$last_name,$gender,$dob,$phone,$lng_type) // start of EditUserInfo function 
	{

		if($user_uniqueid!='' || $first_name!='' || $last_name!='' || $gender!='' || $dob!='' || $phone!='' || $lng_type !='')
		{
			try
			{ 
				$sql_user_update = DB::table('tbl_app_user')->where('user_uniqueid','like',$user_uniqueid)->update([
					'app_user_fname' =>  $first_name,
					'app_user_lname' =>  $last_name,
					'app_user_phone' =>  $phone,
					'app_user_gender' =>  $gender,
					'app_user_dob' =>  $dob,
					'app_user_lang' =>  $lng_type	
				]);

				$GetUserInfo_sql = $sql1=DB::table('tbl_app_user')
							->where('user_uniqueid','=',$user_uniqueid) 
							->get();
		
				if(count($GetUserInfo_sql) > 0)
				{

					$user_uniqueid  =  $sql1[0]->user_uniqueid;
					$app_user_fname = $sql1[0]->app_user_fname;
					$app_user_lname = $sql1[0]->app_user_lname;
					$app_user_email = $sql1[0]->app_user_email;
					$app_user_gender = $sql1[0]->app_user_gender;
					$app_user_dob = $sql1[0]->app_user_dob;
					$lr_governorate_area_id = $sql1[0]->lr_governorate_area_id;
					$app_user_phone = $sql1[0]->app_user_phone;
					$app_user_lang = $sql1[0]->app_user_lang;

					return ([
					'status' =>'200',
					'msg' => 'Profile Updated Successfully.',
					'user_data' =>[
						'user_uniqueid' => $user_uniqueid,
						'user_first_name' => $app_user_fname,
						'user_last_name' => $app_user_lname,
						'user_email' => $app_user_email,
						'user_gender' => $app_user_gender,
						'user_dob' => $app_user_dob,
						'user_area' => $lr_governorate_area_id,
						'user_phone' => $app_user_phone,
						'lng_type' => $app_user_lang
						]
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
				'msg' => 'All fields are required.'
				]);
		}
	}  // end of EditUserInfo function

	public function UserLogin($mobile,$password,$dt)
	{
		
		return ([
	        	"status" => "200",
	        	"msg" => "Successfully retrieve information!",
	        	"mobile" => $mobile,
	        	"password" => $password
	        	]);



	}// end of user login function

	public function UpdatePassword($user_uniqueid,$old_password,$new_password,$confirm_password)  // end of UpdatePassword function
	{
		if($user_uniqueid !='' && $old_password !='' && $new_password !='' && $confirm_password)
		{
			$check_old_password = check_old_password($user_uniqueid,$old_password);
			if($check_old_password > 0)
			{
				if($new_password===$confirm_password)
				{
					try
					{
						$sql_update = DB::table('tbl_app_user')->where('user_uniqueid',$user_uniqueid)->update([
							'app_user_password' => md5($new_password)	
						]);

						return ([
							'status' =>'200',
							'msg' => 'Password updated successfully.'
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
						'msg' => 'Confirm password does not match.'
						]);
				}
			}
			else
			{
				return ([
					'status' =>'401',
					'msg' => 'Old password does not match.'
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
		
	}  // end of UpdatePassword function

	public function GetUserWallet($user_uniqueid)  // end of GetUserWallet function
	{
		if($user_uniqueid !='')
		{
			$GetUserWallet = DB::table('tbl_app_user_wallet')->where('user_uniqueid',$user_uniqueid)->get(['app_user_wallet_amount']);
			if(count($GetUserWallet) > 0)
			{
				$wallet_amount = $GetUserWallet[0]->app_user_wallet_amount;
				return ([
					'status' =>'200',
					'msg' => 'Successfully Retrieve Information.',
					'wallet_amount' => $wallet_amount
					]);
			}
			else
			{
				return ([
					'status' =>'200',
					'msg' => 'Successfully Retrieve Information.',
					'wallet_amount' => 0
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
		
	}  // end of GetUserWallet function

	
	public function OrderReportProblem($user_uniqueid,$order_id,$title,$comment)  // end of OrderReportProblem function
	{
		if($user_uniqueid !='' && $order_id !='' && $title !='' && $comment != '')
		{
			$OrderReportProblem_sql = DB::table('tbl_app_order_report_problem')->insert([
										'user_uniqueid' => $user_uniqueid,
										'app_order_id' => $order_id,
										'app_report_problem_title' => $title,
										'app_report_problem_comment' => $comment
										]);
			
			if($OrderReportProblem_sql == true)
			{
				return ([
					'status' =>'200',
					'msg' => 'Successfully reported your feedback.'
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
		
	}  // end of OrderReportProblem function

	public function AddAddress($user_uniqueid,$address_title,$area_id,$block,$street,$avenue,$house,$phone,$update_id)  // end of AddAddress function
	{
		$curDate = new \DateTime();
		if($update_id=='')
		{
			if($user_uniqueid !='' && $address_title !='' && $area_id !='' && $block !='' && $street !=''  &&  $house !='' && $phone !='')
			{
				$area_name_sql = DB::table('tbl_lr_governorate_area')->where('lr_governorate_area_id',$area_id)->get(['lr_governorate_area_name']);
	
				$is_address_add_before = DB::table('tbl_app_user_address')->where('user_uniqueid',$user_uniqueid)->count();
	
				if($is_address_add_before > 0)
				{  
					$add_status = 0;
				}
				else
				{   
					$add_status = 1;
				} 
	
				$AddAddress_sql = DB::table('tbl_app_user_address')->insert([
											'user_uniqueid' => $user_uniqueid,
											'app_user_add_title' => $address_title,
											'lr_governorate_area_id' => $area_id,
											'app_user_add_block' => $block,
											'app_user_add_street' => $street,
											'app_user_add_avenue' => $avenue,
											'app_user_add_house' => $house,
											'app_user_add_phone' => $phone,
											'app_user_add_created_time' => $curDate,
											'app_user_add_status' => $add_status
											]);
	
				$last_insert_id = DB::getPdo()->lastInsertId();
	
				
				
				if($AddAddress_sql == true)   
				{
					return ([
						'status' =>'200',
						'msg' => 'Address Added Successfully.',
						'add_address_info' =>[
							'add_id' => $last_insert_id,
							'add_area_name' => $area_name_sql[0]->lr_governorate_area_name, 
							'add_title' => $address_title,
							'add_area_id' => $area_id,
							'add_block' => $block,
							'add_street' => $street,
							'add_avenue' => $avenue,
							'add_house' => $house,
							'add_phone' => $phone,
							'add_status' => $add_status
							]
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
		else
		{
			try
			{
				$getAreaName = getAreaName($area_id);
				$add_status_sql = DB::table('tbl_app_user_address')->where('app_user_add_id',$update_id)->get(['app_user_add_status']);

				$add_status = $add_status_sql[0]->app_user_add_status;

				$UpdateAddress_sql = DB::table('tbl_app_user_address')->where('app_user_add_id',$update_id)->update([
					'app_user_add_title' => $address_title,
					'lr_governorate_area_id' => $area_id,
					'app_user_add_block' => $block,
					'app_user_add_street' => $street,
					'app_user_add_avenue' => $avenue,
					'app_user_add_house' => $house,
					'app_user_add_phone' => $phone,
					'app_user_add_updated_time' => $curDate
					]);
	
					return ([
						'status' =>'200',
						'msg' => 'Address Updated Successfully.',
						'add_address_info' =>[
							'add_id' => $update_id,
							'add_area_name' => $getAreaName, 
							'add_title' => $address_title,
							'add_area_id' => $area_id,
							'add_block' => $block,
							'add_street' => $street,
							'add_avenue' => $avenue,
							'add_house' => $house,
							'add_phone' => $phone,
							'add_status' => $add_status
							]
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
	
		
	}  // end of AddAddress function

	public function GetAddressList($user_uniqueid) // start of GetUserInfo function 
	{
		$GetAddressList_sql = $sql1=DB::table('tbl_app_user_address')
							->where('user_uniqueid','=',$user_uniqueid) 
							->get();
			$address_info_data =[];
			foreach($GetAddressList_sql as $val)
			{           
			$app_user_add_id = $val->app_user_add_id;
			$address_title = $val->app_user_add_title;
			$area_id = $val->lr_governorate_area_id;
			$block = $val->app_user_add_block;
			$street = $val->app_user_add_street;
			$avenue = $val->app_user_add_avenue;
			$house = $val->app_user_add_house;
			$phone = $val->app_user_add_phone;
			$status = $val->app_user_add_status;

			$getAreaName = getAreaName($area_id);

			$address_info_data[] = [
				'add_id' => $app_user_add_id,
				'add_title' => $address_title,
				'add_area_id' => $area_id,
				'add_area_name' => $getAreaName,
				'add_block' => $block,
				'add_street' => $street,
				'add_avenue' => $avenue,
				'add_house' => $house,
				'add_phone' => $phone,
				'add_status' => $status
				];
			}
			
			return ([
				'status' => '200',
				'msg' => 'Successfully Retrieve Information.',
				'address_info' => $address_info_data
			]);
		
		
	}  // end of GetUserInfo function

	public function MarkAsDefaultAdd($user_uniqueid,$address_id) // start of GetUserInfo function 
	{
		try
		{

			$MarkAsDefaultAddr_sql1 = $sql1=DB::table('tbl_app_user_address')
							->where('user_uniqueid','like',$user_uniqueid)
							->update([
								'app_user_add_status' => 0
							]);

			$MarkAsDefaultAddr_sql = $sql1=DB::table('tbl_app_user_address')
							->where('user_uniqueid','like',$user_uniqueid)
							->where('app_user_add_id',$address_id) 
							->update([
								'app_user_add_status' => 1
							]);

			return ([
				'status' => '200',
				'msg' => 'Marked As Default Address.'
			]);
		}
		catch(Exception $e)
		{
			return ([
				'status' => '401',
				'msg' => 'Something went wrong, Please try again later.'
			]);
		}
		
	}  // end of GetUserInfo function   

	public function GetPlanDietList($type,$gender,$user_uniqueid) // start of GetPlanDietList function 
	{
		if($type=='PACKAGES')
		{
			$GetPackageList_sql = DB::table('tbl_lr_package')
								->where('admin_status','=',1);

				if($user_uniqueid!='')  
				{ 

					$user_default_address_sql = DB::table('tbl_app_user_address')->select('lr_governorate_area_id')->where(['user_uniqueid' => $user_uniqueid , 'app_user_add_status' => 1])->first();
	
					if($gender!='')
					{
						
						 $GetPackageList_sql->where(function($q) use ($gender) {
					         $q->where('package_gender',$gender)
					           ->orwhere('package_gender','BOTH');
					     });
					} 
					
					if(count($user_default_address_sql) > 0)
					{ 
					   $user_governorate_area_id =	$user_default_address_sql->lr_governorate_area_id;

					   $GetPackageList_sql->where('lr_governorate_area_id',$user_governorate_area_id);
					}
				}

				$GetPackageList_sql = $GetPackageList_sql->get(['lr_package_id','package_name','package_gender','package_price','package_type','image']);
				
			
			if(count($GetPackageList_sql) > 0)
			{
				$plan_info = [];
				foreach($GetPackageList_sql as $packageval)
				{  
					$planid_sql = DB::table('tbl_lr_package_details')->where('lr_package_id',$packageval->lr_package_id)->get(['vendor_plan_id']);


				$diet_centers = [];
				$plan_meals_count = 0;
				$plan_snacks_count = 0;
				$plan_days_count = 0;

				foreach($planid_sql as $planid_val)
				{
					$plan_detail_sql = DB::table('tbl_lr_vendor_plan as t1')
					->join('tbl_lr_userdetail as t2','t1.lr_user_id','t2.lr_user_userid')
					->where('vendor_plan_id','=',$planid_val->vendor_plan_id)
					->get(['vendor_plan_name','vendor_plan_offdays','vendor_plan_menu_type','vendor_plan_type','plan_description','t2.lr_userdetail_logo','t1.vendor_plan_macros','t1.macros_yes_min_carb','t1.macros_yes_max_carb','t1.macros_yes_min_protein','t1.macros_yes_max_protein','t1.macros_yes_plan','t1.macros_no_max_carb','t1.macros_no_max_protein','vendor_plan_pause','plan_cost','t1.lr_user_id','t2.lr_userdetail_centrename','vendor_plan_meals','vendor_plan_snacks']); // sql to get plan details

					$diet_centers[] = [
						'center_id' => $plan_detail_sql[0]->lr_user_id,
						'center_name' => $plan_detail_sql[0]->lr_userdetail_centrename
					];

					$plan_meals_count = $plan_meals_count + $plan_detail_sql[0]->vendor_plan_meals;

					$plan_snacks_count = $plan_snacks_count + $plan_detail_sql[0]->vendor_plan_snacks;

					$plan_days_count = $plan_days_count + 7;


				}

		       if($packageval->package_type == 'FIXEDMENU')
				{
				$plan_menutype = 'FIXED MENU';
				}
				else
				{
				$plan_menutype = 'CUSTOM MENU';
				}

				$diet_centers = array_map("unserialize", array_unique(array_map("serialize", $diet_centers))); // remove duplicate from 2d


				$plan_info[] = [   
					'package_id' => $packageval->lr_package_id,
					'package_name' => $packageval->package_name,
					'plan_menutype' => $plan_menutype,
					'plan_image' => url('/public/admin/upload/package')."/".$packageval->image, 
					'plan_meals_count' => $plan_meals_count,
					'plan_snacks_count' => $plan_snacks_count,
					'plan_days_count' => $plan_days_count,
					'plan_cost' => $packageval->package_price,
					'plan_type' => 'PACKAGE',
					'plan_filter_id' => '',
					'plan_filter_name' => '',
					'plan_filter_image' => '',
					'diet_centers' => $diet_centers
					];
				}

				return ([
					'status' => '200',
					'msg' => 'Successfully Retrieve Information.',
					'plan_info' => $plan_info
				]);
			}
			else
			{
				return ([
					'status' => '200',
					'msg' => 'No Records found.',
					'plan_info' => array()
				]);
			}
		}
		else
		{

				$GetPlanDietList_sql = DB::table('tbl_lr_vendor_plan as t1')
				->join('tbl_lr_userdetail as t2','t1.lr_user_id','t2.lr_user_userid')
								->where('t1.status','=',1) 
								->where('t1.admin_status','=',1) 
								->where('t1.app_status','=',1); 

				if($user_uniqueid!='')  
				{ 
					$user_filter_plan_sql = DB::table('tbl_app_user_plan_filter')->where(['user_uniqueid' => $user_uniqueid , 'vendor_plan_type' => $type])->orderby('user_filter_id','desc')->first();

					$user_default_address_sql = DB::table('tbl_app_user_address')->select('lr_governorate_area_id')->where(['user_uniqueid' => $user_uniqueid , 'app_user_add_status' => 1])->first();

					if(count($user_filter_plan_sql) > 0)
					{  $GetPlanDietList_sql->where('vendor_plan_type','=',$type);  
						if($user_filter_plan_sql->diet_centre_id!='')
						{
							$exp_diet_id = explode(',',$user_filter_plan_sql->diet_centre_id);
							foreach($exp_diet_id as $val)
							{
								$GetPlanDietList_sql->where('t1.lr_user_id',$val);
							}
						}
						if($user_filter_plan_sql->app_planfilter_id!='')
						{
							$GetPlanDietList_sql->where('t1.app_planfilter_id',$user_filter_plan_sql->app_planfilter_id);
						}
					}
					else
					{   
						$GetPlanDietList_sql->where('vendor_plan_type','=',$type);
						if($gender!='')
						{
							
							 $GetPlanDietList_sql->where(function($q) use ($gender) {
						         $q->where('t1.vendor_plan_gendor',$gender)
						           ->orwhere('t1.vendor_plan_gendor','BOTH');
						     });
						}
					}
					if(count($user_default_address_sql) > 0)
					{ 
					   $user_governorate_area_id =	$user_default_address_sql->lr_governorate_area_id;
					   $GetPlanDietList_sql->join('tbl_lr_vendor_governorate_area as vendor_area','vendor_area.lr_user_userid','t1.lr_user_id')->where('vendor_area.lr_governorate_area_id',$user_governorate_area_id);
					}
					else
					{	
					   //	
					}
				}
				else
				{
					$GetPlanDietList_sql->where('vendor_plan_type','=',$type);
					if($gender!='')
					{
						
						 $GetPlanDietList_sql->where(function($q) use ($gender) {
					         $q->where('t1.vendor_plan_gendor',$gender)
					           ->orwhere('t1.vendor_plan_gendor','BOTH');
					     });
					}

				}

				$GetPlanDietList_sql = $GetPlanDietList_sql->get(['t1.vendor_plan_id','vendor_plan_name','vendor_plan_meals','vendor_plan_snacks','plan_cost','t2.lr_user_userid','lr_userdetail_centrename','t1.vendor_plan_menu_type','t1.app_planfilter_id','t1.vendor_plan_type','plan_image']);

				
					 $curDate = new \DateTime();
					 $curDate = $curDate->format('Y/m/d');
					if(count($GetPlanDietList_sql) > 0)
					{
						$plan_info = [];
						foreach($GetPlanDietList_sql as $planval)
						{  
							$type1 = $planval->vendor_plan_type;
							if($type1=='MONTHLY')
							{
								$from = date('Y-m-d', strtotime($curDate. ' + 1 days'));
								$to = date('Y-m-d', strtotime($curDate. ' + 30 days'));

								$no_of_plan_days = DB::table('tbl_lr_vendor_plandetail_final')->GroupBy('vendor_plandetail_date')->whereBetween('vendor_plandetail_date', [$from, $to])->where('vendor_plan_id',$planval->vendor_plan_id)->get();
							}
							else if($type1=='WEEKLY')
							{
								$from = date('Y-m-d', strtotime($curDate. ' + 1 days'));
								$to = date('Y-m-d', strtotime($curDate. ' + 7 days'));

								$no_of_plan_days = DB::table('tbl_lr_vendor_plandetail_final')->GroupBy('vendor_plandetail_date')->whereBetween('vendor_plandetail_date', [$from, $to])->where('vendor_plan_id',$planval->vendor_plan_id)->get();
							}

						 $plan_filter_det_sql = DB::table('tbl_app_planfilter')->where('app_planfilter_id',$planval->app_planfilter_id)->select('app_planfilter_id','app_planfilter_name','app_planfilter_image')->get();

						if($planval->vendor_plan_menu_type=='FIXEDMENU')
						{
						$plan_menutype = 'FIXED MENU';
						}
						else
						{
						$plan_menutype = 'CUSTOM MENU';
						}

						$plan_info[] = [   
							'plan_id' => $planval->vendor_plan_id,
							'plan_name' => $planval->vendor_plan_name,
							'plan_menutype' => $plan_menutype,
							'plan_diet_center_id' => $planval->lr_user_userid,
							'plan_diet_center_name' => $planval->lr_userdetail_centrename,
							'plan_image' => url('/public/vendor/upload/plan_image')."/".$planval->plan_image, 
							'plan_meals_count' => $planval->vendor_plan_meals,
							'plan_snacks_count' => $planval->vendor_plan_snacks,
							'plan_days_count' => count($no_of_plan_days),
							'plan_cost' => $planval->plan_cost,
							'plan_type' => $type1,
							'plan_filter_id' => $plan_filter_det_sql[0]->app_planfilter_id,
							'plan_filter_name' => $plan_filter_det_sql[0]->app_planfilter_name,
							'plan_filter_image' => url('/public/admin/upload/plan_filter_image')."/".$plan_filter_det_sql[0]->app_planfilter_image
							];
						}

						return ([
							'status' => '200',
							'msg' => 'Successfully Retrieve Information.',
							'plan_info' => $plan_info
						]);
					}
					else
					{
						return ([
							'status' => '200',
							'msg' => 'No Records found.',
							'plan_info' => array()
						]);
					}
		}
		
		
	}  // end of GetPlanDietList function
	

	public function GetPlanCalenderDetails($plan_id, $package_id) // start of GetPlanCalenderDetails function 
	{    
		if($package_id != '')
		{

		$package_detail_sql = DB::table('tbl_lr_package')
					->where('lr_package_id','=',$package_id)
					->get(['lr_package_id','package_name','package_description','package_gender','package_price','package_type','image']); // sql to get package details

		$package_plan_detsql = DB::table('tbl_lr_package_details')->where('lr_package_id',$package_id)->select('vendor_plan_id','week_sequence')->orderBy('week_sequence','asc')->get(); // sql to get package plan details

		$curDate = new \DateTime(); 
		$curDate1 = $curDate->format('Y/m/d');
		$startdate = $curDate->modify('+1 day')->format('Y-m-d');

		$max_carb_meal = 0;
		$max_protein_meal = 0;
		$enddate = date('Y-m-d', strtotime($curDate1. ' + 7 days'));
		$final_key = [];
		foreach($package_plan_detsql as $val)
		{  
			$calender_date = [];
			$plan_detail = DB::table('tbl_lr_vendor_plan')->where('vendor_plan_id',$val->vendor_plan_id)->get(['macros_no_max_carb','macros_no_max_protein']);

			$max_carb_meal = $max_carb_meal + $plan_detail[0]->macros_no_max_carb;
			$max_protein_meal = $max_protein_meal + $plan_detail[0]->macros_no_max_protein;

			$calender_date_sql = DB::table('tbl_lr_vendor_plandetail_final')->where('vendor_plan_id',$val->vendor_plan_id)->whereDate('vendor_plandetail_date','>=',$startdate)->whereDate('vendor_plandetail_date','<=',$enddate)->distinct('vendor_plandetail_date')->orderBy('vendor_plandetail_date','ASC')->get(['vendor_plandetail_date','lr_unique_id']);
			
			while($startdate<=$enddate)
			{
			$calender_date[$startdate] = 0;

			$startdate = date ("Y-m-d", strtotime("+1 day", strtotime($startdate)));
			}  

			foreach($calender_date_sql as $cal_val)
			{ 
				$calender_date[$cal_val->vendor_plandetail_date] = $cal_val->vendor_plandetail_date;
			}

			foreach($calender_date as $key => $value)
			{
			$final_key[] = [
				"status" => $value,
				"date" =>  $key,
				"plan_id" =>  $val->vendor_plan_id
			];
			}

			$enddate = date('Y-m-d', strtotime($enddate. ' + 7 days'));

		} 

		
		
		


			if($package_detail_sql[0]->package_type=='FIXEDMENU')
			{
			$package_menutype = 'FIXED MENU';
			}
			else
			{
			$package_menutype = 'CUSTOM MENU';
			}


			return ([    
			'status' => '200',  
			'msg' => 'Successfully Retrieve Information.',
			'plan_calender_detail' =>[
			'package_id' => $package_detail_sql[0]->lr_package_id,
			'package_name' => $package_detail_sql[0]->package_name,
			'package_image' => url('/public/admin/upload/package')."/".$package_detail_sql[0]->image, 
			'plan_menutype' => $package_menutype,
			'plan_cost' => $package_detail_sql[0]->package_price,
			'plan_type' => 'PACKAGES',
			'plan_gender' => $package_detail_sql[0]->package_gender,
			'plan_description' => $package_detail_sql[0]->package_description,
			'edit_macros' => 'NO',
			'min_carb' => "",
			'max_carb' => "",
			'min_protein' => "",
			'max_protein' => "",
			'edit_meal_type' => "",
			'max_carb_meal' => $max_carb_meal,
			'max_protein_meal' => $max_protein_meal,
			'calender_date' => $final_key
			]
		]);
		}
		else if($plan_id != '')
		{
			$plan_detail_sql = DB::table('tbl_lr_vendor_plan as t1')
						->join('tbl_lr_userdetail as t2','t1.lr_user_id','t2.lr_user_userid')
						->where('vendor_plan_id','=',$plan_id)
						->get(['vendor_plan_name','vendor_plan_offdays','vendor_plan_menu_type','vendor_plan_type','plan_description','t2.lr_userdetail_logo','t1.vendor_plan_macros','t1.macros_yes_min_carb','t1.macros_yes_max_carb','t1.macros_yes_min_protein','t1.macros_yes_max_protein','t1.macros_yes_plan','t1.macros_no_max_carb','t1.macros_no_max_protein','vendor_plan_pause','plan_cost','t1.lr_user_id','t2.lr_userdetail_centrename','t1.vendor_plan_gendor']); // sql to get plan details

			$curDate = new \DateTime(); 
			$curDate1 = $curDate->format('Y/m/d');
			$startdate = $curDate->modify('+1 day')->format('Y-m-d'); 

			if($plan_detail_sql[0]->vendor_plan_type=='MONTHLY')
			{
				$enddate = date('Y-m-d', strtotime($curDate1. ' + 30 days'));
			}
			else if($plan_detail_sql[0]->vendor_plan_type=='WEEKLY')
			{
				$enddate = date('Y-m-d', strtotime($curDate1. ' + 7 days')); 
			}

			$calender_date_sql = DB::table('tbl_lr_vendor_plandetail_final')->where('vendor_plan_id',$plan_id)->whereDate('vendor_plandetail_date','>=',$startdate)->whereDate('vendor_plandetail_date','<=',$enddate)->distinct('vendor_plandetail_date')->orderBy('vendor_plandetail_date','ASC')->get(['vendor_plandetail_date','lr_unique_id']);

			// $enddate_sql = DB::table('tbl_lr_vendor_plandetail_final')->where('vendor_plan_id',$plan_id)->orderBy('vendor_plandetail_date','DESC')->first(['vendor_plandetail_date']);

		//	$enddate = $enddate_sql->vendor_plandetail_date;
		
			$calender_date = [];
			while($startdate<=$enddate)
			{
			$calender_date[$startdate] = 0;

			$startdate = date ("Y-m-d", strtotime("+1 day", strtotime($startdate)));
			} 

			foreach($calender_date_sql as $cal_val)
			{ 
				$calender_date[$cal_val->vendor_plandetail_date] = $cal_val->vendor_plandetail_date;
			}
			$final_key = [];
			foreach($calender_date as $key => $value)
			{
			$final_key[] = [
				"status" => $value,
				"date" =>  $key
			];
			}

			if($plan_detail_sql[0]->vendor_plan_menu_type=='FIXEDMENU')
			{
			$plan_menutype = 'FIXED MENU';
			}
			else
			{
			$plan_menutype = 'CUSTOM MENU';
			}


			return ([    
			'status' => '200',  
			'msg' => 'Successfully Retrieve Information.',
			'plan_calender_detail' =>[
			'plan_id' => $plan_id,
			'plan_name' => $plan_detail_sql[0]->vendor_plan_name,
			'plan_menutype' => $plan_menutype,
			'plan_cost' => $plan_detail_sql[0]->plan_cost,
			'plan_type' => $plan_detail_sql[0]->vendor_plan_type,
			'plan_gender' => $plan_detail_sql[0]->vendor_plan_gendor,
			'plan_description' => $plan_detail_sql[0]->plan_description,
			'diet_center_id' => $plan_detail_sql[0]->lr_user_id,
			'diet_center_name' => $plan_detail_sql[0]->lr_userdetail_centrename,
			'diet_center_logo' => url('/public/vendor/upload/logo')."/".$plan_detail_sql[0]->lr_userdetail_logo,
			'edit_macros' => $plan_detail_sql[0]->vendor_plan_macros,
			'min_carb' => $plan_detail_sql[0]->macros_yes_min_carb,
			'max_carb' => $plan_detail_sql[0]->macros_yes_max_carb,
			'min_protein' => $plan_detail_sql[0]->macros_yes_min_protein,
			'max_protein' => $plan_detail_sql[0]->macros_yes_max_protein,
			'edit_meal_type' => $plan_detail_sql[0]->macros_yes_plan,
			'max_carb_meal' => $plan_detail_sql[0]->macros_no_max_carb,
			'max_protein_meal' => $plan_detail_sql[0]->macros_no_max_protein,
			'user_off_days' => $plan_detail_sql[0]->vendor_plan_pause,
			'calender_date' => $final_key
			]
		]);
		} 
				
	}  // end of GetPlanCalenderDetails function

	public function GetPlanMenuDetails($plan_id,$date) // start of GetPlanMenuDetails function 
	{
			
				$menucategoryid_sql =  DB::table('tbl_lr_vendor_plandetail_final')->where('vendor_plan_id',$plan_id)->where('vendor_plandetail_date',$date)->distinct('lr_menucategory_id')->get(['lr_menucategory_id']); //sql to get menu category

				

				$menucat_array = []; // array to hold menu details
				
				foreach($menucategoryid_sql as $menu_cat_val) // loop for menu category
				{  
					$menuname_sql = DB::table('tbl_lr_menu_category')->where('lr_category_id',$menu_cat_val->lr_menucategory_id)->get(['lr_category_name']);
					
					 $menucat_array[] = [
						 'menu_id' => $menu_cat_val->lr_menucategory_id,
						 'menu_category' => $menuname_sql[0]->lr_category_name
					 ];
				}
		

			return ([
				'status' => '200',
				'msg' => 'Successfully Retrieve Information.',
				'menu_detail' =>$menucat_array
			]);

			
	}  // end of GetPlanMenuDetails function

	public function GetPlanMealDetails($plan_id,$date,$menu_id) // start of GetPlanMealDetails function 
	{
		$mealid_sql = DB::table('tbl_lr_vendor_plandetail_final')->where('vendor_plan_id',$plan_id)->where('vendor_plandetail_date',$date)->where('lr_menucategory_id',$menu_id)->get(['lr_meal_id']);

		$meal_array = [];
		foreach($mealid_sql as $mealid_val)
		{
			$meal_name_sql = DB::table('tbl_lr_meal')->where('lr_meal_id',$mealid_val->lr_meal_id)->get(['lr_meal_id','lr_meal_name','lr_meal_calories','lr_meal_fat','lr_meal_carb','lr_meal_protein','lr_meal_description','lr_meal_image']);

			$meal_array[] = [
				'meal_id' => $mealid_val->lr_meal_id,
				'meal_name' => $meal_name_sql[0]->lr_meal_name,
				'meal_calories' => $meal_name_sql[0]->lr_meal_calories,
				'meal_fat' => $meal_name_sql[0]->lr_meal_fat,
				'meal_carb' => $meal_name_sql[0]->lr_meal_carb,
				'meal_protein' => $meal_name_sql[0]->lr_meal_protein,
				'meal_description' => $meal_name_sql[0]->lr_meal_description,
				'meal_image' => url('/public/vendor/upload/meal_image')."/".$meal_name_sql[0]->lr_meal_image
			];
		} // array to hold meal details

			
			return ([
				'status' => '200',
				'msg' => 'Successfully Retrieve Information.',
				'meal_detail' => $meal_array,
			]);

			
	}  // end of GetPlanMealDetails function

	public function GetPlanDietDetails($plan_id) // start of GetPlanDietDetails function 
	{

			$GetPlanDietDetails_sql = DB::table('tbl_lr_vendor_plan')
							->where('vendor_plan_id','=',$plan_id)
							->get(['vendor_plan_name','vendor_plan_offdays','vendor_plan_menu_type']); // sql to get plan details
			
			$plan_detail_date_sql = DB::table('tbl_lr_vendor_plandetail_final')->where('vendor_plan_id',$plan_id)->distinct('vendor_plandetail_date')->get(['vendor_plandetail_date','lr_unique_id']);  // sql to get plan details date wise
			

			$plan_detail_date_wise = [];

			foreach($plan_detail_date_sql as $date) // loop for plan detail date nwise
			{
				$menucategory =  DB::table('tbl_lr_vendor_plandetail_final')->where('vendor_plan_id',$plan_id)->where('vendor_plandetail_date',$date->vendor_plandetail_date)->distinct('lr_menucategory_id')->get(['lr_menucategory_id']); //sql to get menu category

				

				$menucat_array = []; // array to hold menu details
				
				foreach($menucategory as $menu_cat_val) // loop for menu category
				{  
					$meal = DB::table('tbl_lr_vendor_plandetail_final')->where('vendor_plan_id',$plan_id)->where('vendor_plandetail_date',$date->vendor_plandetail_date)->where('lr_menucategory_id',$menu_cat_val->lr_menucategory_id)->get(['lr_meal_id']);

					$meal_name_sql = DB::table('tbl_lr_meal')->where('lr_meal_id',$meal[0]->lr_meal_id)->get(['lr_meal_name']);

					$meal_array = [];  // array to hold meal details

					foreach($meal as $meal_val)
					{
						$meal_array[] = [
							'meal_id' => $meal_val->lr_meal_id,
							'meal_name' => $meal_name_sql[0]->lr_meal_name
						];
					}

					

					$menuname_sql = DB::table('tbl_lr_menu_category')->where('lr_category_id',$menu_cat_val->lr_menucategory_id)->get(['lr_category_name']);
					
					 $menucat_array[] = [
						 'menu_id' => $menu_cat_val->lr_menucategory_id,
						 'menu_category' => $menuname_sql[0]->lr_category_name,
						 'meal_data' => $meal_array
					 ];

					$plan_detail_date_wise[] = [  
						'calender_id' => $date->lr_unique_id,
						'calender_date' => $date->vendor_plandetail_date,
						'menu_data' => $menucat_array
						];
				}
				
			}

			$plan_detail = [];
			$plan_detail[] = [  
				
				];

			return ([
				'status' => '200',
				'msg' => 'Successfully Retrieve Information.',
				'plan_detail' =>[
				'plan_id' => $plan_id,
				'plan_name' => $GetPlanDietDetails_sql[0]->vendor_plan_name,
				'plan_offdays' => $GetPlanDietDetails_sql[0]->vendor_plan_offdays,
				'plan_menutype' => $GetPlanDietDetails_sql[0]->vendor_plan_menu_type,
				'calender_detail' => $plan_detail_date_wise
				],
				
				
			]);

			
	}  // end of GetPlanDietDetails function


	public function checkout($user_uniqueid,$user_full_name,$user_email,$add_id,$timing,$code,$plan_id,$meal_data,$usersOffList,$dislike_ids,$allergy_ids,$card_id,$card_token,$order_id , $package_id) // start of checkout function 
	{   
	  

		if($package_id!='')
		{  
			$curDate = new \DateTime();
			if($order_id=='')
			{	
				$package_detail_sql = DB::table('tbl_lr_package')
					->where('lr_package_id','=',$package_id)
					->get(['lr_package_id','package_name','package_description','package_gender','package_price','package_type','image']);
				$package_plan_detsql = DB::table('tbl_lr_package_details')->where('lr_package_id',$package_id)->select('vendor_plan_id','week_sequence')->orderBy('week_sequence','asc')->get(); // sql to get package plan details
				$max_carb_meal = 0;
				$max_protein_meal = 0;
						foreach($package_plan_detsql as $val)
						{ 

							$plan_detail = DB::table('tbl_lr_vendor_plan')->where('vendor_plan_id',$val->vendor_plan_id)->get(['macros_no_max_carb','macros_no_max_protein']);

							$max_carb_meal = $max_carb_meal + $plan_detail[0]->macros_no_max_carb;
							$max_protein_meal = $max_protein_meal + $plan_detail[0]->macros_no_max_protein;

						}
						// $plan_info_sql = DB::table('tbl_lr_vendor_plan as vendor_plan')->join('tbl_lr_userdetail as vendor_detail','vendor_plan.lr_user_id','vendor_detail.lr_user_userid')->select('vendor_plan.vendor_plan_name','vendor_detail.lr_userdetail_centrename','vendor_plan.vendor_plan_menu_type','vendor_plan.vendor_plan_offdays','vendor_plan.plan_cost','vendor_detail.lr_userdetail_logo','vendor_plan_type','plan_description','vendor_plan_macros','macros_yes_min_carb','macros_yes_max_carb','macros_yes_min_protein','macros_yes_max_protein','macros_yes_plan','macros_no_max_carb','macros_no_max_protein','vendor_plan_pause')->where('vendor_plan_id',$plan_id)->get();

						

						$addr_detail_sql = DB::table('tbl_app_user_address')->where('app_user_add_id',$add_id)->get();

						if($code!='')
						{
							$code_detail_sql = DB::table('tbl_app_promocode')->where('promocode',$code)->get(['amount']);
							$code_amount = $code_detail_sql[0]->amount;
							$total_amount = ($package_detail_sql[0]->package_price - $code_amount) + 100;
						}
						else
						{
							$code_amount = '';
							$total_amount = $package_detail_sql[0]->package_price + 100;
						}

						$getAreaName = getAreaName($addr_detail_sql[0]->lr_governorate_area_id);
						  
						DB::beginTransaction();

						try {
						$checkout_sql = DB::table('tbl_app_pre_order')->insert([
							"user_uniqueid" =>  $user_uniqueid,
							"vendor_plan_id" =>  $package_id,
							"vendor_plan_name" =>  $package_detail_sql[0]->package_name,
							"lr_userdetail_centrename" =>  "",
							"vendor_plan_menu_type" =>  $package_detail_sql[0]->package_type,
							"vendor_plan_offdays" =>  "",
							"plan_cost" =>  $package_detail_sql[0]->package_price,
							"service_fee" =>  100,
							"promocode" =>  $code,
							"promocode_price" =>  $code_amount,
							"app_pre_order_name" =>  $user_full_name,
							"app_pre_order_email" =>  $user_email,
							"app_pre_order_addr_id" =>  $add_id,
							"app_pre_order_addr_title" =>  $addr_detail_sql[0]->app_user_add_title,
							"app_pre_order_addr_areaid" =>  $addr_detail_sql[0]->lr_governorate_area_id,
							"app_pre_order_addr_areaname" =>  $getAreaName,
							"app_pre_order_addr_block" =>  $addr_detail_sql[0]->app_user_add_block,
							"app_pre_order_addr_street" =>  $addr_detail_sql[0]->app_user_add_street,
							"app_pre_order_addr_avenue" =>  $addr_detail_sql[0]->app_user_add_avenue,
							"app_pre_order_addr_house" =>  $addr_detail_sql[0]->app_user_add_house,
							"app_pre_order_addr_phone" =>  $addr_detail_sql[0]->app_user_add_phone,
							"lr_userdetail_logo" =>  $package_detail_sql[0]->image,
							"vendor_plan_type" =>  "PACKAGES",
							"plan_description" =>  $package_detail_sql[0]->package_description,
							"vendor_plan_macros" =>  'NO',
							"macros_yes_min_carb" =>  "",
							"macros_yes_max_carb" =>  "",
							"macros_yes_min_protein" =>  "",
							"macros_yes_max_protein" =>  "",
							"macros_yes_plan" =>  "",
							"macros_no_max_carb" =>  $max_carb_meal,
							"macros_no_max_protein" =>  $max_protein_meal,
							"vendor_plan_pause" =>  "",
							"order_type" =>  "PACKAGES"
							
						]);  

						$last_insert_id = DB::getPdo()->lastInsertId();

						

						foreach($timing as $val)
						{   
							$time_detail_sql = DB::table('tbl_lr_vendor_deleverytime')->where('id',$val['time_id'])->get(); 

							$sql_insert_time = DB::table('tbl_app_pre_order_timing')->insert([
								'app_pre_order_id' => $last_insert_id,
								'diet_center_id' => $val['diet_center_id'],
								'time_id' => $time_detail_sql[0]->id,
								'time_from' => $time_detail_sql[0]->from,
								'time_to' => $time_detail_sql[0]->to,
							]);

						
						}

						foreach($meal_data as $meal_data_val)
						{  
							$sql_insert_calender = DB::table('tbl_app_pre_order_calender')->insert([
								'app_pre_order_id' => $last_insert_id,
								'vendor_plandetail_date' => $meal_data_val['date'],
								'protein' => $meal_data_val['dayProtein'],
								'Carb' => $meal_data_val['dayCarb']
							]);

							if($sql_insert_calender == true)
							{   
								$last_insert_id1 = DB::getPdo()->lastInsertId();
								foreach($meal_data_val['menu'] as $menu_data_val)
								{   
									$menu_id = $menu_data_val['menu_id'];
									$meal_id = $menu_data_val['meal_id'];
									$menu_det_sql =  DB::table('tbl_lr_menu_category')->select('lr_category_name','lr_category_type','lr_category_description')->where('lr_category_id',$menu_id)->get();

									$meal_det_sql =  DB::table('tbl_lr_meal')->select('lr_meal_name','lr_meal_calories','lr_meal_fat','lr_meal_carb','lr_meal_protein','lr_meal_description')->where('lr_meal_id',$meal_id)->get();

									DB::table('tbl_app_preorder_calender_menu_meal')->insert([
										'pre_order_calender_id' => $last_insert_id1,
										'lr_category_id' => $menu_id,
										'lr_category_name' => $menu_det_sql[0]->lr_category_name,
										'lr_category_description' => $menu_det_sql[0]->lr_category_description,
										'lr_category_type' => $menu_det_sql[0]->lr_category_type,
										'lr_meal_id' => $meal_id,
										'lr_meal_name' => $meal_det_sql[0]->lr_meal_name,
										'lr_meal_calories' => $meal_det_sql[0]->lr_meal_calories,
										'lr_meal_fat' => $meal_det_sql[0]->lr_meal_fat,
										'lr_meal_carb' => $meal_det_sql[0]->lr_meal_carb,
										'lr_meal_protein' => $meal_det_sql[0]->lr_meal_protein,
										'lr_meal_description' => $meal_det_sql[0]->lr_meal_description,
										'max_meal_carb' => $menu_data_val['max_meal_carb'],
										'max_meal_protein' => $menu_data_val['max_meal_protein']
									]);
								}
							}

							
						}

						foreach($usersOffList as $usersOffList_val)
						{  
							$sql_insert_usersOffList = DB::table('tbl_app_preorder_useroff_list')->insert([
								'app_pre_order_id' => $last_insert_id,
								'off_date' => $usersOffList_val
							]);
						}

						if(count($allergy_ids) > 0)
						{
							foreach($allergy_ids as $allergy_val)
							{  
								$allergy_name = DB::table('tbl_app_allergy')->where('app_allergy_id',$allergy_val)->get(['allergy_name','app_allergy_id']);

								$sql_insert_allergy = DB::table('tbl_app_preorder_allergy')->insert([
									'app_pre_order_id' => $last_insert_id,
									'app_allergy_id' => $allergy_name[0]->app_allergy_id,
									'allergy_name' => $allergy_name[0]->allergy_name
								]);
							}
						}

						if(count($dislike_ids) > 0)
						{
							foreach($dislike_ids as $dislike_val)
							{  
								$dislike_name = DB::table('tbl_app_dislike')->where('app_dislike_id',$dislike_val)->get(['app_dislike_name','app_dislike_id']);

								$sql_insert_usersOffList = DB::table('tbl_app_preorder_dislike')->insert([
									'app_pre_order_id' => $last_insert_id,
									'app_dislike_id' => $dislike_name[0]->app_dislike_id,
									'app_dislike_name' => $dislike_name[0]->app_dislike_name
								]);
							}
						}

						$order_id = getRandomOrderid(5);    

						$sql_insert_order = DB::table('tbl_app_order')->insert([  
							'app_order_unique_id' => 'LTR'.$order_id,
							'app_pre_order_id' => $last_insert_id,
							'card_id' => $card_id,
							'card_token' => $card_token,
							'app_order_paymode' => 'CASH',
							'app_order_paystatus' => 'YES',
							'app_order_payment_method' => '',
							'app_order_status' => 'PLACED',
							'user_uniqueid' => $user_uniqueid,
							'total_amount' => $total_amount
						]);   
						
					
					DB::commit();

					return ([
						'status' => '200',
						'msg' => 'Order Placed Successfully.',
						'order_id' => 'LTR'.$order_id
					]);

						
					} catch (\Exception $e) {
						DB::rollback();
						return ([
							'status' => '401',
							'msg' => 'Something went wrong, Please try again later.'
						]);
					}
			}
			else
			{

				DB::beginTransaction();
				try 
				{

				$pre_order_sql = DB::table('tbl_app_order')->where('app_order_unique_id',$order_id)->get(['app_pre_order_id']);



					foreach($meal_data as $meal_data_val)
					{  
					$sql_insert_calender = DB::table('tbl_app_pre_order_calender')->insert([
						'app_pre_order_id' => $pre_order_sql[0]->app_pre_order_id,
						'vendor_plandetail_date' => $meal_data_val['date'],
						'protein' => $meal_data_val['dayProtein'],
						'Carb' => $meal_data_val['dayCarb']
					]);

							if($sql_insert_calender == true)
							{   
								$last_insert_id1 = DB::getPdo()->lastInsertId();
								foreach($meal_data_val['menu'] as $menu_data_val)
								{   
									$menu_id = $menu_data_val['menu_id'];
									$meal_id = $menu_data_val['meal_id'];
									$menu_det_sql =  DB::table('tbl_lr_menu_category')->select('lr_category_name','lr_category_type','lr_category_description')->where('lr_category_id',$menu_id)->get();

									$meal_det_sql =  DB::table('tbl_lr_meal')->select('lr_meal_name','lr_meal_calories','lr_meal_fat','lr_meal_carb','lr_meal_protein','lr_meal_description')->where('lr_meal_id',$meal_id)->get();

									DB::table('tbl_app_preorder_calender_menu_meal')->insert([
										'pre_order_calender_id' => $last_insert_id1,
										'lr_category_id' => $menu_id,
										'lr_category_name' => $menu_det_sql[0]->lr_category_name,
										'lr_category_description' => $menu_det_sql[0]->lr_category_description,
										'lr_category_type' => $menu_det_sql[0]->lr_category_type,
										'lr_meal_id' => $meal_id,
										'lr_meal_name' => $meal_det_sql[0]->lr_meal_name,
										'lr_meal_calories' => $meal_det_sql[0]->lr_meal_calories,
										'lr_meal_fat' => $meal_det_sql[0]->lr_meal_fat,
										'lr_meal_carb' => $meal_det_sql[0]->lr_meal_carb,
										'lr_meal_protein' => $meal_det_sql[0]->lr_meal_protein,
										'lr_meal_description' => $meal_det_sql[0]->lr_meal_description,
										'max_meal_carb' => $menu_data_val['max_meal_carb'],
										'max_meal_protein' => $menu_data_val['max_meal_protein']
									]);
								}
							}

							
						}

						foreach($usersOffList as $usersOffList_val)
						{  
							$sql_insert_usersOffList = DB::table('tbl_app_preorder_useroff_list')->insert([
								'app_pre_order_id' => $pre_order_sql[0]->app_pre_order_id,
								'off_date' => $usersOffList_val
							]);
						}

						DB::commit();

						return ([
							'status' => '200',
							'msg' => 'Order Updated Successfully.',
							'order_id' => ""
						]);

					} 
					catch (\Exception $e) 
					{
						DB::rollback();
						return ([
							'status' => '401',
							'msg' => 'Something went wrong, Please try again later.'
						]);
					}
			}
		}
		else
		{	
			$curDate = new \DateTime();
			if($order_id=='')
			{
					$plan_info_sql = DB::table('tbl_lr_vendor_plan as vendor_plan')->join('tbl_lr_userdetail as vendor_detail','vendor_plan.lr_user_id','vendor_detail.lr_user_userid')->select('vendor_plan.vendor_plan_name','vendor_detail.lr_userdetail_centrename','vendor_plan.vendor_plan_menu_type','vendor_plan.vendor_plan_offdays','vendor_plan.plan_cost','vendor_detail.lr_userdetail_logo','vendor_plan_type','plan_description','vendor_plan_macros','macros_yes_min_carb','macros_yes_max_carb','macros_yes_min_protein','macros_yes_max_protein','macros_yes_plan','macros_no_max_carb','macros_no_max_protein','vendor_plan_pause')->where('vendor_plan_id',$plan_id)->get();


					$addr_detail_sql = DB::table('tbl_app_user_address')->where('app_user_add_id',$add_id)->get();

					if($code!='')
					{
						$code_detail_sql = DB::table('tbl_app_promocode')->where('promocode',$code)->get(['amount']);
						$code_amount = $code_detail_sql[0]->amount;
						$total_amount = ($plan_info_sql[0]->plan_cost - $code_amount) + 100;
					}
					else
					{
						$code_amount = '';
						$total_amount = $plan_info_sql[0]->plan_cost + 100;
					}

					$getAreaName = getAreaName($addr_detail_sql[0]->lr_governorate_area_id);
					  
					DB::beginTransaction();

					try {
						$checkout_sql = DB::table('tbl_app_pre_order')->insert([
							"user_uniqueid" =>  $user_uniqueid,
							"vendor_plan_id" =>  $plan_id,
							"vendor_plan_name" =>  $plan_info_sql[0]->vendor_plan_name,
							"lr_userdetail_centrename" =>  $plan_info_sql[0]->lr_userdetail_centrename,
							"vendor_plan_menu_type" =>  $plan_info_sql[0]->vendor_plan_menu_type,
							"vendor_plan_offdays" =>  $plan_info_sql[0]->vendor_plan_offdays,
							"plan_cost" =>  $plan_info_sql[0]->plan_cost,
							"service_fee" =>  100,
							"promocode" =>  $code,
							"promocode_price" =>  $code_amount,
							"app_pre_order_name" =>  $user_full_name,
							"app_pre_order_email" =>  $user_email,
							"app_pre_order_addr_id" =>  $add_id,
							"app_pre_order_addr_title" =>  $addr_detail_sql[0]->app_user_add_title,
							"app_pre_order_addr_areaid" =>  $addr_detail_sql[0]->lr_governorate_area_id,
							"app_pre_order_addr_areaname" =>  $getAreaName,
							"app_pre_order_addr_block" =>  $addr_detail_sql[0]->app_user_add_block,
							"app_pre_order_addr_street" =>  $addr_detail_sql[0]->app_user_add_street,
							"app_pre_order_addr_avenue" =>  $addr_detail_sql[0]->app_user_add_avenue,
							"app_pre_order_addr_house" =>  $addr_detail_sql[0]->app_user_add_house,
							"app_pre_order_addr_phone" =>  $addr_detail_sql[0]->app_user_add_phone,
							"lr_userdetail_logo" =>  $plan_info_sql[0]->lr_userdetail_logo,
							"vendor_plan_type" =>  $plan_info_sql[0]->vendor_plan_type,
							"plan_description" =>  $plan_info_sql[0]->plan_description,
							"vendor_plan_macros" =>  $plan_info_sql[0]->vendor_plan_macros,
							"macros_yes_min_carb" =>  $plan_info_sql[0]->macros_yes_min_carb,
							"macros_yes_max_carb" =>  $plan_info_sql[0]->macros_yes_max_carb,
							"macros_yes_min_protein" =>  $plan_info_sql[0]->macros_yes_min_protein,
							"macros_yes_max_protein" =>  $plan_info_sql[0]->macros_yes_max_protein,
							"macros_yes_min_protein" =>  $plan_info_sql[0]->macros_yes_min_protein,
							"macros_yes_plan" =>  $plan_info_sql[0]->macros_yes_plan,
							"macros_no_max_carb" =>  $plan_info_sql[0]->macros_no_max_carb,
							"macros_no_max_protein" =>  $plan_info_sql[0]->macros_no_max_protein,
							"vendor_plan_pause" =>  $plan_info_sql[0]->vendor_plan_pause
							
						]);  

						$last_insert_id = DB::getPdo()->lastInsertId();
						 

						foreach($timing as $val)
						{   
							$time_detail_sql = DB::table('tbl_lr_vendor_deleverytime')->where('id',$val['time_id'])->get(); 

							$sql_insert_time = DB::table('tbl_app_pre_order_timing')->insert([
								'app_pre_order_id' => $last_insert_id,
								'diet_center_id' => $val['diet_center_id'],
								'time_id' => $time_detail_sql[0]->id,
								'time_from' => $time_detail_sql[0]->from,
								'time_to' => $time_detail_sql[0]->to,
							]);

						
						}
						
						foreach($meal_data as $meal_data_val)
						{  
							$sql_insert_calender = DB::table('tbl_app_pre_order_calender')->insert([
								'app_pre_order_id' => $last_insert_id,
								'vendor_plandetail_date' => $meal_data_val['date'],
								'protein' => $meal_data_val['dayProtein'],
								'Carb' => $meal_data_val['dayCarb']
							]);

							if($sql_insert_calender == true)
							{   
								$last_insert_id1 = DB::getPdo()->lastInsertId();
								foreach($meal_data_val['menu'] as $menu_data_val)
								{   
									$menu_id = $menu_data_val['menu_id'];
									$meal_id = $menu_data_val['meal_id'];
									$menu_det_sql =  DB::table('tbl_lr_menu_category')->select('lr_category_name','lr_category_type','lr_category_description')->where('lr_category_id',$menu_id)->get();

									$meal_det_sql =  DB::table('tbl_lr_meal')->select('lr_meal_name','lr_meal_calories','lr_meal_fat','lr_meal_carb','lr_meal_protein','lr_meal_description')->where('lr_meal_id',$meal_id)->get();

									DB::table('tbl_app_preorder_calender_menu_meal')->insert([
										'pre_order_calender_id' => $last_insert_id1,
										'lr_category_id' => $menu_id,
										'lr_category_name' => $menu_det_sql[0]->lr_category_name,
										'lr_category_description' => $menu_det_sql[0]->lr_category_description,
										'lr_category_type' => $menu_det_sql[0]->lr_category_type,
										'lr_meal_id' => $meal_id,
										'lr_meal_name' => $meal_det_sql[0]->lr_meal_name,
										'lr_meal_calories' => $meal_det_sql[0]->lr_meal_calories,
										'lr_meal_fat' => $meal_det_sql[0]->lr_meal_fat,
										'lr_meal_carb' => $meal_det_sql[0]->lr_meal_carb,
										'lr_meal_protein' => $meal_det_sql[0]->lr_meal_protein,
										'lr_meal_description' => $meal_det_sql[0]->lr_meal_description,
										'max_meal_carb' => $menu_data_val['max_meal_carb'],
										'max_meal_protein' => $menu_data_val['max_meal_protein']
									]);
								}
							}

							
						}

						foreach($usersOffList as $usersOffList_val)
						{  
							$sql_insert_usersOffList = DB::table('tbl_app_preorder_useroff_list')->insert([
								'app_pre_order_id' => $last_insert_id,
								'off_date' => $usersOffList_val
							]);
						}

						if(count($allergy_ids) > 0)
						{
							foreach($allergy_ids as $allergy_val)
							{  
								$allergy_name = DB::table('tbl_app_allergy')->where('app_allergy_id',$allergy_val)->get(['allergy_name','app_allergy_id']);

								$sql_insert_allergy = DB::table('tbl_app_preorder_allergy')->insert([
									'app_pre_order_id' => $last_insert_id,
									'app_allergy_id' => $allergy_name[0]->app_allergy_id,
									'allergy_name' => $allergy_name[0]->allergy_name
								]);
							}
						}

						if(count($dislike_ids) > 0)
						{
							foreach($dislike_ids as $dislike_val)
							{  
								$dislike_name = DB::table('tbl_app_dislike')->where('app_dislike_id',$dislike_val)->get(['app_dislike_name','app_dislike_id']);

								$sql_insert_usersOffList = DB::table('tbl_app_preorder_dislike')->insert([
									'app_pre_order_id' => $last_insert_id,
									'app_dislike_id' => $dislike_name[0]->app_dislike_id,
									'app_dislike_name' => $dislike_name[0]->app_dislike_name
								]);
							}
						}

						$order_id = getRandomOrderid(5);    

						$sql_insert_order = DB::table('tbl_app_order')->insert([  
							'app_order_unique_id' => 'LTR'.$order_id,
							'app_pre_order_id' => $last_insert_id,
							'card_id' => $card_id,
							'card_token' => $card_token,
							'app_order_paymode' => 'CASH',
							'app_order_paystatus' => 'YES',
							'app_order_payment_method' => '',
							'app_order_status' => 'PLACED',
							'user_uniqueid' => $user_uniqueid,
							'total_amount' => $total_amount
						]);   
						
					
					DB::commit();

					return ([
						'status' => '200',
						'msg' => 'Order Placed Successfully.',
						'order_id' => 'LTR'.$order_id
					]);

						
					} catch (\Exception $e) {
						DB::rollback();
						return ([
							'status' => '401',
							'msg' => 'Something went wrong, Please try again later.'
						]);
					}
			}
			else
			{
				DB::beginTransaction();
				try 
				{
				$pre_order_sql = DB::table('tbl_app_order')->where('app_order_unique_id',$order_id)->get(['app_pre_order_id']);

				$delete_cal_meal = DB::table('tbl_app_pre_order_calender')->where('app_pre_order_id' , $pre_order_sql[0]->app_pre_order_id)->get(['pre_order_calender_id']);
				foreach($delete_cal_meal as $val)
				{
					DB::table('tbl_app_preorder_calender_menu_meal')->where('pre_order_calender_id' , $val->pre_order_calender_id)->delete();
				}

				$delete_sql = DB::table('tbl_app_pre_order_calender')->where('app_pre_order_id' , $pre_order_sql[0]->app_pre_order_id)->delete();

				$delete_sql1 = DB::table('tbl_app_preorder_useroff_list')->where('app_pre_order_id' , $pre_order_sql[0]->app_pre_order_id)->delete();

					foreach($meal_data as $meal_data_val)
					{  
					$sql_insert_calender = DB::table('tbl_app_pre_order_calender')->insert([
						'app_pre_order_id' => $pre_order_sql[0]->app_pre_order_id,
						'vendor_plandetail_date' => $meal_data_val['date'],
						'protein' => $meal_data_val['dayProtein'],
						'Carb' => $meal_data_val['dayCarb']
					]);

							if($sql_insert_calender == true)
							{   
								$last_insert_id1 = DB::getPdo()->lastInsertId();
								foreach($meal_data_val['menu'] as $menu_data_val)
								{   
									$menu_id = $menu_data_val['menu_id'];
									$meal_id = $menu_data_val['meal_id'];
									$menu_det_sql =  DB::table('tbl_lr_menu_category')->select('lr_category_name','lr_category_type','lr_category_description')->where('lr_category_id',$menu_id)->get();

									$meal_det_sql =  DB::table('tbl_lr_meal')->select('lr_meal_name','lr_meal_calories','lr_meal_fat','lr_meal_carb','lr_meal_protein','lr_meal_description')->where('lr_meal_id',$meal_id)->get();

									DB::table('tbl_app_preorder_calender_menu_meal')->insert([
										'pre_order_calender_id' => $last_insert_id1,
										'lr_category_id' => $menu_id,
										'lr_category_name' => $menu_det_sql[0]->lr_category_name,
										'lr_category_description' => $menu_det_sql[0]->lr_category_description,
										'lr_category_type' => $menu_det_sql[0]->lr_category_type,
										'lr_meal_id' => $meal_id,
										'lr_meal_name' => $meal_det_sql[0]->lr_meal_name,
										'lr_meal_calories' => $meal_det_sql[0]->lr_meal_calories,
										'lr_meal_fat' => $meal_det_sql[0]->lr_meal_fat,
										'lr_meal_carb' => $meal_det_sql[0]->lr_meal_carb,
										'lr_meal_protein' => $meal_det_sql[0]->lr_meal_protein,
										'lr_meal_description' => $meal_det_sql[0]->lr_meal_description,
										'max_meal_carb' => $menu_data_val['max_meal_carb'],
										'max_meal_protein' => $menu_data_val['max_meal_protein']
									]);
								}
							}

							
						}

						foreach($usersOffList as $usersOffList_val)
						{  
							$sql_insert_usersOffList = DB::table('tbl_app_preorder_useroff_list')->insert([
								'app_pre_order_id' => $pre_order_sql[0]->app_pre_order_id,
								'off_date' => $usersOffList_val
							]);
						}

						DB::commit();

						return ([
							'status' => '200',
							'msg' => 'Order Updated Successfully.',
							'order_id' => ""
						]);

					} 
					catch (\Exception $e) 
					{
						DB::rollback();
						return ([
							'status' => '401',
							'msg' => 'Something went wrong, Please try again later.'
						]);
					}
			}
		}					
	}  // end of checkout function

	public function GetServiceFee($user_uniqueid,$diet_center_id,$address_id,$package_id)
	{
		$service_fee = 100;
		$GetUserWallet = DB::table('tbl_app_user_wallet')->where('user_uniqueid',$user_uniqueid)->get(['app_user_wallet_amount']);

			if(count($GetUserWallet) > 0)
			{
				$wallet_amount = $GetUserWallet[0]->app_user_wallet_amount;
			}
			else
			{
				$wallet_amount = 0;
			}

			

			if($address_id != '')
			{
				$user_default_address_sql = DB::table('tbl_app_user_address')->where('app_user_add_id',$address_id)->get();
			}
			else
			{
				$user_default_address_sql = DB::table('tbl_app_user_address')->where(['user_uniqueid' => $user_uniqueid , 'app_user_add_status' => 1])->get();
			}

		if(count($user_default_address_sql) > 0)
		{
			$getAreaName = getAreaName($user_default_address_sql[0]->lr_governorate_area_id);

			$default_address = [
				"add_id" => $user_default_address_sql[0]->app_user_add_id,
				"add_title" => $user_default_address_sql[0]->app_user_add_title,
				"add_area_id" => $user_default_address_sql[0]->lr_governorate_area_id,
				"add_area_name" => $getAreaName,
				"add_block" => $user_default_address_sql[0]->app_user_add_block,
				"add_street" => $user_default_address_sql[0]->app_user_add_street,
				"add_avenue" => $user_default_address_sql[0]->app_user_add_avenue,
				"add_house" => $user_default_address_sql[0]->app_user_add_house,
				"add_phone" => $user_default_address_sql[0]->app_user_add_phone,
				"add_status" => $user_default_address_sql[0]->app_user_add_status
			];

			if($package_id!='')
			{
				$package_sql = DB::table('tbl_lr_package')->where('lr_package_id',$package_id)->get(['delivery_time']);
				
				$delivery_time = $package_sql[0]->delivery_time;

				$package_detail_sql = DB::table('tbl_lr_package_details')->where('lr_package_id',$package_id)->get();

				if($delivery_time=='ONE')
				{
					$plan_det = DB::table('tbl_lr_vendor_plan')->where('vendor_plan_id',$package_detail_sql[0]->vendor_plan_id)->get(['lr_user_id']);

					$timings_sql = DB::table('tbl_lr_vendor_governorate_area as vendor_area')->join('tbl_lr_vendor_deleverytime as vendor_delivery','vendor_area.id','vendor_delivery.vendor_areaid')->where(['vendor_area.lr_user_userid' => $plan_det[0]->lr_user_id , 'vendor_area.lr_governorate_area_id' => $user_default_address_sql[0]->lr_governorate_area_id])->get(['vendor_delivery.from','vendor_delivery.to','vendor_delivery.id']);

					$diet_center_timing = [];
					$timings = [];
					foreach($timings_sql as $val)
					{
						$diet_center_timing[] = [
								 'time_id' => $val->id,
								 'time' => $val->to."-".$val->from
						     ];
					}

					$timings[] = [
								 'diet_center_id' => $diet_center_id,
								 'diet_center_timing' => $diet_center_timing
						       ];
				}
				else
				{
					$timings = [];
					foreach( $package_detail_sql as $val )
					{
						$plan_det = DB::table('tbl_lr_vendor_plan')->where('vendor_plan_id',$val->vendor_plan_id)->get(['lr_user_id']);

						$timings_sql = DB::table('tbl_lr_vendor_governorate_area as vendor_area')->join('tbl_lr_vendor_deleverytime as vendor_delivery','vendor_area.id','vendor_delivery.vendor_areaid')->where(['vendor_area.lr_user_userid' => $plan_det[0]->lr_user_id , 'vendor_area.lr_governorate_area_id' => $user_default_address_sql[0]->lr_governorate_area_id])->get(['vendor_delivery.from','vendor_delivery.to','vendor_delivery.id']);

						$diet_center_timing = [];

						foreach($timings_sql as $val)
						{
							$diet_center_timing[] = [
									 'time_id' => $val->id,
									 'time' => $val->to."-".$val->from
							     ];
						}

						$timings[] = [
								 'diet_center_id' => $plan_det[0]->lr_user_id,
								 'diet_center_timing' => $diet_center_timing
						       ];
					}
				}
		    }
			else
			{

				$timings_sql = DB::table('tbl_lr_vendor_governorate_area as vendor_area')->join('tbl_lr_vendor_deleverytime as vendor_delivery','vendor_area.id','vendor_delivery.vendor_areaid')->where(['vendor_area.lr_user_userid' => $diet_center_id , 'vendor_area.lr_governorate_area_id' => $user_default_address_sql[0]->lr_governorate_area_id])->get(['vendor_delivery.from','vendor_delivery.to','vendor_delivery.id']);

				$diet_center_timing = [];
				$timings = [];
				foreach($timings_sql as $val)
				{
					$diet_center_timing[] = [
							 'time_id' => $val->id,
							 'time' => $val->to."-".$val->from
					     ];
				}

				$timings[] = [
							 'diet_center_id' => $diet_center_id,
							 'diet_center_timing' => $diet_center_timing
					       ];
			}

			
			
		}
		else
		{
			$default_address = null;
			$timings = [];
		}

		if($user_uniqueid!='')
		{
			$card_detail_sql = DB::table('tbl_app_user_creditcard')->where('user_uniqueid',$user_uniqueid)->first();
		
			if( count($card_detail_sql) > 0 )
			{ 
				$card_details = [
			       "card_id" => $card_detail_sql->user_creditcard_id,
	               "last_digits" => $card_detail_sql->last_digits,
	               "expiry_month" => $card_detail_sql->expiry_month,
	               "expiry_year" => $card_detail_sql->expiry_year,
	               "holder_name" => $card_detail_sql->card_holder_name,
	               "brand" => $card_detail_sql->card_brand,
	               "card_token" => $card_detail_sql->card_token
			     ];
			}
			else
			{
				$card_details = null;
			}
		}
		else
		{
			$card_details = null;
		}

			return ([
				'status' =>'200',
				'msg' => 'Successfully Retrieve Information.',
				'default_address' => $default_address,
				'timings' => $timings,
				'wallet_amount' => $wallet_amount,
				'service_fee' => $service_fee,
				'card_details' => $card_details
				]);

	}

	public function GetfilterDietCenterList($type,$user_uniqueid) // start of GetPlanDietList function 
	{
		if($type=='PACKAGES')
		{
			$GetPlanDietList_sql = $sql1=DB::table('tbl_lr_vendor_package')
								//	->join('tbl_lr_vendor_plan','tbl_lr_vendor_package.vendor_plan_id','tbl_lr_vendor_plan.vendor_plan_id')
									->where('tbl_lr_vendor_package.admin_status','=',1)
								//	->where('tbl_lr_vendor_plan.status','=',1) 
								//	->where('tbl_lr_vendor_plan.admin_status','=',1) 
								//	->where('tbl_lr_vendor_plan.app_status','=',1) 
									->get(['tbl_lr_vendor_package.vendor_plan_id']);

			if(count($GetPlanDietList_sql) > 0)
			{
				$diet_center_info = [];
				foreach($GetPlanDietList_sql as $planval)
				{
					$GetPlandetails_sql = $sql1=DB::table('tbl_lr_vendor_plan as t1')
							->join('tbl_lr_userdetail as t2','t1.lr_user_id','t2.lr_user_userid')
							->where('vendor_plan_id','=',$planval->vendor_plan_id)
							->get(['t2.lr_user_userid','lr_userdetail_centrename']);

					if(!count($GetPlandetails_sql) > 0)
					{
						return ([
							'status' => '200',
							'msg' => 'No Records found.',
							'diet_center_info' => array()
								]);
					}
					
					$diet_center_info[] = [   
						'plan_diet_center_id' => $GetPlandetails_sql[0]->lr_user_userid,
					    'plan_diet_center_name' => $GetPlandetails_sql[0]->lr_userdetail_centrename
						];
				}

				return ([
					'status' => '200',
					'msg' => 'Successfully Retrieve Information.',
					'diet_center_info' => $diet_center_info
				]);
			}
			else
			{
				return ([
					'status' => '200',
					'msg' => 'No Records found.',
					'diet_center_info' => array()
				]);
			}
		}
		else
		{
			$GetfilterDietCenterList = $sql1=DB::table('tbl_lr_vendor_plan as t1')
			->join('tbl_lr_userdetail as t2','t1.lr_user_id','t2.lr_user_userid')
							->where('t1.status','=',1) 
							->where('t1.admin_status','=',1) 
							//->where('t1.app_status','=',1) 
							->where('vendor_plan_type','=',$type)
							->distinct('t1.lr_user_id')
							->get(['t2.lr_user_userid','lr_userdetail_centrename']);

			if($user_uniqueid!='')
			{
				$selected_diet_centre_id_sql = DB::table('tbl_app_user_plan_filter')->where('user_uniqueid',$user_uniqueid)->select('diet_centre_id')->orderby('user_filter_id','desc')->first();
			
				if(count($selected_diet_centre_id_sql) > 0)
				{
					$selected_diet_centre_id = $selected_diet_centre_id_sql->diet_centre_id;
				}
				else
				{
					$selected_diet_centre_id = '';
				}
			}
			else
			{
				$selected_diet_centre_id = '';
			}

			if(count($GetfilterDietCenterList) > 0)
			{
				$diet_center_info = [];
				foreach($GetfilterDietCenterList as $planval)
				{

					if($planval->lr_user_userid==$selected_diet_centre_id)
					{
						$selected = 1;
					}
					else
					{
						$selected = 0;
					}

				$diet_center_info[] = [ 
					'plan_diet_center_id' => $planval->lr_user_userid,
					'plan_diet_center_name' => $planval->lr_userdetail_centrename,
					'selected' => $selected
					];
				}

				return ([
					'status' => '200',
					'msg' => 'Successfully Retrieve Information.',
					'diet_center_info' => $diet_center_info
				]);
			}
			else
			{
				return ([
					'status' => '200',
					'msg' => 'No Records found.',
					'diet_center_info' => array()
				]);
			}
		}
		
		
	}  // end of GetPlanDietList function

	public function GetFilterPlanList($type,$vendor_id) // start of GetFilterPlanList function 
	{
		if($type=='PACKAGES')
		{
			$GetPlanDietList_sql = $sql1=DB::table('tbl_lr_vendor_package')
			->where('admin_status','=',1)
			->get(['vendor_plan_id']);

			if(count($GetPlanDietList_sql) > 0)
			{
				$diet_center_info = [];
				foreach($GetPlanDietList_sql as $planval)
				{
					$GetPlandetails_sql = $sql1=DB::table('tbl_lr_vendor_plan as t1')
							->join('tbl_lr_userdetail as t2','t1.lr_user_id','t2.lr_user_userid')
							->where('vendor_plan_id','=',$planval->vendor_plan_id)
							->get(['t2.lr_user_userid','lr_userdetail_centrename']);

					if(!count($GetPlandetails_sql) > 0)
					{
						return ([
							'status' => '200',
							'msg' => 'No Records found.',
							'diet_center_info' => array()
								]);
					}
					
					$diet_center_info[] = [   
						'plan_diet_center_id' => $GetPlandetails_sql[0]->lr_user_userid,
					    'plan_diet_center_name' => $GetPlandetails_sql[0]->lr_userdetail_centrename
						];
				}

				return ([
					'status' => '200',
					'msg' => 'Successfully Retrieve Information.',
					'diet_center_info' => $diet_center_info
				]);
			}
			else
			{
				return ([
					'status' => '200',
					'msg' => 'No Records found.',
					'diet_center_info' => array()
				]);
			}
		}
		else
		{
			$GetFilterPlanList_Sql = DB::table('tbl_lr_vendor_plan')
							->where('vendor_plan_type','=',$type)
							->where('lr_user_id',$vendor_id)
							->get(['vendor_plan_id','vendor_plan_name']);

			if(count($GetFilterPlanList_Sql) > 0)
			{
				$plan_info = [];
				foreach($GetFilterPlanList_Sql as $planval)
				{

				$plan_info[] = [ 
					'plan_id' => $planval->vendor_plan_id,
					'plan_name' => $planval->vendor_plan_name
					];
				}

				return ([
					'status' => '200',
					'msg' => 'Successfully Retrieve Information.',
					'plan_info' => $plan_info
				]);
			}
			else
			{
				return ([
					'status' => '200',
					'msg' => 'No Records found.',
					'plan_info' => array()
				]);
			}
		}

	}   // end of GetFilterPlanList function

	public function DeleteAddress($add_id)   // start of DeleteAddress function
	{
		$DeleteAddress_Sql = DB::table('tbl_app_user_address')->where('app_user_add_id',$add_id)->delete();

		if($DeleteAddress_Sql==true)
		{
			return ([
				'status' => '200',
				'msg' => 'Address Deleted Successfully.'
			]);
		}
		else
		{
			return ([
				'status' => '401',
				'msg' => 'Something went wrong, Please try again later.'
			]);
		}

	}   // end of DeleteAddress function

	public function CurrentOrder($add_id)   // start of CurrentOrder function
	{
		$CurrentOrder_Sql = DB::table('tbl_app_user_address')->where('app_user_add_id',$add_id)->delete();

		if($CurrentOrder_Sql==true)
		{
			return ([
				'status' => '200',
				'msg' => 'Address Deleted Successfully.'
			]);
		}
		else
		{
			return ([
				'status' => '401',
				'msg' => 'Something went wrong, Please try again later.'
			]);
		}

	}   // end of CurrentOrder function

	public function Random_Meal($plan_id,$date) // start of GetPlanMenuDetails function 
	{
		if(count($plan_id) > 1)
		{
			$random_data = array();
		    $random_menu_meal = array();
		foreach($date as $index => $date_val)
		{	
			$random_data_sql =  DB::table('tbl_lr_vendor_plandetail_final')->where('vendor_plan_id',$plan_id[$index])->where('vendor_plandetail_date',$date_val)->groupBy('lr_menucategory_id')->get(['lr_menucategory_id','lr_meal_id']); 

			if(count($random_data_sql) > 0)
			{	
				$menu = array();
				foreach($random_data_sql as $random_data_val)
				{  
					
					$menuname_sql = DB::table('tbl_lr_menu_category')->where('lr_category_id',$random_data_val->lr_menucategory_id)->get(['lr_category_name']);

					$mealdetail_sql = DB::table('tbl_lr_meal')->where('lr_meal_id',$random_data_val->lr_meal_id)->get(['lr_meal_id','lr_meal_name','lr_meal_calories','lr_meal_fat','lr_meal_carb','lr_meal_protein','lr_meal_description']);

					$meal_detail =  [
						'meal_id' => $mealdetail_sql[0]->lr_meal_id,
						'meal_name' => $mealdetail_sql[0]->lr_meal_name,
						'meal_calories' => $mealdetail_sql[0]->lr_meal_calories,
						'meal_fat' => $mealdetail_sql[0]->lr_meal_fat,
						'meal_carb' => $mealdetail_sql[0]->lr_meal_carb,
						'meal_protein' => $mealdetail_sql[0]->lr_meal_protein,
						'meal_description' => $mealdetail_sql[0]->lr_meal_description
					];

					$menu[] =  [
						'menu_id' => $random_data_val->lr_menucategory_id,
						'menu_category' => $menuname_sql[0]->lr_category_name,
						'meal_detail' => $meal_detail
					];

					
				}  
			}

			$random_data[] = [
						'date' => $date_val,
						'menu' => $menu
					];
			
		} 

		

		if(count($random_data) > 0)
		{
			return ([
				'status' => '200',
				'msg' => 'Successfully Retrieve Information.',
				'random_data' =>$random_data
			]);
		}
		else
		{
			return ([
				'status' => '200',
				'msg' => 'No data found.',
				'random_data' =>$random_data
			]);
		}
		}
		else
		{
			$random_data = array();
			$random_menu_meal = array();
			foreach($date as $date_val)
			{	
				$random_data_sql =  DB::table('tbl_lr_vendor_plandetail_final')->where('vendor_plan_id',$plan_id)->where('vendor_plandetail_date',$date_val)->groupBy('lr_menucategory_id')->get(['lr_menucategory_id','lr_meal_id']); 

				if(count($random_data_sql) > 0)
				{	
					$menu = array();
					foreach($random_data_sql as $random_data_val)
					{  
						
						$menuname_sql = DB::table('tbl_lr_menu_category')->where('lr_category_id',$random_data_val->lr_menucategory_id)->get(['lr_category_name']);

						$mealdetail_sql = DB::table('tbl_lr_meal')->where('lr_meal_id',$random_data_val->lr_meal_id)->get(['lr_meal_id','lr_meal_name','lr_meal_calories','lr_meal_fat','lr_meal_carb','lr_meal_protein','lr_meal_description']);

						$meal_detail =  [
							'meal_id' => $mealdetail_sql[0]->lr_meal_id,
							'meal_name' => $mealdetail_sql[0]->lr_meal_name,
							'meal_calories' => $mealdetail_sql[0]->lr_meal_calories,
							'meal_fat' => $mealdetail_sql[0]->lr_meal_fat,
							'meal_carb' => $mealdetail_sql[0]->lr_meal_carb,
							'meal_protein' => $mealdetail_sql[0]->lr_meal_protein,
							'meal_description' => $mealdetail_sql[0]->lr_meal_description
						];

						$menu[] =  [
							'menu_id' => $random_data_val->lr_menucategory_id,
							'menu_category' => $menuname_sql[0]->lr_category_name,
							'meal_detail' => $meal_detail
						];

					
					}  
				}

				$random_data[] = [
							'date' => $date_val,
							'menu' => $menu
						];
				
				} 

			

				if(count($random_data) > 0)
				{
					return ([
						'status' => '200',
						'msg' => 'Successfully Retrieve Information.',
						'random_data' =>$random_data
					]);
				}
				else
				{
					return ([
						'status' => '200',
						'msg' => 'No data found.',
						'random_data' =>$random_data
					]);
				}
		}
	}  // end of GetPlanMenuDetails function 

	public function Get_Fixed_Menu_Details( $plan_id , $package_id) // start of Get_Fixed_Menu_Details function 
	{ 
		if( $package_id != '' )
		{
			$package_detail_sql = DB::table('tbl_lr_package')
					->where('lr_package_id','=',$package_id)
					->get(['lr_package_id','package_name','package_description','package_gender','package_price','package_type','image']); // sql to get package details

			$package_plan_detsql = DB::table('tbl_lr_package_details')->where('lr_package_id',$package_id)->select('vendor_plan_id','week_sequence')->orderBy('week_sequence','asc')->get(); // sql to get package plan details

			$curDate = new \DateTime(); 
			$curDate1 = $curDate->format('Y/m/d');
			$startdate = $curDate->modify('+1 day')->format('Y-m-d');
			$enddate = date('Y-m-d', strtotime($curDate1. ' + 7 days'));

			$max_carb_meal = 0;
			$max_protein_meal = 0;
			//$calender_date = [];
			$fixed_data = array();
			foreach($package_plan_detsql as $val)
			{ 
				$calender_date = [];
				$plan_detail = DB::table('tbl_lr_vendor_plan')->where('vendor_plan_id',$val->vendor_plan_id)->get(['macros_no_max_carb','macros_no_max_protein']);

				$max_carb_meal = $max_carb_meal + $plan_detail[0]->macros_no_max_carb;
				$max_protein_meal = $max_protein_meal + $plan_detail[0]->macros_no_max_protein;

				$calender_date_sql = DB::table('tbl_lr_vendor_plandetail_final')->where('vendor_plan_id',$val->vendor_plan_id)->whereDate('vendor_plandetail_date','>=',$startdate)->whereDate('vendor_plandetail_date','<=',$enddate)->distinct('vendor_plandetail_date')->orderBy('vendor_plandetail_date','ASC')->get(['vendor_plandetail_date','lr_unique_id']);

				while($startdate<=$enddate)
				{
				$calender_date[$startdate] = 0;

				$startdate = date ("Y-m-d", strtotime("+1 day", strtotime($startdate)));
				} 

				foreach($calender_date_sql as $cal_val)
				{ 
				$calender_date[$cal_val->vendor_plandetail_date] = $cal_val->vendor_plandetail_date;
				}
              
				foreach($calender_date as $key => $value)
				{  
					if($value!=0)
					{  
						$fixed_data_sql =  DB::table('tbl_lr_vendor_plandetail_final')->where('vendor_plan_id',$val->vendor_plan_id)->where('vendor_plandetail_date',$key)->get(['lr_menucategory_id','lr_meal_id']); 

					if(count($fixed_data_sql) > 0)
					{	
						$menu = array();
						foreach($fixed_data_sql as $fixed_data_val)
						{  
							
							$menuname_sql = DB::table('tbl_lr_menu_category')->where('lr_category_id',$fixed_data_val->lr_menucategory_id)->get(['lr_category_name']);

							$mealdetail_sql = DB::table('tbl_lr_meal')->where('lr_meal_id',$fixed_data_val->lr_meal_id)->get(['lr_meal_id','lr_meal_name','lr_meal_calories','lr_meal_fat','lr_meal_carb','lr_meal_protein','lr_meal_description']);

							$meal_detail =  [
								'meal_id' => $mealdetail_sql[0]->lr_meal_id,
								'meal_name' => $mealdetail_sql[0]->lr_meal_name,
								'meal_calories' => $mealdetail_sql[0]->lr_meal_calories,
								'meal_fat' => $mealdetail_sql[0]->lr_meal_fat,
								'meal_carb' => $mealdetail_sql[0]->lr_meal_carb,
								'meal_protein' => $mealdetail_sql[0]->lr_meal_protein,
								'meal_description' => $mealdetail_sql[0]->lr_meal_description
							];

							$menu[] =  [
								'menu_id' => $fixed_data_val->lr_menucategory_id,
								'menu_category' => $menuname_sql[0]->lr_category_name,
								'meal_detail' => $meal_detail
							];

							
						}  
					}
				}
				else
				{   
					$menu =  [];
				}

				
				$fixed_data[] = [
					"date" =>  $key,
					"status" => $value,
					'menu' => $menu
				];
			}

			$enddate = date('Y-m-d', strtotime($enddate. ' + 7 days'));

		} 
		
			return ([       
				'status' => '200',
				'msg' => 'Successfully Retrieve Information.',
				'plan_calender_detail' =>[
				'package_id' => $package_detail_sql[0]->lr_package_id,
				'package_name' => $package_detail_sql[0]->package_name,
				'package_image' => url('/public/admin/upload/package')."/".$package_detail_sql[0]->image, 
				'plan_menutype' => 'FIXED MENU',
				'plan_type' => 'PACKAGES',
				'plan_cost' => $package_detail_sql[0]->package_price,
				'plan_gender' => $package_detail_sql[0]->package_gender,
				'plan_description' => $package_detail_sql[0]->package_description,
				'edit_macros' => "NO",
				'min_carb' => "",
				'max_carb' => "",
				'min_protein' => "",
				'max_protein' => "",
				'edit_meal_type' => "",
				'max_carb_meal' => $max_carb_meal,
				'max_protein_meal' => $max_protein_meal,
				'fixed_data' => $fixed_data
			]
			]);  
		}
		else if( $plan_id != '' )
		{
			$plan_detail_sql = DB::table('tbl_lr_vendor_plan as t1')
			->join('tbl_lr_userdetail as t2','t1.lr_user_id','t2.lr_user_userid')
			->where('vendor_plan_id','=',$plan_id)
			->get(['vendor_plan_name','vendor_plan_offdays','vendor_plan_menu_type','plan_description','t2.lr_userdetail_logo','vendor_plan_pause','vendor_plan_type','t1.vendor_plan_macros','t1.macros_yes_min_carb','t1.macros_yes_max_carb','t1.macros_yes_min_protein','t1.macros_yes_max_protein','t1.macros_yes_plan','t1.macros_no_max_carb','t1.macros_no_max_protein','t1.lr_user_id','t1.plan_cost','t2.lr_userdetail_centrename','t1.vendor_plan_gendor']); // sql to get plan details

			$curDate = new \DateTime(); 
			$curDate1 = $curDate->format('Y/m/d');
			$startdate = $curDate->modify('+1 day')->format('Y-m-d');

			if($plan_detail_sql[0]->vendor_plan_type=='MONTHLY')
			{
				$enddate = date('Y-m-d', strtotime($curDate1. ' + 30 days'));
			}
			else if($plan_detail_sql[0]->vendor_plan_type=='WEEKLY')
			{
				 $enddate = date('Y-m-d', strtotime($curDate1. ' + 7 days')); 
			}

			$calender_date_sql = DB::table('tbl_lr_vendor_plandetail_final')->where('vendor_plan_id',$plan_id)->whereDate('vendor_plandetail_date','>=',$startdate)->whereDate('vendor_plandetail_date','<=',$enddate)->distinct('vendor_plandetail_date')->orderBy('vendor_plandetail_date','ASC')->get(['vendor_plandetail_date','lr_unique_id']);
			
			// $enddate_sql = DB::table('tbl_lr_vendor_plandetail_final')->where('vendor_plan_id',$plan_id)->whereDate('vendor_plandetail_date',$to)->first(['vendor_plandetail_date']);


			// echo 'dgdgfdgfdg'.$enddate = $enddate_sql->vendor_plandetail_date; exit;
			$calender_date = [];
			while($startdate<=$enddate)
			{
			$calender_date[$startdate] = 0;

			$startdate = date ("Y-m-d", strtotime("+1 day", strtotime($startdate)));
			} 

			foreach($calender_date_sql as $cal_val)
			{ 
			$calender_date[$cal_val->vendor_plandetail_date] = $cal_val->vendor_plandetail_date;
			}
			$fixed_data = array();
			foreach($calender_date as $key => $value)
			{
				if($value!=0)
				{
					$fixed_data_sql =  DB::table('tbl_lr_vendor_plandetail_final')->where('vendor_plan_id',$plan_id)->where('vendor_plandetail_date',$key)->get(['lr_menucategory_id','lr_meal_id']); 

					if(count($fixed_data_sql) > 0)
					{	
						$menu = array();
						foreach($fixed_data_sql as $fixed_data_val)
						{  
							
							$menuname_sql = DB::table('tbl_lr_menu_category')->where('lr_category_id',$fixed_data_val->lr_menucategory_id)->get(['lr_category_name']);

							$mealdetail_sql = DB::table('tbl_lr_meal')->where('lr_meal_id',$fixed_data_val->lr_meal_id)->get(['lr_meal_id','lr_meal_name','lr_meal_calories','lr_meal_fat','lr_meal_carb','lr_meal_protein','lr_meal_description']);

							$meal_detail =  [
								'meal_id' => $mealdetail_sql[0]->lr_meal_id,
								'meal_name' => $mealdetail_sql[0]->lr_meal_name,
								'meal_calories' => $mealdetail_sql[0]->lr_meal_calories,
								'meal_fat' => $mealdetail_sql[0]->lr_meal_fat,
								'meal_carb' => $mealdetail_sql[0]->lr_meal_carb,
								'meal_protein' => $mealdetail_sql[0]->lr_meal_protein,
								'meal_description' => $mealdetail_sql[0]->lr_meal_description
							];

							$menu[] =  [
								'menu_id' => $fixed_data_val->lr_menucategory_id,
								'menu_category' => $menuname_sql[0]->lr_category_name,
								'meal_detail' => $meal_detail
							];

						
					}  
					}
				}
				else
				{
					$menu =  [];
				}
				$fixed_data[] = [
					"date" =>  $key,
					"status" => $value,
					'menu' => $menu
				];
			}

			return ([       
				'status' => '200',
				'msg' => 'Successfully Retrieve Information.',
				'plan_calender_detail' =>[
				'plan_id' => $plan_id,
				'plan_name' => $plan_detail_sql[0]->vendor_plan_name,
				'plan_offdays' => $plan_detail_sql[0]->vendor_plan_offdays,
				'user_off_days' => $plan_detail_sql[0]->vendor_plan_pause,
				'plan_menutype' => 'FIXED MENU',
				'plan_type' => $plan_detail_sql[0]->vendor_plan_type,
				'plan_cost' => $plan_detail_sql[0]->plan_cost,
				'plan_gender' => $plan_detail_sql[0]->vendor_plan_gendor,
				'plan_description' => $plan_detail_sql[0]->plan_description,
				'diet_center_id' => $plan_detail_sql[0]->lr_user_id,
				'diet_center_name' => $plan_detail_sql[0]->lr_userdetail_centrename,
				'diet_center_logo' => url('/public/vendor/upload/logo')."/".$plan_detail_sql[0]->lr_userdetail_logo,
				'edit_macros' => $plan_detail_sql[0]->vendor_plan_macros,
				'min_carb' => $plan_detail_sql[0]->macros_yes_min_carb,
				'max_carb' => $plan_detail_sql[0]->macros_yes_max_carb,
				'min_protein' => $plan_detail_sql[0]->macros_yes_min_protein,
				'max_protein' => $plan_detail_sql[0]->macros_yes_max_protein,
				'edit_meal_type' => $plan_detail_sql[0]->macros_yes_plan,
				'max_carb_meal' => $plan_detail_sql[0]->macros_no_max_carb,
				'max_protein_meal' => $plan_detail_sql[0]->macros_no_max_protein,
				'fixed_data' => $fixed_data
			]
			]);   
		}

	}  // end of Get_Fixed_Menu_Details function

	public function Get_Plan_Filter_List($user_uniqueid,$type) // start of Get_Plan_Filter_List function 
	{ 
		if($user_uniqueid!='')
		{
			$selected_filter_id_sql = DB::table('tbl_app_user_plan_filter')->where('user_uniqueid',$user_uniqueid)->where('vendor_plan_type',$type)->select('app_planfilter_id')->orderby('user_filter_id','desc')->first(); 
		
			if(count($selected_filter_id_sql) > 0)
			{
				$exp_selected_filter_id = explode(',',$selected_filter_id_sql->app_planfilter_id);
			}
			else
			{
				$exp_selected_filter_id = array();
			}
		}
		else
		{
			$exp_selected_filter_id = array();
		}
		
		$data_sql = DB::table('tbl_app_planfilter')
		->where('admin_status','=',1)
		->get(['app_planfilter_id','app_planfilter_name','app_planfilter_image']); // sql to get plan filter data
		
		$plan_filter = array();
		foreach($data_sql as  $value)
		{  
			if(in_array($value->app_planfilter_id,$exp_selected_filter_id))
			{
				$selected = 1;
			}
			else
			{
				$selected = 0;
			}
			$plan_filter[] = [
				"plan_filter_id" => $value->app_planfilter_id,
				"plan_filter_name" => $value->app_planfilter_name,
				"plan_filter_image" => url('/public/admin/upload/plan_filter_image')."/".$value->app_planfilter_image,
				"selected" => $selected
			];
			
		}

		return ([ 
			'status' => '200',
			'msg' => 'Successfully Retrieve Information.',
			'plan_filter' =>$plan_filter
		]);

	}  // end of Get_Fixed_Menu_Details function

	public function Get_Filter_Result($type,$gender,$diet_center_ids,$plan_filter_ids,$user_uniqueid) // start of Get_Filter_Result function 
	{ 
		if($type=='PACKAGES')
		{
			
		}
		else
		{
			$GetPlanDietList_sql = DB::table('tbl_lr_vendor_plan as t1')
			->join('tbl_lr_userdetail as t2','t1.lr_user_id','t2.lr_user_userid')
							->where('t1.status','=',1) 
							->where('t1.admin_status','=',1) 
							->where('t1.app_status','=',1) 
							->where('t1.vendor_plan_type','=',$type);

		if($gender!='')
		{
			 $GetPlanDietList_sql->where(function($q) use ($gender) {
		         $q->where('t1.vendor_plan_gendor',$gender)
		           ->orwhere('t1.vendor_plan_gendor','BOTH');
		     });
			
		}

		if(count($diet_center_ids) > 0)
		{
			$GetPlanDietList_sql->where(function($q) use ($diet_center_ids) {;
			foreach($diet_center_ids as $diet_id)
			{
				
		        	 $q->orwhere('t1.lr_user_id',$diet_id);
		    	 
			}

			});

			$imp_diet_centre_id = implode(',',$diet_center_ids);
			
		}
		else
		{
			$imp_diet_centre_id = '';
		}

		if(count($plan_filter_ids) > 0)
		{
			$GetPlanDietList_sql->join('tbl_lr_vendor_plan_filter as t3','t1.vendor_plan_id','t3.vendor_plan_id');
			foreach($plan_filter_ids as $filter_id)
			{
				$GetPlanDietList_sql->where('t3.app_planfilter_id',$filter_id);
			}
			$imp_plan_filter_ids = implode(',',$plan_filter_ids);
			
		}
		else
		{   
			$imp_plan_filter_ids = '';
		}

		$GetPlanDietList_sql = $GetPlanDietList_sql->get(['t1.vendor_plan_id','t1.vendor_plan_name','t2.lr_user_userid','t2.lr_userdetail_centrename','t2.lr_userdetail_logo','t1.vendor_plan_meals','t1.vendor_plan_snacks','t1.vendor_plan_duration','t1.plan_cost','t1.vendor_plan_menu_type','t1.vendor_plan_type','app_planfilter_id','plan_image']);
		

		if($user_uniqueid!='')
		{
			$insert_sql = DB::table('tbl_app_user_plan_filter')->insert([
				'user_uniqueid' => $user_uniqueid,
				'vendor_plan_type' => $type,
				'diet_centre_id' => $imp_diet_centre_id,
				'app_planfilter_id' => $imp_plan_filter_ids
			]);
		}

		
			 $curDate = new \DateTime();
			 $curDate = $curDate->format('Y/m/d');

			if(count($GetPlanDietList_sql) > 0)
			{
				$plan_info = [];
				foreach($GetPlanDietList_sql as $planval)
				{   
					$type1 = $planval->vendor_plan_type;
					if($type1=='MONTHLY')
					{
						$from = date('Y-m-d', strtotime($curDate. ' + 1 days'));
						$to = date('Y-m-d', strtotime($curDate. ' + 30 days'));

						$no_of_plan_days = DB::table('tbl_lr_vendor_plandetail_final')->GroupBy('vendor_plandetail_date')->whereBetween('vendor_plandetail_date', [$from, $to])->where('vendor_plan_id',$planval->vendor_plan_id)->get();
					}
					else if($type1=='WEEKLY')
					{
						$from = date('Y-m-d', strtotime($curDate. ' + 1 days'));
						$to = date('Y-m-d', strtotime($curDate. ' + 7 days'));

						$no_of_plan_days = DB::table('tbl_lr_vendor_plandetail_final')->GroupBy('vendor_plandetail_date')->whereBetween('vendor_plandetail_date', [$from, $to])->where('vendor_plan_id',$planval->vendor_plan_id)->get();
					}

					if($planval->vendor_plan_menu_type=='FIXEDMENU')
					{
						$plan_menutype = 'FIXED MENU';
					}
					else
					{
						$plan_menutype = 'CUSTOM MENU';
					}

					 $plan_filter_det_sql = DB::table('tbl_app_planfilter')->where('app_planfilter_id',$planval->app_planfilter_id)->select('app_planfilter_id','app_planfilter_name','app_planfilter_image')->get();

				$plan_info[] = [   
					'plan_id' => $planval->vendor_plan_id,
					'plan_name' => $planval->vendor_plan_name,
					'plan_menutype' => $plan_menutype,
					'plan_diet_center_id' => $planval->lr_user_userid,
					'plan_diet_center_name' => $planval->lr_userdetail_centrename,
					'plan_image' => url('/public/vendor/upload/plan_image')."/".$planval->plan_image,
					'plan_meals_count' => $planval->vendor_plan_meals,
					'plan_snacks_count' => $planval->vendor_plan_snacks,
					'plan_days_count' => count($no_of_plan_days),
					'plan_type' => $type1,
					'plan_cost' => $planval->plan_cost,
					'plan_filter_id' => $plan_filter_det_sql[0]->app_planfilter_id,
					'plan_filter_name' => $plan_filter_det_sql[0]->app_planfilter_name,
					'plan_filter_image' => url('/public/admin/upload/plan_filter_image')."/".$plan_filter_det_sql[0]->app_planfilter_image
					];
				}

				return ([
					'status' => '200',
					'msg' => 'Successfully Retrieve Information.',
					'plan_info' => $plan_info
				]);
			}
			else
			{
				return ([
					'status' => '200',
					'msg' => 'No Records found.',
					'plan_info' => array()
				]);
			}
		}
	}  // end of Get_Filter_Result function   

	public function Clear_filter($user_uniqueid) // start of Clear_filter function 
	{ 
		if($user_uniqueid!='')
		{
			try{
				$delete_sql = DB::table('tbl_app_user_plan_filter')->where('user_uniqueid',$user_uniqueid)->delete();

			return ([
				'status' => '200',
				'msg' => 'Clear All Data.'
			]);
		    }
			catch(Exception $e)
			{
				return ([
					'status' => '401',
					'msg' => $e->getMessage()
				]);
			}
		}
			
	}  // end of Clear_filter function 

	public function User_Save_Nutrition($user_uniqueid,$height,$weight) // start of User_Save_Nutrition function 
	{ 
		 $curDate = new \DateTime();
		 $curDate = $curDate->format('Y-m-d'); 

		 

		 $insertorupdate_sql = DB::table('tbl_app_user_health_detail')->where('date',$curDate)->first(); 
		 if(count($insertorupdate_sql) > 0)
		 {	
			try{
				$insert_sql = DB::table('tbl_app_user_health_detail')->where('date',$curDate)->update([
					'user_uniqueid' => $user_uniqueid,
					'user_health_detail_height' => $height,
					'user_health_detail_weight' => $weight,
					]);

				 $data_sql = DB::table('tbl_app_user_health_detail')->where('user_uniqueid',$user_uniqueid)->get(); 
					 if(count($data_sql) > 0)
					 {
						$nutrition_data = [];
						foreach($data_sql as $val)
						{
							$nutrition_data[] = [
								'date' => $val->date,
								'height' => $val->user_health_detail_height,
								'weight' => $val->user_health_detail_weight
							];
						}
					}
					else
					{
						$nutrition_data = [];
					}
	
			return ([
				'status' => '200',
				'msg' => 'Data Added Sucessfully.',
				'nutrition_data' => $nutrition_data
			]);
			}
			catch(Exception $e)
			{
				return ([
					'status' => '401',
					'msg' => $e->getMessage()
				]);
			} 
		 }
		 else
		 {
			try
			{
				$insert_sql = DB::table('tbl_app_user_health_detail')->insert([
					'user_uniqueid' => $user_uniqueid,
					'date' => $curDate,
					'user_health_detail_height' => $height,
					'user_health_detail_weight' => $weight
					]);

				 $data_sql = DB::table('tbl_app_user_health_detail')->where('user_uniqueid',$user_uniqueid)->get(); 
					 if(count($data_sql) > 0)
					 {
						$nutrition_data = [];
						foreach($data_sql as $val)
						{
							$nutrition_data[] = [
								'date' => $val->date,
								'height' => $val->user_health_detail_height,
								'weight' => $val->user_health_detail_weight
							];
						}
					}
					else
					{
						$nutrition_data = [];
					}

					return ([
						'status' => '200',
						'msg' => 'Data Added Sucessfully.',
						'nutrition_data' => $nutrition_data
					]);
			}
			catch(Exception $e)
			{
				return ([
					'status' => '401',
					'msg' => $e->getMessage()
				]);
			} 
		 }
		
		
	}  // end of User_Save_Nutrition function    

	public function User_Get_Nutrition($user_uniqueid) // start of User_Get_Nutrition function 
	{ 
		 $data_sql = DB::table('tbl_app_user_health_detail')->where('user_uniqueid',$user_uniqueid)->get(); 
		 if(count($data_sql) > 0)
		 {
				$nutrition_data = [];
				foreach($data_sql as $val)
				{
					$nutrition_data[] = [
						'date' => $val->date,
						'height' => $val->user_health_detail_height,
						'weight' => $val->user_health_detail_weight
					];
				}
				return ([
					'status' => '200',
					'msg' => 'Successfully Retrieve Information.',
					'nutrition_data' => $nutrition_data
				]);
			
		 }
		 else
		 {
			return ([
				'status' => '200',
				'msg' => 'Successfully Retrieve Information.',
				'nutrition_data' => []
			]);
			
		 }
		
		
	}  // end of User_Get_Nutrition function

	public function faq() // start of faq function 
	{ 
		 $data_sql = DB::table('tbl_lr_cms')->where('status',1)->whereNotIn('lr_cms_id', [1,2,2])->get(); 
		
		 if(count($data_sql) > 0)
		 {
				$faq = [];
				foreach($data_sql as $val)
				{
					$faq[] = [
						'que' => $val->lr_cms_title,
						'ans' => $val->lr_cms_description
					];
				}
				return ([
					'status' => '200',
					'msg' => 'Successfully Retrieve Information.',
					'faq' => $faq
				]);
			
		 }
		 else
		 {
			return ([
				'status' => '200',
				'msg' => 'No Record Found.',
				'faq' => []
			]);
			
		 }
		
		
	}  // end of faq function

	public function Dislikes_and_Allergies() // start of Dislikes_and_Allergies function 
	{ 
		 $data_allergy_sql = DB::table('tbl_app_allergy')->where('admin_status',1)->get(); 

		 $data_dislike_sql = DB::table('tbl_app_dislike')->where('admin_status',1)->get();  
		
		 if(count($data_allergy_sql) > 0)
		 {
				$allergies = [];
				foreach($data_allergy_sql as $val)
				{
					$allergies[] = [
						'allergy_id' => $val->app_allergy_id,
						'allergy_name' => $val->allergy_name
					];
				}
		 }
		 else
		 {
			$allergies = [];
		 }

		 if(count($data_dislike_sql) > 0)
		 {
				$dislike = [];
				foreach($data_dislike_sql as $val)
				{
					$dislike[] = [
						'dislike_id' => $val->app_dislike_id,
						'dislike_name' => $val->app_dislike_name
					];
				}
		 }
		 else
		 {
			$dislike = [];
		 }

		 return ([
			'status' => '200',
			'msg' => 'Successfully Retrieve Information.',
			'dislike' => $dislike,
			'allergies' => $allergies
		]);
		
		
	}  // end of Dislikes_and_Allergies function

	public function Apply_Promo_Code($user_uniqueid,$sub_total_amount,$promo_code) // start of Apply_Promo_Code function 
	{ 
		 $valid_promocode_sql = DB::table('tbl_app_promocode')->where('promocode',$promo_code)->get();

		 
		 if(count($valid_promocode_sql) > 0)
		 { 
			$promocode_user = $valid_promocode_sql[0]->promocode_user;
			if($promocode_user=='All')
			{
			  $applied = True;
			  $deduct_amount = $valid_promocode_sql[0]->amount;
			}
			else if($promocode_user=='top-100')
			{
			   $valid_user_sql = DB::table('tbl_app_user')->where([
				   'admin_status'  => 1,
				   ])->OrderBy('app_user_id','ASC')->limit(100)->get(['user_uniqueid']);
				   $valid_user_sql = json_decode(json_encode($valid_user_sql), true);  
				  $res = in_array_r( $user_uniqueid,$valid_user_sql,$strict = false );
				   if($res == True)
				   {
					   $applied = True;
					   $deduct_amount = $valid_promocode_sql[0]->amount;
				   }
				   else
				   {
					   return ([
						   'status' => '200',
						   'msg' => 'Invalid Promocode.',
						   'applied' => false,
						   'deduct_amount' => ''
					   ]);
				   }
   
			}
			return ([
				'status' => '200',
				'msg' => 'Promocode Applied.',
				'applied' => $applied,
				'deduct_amount' => $deduct_amount
			]);

		 }
		 else
		 {
			return ([
				'status' => '200',
				'msg' => 'Invalid Promocode.',
				'applied' => false,
				'deduct_amount' => ''	
			]);
		 }

	}  // end of Apply_Promo_Code function

	public function show_packages_and_social() // start of show_packages_and_social function 
	{ 
		 $app_control_package_sql = DB::table('tbl_app_control')->where('app_control_name','Packages')->get();

		 $app_control_social_sql = DB::table('tbl_app_control')->where('app_control_name','Social Icons')->get();


		 
		 if(count($app_control_package_sql) > 0 && count($app_control_social_sql))
		 { 
			$package_status = $app_control_package_sql[0]->app_control_status;
			$social_status = $app_control_social_sql[0]->app_control_status;

			if($package_status==1)
			{
				$package_status = true;
			}
			else
			{
				$package_status = false;
			}

			if($social_status==1)
			{
				$social_status = true;
			}
			else
			{
				$social_status = false;
			}

			return ([
				'status' => '200',
				'msg' => 'Data Retrieve Successfully.',
				'packages' => $package_status,
				'social' => $social_status	
			]);

		 }
		 else
		 {
			return ([
				'status' => '200',
				'msg' => 'Data Retrieve Successfully.',
				'packages' => false,
				'social' => false	
			]);
		 }

	}  // end of show_packages_and_social function

	public function order_list($user_uniqueid) // start of order_list function 
	{ 
		$curDate = new \DateTime();
		$curDate = $curDate->format('Y-m-d');

		 $order_list_sql = DB::table('tbl_app_pre_order as pre_order')->join('tbl_app_order as order','order.app_pre_order_id','pre_order.app_pre_order_id')->where('pre_order.user_uniqueid',$user_uniqueid)->select('order.app_order_unique_id','pre_order.app_pre_order_id')->get();

		 if(count($order_list_sql))
		 { 
			$current_order = [];
			$order_history = [];
			foreach($order_list_sql as $order_val)
			{
				$order_last_date_sql = DB::table('tbl_app_pre_order_calender')->select('vendor_plandetail_date')->where('app_pre_order_id',$order_val->app_pre_order_id)->orderby('vendor_plandetail_date','desc')->first();

				
				if($order_last_date_sql->vendor_plandetail_date >= $curDate)
				{
					$current_order[] = [
						"order_id" => $order_val->app_order_unique_id,
						"last_date" => $order_last_date_sql->vendor_plandetail_date
					];
				}
				else
				{
					$order_history[] = [
						"order_id" => $order_val->app_order_unique_id
					];
				}
				
			}
			

			return ([
				'status' => '200',
				'msg' => 'Successfully Retrieve Information..',
				'current_order' => $current_order,
				'order_history' => $order_history	
			]);

		 }
		 else
		 {
			return ([
				'status' => '200',
				'msg' => 'Data Retrieve Successfully.',
				'packages' => false,
				'social' => false	
			]);
		 }

	}  // end of order_list function

		public function advertisement() // start of advertisement function 
	{ 
		 $advertisement_sql = DB::table('tbl_app_advertisement')->where('admin_status',1)->get();

		 if(count($advertisement_sql))
		 { 
			
			$ad_list = [];
			foreach($advertisement_sql as $val)
			{
				$ad_list[] = [
				  "ad_image" =>  url('/public/admin/upload/advertisement')."/".$val->image,
				  "ad_title" =>  $val->title,
				  "ad_desc" =>  $val->description
				];
			}
			

			return ([
				'status' => '200',
				'msg' => 'Data Retrieve Successfully.',
				'ad_list' => $ad_list
			]);

		 }
		 else
		 {
			return ([
				'status' => '200',
				'msg' => 'No Record Found.',
				'ad_list' => []	
			]);
		 }

	}  // end of order_list function

	public function add_credit_card($user_uniqueid , $last_digits , $expiry_month , $expiry_year , $holder_name , $brand , $card_token) // start of add_credit_card function 
	{ 
		 $card_insert_sql = DB::table('tbl_app_user_creditcard')->insert([
		 	'user_uniqueid' => $user_uniqueid,
		 	'last_digits'   => $last_digits,
		 	'expiry_month'  => $expiry_month,
		 	'expiry_year'   => $expiry_year,
		 	'card_holder_name'   => $holder_name,
		 	'card_brand'    => $brand,
		 	'card_token'    => $card_token
		 	]);

		 if($card_insert_sql == true)
		 { 

		 	$last_insert_id = DB::getPdo()->lastInsertId();

			return ([
				'status' => '200',
				'msg' => 'Card Added Successfully.',
				'card_details' => [
					"card_id" => $last_insert_id,
					"last_digits" => $last_digits,
					"expiry_month" => $expiry_month,
					"expiry_year" => $expiry_year,
					"holder_name" => $holder_name,
					"brand" => $brand,
					"card_token" => $card_token
				]
			]);

		 }
		 else
		 {
			return ([
				'status' => '401',
				'msg' => 'Something went wrong, Please try again later.'
			]);
		 }

	}  // end of order_list function

	public function card_list($user_uniqueid)
	{
		$card_list_sql = DB::table('tbl_app_user_creditcard')->where("user_uniqueid" , $user_uniqueid)->get();

		 if(count($card_list_sql) > 0)
		 { 
			 $card_list = [];
			 foreach($card_list_sql as $val)
			 {
			 	$card_list[] = [
					"card_id" => $val->user_creditcard_id,
					"last_digits" => $val->last_digits,
					"expiry_month" => $val->expiry_month,
					"expiry_year" => $val->expiry_year,
					"holder_name" => $val->card_holder_name,
					"brand" => $val->card_brand,
					"card_token" => $val->card_token
			    ];
			 } 
		 }
		 else
		 {
			$card_list = [];
		 }

		 return ([
				'status' => '200',
				'msg' => 'Successfully Retrieve Information.',
				'card_list' => $card_list
			]);
	}

	public function delete_card($card_id)
	{
		try{

			$delete_sql = DB::table('tbl_app_user_creditcard')->where('user_creditcard_id',$card_id)->delete();

			 return ([
				'status' => '200',
				'msg' => 'Card Information Deleted Successfully.'
			]);

		}
		catch(Exception $e)
		{
			return ([
				'status' => '401',
				'msg' => $e->getMessage()
			]);
		}
	}

	public function order_detail($user_uniqueid , $order_id , $order_type)
	{
		 $curDate = new \DateTime();
		 $curDate = $curDate->format('Y-m-d');

		$order_info_sql = DB::table('tbl_app_order as order')->join('tbl_app_pre_order as pre_order','pre_order.app_pre_order_id','order.app_pre_order_id')->where('app_order_unique_id',$order_id)->get(['vendor_plan_id','vendor_plan_name','lr_userdetail_centrename','vendor_plan_menu_type','pre_order.user_uniqueid','vendor_plan_pause','vendor_plan_offdays','lr_userdetail_logo','vendor_plan_type','plan_description','vendor_plan_macros','macros_yes_min_carb','macros_yes_max_carb','macros_yes_min_protein','macros_yes_max_protein','macros_yes_plan','macros_no_max_carb','macros_no_max_protein','plan_cost','order_type']);

		$order_last_date_sql = DB::table('tbl_app_order as order')->join('tbl_app_pre_order_calender as pre_order_calender','pre_order_calender.app_pre_order_id','order.app_pre_order_id')->where('app_order_unique_id',$order_id)->select('vendor_plandetail_date')->orderBy('vendor_plandetail_date','desc')->first();  

		$user_off_days = DB::table('tbl_app_order as order')->join('tbl_app_preorder_useroff_list as app_preorder_useroff_list','app_preorder_useroff_list.app_pre_order_id','order.app_pre_order_id')->where('app_order_unique_id',$order_id)->select('off_date')->get();

		if($order_type=='current')
		{
			$pre_order_calender_sql = DB::table('tbl_app_order as order')->join('tbl_app_pre_order_calender as pre_order_calender','pre_order_calender.app_pre_order_id','order.app_pre_order_id')->where('app_order_unique_id',$order_id)->where('vendor_plandetail_date','>=',$curDate)->select('vendor_plandetail_date')->get();

			$enddate_sql = DB::table('tbl_app_order as order')->join('tbl_app_pre_order_calender as pre_order_calender','pre_order_calender.app_pre_order_id','order.app_pre_order_id')->where('app_order_unique_id',$order_id)->where('vendor_plandetail_date','>=',$curDate)->orderBy('vendor_plandetail_date','desc')->select('vendor_plandetail_date')->first();

			$startdate = $pre_order_calender_sql[0]->vendor_plandetail_date;
			$enddate = $enddate_sql->vendor_plandetail_date;
		}
		else
		{
			$pre_order_calender_sql = DB::table('tbl_app_order as order')->join('tbl_app_pre_order_calender as pre_order_calender','pre_order_calender.app_pre_order_id','order.app_pre_order_id')->where('app_order_unique_id',$order_id)->select('vendor_plandetail_date')->get();

			$enddate_sql = DB::table('tbl_app_order as order')->join('tbl_app_pre_order_calender as pre_order_calender','pre_order_calender.app_pre_order_id','order.app_pre_order_id')->where('app_order_unique_id',$order_id)->orderBy('vendor_plandetail_date','desc')->select('vendor_plandetail_date')->first();

			$startdate = $pre_order_calender_sql[0]->vendor_plandetail_date;
			$enddate = $enddate_sql->vendor_plandetail_date;
		}
		

		
		$calender_date = [];
		while($startdate<=$enddate)
		{
		$calender_date[$startdate] = 0;

		$startdate = date ("Y-m-d", strtotime("+1 day", strtotime($startdate)));
		} 

		foreach($pre_order_calender_sql as $cal_val)
		{ 
			$calender_date[$cal_val->vendor_plandetail_date] = $cal_val->vendor_plandetail_date;
		}

		$ordered_meal = [];
		foreach($calender_date as $key => $value)
		{
			if($value!=0)
			{ 
				$ordered_meal_sql = DB::table('tbl_app_order as order')->join('tbl_app_pre_order_calender as pre_order_calender','pre_order_calender.app_pre_order_id','order.app_pre_order_id')->where('app_order_unique_id',$order_id)->where('vendor_plandetail_date',$key)->select('vendor_plandetail_date','protein','Carb','pre_order_calender_id')->first(); 

				$dayCarb = $ordered_meal_sql->Carb;
				$dayProtein = $ordered_meal_sql->protein;
				$calender_id = $ordered_meal_sql->pre_order_calender_id;

				$menu_sql = DB::table('tbl_app_preorder_calender_menu_meal')->where('pre_order_calender_id',$calender_id)->get();
				$menu = [];
				foreach( $menu_sql as $menu_sql_val )
				{
					$menu[] = [
					   "menu_id" => $menu_sql_val->lr_category_id, 
					   "menu_category" => $menu_sql_val->lr_category_name,  
					   "max_meal_carb" => $menu_sql_val->max_meal_carb, 
					   "max_meal_protein" => $menu_sql_val->max_meal_protein,
					   "meal_detail" => [
					      	 "meal_id" => $menu_sql_val->lr_meal_id,
                             "meal_name" => $menu_sql_val->lr_meal_name,
                             "meal_description" => $menu_sql_val->lr_meal_description,
                             "meal_calories" => $menu_sql_val->lr_meal_calories,
                             "meal_fat" => $menu_sql_val->lr_meal_fat,
                             "meal_carb" => $menu_sql_val->lr_meal_carb,
                             "meal_protein" => $menu_sql_val->lr_meal_protein
					   ],
					];
				}
			}
			else
			{
				$dayCarb = '';
				$dayProtein = '';
				$menu = [];
			}

			$ordered_meal[] = [
			    "date" =>  $key, // will start from current date
				"status" => $value, // willbe 0 incase ofvendor orusers dayoff
				"dayCarb" => $dayCarb,
				"dayProtein" => $dayProtein,
				"menu" => $menu
			];
		}

		if($order_info_sql[0]->vendor_plan_type == 'MONTHLY')
		{
			$plan_last_date = date('Y-m-d', strtotime($curDate. ' + 30 days'));
		}
		else if($order_info_sql[0]->vendor_plan_type == 'PACKAGES')
		{	
			$plan_last_date_sql = DB::table('tbl_lr_package_details')->where('lr_package_id',$order_info_sql[0]->vendor_plan_id)->count();

			$plan_last_date = date('Y-m-d', strtotime($curDate));
			for($i=0; $i < $plan_last_date_sql; $i++)
			{
				$plan_last_date = date('Y-m-d', strtotime($plan_last_date. ' + 7 days'));
			}
			
		}
		else
		{
			$plan_last_date = date('Y-m-d', strtotime($curDate. ' + 7 days'));
		}

		if($order_info_sql[0]->vendor_plan_menu_type=='FIXEDMENU')
		{
		$plan_menutype = 'FIXED MENU';
		}
		else
		{
		$plan_menutype = 'CUSTOM MENU';
		}


	   $user_off_list = [];
	   foreach($user_off_days as $user_off_days_val)
	   {
	   	  $user_off_list[] = $user_off_days_val->off_date;
	   }

	   $dislikes_sql = DB::table('tbl_app_order as order')->join('tbl_app_preorder_dislike as dislike','dislike.app_pre_order_id','order.app_pre_order_id')->where('app_order_unique_id',$order_id)->select('app_dislike_id','app_dislike_name')->get();

	   $dislikes = [];
	   foreach($dislikes_sql as $val_dis)
	   {
	   	  $dislikes[] = [
	   	     "dislike_id" => $val_dis->app_dislike_id,
             "dislike_name" => $val_dis->app_dislike_name
	   	  ];
	   }

	   $allergy_sql = DB::table('tbl_app_order as order')->join('tbl_app_preorder_allergy as allergy','allergy.app_pre_order_id','order.app_pre_order_id')->where('app_order_unique_id',$order_id)->select('app_allergy_id','allergy_name')->get();

	   $allergies = [];
	   foreach($allergy_sql as $val_all)
	   {
	   	  $allergies[] = [
	   	     "allergy_id" => $val_all->app_allergy_id,
             "allergy_name" => $val_all->allergy_name
	   	  ];
	   }

	   if( $order_info_sql[0]->order_type == 'PACKAGES' )
	   {
		 $order_info = [
		 "order_id" => $order_id,
         "package_id" => $order_info_sql[0]->vendor_plan_id,
         "package_name" => $order_info_sql[0]->vendor_plan_name,
         "plan_offdays" => $order_info_sql[0]->vendor_plan_offdays,
         "user_off_days" => $order_info_sql[0]->vendor_plan_pause,
         "plan_menutype" => $plan_menutype,
         "plan_type" => $order_info_sql[0]->vendor_plan_type,
         "plan_cost" => $order_info_sql[0]->plan_cost,
         "plan_description" => $order_info_sql[0]->plan_description,
         "diet_center_id" => $order_info_sql[0]->user_uniqueid,
         "diet_center_name" => $order_info_sql[0]->lr_userdetail_centrename,  
         "package_image" => url('/public/admin/upload/package')."/".$order_info_sql[0]->lr_userdetail_logo,
         "edit_macros" => $order_info_sql[0]->vendor_plan_macros,
         "min_carb" => $order_info_sql[0]->macros_yes_min_carb,
         "max_carb" => $order_info_sql[0]->macros_yes_max_carb,
         "min_protein" => $order_info_sql[0]->macros_yes_min_protein,
         "max_protein" => $order_info_sql[0]->macros_yes_max_protein,
         "edit_meal_type" => $order_info_sql[0]->macros_yes_plan,
         "max_carb_meal" => $order_info_sql[0]->macros_no_max_carb,
         "max_protein_meal" => $order_info_sql[0]->macros_no_max_protein,
         "current_date" => $curDate,
         "order_last_date" => $order_last_date_sql->vendor_plandetail_date,
         "plan_last_date" => $plan_last_date,
         "ordered_meal" => $ordered_meal,
         "userOffList" => $user_off_list,
         "dislikes" => $dislikes,
         "allergies" => $allergies
	     ];
	   } 
	   else
	   {
	   	 $order_info = [
			 "order_id" => $order_id,
	         "plan_id" => $order_info_sql[0]->vendor_plan_id,
	         "plan_name" => $order_info_sql[0]->vendor_plan_name,
	         "plan_offdays" => $order_info_sql[0]->vendor_plan_offdays,
	         "user_off_days" => $order_info_sql[0]->vendor_plan_pause,
	         "plan_menutype" => $plan_menutype,
	         "plan_type" => $order_info_sql[0]->vendor_plan_type,
	         "plan_cost" => $order_info_sql[0]->plan_cost,
	         "plan_description" => $order_info_sql[0]->plan_description,
	         "diet_center_id" => $order_info_sql[0]->user_uniqueid,
	         "diet_center_name" => $order_info_sql[0]->lr_userdetail_centrename,  
	         "diet_center_logo" => url('/public/vendor/upload/logo')."/".$order_info_sql[0]->lr_userdetail_logo,
	         "edit_macros" => $order_info_sql[0]->vendor_plan_macros,
	         "min_carb" => $order_info_sql[0]->macros_yes_min_carb,
	         "max_carb" => $order_info_sql[0]->macros_yes_max_carb,
	         "min_protein" => $order_info_sql[0]->macros_yes_min_protein,
	         "max_protein" => $order_info_sql[0]->macros_yes_max_protein,
	         "edit_meal_type" => $order_info_sql[0]->macros_yes_plan,
	         "max_carb_meal" => $order_info_sql[0]->macros_no_max_carb,
	         "max_protein_meal" => $order_info_sql[0]->macros_no_max_protein,
	         "current_date" => $curDate,
	         "order_last_date" => $order_last_date_sql->vendor_plandetail_date,
	         "plan_last_date" => $plan_last_date,
	         "ordered_meal" => $ordered_meal,
	         "userOffList" => $user_off_list,
	         "dislikes" => $dislikes,
	         "allergies" => $allergies
	     ];
	   }

		 return ([
		 	'status' => '200',
			'msg' => 'Successfully Retrieve Information.',
			'order_info' => $order_info
		]);
			
	  			 
	}

	}// end of class        
