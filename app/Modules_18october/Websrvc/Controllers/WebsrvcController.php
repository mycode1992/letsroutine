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
 
   

  



   
}// end of class
