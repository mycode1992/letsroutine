<?php

    function check_old_password($user_uniqueid,$old_password)
    {
        $is_exists = DB::table('tbl_app_user')->where('user_uniqueid',$user_uniqueid)->where('app_user_password',md5($old_password))->count();
        return $is_exists;
    }

    function getAreaName($area_id)
    {
       $area_name_sql = DB::table('tbl_lr_governorate_area')->where('lr_governorate_area_id',$area_id)->get(['lr_governorate_area_name']);
       return $area_name_sql[0]->lr_governorate_area_name;
    }

    function in_array_r($needle, $haystack, $strict = false) {
        foreach ($haystack as $item) {
            if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
                return true;
            }
        }
    
        return false;
    }

    function getRandomOrderid($length)
    {  
        $validCharacters = "abcdefghijklmnopqrstuxyvwz0123456789ABCDEFGHIJKLMNOPQRSTUXYVWZ0123456789";
        $validCharNumber = strlen($validCharacters);
        $result = "";
        for ($i = 0; $i < $length; $i++)
        {

            $index = mt_rand(0, $validCharNumber - 1);
            $result .= $validCharacters[$index];
        }
        $finalresult = $result;
        return $finalresult;
    }
?>