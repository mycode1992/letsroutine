<?php 
namespace App\Modules\Vendor\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use Illuminate\Support\Facades\Redirect;
use DB;
use View;

class VendorController extends Controller
{
   
    public function __construct()
    {
            $this->middleware(function ($request, $next){
            $session_all = Session::get('sessionvendor');

            $sessionuserid = $session_all['userid'];
            $sql_name = DB::table('tbl_lr_user')->select('lr_user_name')->where('lr_user_userid',$sessionuserid)->get();

            $sql_sel = DB::table('tbl_lr_userdetail')->select('lr_userdetail_profile')->where('lr_user_userid',$sessionuserid)->get();
    
            $uri_path = $_SERVER['REQUEST_URI']; 
            $uri_parts = explode('/', $uri_path);
            $last_url = end($uri_parts); 
    
            View::share('sessionuserid',$sessionuserid);
            View::share('sql_name',$sql_name);
            View::share('sql_sel',$sql_sel);
            View::share('last_url',$last_url);

            return $next($request);
        });
    }

   
    public function logout(){
        Session::forget('sessionvendor','userid','role_id','email','name');
        return Redirect::to('/login');
     exit();
    }

    public function myprofil()
    {
        $session_all=Session::get('sessionvendor');
        if($session_all==false)
        {
            return Redirect::to('/login');
            exit();
        } 

        $userid = $session_all['userid']; 
        $data = DB::table('tbl_lr_user AS t1')
                ->join('tbl_lr_userdetail AS t2','t1.lr_user_userid','t2.lr_user_userid')
                ->where('t1.lr_user_userid',$userid)
                ->select('t1.lr_user_userid','t1.lr_user_email','t2.lr_userdetail_fname','t2.lr_userdetail_lname','t2.lr_userdetail_phone','t2.lr_userdetail_centrename','t2.lr_userdetail_centreaddr','t2.lr_userdetail_area','t2.lr_userdetail_block','t2.lr_userdetail_street','t2.lr_userdetail_building_number','t2.lr_userdetail_office','t2.lr_userdetail_logo')->get();

        $governorate = DB::table('tbl_lr_governorate')->select('lr_governorate_id','lr_governorate_name')->where('admin_status','1')->get();

        return view("Vendor::myprofile",compact('data','governorate'));
    }


    public function current_order()
    {
      $curDate = new \DateTime();
      $curDate = $curDate->format('Y-m-d');

        $session_all=Session::get('sessionvendor');
       
        if($session_all==false)
        {
            return Redirect::to('/login');
            exit();
        }
        $sessionuserid = $session_all['userid'];

         $order_list_sql = DB::table('tbl_app_pre_order as pre_order')->join('tbl_app_order as order','order.app_pre_order_id','pre_order.app_pre_order_id')->join('tbl_lr_vendor_plan as vendor_plan','vendor_plan.vendor_plan_id','pre_order.vendor_plan_id')->join('tbl_app_user as user','user.user_uniqueid','pre_order.user_uniqueid')->where('vendor_plan.lr_user_id',$sessionuserid)->select('order.app_order_unique_id','pre_order.app_pre_order_id','user.app_user_fname','user.app_user_lname','order.created_at')->get();


        return view("Vendor::current_order", compact('order_list_sql'))->with('curDate',$curDate);
    }  


   public function order_history()
    {
       $curDate = new \DateTime();
      $curDate = $curDate->format('Y-m-d');

        $session_all=Session::get('sessionvendor');
       
        if($session_all==false)
        {
            return Redirect::to('/login');
            exit();
        }
        $sessionuserid = $session_all['userid'];

         $order_list_sql = DB::table('tbl_app_pre_order as pre_order')->join('tbl_app_order as order','order.app_pre_order_id','pre_order.app_pre_order_id')->join('tbl_lr_vendor_plan as vendor_plan','vendor_plan.vendor_plan_id','pre_order.vendor_plan_id')->join('tbl_app_user as user','user.user_uniqueid','pre_order.user_uniqueid')->where('vendor_plan.lr_user_id',$sessionuserid)->select('order.app_order_unique_id','pre_order.app_pre_order_id','user.app_user_fname','user.app_user_lname','order.created_at')->get();


        return view("Vendor::order_history", compact('order_list_sql'))->with('curDate',$curDate);
    }  
    

    public function menu_list()
    {  
        $session_all=Session::get('sessionvendor');
       
        if($session_all==false)
        {
            return Redirect::to('/login');
            exit();
        }
        $sessionuserid = $session_all['userid'];
        $data = DB::table('tbl_lr_vendor_menu')->where('admin_status','!=','2')->where('lr_user_id',$sessionuserid)->select('lr_unique_id','vendor_menu_name')->distinct('lr_unique_id')->orderBy('vendor_menu_id','desc')->get();
      
        return view("Vendor::menu_list",compact('data'));
       
    }

    public function menu_details($order_unique_id)
    {
        $session_all=Session::get('sessionvendor');
        if($session_all==false)
        {
            return Redirect::to('/login');
            exit();
        }
        if($order_unique_id!='')
        {
           $menuname = DB::table('tbl_lr_vendor_menu')->distinct('lr_unique_id')->where('lr_unique_id',$order_unique_id)->select('lr_unique_id','vendor_menu_name')->get();

           $data = DB::table('tbl_lr_vendor_menu')->where('lr_unique_id',$order_unique_id)->select('lr_unique_id','vendor_menu_category','vendor_menu_category_meal')->get();


           return view("Vendor::menu_details",compact('menuname','data'));
        }
        else
        {
          return view("Vendor::myprofile");
        }

        
    }


    public function offer()
    {   
        return view("Vendor::offer");
    }

    public function add_meal($id=null)
    {
        $session_all=Session::get('sessionvendor');
        if($session_all==false)
        {
            return Redirect::to('/login');
            exit();
        } 
        if($id!='')
        {
            $data = DB::table('tbl_lr_meal')->where('lr_meal_id',$id)->get();
            return view("Vendor::add_meal",compact('data'));
        }
        else
        {
            return view("Vendor::add_meal");
        }

        
    }

    public function meal_list()
    {  
        $session_all=Session::get('sessionvendor');
        if($session_all==false)
        {
            return Redirect::to('/login');
            exit();
        }
        $sessionuserid = $session_all['userid'];
        $data = DB::table('tbl_lr_meal')->where('admin_status','!=','2')->where('lr_user_userid',$sessionuserid)->select('lr_meal_id','lr_user_userid','lr_meal_name','lr_meal_calories','lr_meal_fat','lr_meal_carb','lr_meal_protein','lr_meal_description')->orderBy('lr_meal_id','desc')->get();
      
        return view("Vendor::meal_list",compact('data'));
    }

    public function package_info()
    {     
        $session_all=Session::get('sessionvendor');
        if($session_all==false)
        {
            return Redirect::to('/login');
            exit();
        }

        $session_all = Session::get('sessionvendor');
        $sessionuserid = $session_all['userid'];
        $data = DB::table('tbl_lr_vendor_package')->where('lr_user_id',$sessionuserid)->select('lr_package_id','package_name','vendor_plan_id','package_description','package_gender','package_price','admin_status')->orderBy('lr_package_id','desc')->get();

        return view("Vendor::package_info",compact('data'));    
    }

    

    public function plan_listing()
    {
        $session_all=Session::get('sessionvendor');
        if($session_all==false)
        {
            return Redirect::to('/login');
            exit();
        } 
        $session_all = Session::get('sessionvendor');
        $sessionuserid = $session_all['userid'];
        $data = DB::table('tbl_lr_vendor_plan')->where('lr_user_id',$sessionuserid)->select('status','vendor_plan_id','vendor_plan_name','admin_status')->orderBy('vendor_plan_id','desc')->get();
        return view("Vendor::plan_listing",compact('data'));
    }

    public function plan_viewdetail($id)
    {
        $session_all=Session::get('sessionvendor');
        if($session_all==false)
        {
            return Redirect::to('/login');
            exit();
        }
        $data = DB::table('tbl_lr_vendor_plan')->where('vendor_plan_id',$id)
        ->select('vendor_plan_name','vendor_plan_meals','vendor_plan_snacks','vendor_plan_macros','macros_yes_min_carb','macros_yes_max_carb','macros_yes_min_protein','macros_yes_max_protein','macros_yes_plan','macros_no_max_carb','macros_no_max_protein','vendor_plan_gendor','vendor_plan_pause','lr_plancategory_id','lr_plan_subcat_id','vendor_plan_duration','vendor_plan_offdays','vendor_plan_menu_type','custom_menu_vendor_menu_id')->get();
        return view("Vendor::plan_viewdetail",compact('data'));
    }
    public function setting()
    {  
        $session_all=Session::get('sessionvendor');
        if($session_all==false)
        {
            return Redirect::to('/login');
            exit();
        } 
        $session_all = Session::get('sessionvendor');
        $sessionuserid = $session_all['userid'];
        $data_lang = DB::table('_language')->get();
        
        $data = DB::table('tbl_lr_user AS t1')
                ->join('tbl_lr_userdetail AS t2','t1.lr_user_userid','t2.lr_user_userid')->where('t1.lr_user_userid',$sessionuserid)
                ->select('t2.lr_userdetail_lang')->get();
        return view("Vendor::setting",compact('data_lang','data'));
    }

    public function add_plan($id=null)
    {
        $session_all=Session::get('sessionvendor');
        if($session_all==false)
        {
            return Redirect::to('/login');
            exit();
        } 

        $userid = $session_all['userid']; 
        $category_plan = DB::table('tbl_lr_plancategory')->select('lr_plancategory_id','lr_plancategory_name')->where('admin_status','1')->get();
        $package_feature = DB::table('tbl_lr_package_feature')->select('id','name')->get();

        $menu_list = DB::table('tbl_lr_vendor_menu')->groupby('lr_unique_id')->distinct('lr_unique_id')->where('lr_user_id',$userid)->select('lr_unique_id','vendor_menu_id','vendor_menu_name')->get();
        # addmenu
        $menu_list_m = DB::table('tbl_lr_menu_category')->where('admin_status','1')->select('lr_category_id','lr_category_name')->get();
        $meal_list_m = DB::table('tbl_lr_meal')->select('lr_meal_id','lr_meal_name')->where('admin_status','1')->get(); 
        #end menu

        $plan_filter_list = DB::table('tbl_app_planfilter')->where('admin_status',1)->get();
    
        if($id!='')
        {
            $data = DB::table('tbl_lr_vendor_plan')->where('vendor_plan_id',$id)->select('vendor_plan_id','vendor_plan_name','vendor_plan_meals','vendor_plan_snacks','vendor_plan_macros','macros_yes_min_carb','macros_yes_max_carb','macros_yes_min_protein','macros_yes_max_protein','macros_yes_plan','macros_no_max_carb','macros_no_max_protein','vendor_plan_gendor','vendor_plan_pause','lr_plancategory_id','lr_plan_subcat_id','vendor_plan_duration','vendor_plan_offdays','vendor_plan_menu_type','custom_menu_vendor_menu_id','vendor_plan_type','plantype_weekly','plantype_weekly_packagefeature','cost_plan_package_feature','plan_cost','plan_description','app_planfilter_id','plan_image')->get();

            return view("Vendor::add_plan",compact('category_plan','menu_list','data','package_feature','menu_list_m','meal_list_m','plan_filter_list'));
        }
        else
        {
            return view("Vendor::add_plan",compact('category_plan','menu_list','package_feature','menu_list_m','meal_list_m','plan_filter_list'));
        }
       
    }
    public function save_custom_menu(Request $request)
    {
      if($request->isMethod('post'))
      { 
         $session_all = Session::get('sessionvendor');
         $sessionuserid = $session_all['userid'];
         $menu_name = $request->menu_name; 
         $menu_category = $request->menu_category;
         $lr_unique_id = date("YmdHis");
         #form validation
         if($menu_name=='')
         {
            return response()->json(
                [
                'status' =>'401',
                'msg' => 'Please enter menu name.'
                ]); 
         }
         if($menu_category=='')
         {
            return response()->json(
                [
                'status' =>'401',
                'msg' => 'Please select category first.'
                ]); 
         }
        #insert menu  
        $str = $request->menu_category;
        $returndata = array();
        $strArray = explode("&", $str);
        $i = 0;
        $array = array();
        for($i ; $i<count($strArray); $i++)
        {
          
            $array = explode("=", $strArray[$i]);
            $sql_insert = DB::table('tbl_lr_vendor_menu')->insert([
                            'lr_unique_id' => $lr_unique_id,
                            'vendor_menu_name' => $menu_name,
                            'lr_user_id' => $sessionuserid,
                            'vendor_menu_category' => $array[1],
                            //'vendor_menu_category_meal' => $v,
                            'admin_status' => '1'
                            ]);
            //echo $array[1]."<br>";
        }//end for loop
        if($sql_insert==true)
        {
            $menuid = DB::getPdo()->lastInsertId();
              return response()->json(
                  [
                  'status' =>'200',
                  'msg' => 'Menu inserted successfully.',
                  'data' => $array,
                  'menu_name' => $menu_name,
                  'menuid' => $menuid
                  ]);
           }
           else
           {
              return response()->json(
                  [
                  'status' =>'200',
                  'msg' => 'Something went wrong,Please try again later.',
                  'data' => ''
                  ]);
           }//end ifelse 
         
      }//end method post
      else
      {
        return response()->json(
        [
        'status' =>'401',
        'msg' => 'Invalid Request.',
        'data' => ''
        ]);
      }

    }
    public function changeplan_sub_cat(Request $request)
    {
        if($request->isMethod('post'))
      {    
       
       $plan_categoryid = $request->plan_categoryid;
     
       if($plan_categoryid!='')
       {
        $list_subcat = DB::table('tbl_lr_plansubcategory')->select('lr_plan_subcat_id','lr_plan_subcat_name')->where('lr_plancategory_id',$plan_categoryid)->get();
       
        return response()->json(
            [
            'status' =>'200',
            'list_subcat' => $list_subcat
            ]);
       }
       else
       {
        return response()->json(
            [
            'status' =>'401',
            'msg' => 'Please select category first.'
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

    public function save_plan(Request $request)
    {
        if($request->isMethod('POST'))
        {
          $session_all = Session::get('sessionvendor');
          $sessionuserid = $session_all['userid'];   

          $plan_name = $request->plan_name;
          $plan_description = $request->plan_description;
          $meal_count = $request->meal_count;
          $snack_count = $request->snack_count;
          $macros_carb_pro = $request->macros_carb_pro;
          $min_carb_macros_yes = $request->min_carb_macros_yes;
          $max_carb_macros_yes = $request->max_carb_macros_yes;
          $min_protien_macros_yes = $request->min_protien_macros_yes;
          $max_protien_macros_yes = $request->max_protien_macros_yes;
          $macros_yes_plan = $request->macros_yes_plan; 
          $max_carb_macros_no = $request->max_carb_macros_no;
          $max_protein_macros_no = $request->max_protein_macros_no;
          $gender = $request->gender;            
          $vendor_plan_pause = $request->vendor_plan_pause;
          $plan_category = $request->plan_category;
          $plan_sub_category = $request->plan_sub_category;
          $plan_duration = $request->plan_duration;
          $off_days = $request->off_days;
          $custom_fixed_menu = $request->custom_fixed_menu;
        //  $custom_menu_list = $request->custom_menu_list;
          $updateid = $request->updateid;

          $plan_type_week = $request->plan_type_week;
          $plan_type = $request->plan_type;
          $package_feature = $request->package_feature;
          $cost_plan_package_feature = $request->cost_plan_package_feature;
          $cost_plan = $request->cost_plan;
          $plan_filter = $request->selectedplan_filter;
          $imageidd = $request->file('plan_image'); 
          
          

          if($meal_count=='')
          {
            $meal_count = 0;
          }
          if($snack_count=='')
          {
            $snack_count = 0;
          }
          if($min_carb_macros_yes=='')
          {
            $min_carb_macros_yes = 0;
          }
          if($max_carb_macros_yes=='')
          {
            $max_carb_macros_yes = 0;
          }
          if($min_protien_macros_yes=='')
          {
            $min_protien_macros_yes = 0;
          }
          if($max_protien_macros_yes=='')
          {
            $max_protien_macros_yes = 0;
          }

          if($max_carb_macros_no=='')
          {
            $max_carb_macros_no = 0;
          }
          if($max_protein_macros_no=='')
          {
            $max_protein_macros_no = 0;
          }
        //   if($custom_menu_list=='-1')
        //   {
        //     $custom_menu_list = '';
        //   }
         
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
                 $dir = public_path().'/vendor/upload/plan_image/'; 
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

                try {
                    $sql_insert = DB::table('tbl_lr_vendor_plan')     
                    ->insert([            
                        'lr_user_id' => $sessionuserid ,
                        'vendor_plan_name' => $plan_name ,
                        'vendor_plan_meals' =>  $meal_count,
                        'vendor_plan_snacks' =>  $snack_count,
                        'vendor_plan_macros' =>  $macros_carb_pro,
                        'macros_yes_min_carb' => $min_carb_macros_yes ,
                        'macros_yes_max_carb' => $max_carb_macros_yes ,
                        'macros_yes_min_protein' =>  $min_protien_macros_yes,
                        'macros_yes_max_protein' =>  $max_protien_macros_yes,
                        'macros_yes_plan' =>  $macros_yes_plan,
                        'macros_no_max_carb' =>  $max_carb_macros_no,
                        'macros_no_max_protein' =>  $max_protein_macros_no,
                        'vendor_plan_gendor' =>  $gender,
                        'vendor_plan_pause' =>  $vendor_plan_pause,
                        'lr_plancategory_id' =>  $plan_category,
                        'lr_plan_subcat_id' =>  $plan_sub_category,
                        'vendor_plan_type' =>  $plan_type,
                        'plantype_weekly' =>  $plan_type_week,
                        'plantype_weekly_packagefeature' =>  $package_feature,
                        'cost_plan_package_feature' =>  $cost_plan_package_feature,
                        'vendor_plan_duration' =>  $plan_duration,
                        'vendor_plan_offdays' =>  $off_days,
                        'plan_cost' =>  $cost_plan,
                        'vendor_plan_menu_type' =>  $custom_fixed_menu,
                        'plan_description' =>  $plan_description,
                        'app_planfilter_id' =>  $plan_filter,
                        // 'custom_menu_vendor_menu_id' =>  $custom_menu_list,
                          'status' =>  '1',
                          'admin_status' =>  '0',
                          'plan_image' =>  $filename
                      ]);

                      return response()->json([
                          'status'=>'200',
                          'msg'=>'Inserted Successfully.'
                      ]); 

                  }catch (\Exception $e) {
                 
                  return response()->json([
                      'status'=>'401',
                      'msg'=>$e->getMessage()
                  ]); 
                  }
          }
          else
          {
            
            try{
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
                 $dir = public_path().'/vendor/upload/plan_image/'; 
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
                $filename_sql = DB::table('tbl_lr_vendor_plan')->where('vendor_plan_id',$updateid)->get(['plan_image']); 
                if(count($filename_sql) > 0)
                {
                 $filename = $filename_sql[0]->plan_image;
                }
                else
                {
                  $filename = '';
                }

             }
                $sql_update = DB::table('tbl_lr_vendor_plan')  
                ->where('vendor_plan_id',$updateid)   
                ->update([
                    'vendor_plan_name' => $plan_name ,
                    'vendor_plan_meals' =>  $meal_count,
                    'vendor_plan_snacks' =>  $snack_count,
                    'vendor_plan_macros' =>  $macros_carb_pro,
                    'macros_yes_min_carb' => $min_carb_macros_yes ,
                    'macros_yes_max_carb' => $max_carb_macros_yes ,
                    'macros_yes_min_protein' =>  $min_protien_macros_yes,
                    'macros_yes_max_protein' =>  $max_protien_macros_yes,
                    'macros_yes_plan' =>  $macros_yes_plan,
                    'macros_no_max_carb' =>  $max_carb_macros_no,
                    'macros_no_max_protein' =>  $max_protein_macros_no,
                    'vendor_plan_gendor' =>  $gender,
                    'vendor_plan_pause' =>  $vendor_plan_pause,
                    'lr_plancategory_id' =>  $plan_category,
                    'lr_plan_subcat_id' =>  $plan_sub_category,
                    'vendor_plan_type' =>  $plan_type,
                    'plantype_weekly' =>  $plan_type_week,
                    'plantype_weekly_packagefeature' =>  $package_feature,
                    'cost_plan_package_feature' =>  $cost_plan_package_feature,
                    'vendor_plan_duration' =>  $plan_duration,
                    'vendor_plan_offdays' =>  $off_days,
                    'plan_cost' =>  $cost_plan,
                    'vendor_plan_menu_type' =>  $custom_fixed_menu,
                    'plan_description' =>  $plan_description,
                    'app_planfilter_id' =>  $plan_filter,
                  //  'custom_menu_vendor_menu_id' =>  $custom_menu_list,
                    'admin_status' =>  '0',
                    'plan_image' =>  $filename
                ]);

                

                return response()->json([
                    'status'=>'200',
                    'msg'=>'Update Successfully.'
                ]); 
            }
            catch(Exception $e)
            {
            return response()->json([
            'status'=>'401',
            'msg'=>'Something went wrong, Please try again later.'
            ]);  
            }
           
            
          }
         
         }
         else
         {
         return response()->json([
         'status'=>'401',
         'msg'=>'Invalid Request.'
         ]); 
         } 
    }

   public function update_profile(Request $request)
   {
      if($request->isMethod('post'))
      {    // dd($request->all());   
       $userid = $request->userid;
       $fname = $request->fname; 
       $lname = $request->lname;
       $name = ucfirst($fname)." ".ucfirst($lname); 
       $phone = $request->phone;
       $email = $request->email;
       $area = $request->area;
       $block = $request->block;
       $street = $request->street;
       $building = $request->building;
       $office = $request->office;
       //$center_address = $request->center_address;
       $imageidd = $request->file('coverimage'); 
            
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
   else{ 
       $logo = DB::table('tbl_lr_userdetail')->select('lr_userdetail_logo') ->where('lr_user_userid',$userid)->get();

       $filename = $logo[0]->lr_userdetail_logo; 
   }

       if($fname!='' && $lname!='' && $phone!='' && $email!='' && $area !=''&& $block !=''&& $street !=''&& $building !='')
       {
       DB::beginTransaction();
       try {
        
            $sql_update1 = DB::table('tbl_lr_user')
                        ->where('lr_user_userid',$userid)
                        ->update([
                            'lr_user_name' => $name,
                            'lr_user_email' => $email
                        ]);
                        
            $sql_update2 = DB::table('tbl_lr_userdetail')
                        ->where('lr_user_userid',$userid)
                        ->update([
                        'lr_userdetail_fname' => $fname,
                        'lr_userdetail_lname' => $lname,
                        'lr_userdetail_phone' => $phone,
                        'lr_userdetail_area' => $area,
                        'lr_userdetail_block' => $block,
                        'lr_userdetail_street' => $street,
                        'lr_userdetail_building_number' => $building,
                        'lr_userdetail_office' => $office,
                        'lr_userdetail_logo' => $filename
                      ]);
            DB::commit();
            return response()->json(
            [
            'status' =>'200',
            'msg' => 'Updated successfully.'
            ]);
        } catch (\Exception $e) {
          
            DB::rollback();
            return response()->json(
                [
                'status' =>'401',
                'msg' => 'Something went wrong. Please try again later.'
                ]);
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

   public function profilepic(Request $request)
   {
       $imageidd = $request->file('profilepic'); 
       $session_all=Session::get('sessionvendor');
       $sessionuserid = $session_all['userid'];
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
       $dir = public_path().'/vendor/upload/profile/'; 
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
       $sql_update = DB::table('tbl_lr_userdetail')->where('lr_user_userid',$sessionuserid)
                            ->update(['lr_userdetail_profile' => $filename]);
       return response()->json(
        [
        'status' =>'200',
        'msg' => 'Profile updated successfully.'
        ]);
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
    
   public function change_password(Request $request)
   {
        if($request->isMethod('post'))
        {
            $session_all=Session::get('sessionvendor');
            $sessionuserid = $session_all['userid'];
            $language = $request->language;
            $password = $request->password;
            $old_password = $request->old_password;
            $con_password = $request->con_password;

            if($old_password!='' || $password!='' || $con_password!='')
        {
           $old_password = md5($old_password);
           $sql1 = DB::table('tbl_lr_user')
                  ->where('lr_user_userid',$sessionuserid)
                  ->where('lr_user_password',$old_password)->count();

           if($sql1>0)
           {
              $password = md5($password);
              if($password==$old_password)
              {
                return response()->json(
                    [
                    'status' =>'200',
                    'msg' => 'Password change successfully'
                    ]);
              }
              else
              {
                  DB::begintransaction();
                  try
                  {
                   $sql2 = DB::table('tbl_lr_user')
                   ->where('lr_user_userid',$sessionuserid)
                   ->update([
                    'lr_user_password'=>$password
                    ]);

                    $sql_updatelang = DB::table('tbl_lr_userdetail')
                    ->where('lr_user_userid',$sessionuserid)
                    ->update([
                     'lr_userdetail_lang'=>$language
                     ]);
                     DB::commit();
                    
                    return response()->json(
                    [
                    'status' =>'200',
                    'msg' => 'Updated successfully'
                    ]);
                   
                  }
                  catch(Exception $e)
                  {
                    DB::rollback();
                  return response()->json(
                  [
                  'status' =>'401',
                  'msg' => 'Something went wrong, please try again later'
                  ]);
                  }
                     
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
                $sql_updatelang = DB::table('tbl_lr_userdetail')
                ->where('lr_user_userid',$sessionuserid)
                ->update([
                 'lr_userdetail_lang'=>$language
                 ]);
                return response()->json(
                    [
                    'status' =>'200',
                    'msg' => 'Updated Successfully'
                    ]); 
            }

        }
        else
        {
            return response()->json([
            'status' => '401',
            'mag' => 'Invalid Request.' 
            ]);
        }
   }

   public function notification_and_announcement()
   {
        $session_all=Session::get('sessionvendor');
        if($session_all==false)
        {
        return Redirect::to('/login');
        exit();
        } 
        $sessionuserid = $session_all['userid'];
        $data = DB::table('tbl_lr_notifi_announc')
        ->where('admin_status','!=','2')
        ->orderBy('lr_notifi_announc_id','desc')
        ->select('lr_notifi_announc_id','lr_user_id','lr_notifi_announc_name','lr_notifi_announc_desp','lr_notifi_announc_date')->get();
        return view("Vendor::notification_and_announcement",compact('data'))->with('sessionuserid',$sessionuserid);
   }           

   public function report_problem()
   {    
    $session_all=Session::get('sessionvendor');
    if($session_all==false)
    {
        return Redirect::to('/login');
        exit();
    } 
    $session_all = Session::get('sessionvendor');
    $sessionuserid = $session_all['userid'];
    
    $data = DB::table('tbl_lr_report_prbl')
            ->where('lr_user_userid',$sessionuserid)
            ->orderBy('lr_id','desc')
            ->select('lr_id','lr_user_userid','lr_name','lr_title','lr_problem','lr_date')->get();

    
         return view("Vendor::Report_problem",compact('data'));
   } 

   public function save_problem(Request $request)
   {
       if($request->isMethod('post'))
       {
        $session_all=Session::get('sessionvendor');
        if($session_all==false)
        {
            return Redirect::to('/login');
            exit();
        } 

        $session_all = Session::get('sessionvendor');
        $sessionuserid = $session_all['userid'];
        $name = $request->name;
        $title = $request->title;
        $description = $request->description;
        $curDate = new \DateTime();

        if($name!=''|| $title!='' || $description!='')
        {
        $sql_insert = DB::table('tbl_lr_report_prbl')
                        ->insert([
                            'lr_user_userid' => $sessionuserid,
                            'lr_name' => $name,
                            'lr_title' => $title,
                            'lr_problem' => $description,
                            'lr_date' => $curDate
                        ]);
        if($sql_insert==true)
        {
        return response()->json([
        'status'=>'200',
        'msg'=>'Problem reported successfully.'
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
            'msg'=>'All fields are required.'
        ]);
        }
       }
       else
       {
           return response()->json([
               'status'=>'401',
               'msg'=>'Invalid Request.'
           ]);
       }
   }

   public function readmore(Request $request){
        
    if($request->isMethod('POST')){
       $tblname = $request->tblname;
       $id =  $request->id;
       $colnamewhere =  $request->colnamewhere;
       $colmsg =  $request->colmsg;  
   //   echo  $sql=DB::table($tblname')->where($colname,$id)->update([$colstatus =>$status]); exit;
        $sql = "select $colmsg from $tblname where $colnamewhere='$id'"; 
        $data = DB::select($sql);
        $data = json_decode(json_encode($data), True);
        if($data==true){ echo $data[0][$colmsg] ;}else{
        echo 'Something went wrong'; 
         }

        }
    }

    public function save_meal(Request $request)
    {
        if($request->isMethod('POST'))
        {
          $session_all = Session::get('sessionvendor');
          $sessionuserid = $session_all['userid'];
          $name_of_meal = $request->name_of_meal;
          $calories = $request->calories;
          $fat = $request->fat;
          $carb = $request->carb;
          $protien = $request->protien;
          $description = $request->description;
          $updateid = $request->updateid;
          $imageidd = $request->file('meal_image'); 
          if($calories=='')
          {
            $calories = 0;
          }
          if($fat=='')
          {
            $fat = 0;
          }
          if($carb=='')
          {
            $carb = 0;
          }
          if($protien=='')
          {
            $protien = 0;
          }
         
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
                 $dir = public_path().'/vendor/upload/meal_image/'; 
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
               return response()->json([
                'status'=>'401',
                'msg'=>'Please Add Image.'
              ]); 
             }

            if($name_of_meal!='' && $description!='')
            {
              $sql_insert = DB::table('tbl_lr_meal')     
                          ->insert([
                              'lr_user_userid' => $sessionuserid ,
                              'lr_meal_name' => $name_of_meal ,
                              'lr_meal_calories' =>  $calories,
                              'lr_meal_fat' =>  $fat,
                              'lr_meal_carb' =>  $carb,
                              'lr_meal_protein' => $protien ,
                              'lr_meal_description' =>  $description,
                              'lr_meal_image' =>  $filename,
                              'admin_status' =>  '1'
                          ]);
                  if($sql_insert==true)
                  {
                  return response()->json([
                  'status'=>'200',
                  'msg'=>'Inserted Successfully.'
                  ]); 
                  }
                  else
                  {
                  return response()->json([
                  'status'=>'401',
                  'msg'=>'Something went wrong,Please try again later.'
                  ]); 
                  }
                }
                else
                {
                return response()->json([
                'status'=>'401',
                'msg'=>'Name of meal and description are required fields.'
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
             $dir = public_path().'/vendor/upload/meal_image/'; 
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
                $filename_sql  = DB::table('tbl_lr_meal')->where('lr_meal_id',$updateid)->get(['lr_meal_image']);
                $filename = $filename_sql[0]->lr_meal_image;
             }

            if($name_of_meal!='' && $description!='')
            {
            try{
                $sql_update = DB::table('tbl_lr_meal')  
                ->where('lr_meal_id',$updateid)   
                ->update([
                    'lr_user_userid' => $sessionuserid ,
                    'lr_meal_name' => $name_of_meal ,
                    'lr_meal_calories' =>  $calories,
                    'lr_meal_fat' =>  $fat,
                    'lr_meal_carb' =>  $carb,
                    'lr_meal_protein' => $protien ,
                    'lr_meal_description' =>  $description,
                    'lr_meal_image' =>  $filename
                ]);
                return response()->json([
                    'status'=>'200',
                    'msg'=>'Update Successfully.'
                ]); 
            }
            catch(Exception $e)
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
            'msg'=>'Name of meal and description are required fields.'
            ]); 
            }
          }
         
         }
         else
         {
         return response()->json([
         'status'=>'401',
         'msg'=>'Invalid Request.'
         ]); 
         }
    }

    public function save_meal_menu(Request $request)
    {
        if($request->isMethod('POST'))
        {
          $session_all = Session::get('sessionvendor');
          $sessionuserid = $session_all['userid'];
          $name_of_meal = $request->name_of_meal;
          $calories = $request->calories;
          $fat = $request->fat;
          $carb = $request->carb;
          $protien = $request->protien;
          $description = $request->description;
         
          if($calories=='')
          {
            $calories = 0;
          }
          if($fat=='')
          {
            $fat = 0;
          }
          if($carb=='')
          {
            $carb = 0;
          }
          if($protien=='')
          {
            $protien = 0;
          }
         
            if($name_of_meal!='' && $description!='')
            {
              $sql_insert = DB::table('tbl_lr_meal')     
                          ->insert([
                              'lr_user_userid' => $sessionuserid ,
                              'lr_meal_name' => $name_of_meal ,
                              'lr_meal_calories' =>  $calories,
                              'lr_meal_fat' =>  $fat,
                              'lr_meal_carb' =>  $carb,
                              'lr_meal_protein' => $protien ,
                              'lr_meal_description' =>  $description,
                              'admin_status' =>  '1'
                          ]);
              if($sql_insert==true)
              {
                $last_insert_id = DB::getPdo()->lastInsertId();
              return response()->json([
              'status'=>'200',
              'msg'=>'Inserted Successfully.',
              'last_insert_id'=>$last_insert_id,
              'meal_name' => $name_of_meal
              ]); 
              }
              else
              {
              return response()->json([
              'status'=>'401',
              'msg'=>'Something went wrong,Please try again later.'
              ]); 
              }
            }
            else
            {
            return response()->json([
            'status'=>'401',
            'msg'=>'Name of meal and description are required fields.'
            ]); 
            }
          
         }
         else
         {
         return response()->json([
         'status'=>'401',
         'msg'=>'Invalid Request.'
         ]); 
         }
    }

    public function change_area(Request $request)
    {
        if($request->isMethod('post'))
      {    
        $arr_governorate = array();
       $governorate_id = $request->governorate_id;
      $arr_governorate = explode(',',$governorate_id);
       if(count($arr_governorate)>0)
       {
        $area_id = array();
        $area_name = array();
        foreach($arr_governorate AS $val)
        {
         $area_detail =   DB::table('tbl_lr_governorate_area')->where('admin_status','1')->where('lr_governorate_id',$val)->select('lr_governorate_area_id','lr_governorate_area_name')->get();
         if(count($area_detail))
         {
            array_push($area_id, $area_detail[0]->lr_governorate_area_id);
            array_push($area_name, $area_detail[0]->lr_governorate_area_name);
         }
        }
        return response()->json(
            [
            'status' =>'200',
            'area_id' => $area_id,
            'area_name' => $area_name
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

    public function deleterowstatus(Request $request){
        if($request->isMethod('POST')){   
            $id = trim($request->id);
            $tblname = trim($request->tblname);
            $colwhere = trim($request->colwhere);
            $statuscol = trim($request->statuscol);
            if($id!=''){
             
                $sql = "UPDATE $tblname SET $statuscol = '2' WHERE $colwhere='$id'";
                $data = DB::select($sql);
              if($sql==true){
                 return response()->json([
                    'status' =>'200',
                    'msg' => 'Deleted successfully'
                 ]);
              }
              else
              {
                return response()->json([
                    'status' =>'401',
                    'msg' => 'Something wernt wrong, please try again later'
                 ]);
              }
            }
        }
    }              



    public function deleteallrow(Request $request){
        if($request->isMethod('POST')){
            $tblname = trim($request->tblname);
          
                $sql = "DELETE FROM $tblname"; 
               
                $data = DB::select($sql);
              if($sql==true){
                 return response()->json([
                    'status' =>'200',
                    'msg' => 'Deleted successfully'
                 ]);
              }
              else
              {
                return response()->json([
                    'status' =>'401',
                    'msg' => 'Something wernt wrong, please try again later'
                 ]);
              }
           
        }
    }

    public function deleterow(Request $request){
        if($request->isMethod('POST')){   
            $id = trim($request->id);
            $tblname = trim($request->tblname);
            $colwhere = trim($request->colwhere);
            if($id!=''){
                $sql = "DELETE FROM $tblname WHERE $colwhere='$id'";
                $data = DB::select($sql);
              if($sql==true){
                 return response()->json([
                    'status' =>'200',
                    'msg' => 'Deleted successfully'
                 ]);
              }
              else
              {
                return response()->json([
                    'status' =>'401',
                    'msg' => 'Something wernt wrong, please try again later'
                 ]);
              }
            }
        }
    }

    public function add_menu()
    {
        $session_all=Session::get('sessionvendor');
        if($session_all==false)
        {
            return Redirect::to('/login');
            exit();
        }
        $menu_list = DB::table('tbl_lr_menu_category')->where('admin_status','1')->select('lr_category_id','lr_category_name')->get();
        $meal_list = DB::table('tbl_lr_meal')->select('lr_meal_id','lr_meal_name')->where('admin_status','1')->get();
      
        return view("Vendor::add_menu",compact('menu_list','meal_list'));
        
    }

    public function edit_menu($id)
    {
        $session_all=Session::get('sessionvendor');
        if($session_all==false)
        {
            return Redirect::to('/login');
            exit();
        }

        $menu_list = DB::table('tbl_lr_menu_category')->where('admin_status','1')->select('lr_category_id','lr_category_name')->get();
        $meal_list = DB::table('tbl_lr_meal')->select('lr_meal_id','lr_meal_name')->where('admin_status','1')->get();

        $data = DB::table('tbl_lr_vendor_menu')->where('lr_unique_id',$id)->select('lr_unique_id','vendor_menu_name')->get();

        $data_menu_cat = DB::table('tbl_lr_vendor_menu')->where('lr_unique_id',$id)->distinct('vendor_menu_category')->select('vendor_menu_category')->get();

        $selected_mealid = DB::table('tbl_lr_vendor_menu')->where('lr_unique_id',$id)->select('vendor_menu_category_meal','vendor_menu_category')->get();

     //  echo '<pre>'; print_r($selected_mealid); exit;
        
        return view("Vendor::edit_menu",compact('menu_list','data','data_menu_cat','meal_list','selected_mealid'))->with('order_unique_id',$id);
       
    }

    public function showmeal_menu(Request $request)
    {
        if($request->isMethod('post'))
        { 
         $menu_list = $request->menu_list;
         if($menu_list!='')
         {
 
            $menu_list_arr = explode(',',$menu_list);
        
            $menu_list_name = array();
            $menu_list_id = array();
            foreach($menu_list_arr AS $val)
            {
               $menu_detail = DB::table('tbl_lr_menu_category')->where('lr_category_id',$val)->select('lr_category_id','lr_category_name')->get();
               array_push($menu_list_name,$menu_detail[0]->lr_category_name);
               array_push($menu_list_id,$menu_detail[0]->lr_category_id);
            }
   
            $meal_list = DB::table('tbl_lr_meal')->select('lr_meal_id','lr_meal_name')->where('admin_status','1')->get();
   
            return response()->json(
               [
               'status' =>'200',
               'menu_list_name' => $menu_list_name,
               'meal_list' => $meal_list,
               'menu_list_id' => $menu_list_id
               ]);
         }
         else
         {
            return response()->json(
                [
                'status' =>'401',
                'msg' => 'Something went wrong.',
               
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

    public function edit_showmeal_menu(Request $request)
    {
        if($request->isMethod('post'))
        { 
        
         $menu_list = $request->menu_list; 
         $order_unique_id = $request->order_unique_id;
        
         if($menu_list!='')
         {
 
            $menu_list_arr = explode(',',$menu_list);
        
            $menu_list_name = array();
            $menu_list_id = array();
          //  $menu_meal_id = [];
           
            foreach($menu_list_arr AS $val)
            {   
               $menu_detail = DB::table('tbl_lr_menu_category')->where('lr_category_id',$val)->select('lr_category_id','lr_category_name')->get();
               array_push($menu_list_name,$menu_detail[0]->lr_category_name);
               array_push($menu_list_id,$menu_detail[0]->lr_category_id);

               $menu_meal_detail = DB::table('tbl_lr_vendor_menu')->where('lr_unique_id',$order_unique_id)->where('vendor_menu_category',$val)->select('vendor_menu_category','vendor_menu_category_meal')->get();
               foreach($menu_meal_detail AS $mealval)
               {
                  //array_push($menu_meal_id,$mealval->vendor_menu_category_meal);
                  $menu_meal_id[$mealval->vendor_menu_category][] = $mealval->vendor_menu_category_meal;

               }
             
            } 

           // print_r($menu_meal_id); exit;
            
            $meal_list = DB::table('tbl_lr_meal')->select('lr_meal_id','lr_meal_name')->where('admin_status','1')->get();
   
            return response()->json(
               [
               'status' =>'200',
               'menu_list_name' => $menu_list_name,
               'meal_list' => $meal_list,
               'menu_list_id' => $menu_list_id,
               'menu_meal_id' => $menu_meal_id
               ]);
         }
         else
         {
            return response()->json(
                [
                'status' =>'401',
                'msg' => 'Something went wrong.',
               
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

    public function save_menu(Request $request)
    {
        if($request->isMethod('post'))
        {
          $session_all = Session::get('sessionvendor');
          $sessionuserid = $session_all['userid'];
          $menu_name = $request->menu_name; 
          $mealname = $request->mealname;
          $lr_unique_id = date("YmdHis");
          foreach($mealname AS $key => $val)
          {
              foreach($val AS $k => $v)
              {
                  $sql_insert = DB::table('tbl_lr_vendor_menu')->insert([
                      'lr_unique_id' => $lr_unique_id,
                      'vendor_menu_name' => $menu_name,
                      'lr_user_id' => $sessionuserid,
                      'vendor_menu_category' => $key,
                      'vendor_menu_category_meal' => $v,
                      'admin_status' => '1'
                      ]);
              }
             
           
          }
        

         if($sql_insert==true)
         {
            return response()->json(
                [
                'status' =>'200',
                'msg' => 'Menu inserted successfully.'
                ]);
         }
         else
         {
            return response()->json(
                [
                'status' =>'200',
                'msg' => 'Something went wrong,Please try again later.'
                ]);
         }
        }
        else
        {
        return response()->json([
        'status'=>'401',
        'msg'=>'Invalid Request.'
        ]); 
        }

        
    }

    public function edit_save_menu(Request $request)
    {
        if($request->isMethod('post'))
        {
        $session_all = Session::get('sessionvendor');
        $sessionuserid = $session_all['userid'];
        $menu_name = $request->menu_name; 
        $mealname = $request->mealname;  
        $updateid = $request->updateid;

        DB::beginTransaction();

        $deleteData =  DB::table('tbl_lr_vendor_menu')->where('lr_unique_id', '=', $updateid)->delete();
          if(!$deleteData)
          {
            DB::rollback();
          }  
        
          foreach($mealname AS $key => $val)
          {
              foreach($val AS $k => $v)
              {
                  $sql_update = DB::table('tbl_lr_vendor_menu')->insert([
                      'lr_unique_id'=>$updateid,
                      'vendor_menu_name' => $menu_name,
                      'vendor_menu_category' => $key,
                      'vendor_menu_category_meal' => $v,
                      'lr_user_id' => $sessionuserid,
                      'admin_status' => '1'
                      ]);


        if(!$sql_update && !$deleteData)
          {
            DB::rollback();
          } 
              }
             
             
          }
        DB::commit();
       

      //  print_r($mealname); exit;
       
       
            return response()->json(
                [
                'status' =>'200',
                'msg' => 'Menu updated successfully.'
                ]);
        
        }
        else
        {
        return response()->json([
        'status'=>'401',
        'msg'=>'Invalid Request.'
        ]); 
        }

        
    }


    public function add_package($id=null)
    {                
        $session_all=Session::get('sessionvendor');
        if($session_all==false)
        {
            return Redirect::to('/login');
            exit();
        }
        $session_all = Session::get('sessionvendor');
        $sessionuserid = $session_all['userid'];
        $plan_list = DB::table('tbl_lr_vendor_plan')->where('lr_user_id',$sessionuserid)->where('admin_status','1')->orderBy('vendor_plan_id','desc')->select('vendor_plan_id','vendor_plan_name')->get();
        if($id!='')
        {
            $data = DB::table('tbl_lr_vendor_package')->where('lr_package_id',$id)->select('lr_package_id','package_name','vendor_plan_id','package_description','package_gender','package_price')->get();

            return view("Vendor::add_package",compact('plan_list','data'));
        }
        else
        {
            return view("Vendor::add_package",compact('plan_list'));
        }
        
    }

    public function save_package(Request $request)
    {
        if($request->isMethod('POST'))
        {
          $session_all = Session::get('sessionvendor');
          $sessionuserid = $session_all['userid'];
          $package_name = $request->package_name;
          $planid = $request->planid;
          $package_description = $request->package_description;
          $gender = $request->gender;
          $package_price = $request->package_price;
          $updateid = $request->updateid;
          if($updateid=='')
          {
            if($package_name!='' && $planid!='' && $package_description!='' && $gender!='' && $package_price!='')
            {
              $sql_insert = DB::table('tbl_lr_vendor_package')     
                          ->insert([
                              'lr_user_id' => $sessionuserid ,
                              'package_name' => $package_name ,
                              'vendor_plan_id' =>  $planid,
                              'package_description' =>  $package_description,
                              'package_gender' =>  $gender,
                              'package_price' => $package_price, 
                              'admin_status' =>  '1'
                          ]);
              if($sql_insert==true)
              {
              return response()->json([
              'status'=>'200',
              'msg'=>'Inserted Successfully.'
              ]); 
              }
              else
              {
              return response()->json([
              'status'=>'401',
              'msg'=>'Something went wrong,Please try again later.'
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
          else
          {
            if($package_name!='' && $planid!='' && $package_description!='' && $gender!='' && $package_price!='')
            {
            try{
                $sql_update = DB::table('tbl_lr_vendor_package')  
                ->where('lr_package_id',$updateid)   
                ->update([
                    'package_name' => $package_name ,
                    'vendor_plan_id' =>  $planid,
                    'package_description' =>  $package_description,
                    'package_gender' =>  $gender,
                    'package_price' => $package_price,
                ]);
                return response()->json([
                    'status'=>'200',
                    'msg'=>'Update Successfully.'
                ]); 
            }
            catch(Exception $e)
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
            'msg'=>'Something went wrong, Please try again later.'
            ]); 
            }
          }
         
         }
         else
         {
         return response()->json([
         'status'=>'401',
         'msg'=>'Invalid Request.'
         ]); 
         }
    }

    
    public function delivery_area_info()
    {
        $session_all=Session::get('sessionvendor');
        if($session_all==false)
        {
            return Redirect::to('/login');
            exit();
        }
        $sessionuserid = $session_all['userid'];
        $data = DB::table('tbl_lr_governorate')->where('admin_status','1')->select('lr_governorate_id','lr_governorate_name')->get();

        $checked_area = DB::table('tbl_lr_vendor_governorate_area')->where('lr_user_userid',$sessionuserid)->select('lr_governorate_area_id')->get();
        $arr_area = [];
        foreach($checked_area AS $val)
        {
            array_push($arr_area, $val->lr_governorate_area_id);
        }
        
       
        $vendor_governorate = DB::table('tbl_lr_vendor_governorate_area AS t1')
                                ->join('tbl_lr_governorate_area AS t2','t1.lr_governorate_area_id','t2.lr_governorate_area_id')
                                ->join('tbl_lr_governorate AS t3','t3.lr_governorate_id','t2.lr_governorate_id')
                                ->where('t1.lr_user_userid',$sessionuserid)
                                ->select('t1.id','t1.lr_governorate_area_id','t2.lr_governorate_id','t2.lr_governorate_area_name','t3.lr_governorate_name')->get();

        $unique = array();
        foreach ($vendor_governorate as $value)
        {
            $unique[] = $value->lr_governorate_id;
        }
        $governorateid =  array_unique($unique);
       

        return view("Vendor::delivery_area_info",compact('data','vendor_governorate','governorateid','arr_area'));
    }

    public function save_governorate_area(Request $request)
    { 
        if($request->isMethod('post'))
        {
            $session_all = Session::get('sessionvendor');
            $sessionuserid = $session_all['userid'];
            $area = array();
            $area = $request->governorate_area;
            if(count($area)>0)
            {
                $deletesql = DB::table('tbl_lr_vendor_governorate_area')->where('lr_user_userid',$sessionuserid)->delete();
                
                foreach($area AS $val)
                {
                 $sql_insert =   DB::table('tbl_lr_vendor_governorate_area')->insert([
                        'lr_user_userid' => $sessionuserid,
                        'lr_governorate_area_id' => $val
                    ]);
                }
                if($sql_insert==true)
                {
                    return response()->json([
                        'status' => '200',
                        'msg'    => 'Governarate area\'s added successfully.'
                    ]);
                }
                else
                {
                    return response()->json([
                        'status' => '401',
                        'msg'    => 'Something went wrong, Please try again later.'
                    ]);
                }
            }
            else
            {
                return response()->json([
                    'status' => '401',
                    'msg'    => 'All fields are required.'
                ]);
            }
        }
        else
        {
            return response()->json([
                'status' => '401',
                'msg'    => 'Invalid Requests.'
            ]);
        }
       
    }

   public function save_deliverytime(Request $request)
   {
       if($request->isMethod('post'))
       {            
            $time = array();
            $to = array();
            $from = $request->from;
            $to = $request->to;
            $vendor_area_id = $request->vendor_area_id;

            for($i=0; $i < count($from); $i++)
            {
                if($from[$i]=='' || $to[$i]=='')
                {
                    return response()->json([
                        'status' => '401',
                        'msg' => 'All fields are required.'
                    ]);
                }
                DB::table('tbl_lr_vendor_deleverytime')->insert([
                    'vendor_areaid' => $vendor_area_id,
                    'from' => $from[$i],
                    'to' => $to[$i]
                ]);
            }

            return response()->json([
                'status' => '200',
                'msg' => 'Delivery time added successfully.'
            ]);
           
       }
       else
       {
        return reponse()->json([
            'status' => '401',
            'msg' => 'Invalid Requests.'
        ]);
       }
   }

   public function delivery_centre_available()
   {
    $session_all=Session::get('sessionvendor');
    if($session_all==false)
    {
        return Redirect::to('/login');
        exit();
    }
    $sessionuserid = $session_all['userid'];
    $data = DB::table('tbl_lr_vendor_delivery_status')->where('lr_user_userid',$sessionuserid)->select('lr_delivery_status','lr_delivery_status_available_after')->get();

    return view("Vendor::delivery_centre_available",compact('data'));
   }

   public function save_vendor_availability_status(Request $request)
   {
       if($request->isMethod('post'))
       {
            $avalability_status = $request->avalability_status; 
            $available_after = $request->available_after;
            $session_all=Session::get('sessionvendor');
            $sessionuserid = $session_all['userid'];
            if($avalability_status!=''){
                $is_exists = DB::table('tbl_lr_vendor_delivery_status')->where('lr_user_userid',$sessionuserid)->count();
                if($is_exists>0)
                {
                    try
                    {
                    $sql_update = DB::table('tbl_lr_vendor_delivery_status')->where('lr_user_userid', $sessionuserid)->update([
                        'lr_delivery_status' => $avalability_status,
                        'lr_delivery_status_available_after' => $available_after
                    ]);
                    return response()->json([
                        'status' => '200',
                        'msg' => 'Data updated successfully.'
                    ]);
                    }
                    catch(Exception $e)
                    {
                        return response()->json([
                            'status' => '401',
                            'msg' => 'Something went wrong, please try again later.'
                        ]);
                    }
                   
                }
                else
                {
                   
                        $sql_insert = DB::table('tbl_lr_vendor_delivery_status')->insert([
                            'lr_user_userid' => $sessionuserid,
                            'lr_delivery_status' => $avalability_status,
                            'lr_delivery_status_available_after' => $available_after
                        ]);
                        if($sql_insert==true)
                        {
                            return response()->json([
                                'status' => '200',
                                'msg' => 'Data addedd successfully.'
                            ]);
                        }
                        else
                        {
                            return response()->json([
                                'status' => '401',
                                'msg' => 'Something went wrong, please try again later.'
                            ]);
                        }
                    

                   
                }
               

               
            }
            else
            {
                return response()->json([
                    'status' => '401',
                    'msg' => 'All fields are required.'
                ]);
            }
       }
       else
       {
           return response()->json([
            'status' => '401',
            'msg' => 'Invalid Requests'
           ]);
       }
   }

   public function get_meal_data(Request $request)
   {
        if($request->isMethod('post'))
        {
            $mealid = $request->id;
            if($mealid!='')
            {
                $meal_data = DB::table('tbl_lr_meal')->where('lr_meal_id',$mealid)->get();
                return response()->json([
                    'status' => '200',
                    'msg' => $meal_data
                ]); 
            }
            else{
                return response()->json([
                    'status' => '401',
                    'msg' => 'Something went wrong, please try again later.'
                ]);    
            }
        }
        else
        {
            return response()->json([
                'status' => '401',
                'msg' => 'Invalid Requests.'
            ]);
        }
   }

   public function plan_calender($plan_id)
   {
    $session_all=Session::get('sessionvendor');
    if($session_all==false)
    {
        return Redirect::to('/login');
        exit();
    }
    $sessionuserid = $session_all['userid'];
    $curDate = new \DateTime(); 
    
    if($plan_id!='')
    {
        $data = DB::table('tbl_lr_vendor_plan')->select('vendor_plan_menu_type','vendor_plan_meals','vendor_plan_snacks','vendor_plan_offdays','app_status')->where('vendor_plan_id',$plan_id)->get();
       
      
        $vendor_menu_category = DB::table('tbl_lr_vendor_menu as t1')
                                ->join('tbl_lr_menu_category as t2','t1.vendor_menu_category','t2.lr_category_id')
                                ->where('t1.lr_user_id',$sessionuserid)->where('t2.lr_category_type','MEAL')->where('t2.admin_status','1')->select('t1.vendor_menu_name','t1.lr_unique_id')->distinct('lr_unique_id')->get();

        $vendor_menu_name_snacks = DB::table('tbl_lr_vendor_menu as t1')
        ->join('tbl_lr_menu_category as t2','t1.vendor_menu_category','t2.lr_category_id')
        ->where('t1.lr_user_id',$sessionuserid)->where('t2.lr_category_type','SNACKS')->where('t2.admin_status','1')->select('t1.vendor_menu_name','t1.lr_unique_id')->distinct('lr_unique_id')->get(); 

        $isvendor_exists = DB::table('tbl_lr_vendor_plandetail_final')->where('lr_user_id',$sessionuserid)->where('vendor_plan_id',$plan_id)->min('vendor_plandetail_date');

        if($isvendor_exists!='')
        {
            
            $date_start = $curDate->format('Y-m-d');  
            $defaul_end_date = date('Y-m-d', strtotime($date_start. ' + 120 days')); 
            
        }
        else
        {
            $date_start = '';
            $defaul_end_date = '';
        }

         return view("Vendor::test_calender",compact('data','vendor_menu_category','vendor_menu_name_snacks'))->with('date_start',$date_start)->with('defaul_end_date',$defaul_end_date)->with('planid',$plan_id);


    }
    else
    {
        return Redirect::to('/vendor/myprofile');
        exit();
    }
    
   }

   public function plan_changemenucat(Request $request)
   {
        if($request->isMethod('post'))
        {
           $uniqueid = $request->uniqueid;
           $data = DB::table('tbl_lr_vendor_menu as t1')
                    ->join('tbl_lr_menu_category as t2','t1.vendor_menu_category','t2.lr_category_id')
                    ->where('lr_unique_id',$uniqueid)->where('t2.lr_category_type','MEAL')->select('t1.vendor_menu_category')->distinct('t1.vendor_menu_category')->get();

            $menu_asso_array = array();
            foreach($data as $val)
            {
                $menu_id_name = DB::table('tbl_lr_menu_category')->where('lr_category_id',$val->vendor_menu_category)->select('lr_category_id','lr_category_name')->get();
                $menu_asso_array[$menu_id_name[0]->lr_category_id] = $menu_id_name[0]->lr_category_name;

            }

         //   echo print_r($menu_asso_array); exit;

            return response()->json([
                'status' => '200',
                'data' => $menu_asso_array,
                'uniqueid' => $uniqueid
            ]);
        
        }
        else
        {
            return response()->json([
                'status' => '401',
                'msg' => 'Invalid Requests.'
            ]);
        }
   }

   public function plan_changemeal(Request $request)
   {
    if($request->isMethod('post'))
    {
       $menuid = $request->menuid;    
       $uniqueid = $request->uniqueid;
       $data = DB::table('tbl_lr_vendor_menu as t1')
                ->join('tbl_lr_meal as t2','t1.vendor_menu_category_meal','t2.lr_meal_id')
                ->where('vendor_menu_category',$menuid)->where('lr_unique_id',$uniqueid)->select('t2.lr_meal_id','t2.lr_meal_name')->get();

        return response()->json([
            'status' => '200',
            'data' => $data
        ]);
    
    }
    else
    {
        return response()->json([
            'status' => '401',
            'msg' => 'Invalid Requests.'
        ]);
    }
   }

   public function plan_changemenucat_snacks(Request $request)
   {
    if($request->isMethod('post'))
    {
       $uniqueid = $request->uniqueid;
       $data = DB::table('tbl_lr_vendor_menu as t1')
                ->join('tbl_lr_menu_category as t2','t1.vendor_menu_category','t2.lr_category_id')
                ->where('lr_unique_id',$uniqueid)->where('t2.lr_category_type','SNACKS')->select('t1.vendor_menu_category')->distinct('t1.vendor_menu_category')->get();

        $menu_asso_array = array();
        foreach($data as $val)
        {
            $menu_id_name = DB::table('tbl_lr_menu_category')->where('lr_category_id',$val->vendor_menu_category)->select('lr_category_id','lr_category_name')->get();
            $menu_asso_array[$menu_id_name[0]->lr_category_id] = $menu_id_name[0]->lr_category_name;

        }

     //   echo print_r($menu_asso_array); exit;

        return response()->json([
            'status' => '200',
            'data' => $menu_asso_array,
            'uniqueid' => $uniqueid
        ]);
    
    }
    else
    {
        return response()->json([
            'status' => '401',
            'msg' => 'Invalid Requests.'
        ]);
    }
   }

   public function plan_changemeal_snacks(Request $request)
        {
            if($request->isMethod('post'))
            {
               $menuid = $request->menuid;    
               $uniqueid = $request->uniqueid;
               $data = DB::table('tbl_lr_vendor_menu as t1')
                        ->join('tbl_lr_meal as t2','t1.vendor_menu_category_meal','t2.lr_meal_id')
                        ->where('vendor_menu_category',$menuid)->where('lr_unique_id',$uniqueid)->select('t2.lr_meal_id','t2.lr_meal_name')->get();
        
                return response()->json([
                    'status' => '200',
                    'data' => $data
                ]);
            
            }
            else
            {
                return response()->json([
                    'status' => '401',
                    'msg' => 'Invalid Requests.'
                ]);
            }
        }

        public function save_plan_detail(Request $request)
        {
            if($request->isMethod('post'))
            {
              $session_all = Session::get('sessionvendor');
              $sessionuserid = $session_all['userid'];

              $date                    =  $request->date;
              $planid                    =  $request->planid; 
              $vendor_menu_name        =  $request->vendor_menu_name;
              $mealcheckbox            =  $request->mealcheckbox; 
              $vendor_menu_name_snacks =  $request->vendor_menu_name_snacks;
              $mealsnackscheckbox      =  $request->mealsnackscheckbox;
              $lr_unique_id            =  date("YmdHis");

              $is_app_status_active_sql = DB::table('tbl_lr_vendor_plan')->where('vendor_plan_id',$planid)->get(['app_status']);

              $is_app_status_active = $is_app_status_active_sql[0]->app_status;
              if($is_app_status_active == 1)
              {
                  $tablename = 'tbl_lr_vendor_plandetail_final';
              }
              else
              {
                  $tablename = 'tbl_lr_vendor_plandetail';
              }



              if(count($mealcheckbox)>0)
              {
              foreach($mealcheckbox AS $key => $value)
              {
                foreach($value AS $k => $v)   
                {
                    $sql = DB::table($tablename)->insert([
                        'lr_user_id' => $sessionuserid,
                        'lr_unique_id' => $lr_unique_id,
                        'vendor_plan_id' => $planid,
                        'vendor_plandetail_date' => $date,
                        'vendor_menu_id' => $vendor_menu_name,
                        'lr_menucategory_id' => $key,
                        'lr_meal_id' => $v,
                        'lr_category_type' => 'MEAL'
                    ]);
                }
              }
              }
              if(count($mealsnackscheckbox)>0)
              {
              foreach($mealsnackscheckbox AS $key => $value)
              {
                foreach($value AS $k => $v)
                {
                    $sql = DB::table($tablename)->insert([
                        'lr_user_id' => $sessionuserid,
                        'lr_unique_id' => $lr_unique_id,
                        'vendor_plan_id' => $planid,
                        'vendor_plandetail_date' => $date,
                        'vendor_menu_id' => $vendor_menu_name_snacks,
                        'lr_menucategory_id' => $key,
                        'lr_meal_id' => $v,
                        'lr_category_type' => 'SNACKS'
                    ]);
                }
              }
            }
              return response()->json([
                'status' => '200',
                'msg' => 'Added Successfully.'
            ]);

            }
            else
            {
                return response()->json([
                    'status' => '401',
                    'msg' => 'Invalid Requests.'
                ]);
            }
        }

        public function final_calender(Request $request)
        {
           $curDate = new \DateTime();  
           $planid = $request->planid;
           $date_start = $request->date_start;
           $break = '';
           $date = DB::table('tbl_lr_vendor_plandetail')->select('vendor_plandetail_date')->distinct('vendor_plandetail_date')->where('vendor_plan_id',$planid)->get();

           $planoffdays_sql = DB::table('tbl_lr_vendor_plan')->where('vendor_plan_id',$planid)->select('vendor_plan_offdays')->get();

           $planoffdays = $planoffdays_sql[0]->vendor_plan_offdays;

          // $date_start_sql = DB::table('tbl_lr_vendor_plandetail')->where('vendor_plan_id',$planid)->select(\DB::raw("MIN(vendor_plandetail_date) AS vendor_plandetail_date"))->get();

          // $date_start = $date_start_sql[0]->vendor_plandetail_date; 
         
           $date_start = $curDate->format('Y-m-d');
           $date_start = date ("Y-m-d", strtotime("+2 day", strtotime($date_start)));
         
           $array_date = [];
           foreach($date as $date1)
            {  
              $array_date[] = $date1->vendor_plandetail_date;
            } 
          
           if(count($date) > 0)
           {  
               for($i=1; $i<=45; $i++)
               {   
                  $nameOfDay = date('l', strtotime($date_start));
                  if(!in_array($date_start,$array_date) && $planoffdays!=strtoupper($nameOfDay))
                  { 
                    $break = 'break'; 
                  }
                if($break=='break')
                {   
                    return response()->json([
                        'status' => '401',
                        'msg' => 'Please add meal on '.$date_start
                       ]);
                } 
                else
                {  
                    $date_start = date ("Y-m-d", strtotime("+1 day", strtotime($date_start)));
                }
               
               }

               DB::beginTransaction();
               try {
                
                $sql = "INSERT INTO tbl_lr_vendor_plandetail_final(`lr_user_id`,`lr_unique_id`,`vendor_plan_id`,`vendor_plandetail_date`,`vendor_menu_id`,`lr_menucategory_id`,`lr_meal_id`,`lr_category_type`) SELECT `lr_user_id`,`lr_unique_id`,`vendor_plan_id`,`vendor_plandetail_date`,`vendor_menu_id`,`lr_menucategory_id`,`lr_meal_id`,`lr_category_type` FROM tbl_lr_vendor_plandetail WHERE tbl_lr_vendor_plandetail.vendor_plan_id=$planid";

                 $insert_tofinal_sql = DB::select($sql);
                 
                $delete_sql = DB::table('tbl_lr_vendor_plandetail')->where('vendor_plan_id',$planid)->delete();

                $update_sql = DB::table('tbl_lr_vendor_plan')->where('vendor_plan_id',$planid)->update([
                    "app_status" => 1
                ]);

                DB::commit();
                return response()->json(
                [
                'status' =>'200',
                'msg' => 'Plan Detail Added Successfully.'
                ]);
                
                } catch (\Exception $e) {
                    DB::rollback();
                    return response()->json(
                        [
                        'status' =>'401',
                        'msg' => 'Something went wrong. Please try again later.'
                        ]);
                }
              
             
           }
           else
           {
              return response()->json([
                'status' => '401',
                'msg' => 'No Meals Are Added.'
              ]);
           }
        }

        public function edit_plan_detail(Request $request)
        {
            if($request->isMethod('post'))
            {
                $date = $request->selecteddate; 
                $planid = $request->planid; 
                $is_app_status_active_sql = DB::table('tbl_lr_vendor_plan')->where('vendor_plan_id',$planid)->get(['app_status']);

                $is_app_status_active = $is_app_status_active_sql[0]->app_status;
                if($is_app_status_active == 1)
                {
                    $tablename = 'tbl_lr_vendor_plandetail_final';
                }
                else
                {
                    $tablename = 'tbl_lr_vendor_plandetail';
                }

                $isdataavailable = DB::table($tablename)->where('vendor_plandetail_date',$date)->where('vendor_plan_id',$planid)->count();
                if($isdataavailable>0)
                {  
                  $menuname_meal = DB::table($tablename)
                                    ->where('vendor_plandetail_date',$date)
                                    ->where('vendor_plan_id',$planid)
                                    ->where('lr_category_type','MEAL')
                                    ->select('vendor_menu_id')->distinct('vendor_menu_id')->get();

                 $menuname_snacks = DB::table($tablename)
                                    ->where('vendor_plandetail_date',$date)
                                    ->where('vendor_plan_id',$planid)
                                    ->where('lr_category_type','SNACKS')
                                    ->select('vendor_menu_id')->distinct('vendor_menu_id')->get();
             
                $menu_category_meal = DB::table($tablename.' as t1')   
                            ->join('tbl_lr_menu_category as t2','t1.lr_menucategory_id','t2.lr_category_id')
                            ->where('vendor_plandetail_date',$date)
                            ->where('t1.lr_category_type','MEAL')
                            ->select('t2.lr_category_name','t2.lr_category_id')->distinct('t1.lr_menucategory_id')->get();
                
                $menu_category_snacks = DB::table($tablename.' as t1')   
                ->join('tbl_lr_menu_category as t2','t1.lr_menucategory_id','t2.lr_category_id')
                ->where('vendor_plandetail_date',$date)
                ->where('t1.lr_category_type','SNACKS')
                ->select('t1.lr_category_type','t2.lr_category_name','t2.lr_category_id')->distinct('t1.lr_menucategory_id')->get();

                $meal_id_snacks = DB::table($tablename.' as t1')   
                ->join('tbl_lr_meal as t2','t1.lr_meal_id','t2.lr_meal_id')
                ->where('vendor_plandetail_date',$date)
                ->where('t1.lr_category_type','SNACKS')
                ->select('t1.lr_category_type','t2.lr_meal_id','t2.lr_meal_name')->get();
                
                return response()->json([
                    'status' => '200',
                    'menu_category_snacks'    => $menu_category_snacks,
                    'menu_category_meal'    => $menu_category_meal,
                    'meal_id_snacks'    => $meal_id_snacks,
                    'date'              => $date,
                    'menuname_meal'     => $menuname_meal,
                    'menuname_snacks'     => $menuname_snacks,
                    'tablename'     => $tablename
                  ]);
                }
                else // data not available
                {
                 
                }
               
            }
            else
            {
                return response()->json([
                    'status' => '401',
                    'msg'    => 'Invalid Requests'
                ]);
            }
        }

        public function get_meal_edit(Request $request)
        {
            if($request->isMethod('post'))
            {
                $date = $request->date;  
                $menucatid = $request->menucatid; 
                $tablename = $request->tablename;
                $type = $request->type;  
               //  echo $tablename; exit;
                $meal_list = DB::table($tablename.' as t1') 
                            ->join('tbl_lr_meal as t2','t1.lr_meal_id','t2.lr_meal_id')
                            ->where('vendor_plandetail_date',$date)->where('lr_category_type',$type)->where('lr_menucategory_id',$menucatid)->select('t2.lr_meal_id','t2.lr_meal_name')->get();
               
                return response()->json([
                    'status' => '200',
                    'meal_list'    => $meal_list,
                    'menu_id' => $menucatid
                ]);
                
            }
            else
            {
                return response()->json([
                    'status' => '401',
                    'msg'    => 'Invalid Requests'
                ]);
            }
        }

        public function update_plan_detail(Request $request)
        {
            if($request->isMethod('post'))
            {

              $date                    =  $request->date;
              $planid                    =  $request->planid;
              $vendor_menu_name        =  $request->vendor_menu_name;
              $mealcheckbox            =  $request->mealcheckbox; 
              $vendor_menu_name_snacks =  $request->vendor_menu_name_snacks;
              $mealsnackscheckbox      =  $request->mealsnackscheckbox;
              $session_all             =  Session::get('sessionvendor');
              $sessionuserid           =  $session_all['userid'];
              $lr_unique_id            =  date("YmdHis");

              $is_app_status_active_sql = DB::table('tbl_lr_vendor_plan')->where('vendor_plan_id',$planid)->get(['app_status']);

              $is_app_status_active = $is_app_status_active_sql[0]->app_status;
              if($is_app_status_active == 1)
              {
                  $tablename = 'tbl_lr_vendor_plandetail_final';
              }
              else
              {
                  $tablename = 'tbl_lr_vendor_plandetail';
              }

              $sql_del = DB::table($tablename)->where('vendor_plandetail_date',$date)->where('vendor_plan_id',$planid)->delete();

              if($sql_del == true)
              {
                if(count($mealcheckbox)>0)
                {
                    foreach($mealcheckbox AS $key => $value)
                    {
                      foreach($value AS $k => $v)
                      {
                          $sql = DB::table($tablename)->insert([
                              'lr_user_id' => $sessionuserid,
                              'lr_unique_id' => $lr_unique_id,
                              'vendor_plan_id' => $planid,
                              'vendor_plandetail_date' => $date,
                              'vendor_menu_id' => $vendor_menu_name,
                              'lr_menucategory_id' => $key,
                              'lr_meal_id' => $v,
                              'lr_category_type' => 'MEAL'
                          ]);
                      }
                    }
                }
                
  
                if(count($mealsnackscheckbox)>0)
                {
                    foreach($mealsnackscheckbox AS $key => $value)
                    {
                      foreach($value AS $k => $v)
                      {
                          $sql = DB::table($tablename)->insert([
                              'lr_user_id' => $sessionuserid,
                              'lr_unique_id' => $lr_unique_id,
                              'vendor_plan_id' => $planid,
                              'vendor_plandetail_date' => $date,
                              'vendor_menu_id' => $vendor_menu_name_snacks,
                              'lr_menucategory_id' => $key,
                              'lr_meal_id' => $v,
                              'lr_category_type' => 'SNACKS'
                          ]);
                      }
                    }
                }
                
  
                    return response()->json([
                    'status' => '200',
                    'msg' => 'Updated Successfully.'
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
                return response()->json([
                    'status' => '401',
                    'msg'    => 'Invalid Requests'
                ]);
            }
        }

         public function get_user_address_detail(Request $request)
          {
              $app_pre_order_id = $request->app_pre_order_id;

              $user_address_detail = DB::table('tbl_app_pre_order')->where('app_pre_order_id',$app_pre_order_id)->get(['app_pre_order_addr_id','app_pre_order_addr_title','app_pre_order_addr_areaid','app_pre_order_addr_areaname','app_pre_order_addr_block','app_pre_order_addr_street','app_pre_order_addr_avenue','app_pre_order_addr_house','app_pre_order_addr_phone']);

              if(count($user_address_detail) > 0)
              {
                  return response()->json([   
                      'status' => '200',
                      'user_address_detail' => $user_address_detail
                  ]);
              }
              else
              {
                  return response()->json([
                      'status' => '401',
                      'msg' => 'Data not found.'
                  ]);
              }

          }

          public function order_detail($pre_order_id)
          {
            
            $calender_list_sql = DB::table('tbl_app_pre_order_calender')->where('app_pre_order_id',$pre_order_id)->get();

            return view("Vendor::order_detail", compact('calender_list_sql'));
          }

          public function get_user_meal_detail(Request $request)
          {
            $pre_order_calender_id = $request->pre_order_calender_id;

              $user_ordermeal_detail = DB::table('tbl_app_preorder_calender_menu_meal')->where('pre_order_calender_id',$pre_order_calender_id)->get(['lr_category_name','lr_meal_name','lr_meal_calories','lr_meal_fat','lr_meal_carb','lr_meal_protein','max_meal_carb','max_meal_protein']);

              if(count($user_ordermeal_detail) > 0)
              {
                  return response()->json([   
                      'status' => '200',
                      'user_ordermeal_detail' => $user_ordermeal_detail
                  ]);
              }
              else
              {
                  return response()->json([
                      'status' => '401',
                      'msg' => 'Data not found.'
                  ]);
              }
          }
}
