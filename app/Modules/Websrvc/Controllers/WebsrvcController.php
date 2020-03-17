<?php

namespace App\Modules\Websrvc\Controllers;
use App\Modules\Websrvc\Models\Websrvc;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Response;
class WebsrvcController extends Controller
{
  public function __construct()
  {
       
  }
   public function AreaList(Request $request) // Area List
    {
      if($request->isMethod('POST'))  //start of post
      {
          $ModelCalled = new Websrvc;
          $AreaList = $ModelCalled->AreaList();
          return response()->json($AreaList);
      }
      else
      {
         return response()->json(
          [
          'status' =>'401',
          'msg' => 'Invalid request, please try again.'
          ]);
      }
    } // end of area list function

    public function RegisterUser(Request $request) // start of register function 
    {
      if($request->isMethod('post'))
      {
        $ModelCalled = new Websrvc;
        $RegisterUser = $ModelCalled->RegisterUser($request);
        return response()->json($RegisterUser);
      }
      else
      {
        return response()->json(
          [
          'status' =>'401',
          'msg' => 'Invalid request, please try again.'
          ]);
      }
    }  // end of register function 

    public function LoginUser(Request $request) // start of LoginUser function 
    {
      if($request->isMethod('post'))
      {
        $ModelCalled = new Websrvc;
        $LoginUser = $ModelCalled->LoginUser($request);
        return response()->json($LoginUser);
      }
      else
      {
        return response()->json(
          [
          'status' =>'401',
          'msg' => 'Invalid request, please try again.'
          ]);
      }
    } // end of LoginUser function 

    public function ForgotPassword(Request $request) // start of ForgotPassword function 
    {
      if($request->isMethod('post'))
      {
       $email =  $request->email;
        if($email!='')
	    	{
          $ModelCalled = new Websrvc;
          $ForgotPassword = $ModelCalled->ForgotPassword($email);
          return response()->json($ForgotPassword);
        }
        else
        {
          return ([
            'status' =>'401',
            'msg' => 'Please enter your e-mail address.'
            ]);
        }
      }
      else
      {
        return response()->json(
          [
          'status' =>'401',
          'msg' => 'Invalid request, please try again.'
          ]);
      }
    } // end of ForgotPassword function 

    public function UserLogin(Request $request)
    {
      if($request->isMethod('POST'))//start of post
      {
        $mobile = trim($request->mobile);
        $password = trim($request->password);
        $dt = 'datetime';
        if($password != "" && $password != "")
        {
          $ModelCalled = new Websrvc;
          $UserLogin = $ModelCalled->UserLogin($mobile,$password,$dt);
          return response()->json($UserLogin);

        }
        else
        {
          return response()->json(
                [
                'status' =>'401',
                'msg' => 'All fields required.'
                ]);
        }

       
      }
      else
      {
         return response()->json(
                [
                'status' =>'401',
                'msg' => 'Invalid request, please try again.'
                ]);
      }
    }

    public function changepassword($token)  // start of changepassword function 
    {
      if($token!='')
      {    $ModelCalled = new Websrvc;
           $changepassword = $ModelCalled->changepassword($token);
           return $changepassword;
      }
      else
      {
          $token_status = '3';
          return view("Websrvc::changepassword")->with('token',$token);
      }
    }  // end of changepassword function 

    public function changepasswordinsert(Request $request) // start of changepasswordinsert function 
    {
      if($request->isMethod('POST'))
      {       
      $password = $request->password;
      $token = $request->user_id;

       $ModelCalled = new Websrvc;
       $changepasswordinsert = $ModelCalled->changepasswordinsert($password,$token);
       return response()->json($changepasswordinsert);
      } // check for method post
      else
      {
      return response()->json(
      [
      'status' =>'401',
      'msg' => 'Invalid Request'
      ]); 
      }
    }  // end of changepasswordinsert function 

    public function Aboutus(Request $request) // start of Aboutus function 
    {
     
       $ModelCalled = new Websrvc;
       $Aboutus = $ModelCalled->Aboutus();
       return $Aboutus;

    }  // end of aboutus function 

    public function GetPageLinks(Request $request) // start of aboutus function 
    {
      if($request->isMethod('POST'))
      { 
       $ModelCalled = new Websrvc;
       $GetPageLinks = $ModelCalled->GetPageLinks();
       return response()->json($GetPageLinks);
      } // check for method post
      else
      {
      return response()->json(
      [
      'status' =>'401',
      'msg' => 'Invalid Request'
      ]); 
      }
    }  // end of aboutus function 

    public function GetSupport(Request $request) // start of GetSupport function 
    {
      if($request->isMethod('POST'))
      { 
       $ModelCalled = new Websrvc;
       $GetSupport = $ModelCalled->GetSupport();
       return response()->json($GetSupport);
      } // check for method post
      else
      {
      return response()->json(
      [
      'status' =>'401',
      'msg' => 'Invalid Request'
      ]); 
      }
    }  // end of GetSupport function   

    public function GetUserInfo(Request $request) // start of GetUserInfo function 
    { 
      if($request->isMethod('POST'))
      { 
       $user_uniqueid = $request->user_uniqueid;
       $ModelCalled = new Websrvc;
       $GetUserInfo = $ModelCalled->GetUserInfo($user_uniqueid);
       return response()->json($GetUserInfo);
      } // check for method post
      else
      {
      return response()->json(
      [
      'status' =>'401',
      'msg' => 'Invalid Request'
      ]); 
      }
    }  // end of GetUserInfo function 

    public function EditUserInfo(Request $request) // start of EditUserInfo function 
    { 
      if($request->isMethod('POST'))
      { 
       $user_uniqueid = $request->user_uniqueid;
       $first_name = $request->first_name;
       $last_name = $request->last_name;
       $gender = $request->gender;
       $dob = $request->dob;  
       $phone = $request->phone;
       $lng_type = $request->lng_type;

       $ModelCalled = new Websrvc;
       $EditUserInfo = $ModelCalled->EditUserInfo($user_uniqueid,$first_name,$last_name,$gender,$dob,$phone,$lng_type);
       return response()->json($EditUserInfo);
      } // check for method post
      else
      {
      return response()->json(
      [
      'status' =>'401',
      'msg' => 'Invalid Request'
      ]); 
      }
    }  // end of EditUserInfo function   

    public function UpdatePassword(Request $request) // start of UpdatePassword function 
    { 
      if($request->isMethod('POST'))
      { 
       $user_uniqueid = $request->user_uniqueid;
       $old_password = $request->old_password;
       $new_password = $request->new_password;
       $confirm_password = $request->confirm_password;

       $ModelCalled = new Websrvc;
       $UpdatePassword = $ModelCalled->UpdatePassword($user_uniqueid,$old_password,$new_password,$confirm_password);
       return response()->json($UpdatePassword);
      } // check for method post
      else
      {
      return response()->json(
      [
      'status' =>'401',
      'msg' => 'Invalid Request'
      ]); 
      }
    }  // end of UpdatePassword function 

    public function GetUserWallet(Request $request) // start of GetUserWallet function 
    { 
      if($request->isMethod('POST'))
      { 
       $user_uniqueid = $request->user_uniqueid;

       $ModelCalled = new Websrvc;
       $GetUserWallet = $ModelCalled->GetUserWallet($user_uniqueid);
       return response()->json($GetUserWallet);
      } // check for method post
      else
      {
      return response()->json(
      [
      'status' =>'401',
      'msg' => 'Invalid Request'
      ]); 
      }
    }  // end of GetUserWallet function   

    public function OrderReportProblem(Request $request) // start of OrderReportProblem function 
    { 
      if($request->isMethod('POST'))
      { 
       $user_uniqueid = $request->user_uniqueid;
       $order_id = $request->order_id;
       $title = $request->title;
       $comment = $request->detail;

       $ModelCalled = new Websrvc;
       $OrderReportProblem = $ModelCalled->OrderReportProblem($user_uniqueid,$order_id,$title,$comment);
       return response()->json($OrderReportProblem);
      } // check for method post
      else
      {
      return response()->json(
      [
      'status' =>'401',
      'msg' => 'Invalid Request'
      ]); 
      }
    }  // end of OrderReportProblem function   

    public function AddAddress(Request $request) // start of AddAddress function 
    { 
      if($request->isMethod('POST'))
      { 
       $update_id = $request->address_id;
       $user_uniqueid = $request->user_uniqueid;
       $address_title = $request->address_title;
       $area_id = $request->area_id;
       $block = $request->block;
       $street = $request->street;
       $avenue = $request->avenue;
       $house = $request->house;
       $phone = $request->phone;

       $ModelCalled = new Websrvc;
       $AddAddress = $ModelCalled->AddAddress($user_uniqueid,$address_title,$area_id,$block,$street,$avenue,$house,$phone,$update_id);
       return response()->json($AddAddress);
      } // check for method post
      else
      {
      return response()->json(
      [
      'status' =>'401',
      'msg' => 'Invalid Request'
      ]); 
      }
    }  // end of AddAddress function 
 
   

    public function GetAddressList(Request $request) // start of GetAddressList function 
    { 
      if($request->isMethod('POST'))
      { 
       $user_uniqueid = $request->user_uniqueid;
       $ModelCalled = new Websrvc;
       $GetAddressList = $ModelCalled->GetAddressList($user_uniqueid);
       return response()->json($GetAddressList);
      } // check for method post
      else
      {
      return response()->json(
      [
      'status' =>'401',
      'msg' => 'Invalid Request'
      ]); 
      }
    }  // end of GetAddressList function 

    public function MarkAsDefaultAdd(Request $request) // start of MarkAsDefaultAddr function 
    { 
      if($request->isMethod('POST'))
      { 
       $user_uniqueid = $request->user_uniqueid;
       $address_id = $request->address_id;
       if($user_uniqueid != "" && $address_id != "")
       {
          $ModelCalled = new Websrvc;
          $MarkAsDefaultAdd = $ModelCalled->MarkAsDefaultAdd($user_uniqueid,$address_id);
          return response()->json($MarkAsDefaultAdd);
       }
       else
       {
        return response()->json(
          [
          'status' =>'401',
          'msg' => 'All field are required.'
          ]);
       }
     
      } // check for method post
      else
      {
      return response()->json(
      [
      'status' =>'401',
      'msg' => 'Invalid Request'
      ]); 
      }
    }  // end of MarkAsDefaultAddr function   

    public function GetPlanDietList(Request $request) // start of GetPlanDietList function 
    { 
      if($request->isMethod('POST'))
      { 
       $type = $request->type; // MONTHLY,PACKAGE,WEEKLY
       $gender = $request->gender; // MONTHLY,PACKAGE,WEEKLY
       $user_uniqueid = $request->user_uniqueid;
      
      if($type != "")
      {
        $ModelCalled = new Websrvc;
        $GetPlanDietList = $ModelCalled->GetPlanDietList($type,$gender,$user_uniqueid);
        return response()->json($GetPlanDietList);
      }
      else
      {
        return response()->json(
          [
          'status' =>'401',
          'msg' => 'All field are required.'
          ]);
      }

      } // check for method post
      else
      {
        return response()->json(
        [
        'status' =>'401',
        'msg' => 'Invalid Request'
        ]); 
      }
    }  // end of GetPlanDietList function

   

    public function GetPlanCalenderDetails(Request $request) // start of GetPlanCalenderDetails function 
    { 
      if($request->isMethod('POST'))
      { 
       $package_id = $request->package_id;
       $plan_id = $request->plan_id;
       if($plan_id!='' || $package_id!='')
       {
        $ModelCalled = new Websrvc;
        $GetPlanCalenderDetails = $ModelCalled->GetPlanCalenderDetails($plan_id , $package_id);
        return response()->json($GetPlanCalenderDetails);
       }
       else  
       {
        return response()->json(
          [
          'status' =>'401',
          'msg' => 'All field are required.'
          ]);
       }
       
      } // check for method post
      else
      {
      return response()->json(
      [
      'status' =>'401',
      'msg' => 'Invalid Request'
      ]); 
      }
    }  // end of GetPlanCalenderDetails function  

    public function Random_Meal(Request $request) // start of GetPlanCalenderDetails function 
    { 
      if($request->isMethod('POST'))
      { 
       $date = array();
       $plan_id = array();
       $plan_id = $request->plan_id;
       $date = $request->date;
       if(count($plan_id) && count($date) > 0 )
       {
        $ModelCalled = new Websrvc;
        $GetPlanCalenderDetails = $ModelCalled->Random_Meal($plan_id,$date);
        return response()->json($GetPlanCalenderDetails);
       }
       else  
       {
        return response()->json(
          [
          'status' =>'401',
          'msg' => 'All field are required.'
          ]);
       }
       
      } // check for method post
      else
      {
      return response()->json(
      [
      'status' =>'401',
      'msg' => 'Invalid Request'
      ]); 
      }
    }  // end of GetPlanCalenderDetails function  

    public function GetPlanMenuDetails(Request $request) // start of GetPlanMenuDetails function 
    { 
      if($request->isMethod('POST'))
      { 
       $plan_id = $request->plan_id;
       $date = $request->date;
       if($plan_id != '' && $date != '')
       {
        $ModelCalled = new Websrvc;
        $GetPlanMenuDetails = $ModelCalled->GetPlanMenuDetails($plan_id,$date);
        return response()->json($GetPlanMenuDetails);
       }
       else  
       {
        return response()->json(
          [
          'status' =>'401',
          'msg' => 'All field are required.'
          ]);
       }
       
      } // check for method post
      else
      {
      return response()->json(
      [
      'status' =>'401',
      'msg' => 'Invalid Request'
      ]); 
      }
    }  // end of GetPlanMenuDetails function  

    public function GetPlanMealDetails(Request $request) // start of GetPlanMealDetails function 
    { 
      if($request->isMethod('POST'))
      { 
       $plan_id = $request->plan_id;
       $date = $request->date;
       $menu_id = $request->menu_id;
       if($plan_id != '' && $date != '' && $menu_id != '')
       {
        $ModelCalled = new Websrvc;
        $GetPlanMealDetails = $ModelCalled->GetPlanMealDetails($plan_id,$date,$menu_id);
        return response()->json($GetPlanMealDetails);
       }
       else  
       {
        return response()->json(
          [
          'status' =>'401',
          'msg' => 'All field are required.'
          ]);
       }
       
      } // check for method post
      else
      {
      return response()->json(
      [
      'status' =>'401',
      'msg' => 'Invalid Request'
      ]); 
      }
    }  // end of GetPlanMealDetails function  

    public function GetPlanDietDetails(Request $request) // start of GetPlanDietDetails function 
    { 
      if($request->isMethod('POST'))
      { 
       $plan_id = $request->plan_id;
       if($plan_id!='')
       {
        $ModelCalled = new Websrvc;
        $GetPlanDietDetails = $ModelCalled->GetPlanDietDetails($plan_id);
        return response()->json($GetPlanDietDetails);
       }
       else  
       {
        return response()->json(
          [
          'status' =>'401',
          'msg' => 'All field are required.'
          ]);
       }
       
      } // check for method post
      else
      {
      return response()->json(
      [
      'status' =>'401',
      'msg' => 'Invalid Request'
      ]); 
      }
    }  // end of GetPlanDietDetails function

    public function checkout(Request $request) // start of checkout function 
    { 
      if($request->isMethod('POST'))
      {  
         $meal_data = array();
         $usersOffList = array();   
         $dislike_ids = array();   
         $allergy_ids = array();   
         $timing = array();   

         $user_uniqueid = $request->user_uniqueid; 
         $user_full_name = $request->full_name; 
         $user_email = $request->email; 
         $add_id = $request->add_id; 
         $order_id = $request->order_id; 

         $card_id  = $request->card_id ; 
         $card_token  = $request->card_token ; 

         $timing = $request->timing; 
         $code = $request->code;
         $plan_id = $request->plan_id;
         $package_id = $request->package_id;

         $meal_data = $request->meal_data;
         $usersOffList = $request->usersOffList;
         $dislike_ids = $request->dislike_ids;
         $allergy_ids = $request->allergy_ids;

            $ModelCalled = new Websrvc;
            $checkout = $ModelCalled->checkout($user_uniqueid,$user_full_name,$user_email,$add_id,$timing,$code,$plan_id,$meal_data,$usersOffList,$dislike_ids,$allergy_ids,$card_id,$card_token,$order_id , $package_id);

            return response()->json($checkout);
         
      } // check for method post
      else
      {
      return response()->json(
      [
      'status' =>'401',
      'msg' => 'Invalid Request'
      ]); 
      }
    }  // end of checkout function

    public function GetServiceFee(Request $request)
    {
      if($request->isMethod('post'))
      {     
        $user_uniqueid = $request->user_uniqueid; 
        $diet_center_id = $request->diet_center_id;
        $address_id = $request->address_id;
        $package_id = $request->package_id;

        if($user_uniqueid!='')
        {
          $ModelCalled = new Websrvc;
          $GetServiceFee = $ModelCalled->GetServiceFee($user_uniqueid,$diet_center_id,$address_id,$package_id);
          return response()->json($GetServiceFee);
        }
        else
        {
          return response()->json(
            [
            'status' =>'401',
            'msg' => 'All field are required sdfd.'
            ]);
        }
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

    public function GetfilterDietCenterList(Request $request) // start of GetfilterDietCenterList function 
    { 
      if($request->isMethod('POST'))
      { 
       $user_uniqueid = $request->user_uniqueid; // MONTHLY,PACKAGE,WEEKLY
       $type = $request->type; // MONTHLY,PACKAGE,WEEKLY
      if($type != "")
      {
        $ModelCalled = new Websrvc;
        $GetfilterDietCenterList = $ModelCalled->GetfilterDietCenterList($type,$user_uniqueid);
        return response()->json($GetfilterDietCenterList);
      }
      else
      {
        return response()->json(
          [
          'status' =>'401',
          'msg' => 'All field are required.'
          ]);
      }

      } // check for method post
      else
      {
        return response()->json(
        [
        'status' =>'401',
        'msg' => 'Invalid Request'
        ]); 
      }
    }  // end of GetfilterDietCenterList function   

    public function GetFilterPlanList(Request $request) // start of GetFilterPlanList function 
    { 
      if($request->isMethod('POST'))
      { 
       $type = $request->type; // MONTHLY,PACKAGE,WEEKLY
       $vendor_id = $request->diet_center_id; 
      if($type != "" && $vendor_id != '')
      {
        $ModelCalled = new Websrvc;
        $GetFilterPlanList = $ModelCalled->GetFilterPlanList($type,$vendor_id);
        return response()->json($GetFilterPlanList);
      }
      else
      {
        return response()->json(
          [
          'status' =>'401',
          'msg' => 'All field are required.'
          ]);
      }

      } // check for method post
      else
      {
        return response()->json(
        [
        'status' =>'401',
        'msg' => 'Invalid Request'
        ]); 
      }
    }  // end of GetFilterPlanList function

    public function DeleteAddress(Request $request)
    {
        if($request->isMethod('POST'))
        { 
        $add_id = $request->address_id; // MONTHLY,PACKAGE,WEEKLY
        if($add_id != "")
        {
          $ModelCalled = new Websrvc;
          $DeleteAddress = $ModelCalled->DeleteAddress($add_id);
          return response()->json($DeleteAddress);
        }
        else
        {
          return response()->json(
            [
            'status' =>'401',
            'msg' => 'All field are required.'
            ]);
        }

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

    public function CurrentOrder(Request $request)  // start of CurrentOrder function 
    {
        if($request->isMethod('POST'))
        { 
        $user_uniqueid = $request->user_uniqueid; 
        if($user_uniqueid != "")
        {
          $ModelCalled = new Websrvc;
          $CurrentOrder = $ModelCalled->CurrentOrder($add_id);
          return response()->json($CurrentOrder);
        }
        else
        {
          return response()->json(
            [
            'status' =>'401',
            'msg' => 'All field are required.'
            ]);
        }

        } // check for method post
        else
        {
          return response()->json(
          [
          'status' =>'401',
          'msg' => 'Invalid Request'
          ]); 
        }
    }          // end of CurrentOrder function

    public function Get_Fixed_Menu_Details(Request $request) // start of Get_Fixed_Menu_Details function 
    { 
      if($request->isMethod('POST'))
      { 
       $plan_id = $request->plan_id;
       $package_id = $request->package_id;
      
        $ModelCalled = new Websrvc;
        $GetPlanCalenderDetails = $ModelCalled->Get_Fixed_Menu_Details( $plan_id , $package_id);
        return response()->json($GetPlanCalenderDetails);
      
      } // check for method post
      else
      {
      return response()->json(
      [
      'status' =>'401',
      'msg' => 'Invalid Request'
      ]); 
      }
    }  // end of GetPlanCalenderDetails function   

    public function Get_Plan_Filter_List(Request $request) // start of Get_Plan_Filter_List function 
    { 
      if($request->isMethod('POST'))
      { 
        $user_uniqueid = $request->user_uniqueid;
        $type = $request->type;
        $ModelCalled = new Websrvc;
        $Get_Plan_Filter_List = $ModelCalled->Get_Plan_Filter_List($user_uniqueid,$type);
        return response()->json($Get_Plan_Filter_List);
       
      } // check for method post
      else
      {
      return response()->json(
      [
      'status' =>'401',
      'msg' => 'Invalid Request'
      ]); 
      }
    }  // end of Get_Plan_Filter_List function  

    public function Get_Filter_Result(Request $request) // start of Get_Filter_Result function 
    { 
      if($request->isMethod('POST'))
      {  
        $diet_center_ids = [];
        $plan_filter_ids = [];

        $type = $request->type;
        $gender = $request->gender;
        $diet_center_ids = $request->diet_center_ids;
        $plan_filter_ids = $request->plan_filter_ids;
        $user_uniqueid = $request->user_uniqueid;

        if($type != '')
        {
          $ModelCalled = new Websrvc;
          $Get_Filter_Result = $ModelCalled->Get_Filter_Result($type,$gender,$diet_center_ids,$plan_filter_ids,$user_uniqueid);
          return response()->json($Get_Filter_Result);
        }
        else
        {
          return response()->json(
            [
            'status' =>'401',
            'msg' => 'All fields are required.'
            ]);
        }
       
       
      } // check for method post
      else
      {
      return response()->json(
      [
      'status' =>'401',
      'msg' => 'Invalid Request'
      ]); 
      }
    }  // end of Get_Filter_Result function    

    public function Clear_filter(Request $request) // start of Get_Filter_Result function 
    { 
      if($request->isMethod('POST'))
      {
        $user_uniqueid = $request->user_uniqueid;

        if($user_uniqueid != '')
        {
          $ModelCalled = new Websrvc;
          $Clear_filter = $ModelCalled->Clear_filter($user_uniqueid);
          return response()->json($Clear_filter);
        }
        else
        {
          return response()->json(
            [
            'status' =>'401',
            'msg' => 'All fields are required.'
            ]);
        }
       
       
      } // check for method post
      else
      {
      return response()->json(
      [
      'status' =>'401',
      'msg' => 'Invalid Request'
      ]); 
      }
    }  // end of Get_Filter_Result function

    public function User_Save_Nutrition(Request $request) // start of User_Save_Nutrition function 
    { 
      if($request->isMethod('POST'))
      {
        $user_uniqueid = $request->user_uniqueid;
        $height = $request->height;
        $weight = $request->weight;

        if($user_uniqueid != '' && $height !='' && $weight!='')
        {
          $ModelCalled = new Websrvc;
          $User_Save_Nutrition = $ModelCalled->User_Save_Nutrition($user_uniqueid,$height,$weight);
          return response()->json($User_Save_Nutrition);
        }
        else
        {
          return response()->json(
            [
            'status' =>'401',
            'msg' => 'All fields are required.'
            ]);
        }
       
       
      } // check for method post
      else
      {
      return response()->json(
      [
      'status' =>'401',
      'msg' => 'Invalid Request'
      ]); 
      }
    }  // end of User_Save_Nutrition function  

    public function User_Get_Nutrition(Request $request) // start of Get_Nutrition function 
    { 
      if($request->isMethod('POST'))
      {
        $user_uniqueid = $request->user_uniqueid;

        if($user_uniqueid != '')
        {
          $ModelCalled = new Websrvc;
          $User_Get_Nutrition = $ModelCalled->User_Get_Nutrition($user_uniqueid);
          return response()->json($User_Get_Nutrition);
        }
        else
        {
          return response()->json(
            [
            'status' =>'401',
            'msg' => 'All fields are required.'
            ]);
        }
       
       
      } // check for method post
      else
      {
      return response()->json(
      [
      'status' =>'401',
      'msg' => 'Invalid Request'
      ]); 
      }
    }  // end of Get_Nutrition function 

    public function faq(Request $request) // start of Get_Nutrition function 
    { 
      if($request->isMethod('POST'))
      {
       
          $ModelCalled = new Websrvc;
          $faq = $ModelCalled->faq();
          return response()->json($faq);
        
      } // check for method post
      else
      {
      return response()->json(
      [
      'status' =>'401',
      'msg' => 'Invalid Request'
      ]); 
      }
    }  // end of Get_Nutrition function 

    public function Dislikes_and_Allergies(Request $request) // start of Get_Nutrition function 
    { 
      if($request->isMethod('POST'))
      {
       
          $ModelCalled = new Websrvc;
          $Dislikes_and_Allergies = $ModelCalled->Dislikes_and_Allergies();
          return response()->json($Dislikes_and_Allergies);
        
      } // check for method post
      else
      {
      return response()->json(
      [
      'status' =>'401',
      'msg' => 'Invalid Request'
      ]); 
      }
    }  // end of Get_Nutrition function 
    
    public function Apply_Promo_Code(Request $request) // start of Get_Nutrition function 
    { 
      if($request->isMethod('POST'))
      {
          $user_uniqueid = $request->user_uniqueid;
          $sub_total_amount = $request->sub_total_amount;
          $promo_code = $request->promo_code;

          if($user_uniqueid != '' && $sub_total_amount != '' && $promo_code != '')
          {
            $ModelCalled = new Websrvc;
            $Apply_Promo_Code = $ModelCalled->Apply_Promo_Code($user_uniqueid,$sub_total_amount,$promo_code);
            return response()->json($Apply_Promo_Code);
          }
          else
          {
            return response()->json(
              [
              'status' =>'401',
              'msg' => 'All fields are required.'
              ]);
          }
        
      } // check for method post
      else
      {
      return response()->json(
      [
      'status' =>'401',
      'msg' => 'Invalid Request'
      ]); 
      }
    }  // end of Get_Nutrition function 

    public function show_packages_and_social(Request $request) // start of show_packages_and_social function 
    { 
      if($request->isMethod('POST'))
      {
            $ModelCalled = new Websrvc;
            $show_packages_and_social = $ModelCalled->show_packages_and_social();
            return response()->json($show_packages_and_social);
      } // check for method post
      else
      {
      return response()->json(
      [
      'status' =>'401',
      'msg' => 'Invalid Request'
      ]); 
      }
    }  // end of show_packages_and_social function 

    public function order_list(Request $request) // start of order_list function 
    { 
      if($request->isMethod('POST'))
      {  
            $user_uniqueid = $request->user_uniqueid;
            if($user_uniqueid!='')
            {
              $ModelCalled = new Websrvc;
              $order_list = $ModelCalled->order_list($user_uniqueid);
              return response()->json($order_list);
            }
            else
            {
              return response()->json(
                [
                'status' =>'401',
                'msg' => 'All fields are required.'
                ]); 
            }
      } // check for method post
      else
      {
      return response()->json(
        [
        'status' =>'401',
        'msg' => 'Invalid Request'
        ]); 
      }
    }  // end of order_list function 

    public function advertisement(Request $request) // start of order_list function 
    { 
      if($request->isMethod('POST'))
      {  
       
          $ModelCalled = new Websrvc;
          $advertisement = $ModelCalled->advertisement();
          return response()->json($advertisement);
           
      } // check for method post
      else
      {
      return response()->json(
        [
        'status' =>'401',
        'msg' => 'Invalid Request'
        ]); 
      }
    }  // end of order_list function 

    public function add_credit_card(Request $request) // start of add_credit_card function 
    { 
      if($request->isMethod('POST'))
      {  
            $user_uniqueid = $request->user_uniqueid;
            $last_digits = $request->last_digits;
            $expiry_month = $request->expiry_month;
            $expiry_year = $request->expiry_year;
            $holder_name = $request->holder_name;
            $brand = $request->brand;
            $card_token = $request->card_token;

            if($user_uniqueid!='' && $last_digits!='' && $expiry_month!='' && $expiry_year!='' && $holder_name!='' && $brand!='' && $card_token!='')
            {
              $ModelCalled = new Websrvc;
              $add_credit_card = $ModelCalled->add_credit_card($user_uniqueid , $last_digits , $expiry_month , $expiry_year , $holder_name , $brand , $card_token);
              return response()->json($add_credit_card);
            }
            else
            {
              return response()->json(
                [
                'status' =>'401',
                'msg' => 'All fields are required.'
                ]); 
            }
      } // check for method post
      else
      {
      return response()->json(
        [
        'status' =>'401',
        'msg' => 'Invalid Request'
        ]); 
      }
    }  // end of add_credit_card function 

     public function card_list(Request $request) // start of add_credit_card function 
    { 
      if($request->isMethod('POST'))
      {  
            $user_uniqueid = $request->user_uniqueid;

            if($user_uniqueid!='')
            {
              $ModelCalled = new Websrvc;
              $add_credit_card = $ModelCalled->card_list($user_uniqueid);
              return response()->json($add_credit_card);
            }
            else
            {
              return response()->json(
                [
                'status' =>'401',
                'msg' => 'All fields are required.'
                ]); 
            }
      } // check for method post
      else
      {
      return response()->json(
        [
        'status' =>'401',
        'msg' => 'Invalid Request'
        ]); 
      }
    }  // end of add_credit_card function 

    public function delete_card(Request $request) // start of add_credit_card function 
    { 
      if($request->isMethod('POST'))
      {  
            $card_id = $request->card_id;

            if($card_id!='')
            {
              $ModelCalled = new Websrvc;
              $delete_card = $ModelCalled->delete_card($card_id);
              return response()->json($delete_card);
            }
            else
            {
              return response()->json(
                [
                'status' =>'401',
                'msg' => 'All fields are required.'
                ]); 
            }
      } // check for method post
      else
      {
      return response()->json(
        [
        'status' =>'401',
        'msg' => 'Invalid Request'
        ]); 
      }
    }  // end of add_credit_card function 

    public function order_detail(Request $request)
    {
      if($request->isMethod('POST'))
      {   
            $user_uniqueid = $request->user_uniqueid;
            $order_id = $request->order_id;
            $order_type = $request->order_type;

            if($user_uniqueid!='' && $order_id!='' && $order_type!='')
            {
              $ModelCalled = new Websrvc;
              $order_detail = $ModelCalled->order_detail($user_uniqueid , $order_id , $order_type);
              return response()->json($order_detail);
            }
            else
            {
              return response()->json(
                [
                'status' =>'401',
                'msg' => 'All fields are required.'
                ]); 
            }
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

    

}     // end of class     
