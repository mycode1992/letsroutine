<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;
use App\Modules\Admin\Models\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use DB;
use Session;

class AppController extends Controller
{
    public function user_list($id=null)
    {
        $session_all=Session::get('sessionadmin');
        if($session_all==false)
        {
            return Redirect::to('/lradmin');
            exit();
        }

        if($id=='all_user')
        {
        $user_list = DB::table('tbl_app_user as t1')
      ->join('tbl_lr_governorate_area as t2','t1.lr_governorate_area_id','t2.lr_governorate_area_id')->orderby('app_user_id','desc')->get(['user_uniqueid','app_user_fname','app_user_lname','app_user_phone','app_user_email','app_user_gender','app_user_dob','t1.admin_status','lr_governorate_area_name','app_user_id']);
        }
        elseif($id=='active_user'){

         $user_list = DB::table('tbl_app_user as t1')
                    ->join('tbl_lr_governorate_area as t2','t1.lr_governorate_area_id','t2.lr_governorate_area_id')->where('t1.admin_status','1')->orderby('app_user_id','desc')->get(['user_uniqueid','app_user_fname','app_user_lname','app_user_phone','app_user_email','app_user_gender','app_user_dob','t1.admin_status','lr_governorate_area_name','app_user_id']);
        }
         elseif($id=='deactive_user'){
         $user_list = DB::table('tbl_app_user as t1')
                    ->join('tbl_lr_governorate_area as t2','t1.lr_governorate_area_id','t2.lr_governorate_area_id')->where('t1.admin_status','0')->orderby('app_user_id','desc')->get(['user_uniqueid','app_user_fname','app_user_lname','app_user_phone','app_user_email','app_user_gender','app_user_dob','t1.admin_status','lr_governorate_area_name','app_user_id']);
        }

        else
        {
            return redirect('lradmin/dashboard');
        }

        return view("Admin::app.user_list",compact('user_list'));
    }

    public function exportuser($id)
    {
        $session_all=Session::get('sessionadmin');
        if($session_all==false)
        {
            return Redirect::to('/lradmin');
            exit();
        }
        if($id=='User List')
        {
            $data = DB::table('tbl_app_user as t1')
            ->join('tbl_lr_governorate_area as t2','t1.lr_governorate_area_id','t2.lr_governorate_area_id')->get(['user_uniqueid','app_user_fname','app_user_lname','app_user_phone','app_user_email','app_user_gender','app_user_dob','t1.admin_status','lr_governorate_area_name']);
        }
        else
        {
            return Redirect::to('/lradmin/dashboard');
        }
        return view("Admin::export.exportuser",compact('data'))->with('page_name',$id);

    }

    public function get_user_address_detail(Request $request)
    {
        $user_uniqueid = $request->user_uniqueid;
        $user_address_detail = DB::table('tbl_app_user_address')->where('user_uniqueid',$user_uniqueid)->get(['app_user_add_title','app_user_add_block','app_user_add_street','app_user_add_avenue','app_user_add_house','app_user_add_phone','lr_governorate_area_id']);

        if(count($user_address_detail) > 0)
        {
            $getAreaName = getAreaName($user_address_detail[0]->lr_governorate_area_id);
            return response()->json([   
                'status' => '200',
                'getAreaName' => $getAreaName,
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


    public function about_us()
    {
        $session_all=Session::get('sessionadmin');
        if($session_all==false)
        {
        return Redirect::to('/lradmin');
        exit();
        }
        $data = DB::table('tbl_app_cms')->select('app_cms_desp')
        ->where('app_cms_id',1)->get();
        return view("Admin::app.aboutus",compact('data'));
    }#about-us


    public function update_aboutus(Request $request){
        if($request->isMethod('post')){
        $aboutus = addslashes($request->aboutus);
        try
        {
        $sql=DB::table('tbl_app_cms')
            ->where('app_cms_id', '=','1')
            ->update([
            'app_cms_desp'=>$aboutus,
            'updated_at'=>date('Y-m-d h:i:s')
        ]);

        return response()->json(
        [
        'status' =>'200',
        'msg' => 'About Us Content Updated Successfully.'
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
        'msg' => 'Invalid Request'
        ]);
        }
    }#update_aboutus


     public function customer_service()
     {
        $session_all=Session::get('sessionadmin');
        if($session_all==false)
        {
        return Redirect::to('/lradmin');
        exit();
        }
        $data = DB::table('tbl_app_customer_service')->select('*')
        ->where('id',1)->get();
        return view("Admin::app.customerservice",compact('data'));
     }#customer_service

     public function update_customer_service(Request $request){
        if($request->isMethod('post')){
        $phone = $request->phone;
        $email=$request->email;
        try
        {
        $sql=DB::table('tbl_app_customer_service')
            ->where('id', '=','1')
            ->update([
            'phone_no'=>$phone,
            'app_customer_service_email'=>$email,
            'updated_at'=>date('Y-m-d h:i:s')
        ]);

        return response()->json(
        [
        'status' =>'200',
        'msg' => 'Details Updated Successfully.'
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
        'msg' => 'Invalid Request'
        ]);
        }
    }#update_customer_service


    public function user_edit(Request $request, $id=null)
    {
    if($id==null || $id=='')
    {
        return redirect('/lradmin/app/user-list/all_user');
    }
    # Fetch page data for user _edit view
    $Users = DB::table('tbl_app_user')->where('user_uniqueid',$id)->first();
    $area  = DB::table('tbl_lr_governorate_area')->get();
    #If Form Submitted
    if($request->isMethod('post')):
      //  dd($request->all());

        # Validation Logic
         $pass_valid=($request->password!='') ? 'min:6|max:20' : '';
        $rules = [
            'firstname'     => 'required|string|max:20',
            'lastname'    => 'required|string|max:20',
            'phone_no'   => 'required|min:10',
            'gender' => 'required',
            'area'       => 'required',
            'date_of_birth' => 'required|date'
        ];
        $messages = [
            'required' => 'Please enter :attribute',
            'min'      => 'The :attribute must be atleast :min characters.',
            'phone_no.min'      => 'The phone no must be 10 numbers.',

        ];

        $this->validate($request,$rules,$messages);

        try{
            # Save request data

            $values=array(
            "app_user_fname"=>$request->firstname,
            "app_user_lname"=>$request->lastname,
            "app_user_phone"=>$request->phone_no,
            "app_user_gender"=>$request->gender,
            "app_user_dob"=>date('Y-m-d', strtotime($request->date_of_birth)),
            "lr_governorate_area_id"=>$request->area,
            "app_user_updated_time"=>date('Y-m-d h:i:s'),
            );
            $save_status = DB::table('tbl_app_user')->where('user_uniqueid',$id)->update($values);

            if($save_status){
                Session::flash('msg','Record updated successfully.');
                return redirect('/lradmin/app/user_edit/'.$id);
            }else{
                Session::flash('msg','Something went wrong.');
                 return redirect('/lradmin/app/user_edit/'.$id);
            }

        }catch(\Exception $e){
           // dd($e->getMessage());
           Session::flash('admin_post_error',$e->getMessage());
        }
    endif;

    # Store data and Load views
    $view['user'] = $Users;
    $view['area'] = $area;
    return view("Admin::app.user_edit",$view);
  }

  public function user_transactions($id=null)
  {
    if($id==null || $id=='')
      return redirect('lradmin/app/user-list/all_user');

  $data=DB::table('tbl_app_user_wallet_txns')
  ->select('*')->where(['user_uniqueid'=>$id])->get();

  $name=DB::table('tbl_app_user')
  ->select('app_user_fname','app_user_lname')->where(['user_uniqueid'=>$id])->first();
  $view['data']=$data;
  $view['id']=$id;
  $view['fullname']=$name->app_user_fname.' '.$name->app_user_lname;
  return view("Admin::app.user_transactions",$view);
  }

  public function user_orders($id=null)
  {
    if($id==null || $id=='')
    return redirect('lradmin/app/user-list/all_user');

    $data=DB::table('tbl_app_order')
    ->select('*')->where(['user_uniqueid'=>$id])->get();
    $name=DB::table('tbl_app_user')
    ->select('app_user_fname','app_user_lname')->where(['user_uniqueid'=>$id])->first();
    $view['data']=$data;
    $view['id']=$id;
    $view['fullname']=$name->app_user_fname.' '.$name->app_user_lname;
    return view("Admin::app.user_orders",$view);
  }

  public function user_report_problem()
  {
    $session_all=Session::get('sessionadmin');
    if($session_all==false)
    {
        return Redirect::to('/lradmin');
        exit();
    }
    $data=DB::table('tbl_app_order_report_problem as t1')
    ->join('tbl_app_user as t2','t2.user_uniqueid','t1.user_uniqueid')
    ->select('t1.*','t2.app_user_fname','t2.app_user_lname','t2.app_user_email')->get();
    $view['data']=$data;
    return view("Admin::app.user_reportproblem",$view);
  }

  public function export_report_problem()
  {
      $session_all=Session::get('sessionadmin');
      if($session_all==false)
      {
          return Redirect::to('/lradmin');
          exit();
      }
      $data=DB::table('tbl_app_order_report_problem')->get();
      return view("Admin::export.export_report_problem",compact('data'));

  }

  public function control_packages_social_icons()
  {
    $session_all=Session::get('sessionadmin');
    if($session_all==false)
    {
        return Redirect::to('/lradmin');
        exit();
    }

   $data = DB::table('tbl_app_control')->get();
    
    return view("Admin::app.control_packages_social_icons",compact('data'));
  }

  public function plan_filter()
  {
    $session_all=Session::get('sessionadmin');
    if($session_all==false)
    {
        return Redirect::to('/lradmin');
        exit();
    }

    $data = DB::table('tbl_app_planfilter')->get();
    
    return view("Admin::app.plan_filter",compact('data'));
  }

  public function add_plan_filter($id=null)
  {
    $session_all=Session::get('sessionadmin');
    if($session_all==false)
    {
        return Redirect::to('/lradmin');
        exit();
    }
    if($id!='')
    {
        $data = DB::table('tbl_app_planfilter')->where('app_planfilter_id',$id)->get();
        return view("Admin::app.add_plan_filter",compact('data'));
    }
    else
    {
      return view("Admin::app.add_plan_filter");
    }
  
  }

  public function save_plan_filter(Request $request)
  {
      if($request->isMethod('post'))
      {
        $plan_filter = $request->plan_filter;
        $updateid = $request->updateid;
        $imageidd = $request->file('plan_filter_image'); 

        if($updateid == '')
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
                 $dir = public_path().'/admin/upload/plan_filter_image/'; 
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
                    'msg' => 'Please add plan filter image.'
                    ]);
             }

            $insert_sql = DB::table('tbl_app_planfilter')->insert([
                'app_planfilter_name' => $plan_filter,
                'app_planfilter_image' => $filename,
                'admin_status' => 1
            ]);
        
            if($insert_sql == true)
            {
                return response()->json(
                    [
                    'status' =>'200',
                    'msg' => 'Added Successfully.'
                    ]);
            }
            else
            {
                return response()->json(
                [
                'status' =>'401',
                'msg' => 'Something went wrong Please try again later.'
                ]);
            }
        }
        else
        {
            try
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
                 $dir = public_path().'/admin/upload/plan_filter_image/'; 
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
                    $filename_sql = DB::table('tbl_app_planfilter')->where('app_planfilter_id',$updateid)->get(['app_planfilter_image']); 
                    if(count($filename_sql) > 0)
                    {
                    $filename = $filename_sql[0]->app_planfilter_image;
                    }
                    else
                    {
                    $filename = '';
                    }

                }

                $update_sql = DB::table('tbl_app_planfilter')->where('app_planfilter_id',$updateid)->update([
                    'app_planfilter_name' => $plan_filter,
                    'app_planfilter_image' => $filename
                ]);

                return response()->json(
                    [
                    'status' =>'200',
                    'msg' => 'Updated Successfully.'
                    ]);
            }
            catch(Exception $e)
            {
                return response()->json(
                [
                'status' =>'401',
                'msg' => $e->getMessage()
                ]);
            }
                
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

  public function allergy()
  {
    $session_all=Session::get('sessionadmin');
    if($session_all==false)
    {
        return Redirect::to('/lradmin');
        exit();
    }

    $data = DB::table('tbl_app_allergy')->get();
    
    return view("Admin::app.allergy",compact('data'));
  }

  public function add_allergy($id=null)
  {
    $session_all=Session::get('sessionadmin');
    if($session_all==false)
    {
        return Redirect::to('/lradmin');
        exit();
    }
    if($id!='')
    {
        $data = DB::table('tbl_app_allergy')->where('app_allergy_id',$id)->get();
        return view("Admin::app.add_allergy",compact('data'));
    }
    else
    {
      return view("Admin::app.add_allergy");
    }
  
  }

  public function save_allergy(Request $request)
  {
      if($request->isMethod('post'))
      {
        $allergy = $request->allergy;
        $updateid = $request->updateid;
        if($updateid == '')
        {
            $insert_sql = DB::table('tbl_app_allergy')->insert([
                'allergy_name' => $allergy,
                'admin_status' => 1
            ]);
        
            if($insert_sql == true)
            {
                return response()->json(
                    [
                    'status' =>'200',
                    'msg' => 'Added Successfully.'
                    ]);
            }
            else
            {
                return response()->json(
                [
                'status' =>'401',
                'msg' => 'Something went wrong Please try again later.'
                ]);
            }
        }
        else
        {
            try
            {
                $update_sql = DB::table('tbl_app_allergy')->where('app_allergy_id',$updateid)->update([
                    'allergy_name' => $allergy
                ]);

                return response()->json(
                    [
                    'status' =>'200',
                    'msg' => 'Updated Successfully.'
                    ]);
            }
            catch(Exception $e)
            {
                return response()->json(
                [
                'status' =>'401',
                'msg' => $e->getMessage()
                ]);
            }
                
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

  public function dislike()
  {
    $session_all=Session::get('sessionadmin');
    if($session_all==false)
    {
        return Redirect::to('/lradmin');
        exit();
    }

    $data = DB::table('tbl_app_dislike')->get();
    
    return view("Admin::app.dislike",compact('data'));
  }

  public function add_dislike($id=null)
  {
    $session_all=Session::get('sessionadmin');
    if($session_all==false)
    {
        return Redirect::to('/lradmin');
        exit();
    }
    if($id!='')
    {
        $data = DB::table('tbl_app_dislike')->where('app_dislike_id',$id)->get();
        return view("Admin::app.add_dislike",compact('data'));
    }
    else
    {
      return view("Admin::app.add_dislike");
    }
  
  }

  public function save_dislike(Request $request)
  {
      if($request->isMethod('post'))
      {
        $dislike = $request->dislike;
        $updateid = $request->updateid;
        if($updateid == '')
        {
            $insert_sql = DB::table('tbl_app_dislike')->insert([
                'app_dislike_name' => $dislike,
                'admin_status' => 1
            ]);
        
            if($insert_sql == true)
            {
                return response()->json(
                    [
                    'status' =>'200',
                    'msg' => 'Added Successfully.'
                    ]);
            }
            else
            {
                return response()->json(
                [
                'status' =>'401',
                'msg' => 'Something went wrong Please try again later.'
                ]);
            }
        }
        else
        {
            try
            {
                $update_sql = DB::table('tbl_app_dislike')->where('app_dislike_id',$updateid)->update([
                    'app_dislike_name' => $dislike
                ]);

                return response()->json(
                    [
                    'status' =>'200',
                    'msg' => 'Updated Successfully.'
                    ]);
            }
            catch(Exception $e)
            {
                return response()->json(
                [
                'status' =>'401',
                'msg' => $e->getMessage()
                ]);
            }
                
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

  public function promo_code()
  {
    $session_all=Session::get('sessionadmin');
    if($session_all==false)
    {
        return Redirect::to('/lradmin');
        exit();
    }
    $data = DB::table('tbl_app_promocode')->get();
    return view("Admin::app.promo_code",compact('data'));
  }

  public function add_promo_code($id=null)
  {
    $session_all=Session::get('sessionadmin');
    if($session_all==false)
    {
        return Redirect::to('/lradmin');
        exit();
    }
    $data = DB::table('tbl_app_promocode')->where('promocode_id',$id)->get();
    return view("Admin::app.save_promo_code",compact('data'));
  }

  public function save_promo_code(Request $request)
  {
    if($request->isMethod('post'))
    {
        $updateid = $request->updateid;
        $amount = $request->amount;
        $user_type = $request->user_type;

        if( $amount!='' && $user_type!='' )
        {
            if($updateid=='')
            {
                $promocode = getRandomString(10);
                $insert_sql = DB::table('tbl_app_promocode')->insert([  
                    "promocode" => $promocode,
                    "amount" => $amount,
                    "promocode_user" => $user_type,
                    "promocode_status" => 1,
                ]);
    
                if($insert_sql==true)
                {
                    return response()->json(
                        [
                        'status' =>'200',
                        'msg' => 'Added Successfully.'
                        ]);
                }
                else
                {
                    return response()->json(
                        [
                        'status' =>'401',
                        'msg' => 'Something went wrong, Please try again later.'
                        ]);
                }
            }
            else
            {
                try
                {
                    $update_sql = DB::table('tbl_app_promocode')->where('promocode_id',$updateid)->update([ 
                        "amount" => $amount,
                        "promocode_user" => $user_type
                    ]); 

                    return response()->json(
                        [
                        'status' =>'200',
                        'msg' => 'Updated Successfully.'
                        ]);
                }
                catch(Exception $e)
                {
                    return response()->json(
                        [
                        'status' =>'401',
                        'msg' => $e->getMessage()
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

  public function advertisement()
  {
      $session_all=Session::get('sessionadmin');
      if($session_all==false)
      {
          return Redirect::to('/lradmin');
          exit();
      }

       $data = DB::table('tbl_app_advertisement')->get();

      return view("Admin::app.advertisement",compact('data'));
  }

  public function add_advertisement($id=null)
  {
    $session_all=Session::get('sessionadmin');
    if($session_all==false)
    {
        return Redirect::to('/lradmin');
        exit();
    }
    if($id!='')
    {
        $data = DB::table('tbl_app_advertisement')->where('id',$id)->get();
        return view("Admin::app.save_advertisement",compact('data'));
    }
    else
    {
      return view("Admin::app.save_advertisement");
    }
  
  }

   public function save_advertisement(Request $request)
  {
      if($request->isMethod('post'))
      {
        $updateid = $request->updateid;
        $title = $request->title;
        $description = $request->description;
        $imageidd = $request->file('adv_image'); 

        if($updateid == '')
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
                 $dir = public_path().'/admin/upload/advertisement/'; 
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
                    'msg' => 'Please add image.'
                    ]);
             }

            $insert_sql = DB::table('tbl_app_advertisement')->insert([
                'image' => $filename,
                'title' => $title,
                'description' => $description,
                'admin_status' => 1
            ]);
        
            if($insert_sql == true)
            {
                return response()->json(
                    [
                    'status' =>'200',
                    'msg' => 'Added Successfully.'
                    ]);
            }
            else
            {
                return response()->json(
                [
                'status' =>'401',
                'msg' => 'Something went wrong Please try again later.'
                ]);
            }
        }
        else
        {
            try
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
                 $dir = public_path().'/admin/upload/advertisement/'; 
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
                    $filename_sql = DB::table('tbl_app_advertisement')->where('id',$updateid)->get(['image']); 
                    if(count($filename_sql) > 0)
                    {
                    $filename = $filename_sql[0]->image;
                    }
                    else
                    {
                    $filename = '';
                    }

                }

                $update_sql = DB::table('tbl_app_advertisement')->where('id',$updateid)->update([
                    'title' => $title,
                    'description' => $description,
                    'image' => $filename
                ]);

                return response()->json(
                    [
                    'status' =>'200',
                    'msg' => 'Updated Successfully.'
                    ]);
            }
            catch(Exception $e)
            {
                return response()->json(
                [
                'status' =>'401',
                'msg' => $e->getMessage()
                ]);
            }
                
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

  public function packages()
  {
      $session_all=Session::get('sessionadmin');
      if($session_all==false)
      {
          return Redirect::to('/lradmin');
          exit();
      }
      $data = DB::table('tbl_lr_package')->get();
      return view("Admin::app.packages",compact('data'));
  }

  public function add_packages($id=null)
  {
    $session_all=Session::get('sessionadmin');
    if($session_all==false)
    {
        return Redirect::to('/lradmin');
        exit();
    }

    $area = DB::table('tbl_lr_governorate_area')->where('admin_status','1')->select('lr_governorate_area_name','lr_governorate_area_id')->get();


    if($id!='')
    {
        $data = DB::table('tbl_lr_package')->where('lr_package_id',$id)->get();

         $plan_list = DB::table('tbl_lr_vendor_plan')->join('tbl_lr_vendor_governorate_area','tbl_lr_vendor_governorate_area.lr_user_userid','tbl_lr_vendor_plan.lr_user_id')->where('vendor_plan_type','WEEKLY')->where('vendor_plan_menu_type',$data[0]->package_type)->where('admin_status','1')->where('status','1')->where('vendor_plan_gendor',$data[0]->package_gender)->where('app_status','1')->where('lr_governorate_area_id',$data[0]->lr_governorate_area_id)->select('vendor_plan_id','vendor_plan_name')->get(); ;
        
        $package_detail_sql = DB::table('tbl_lr_package_details')->where('lr_package_id',$id)->get(['vendor_plan_id']);

       

        $package_detail_sql = json_decode( json_encode($package_detail_sql), true);
        return view("Admin::app.save_packages",compact('data','package_detail_sql','area','plan_list'));
    }
    else
    {
      return view("Admin::app.save_packages",compact('area'));
    }
  }

  public function save_packages(Request $request)
  {  
    $priority = array();
    $priority_key = array();
    $plan_id = array();
    $plan_id_key = array();
    $package_name = $request->package_name; 
    $package_description = $request->package_description; 
    $gender = $request->gender; 
    $delivery_time = $request->delivery_time; 
    $package_price = $request->package_price; 
    $priority = $request->priority; 
    $plan_id = $request->plan_id; 
    $updateid = $request->updateid; 
    $imageidd = $request->file('coverimage'); 
    $custom_fixed_menu = $request->custom_fixed_menu;
    $governorate_area = $request->governorate_area;
  

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
       $dir = public_path().'/admin/upload/package/'; 
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
       $image = DB::table('tbl_lr_package')->select('image') ->where('lr_package_id',$updateid)->get();

       $filename = $image[0]->image; 
   }

     if( $updateid == '' )
     {
       DB::beginTransaction();  
       try {
        
            $sql_insert1 = DB::table('tbl_lr_package')
                        ->insert([
                            'package_name' => $package_name,
                            'package_description' => $package_description,
                            'package_gender' => $gender,
                            'package_price' => $package_price,
                            'package_type' =>  $custom_fixed_menu,
                            'delivery_time' =>  $delivery_time,
                            'image' => $filename,
                            'lr_governorate_area_id' => $governorate_area,
                            'admin_status' => 1,
                        ]);

            $last_insert_id = DB::getPdo()->lastInsertId();

            foreach($priority as $key => $priority_val)
            {  
               DB::table('tbl_lr_package_details')->insert([
                            'lr_package_id' => $last_insert_id,
                            'vendor_plan_id' => $plan_id[$key],
                            'week_sequence' => $key
                        ]);
            }
               
            DB::commit();
            return response()->json(
            [
            'status' =>'200',
            'msg' => 'Package Added successfully.'
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
        DB::beginTransaction();
       try {
        
            $sql_insert1 = DB::table('tbl_lr_package')
                        ->where('lr_package_id',$updateid)
                        ->update([
                            'package_name' => $package_name,
                            'package_description' => $package_description,
                            'package_gender' => $gender,
                            'package_price' => $package_price,
                            'package_type' =>  $custom_fixed_menu,
                            'delivery_time' =>  $delivery_time,
                            'lr_governorate_area_id' => $governorate_area,
                            'image' => $filename
                        ]);

            $last_insert_id = DB::getPdo()->lastInsertId();
              DB::table('tbl_lr_package_details')->where('lr_package_id',$updateid)->delete();

            foreach($priority as $key => $priority_val)
            {  
               DB::table('tbl_lr_package_details')->insert([
                            'lr_package_id' => $updateid,
                            'vendor_plan_id' => $plan_id[$key],
                            'week_sequence' => $key
                        ]);
            }
               
            DB::commit();
            return response()->json(
            [
            'status' =>'200',
            'msg' => 'Package Updated successfully.'
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
     
  }

  public function edit_package_priority(Request $request)
  {   
     $package_id = $request->package_id; 
     $plan_id = $request->plan_id; 

     $sql_priority = DB::table('tbl_lr_package_details')->join('tbl_lr_vendor_plan','tbl_lr_vendor_plan.vendor_plan_id','tbl_lr_package_details.vendor_plan_id')->where([
        'lr_package_id' => $package_id,
        'tbl_lr_package_details.vendor_plan_id' => $plan_id
      ])->get(['week_sequence','tbl_lr_package_details.vendor_plan_id','vendor_plan_name']);

     if(count($sql_priority))
     {
        return response()->json(
        [
        'status' =>'200',
        'data' => $sql_priority
        ]);
     }
     else
     {
        return response()->json(
        [
        'status' =>'401',
        'msg' => 'No result.'
        ]);
     }
  }

  public function package_planlisting(Request $request)
  {
     $custom_fixed_menu = $request->custom_fixed_menu; 
     $areaid = $request->areaid; 
     $gender = $request->gender; 

     $plan_list = DB::table('tbl_lr_vendor_plan')->join('tbl_lr_vendor_governorate_area','tbl_lr_vendor_governorate_area.lr_user_userid','tbl_lr_vendor_plan.lr_user_id')->where('vendor_plan_type','WEEKLY')->where('vendor_plan_menu_type',$custom_fixed_menu)->where('admin_status','1')->where('status','1')->where('vendor_plan_gendor',$gender)->where('app_status','1')->where('lr_governorate_area_id',$areaid)->select('vendor_plan_id','vendor_plan_name')->get();

     if(count($plan_list))
     {
        return response()->json(
        [
        'status' =>'200',
        'data' => $plan_list
        ]);
     }
     else
     {
        return response()->json(
        [
        'status' =>'401',
        'data' => 'No result.'
        ]);
     }
  }

  public function package_editplanlisting(Request $request)
  {
       $updateid = $request->updateid;
       $data = DB::table('tbl_lr_package_details')->select('vendor_plan_id')->where('lr_package_id',$updateid)->get();

        return response()->json(
        [
        'status' =>'200',
        'data' => $data
        ]);
  }

}#appcontroller            
