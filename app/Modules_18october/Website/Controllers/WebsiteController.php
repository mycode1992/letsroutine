<?php

namespace App\Modules\Website\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Admin\Models\Admin;
use DB;
use View;
use Session;
class WebsiteController extends Controller
{
    public function __construct()
    {
      $this->middleware(function ($request, $next){
           
            $session_all = Session::get('sessionvendor');
            if(!empty($session_all)>0)
            {   
                $sessionuserid = $session_all['userid'];
            }
            else
            {   
                $sessionuserid = '';
            }
            View::share('sessionuserid',$sessionuserid);
            return $next($request);
        });
    }

    public function index()
    {   
        return view("Website::index");
    }
    public function about_us()
    {
        $data = DB::table('tbl_lr_cms')->select('lr_cms_description')
        ->where('lr_cms_id',1)->get();
        return view("Website::about",compact('data'));
    }
    public function terms_condition()
    {
        $data = DB::table('tbl_lr_cms')->select('lr_cms_description')
        ->where('lr_cms_id',2)->get();
        return view("Website::terms_condition",compact('data'));
    }
    public function privacy_policy()
    {
        $data = DB::table('tbl_lr_cms')->select('lr_cms_description')
        ->where('lr_cms_id',3)->get();
        return view("Website::privacy_policy",compact('data'));
    }
    public function contact()
    {
        return view("Website::contact");
    }

    public function storecontact(Request $request)
    {
        if($request->isMethod('POST')){
        $name = ucfirst(trim($request->name));
        $email = trim($request->email);
        $message = $request->message; 
        $ip_address =  \Request::ip(); 
        $curDate = new \DateTime();

        if($name !='' && $email !=''  && $message !='')
        {
       
        if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
        return response()->json(
        [
        'status' =>'401',
        'msg' => 'Only letters and white space allowed'
        ]);
        }

        // check if e-mail address is well-formed    
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return response()->json(
        [
        'status' =>'401',
        'msg' => 'Invalid e-mail address'
        ]);
        }
 
        $sql = DB::table('tbl_lr_contactus')->insert([
        'lr_contactus_name' => ucfirst($name),
        'lr_contactus_email' => $email,
        'lr_contactus_message' => ucfirst($message),
        'lr_contactus_ip' => $ip_address,
        'lr_contactus_created_at' => $curDate
        ]);
                
        if($sql==true)
        {
        $sendemail= contactemail($name);
        return response()->json(
        [
        'status' =>'200',
        'msg' => 'Thank You! Your enquiry has been submitted successfully,We will get back to you Soon!'
        ]);  
        }
        else
        {
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

    public function faq()
    {
        $data = DB::table('tbl_lr_cms')->select('lr_cms_description')
        ->where('lr_cms_id',4)->get();
        return view("Website::faq",compact('data'));
    }
    public function signup()
    {
        return view("Website::signup");
    }
   
    
    

    public function register(Request $request){
        if($request->isMethod('POST'))
        {
        $diet_centre_name =  ucfirst($request->diet_centre_name);
        $fname =  ucfirst($request->fname);
        $lname =  ucfirst($request->lname);
        $phone =  $request->phone;
        $email =  $request->email;
        $password =  $request->password;
        $diet_centre_addr =  ucfirst($request->diet_centre_addr);
        $imageidd = $request->file('coverimage'); 
        $role_id = '2';

        $obj = new Admin;
        $data = $obj->register($diet_centre_name,$fname,$lname,$phone,$email,$password,$diet_centre_addr,$imageidd,$role_id); 
        return $data;   
        }
        else
        {
        return response()->json(
        [
        'status' =>'401',
        'msg' => 'Invalid request, please try again'
        ]);
        }
    }


  

    
}
