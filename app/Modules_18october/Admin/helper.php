<?php

function getRandomString($length)
{
    $validCharacters = "abcdefghijklmnopqrstuxyvwzABCDEFGHIJKLMNOPQRSTUXYVWZ";
    $validCharNumber = strlen($validCharacters);
    $result = "";
    for ($i = 0; $i < $length; $i++)
    {

        $index = mt_rand(0, $validCharNumber - 1);
        $result .= $validCharacters[$index];
    }
    $finalresult = date('Ymdhis').$result;
    return $finalresult;
}

function ForgotPasswordEmail($name,$email,$token,$role_id)
        {
        if($role_id=='1'){
            $varification_code=url('/').'/lradmin/changepassword/'.$token;
        }else if($role_id=='2'){
            $varification_code=url('/').'/changepassword'.'/'.$token;
        }
        else if($role_id=='App')
        {
            $varification_code=url('/').'/websrvc/changepassword'.'/'.$token; 
        }

        $to = $email;
            
            $username=$name;
            $subject ='Lets Routine Forgot Password';
        $baseurl=url('/');
            $logo_path=url('/').'/public/admin/js/dist/img/Routine_logo.png';
            $admin_mail="";
            $admin_mail3="rituraj.kumar@karmatech.in";
            $admin_mail2="sweta.gupta@karmatech.in";
            $message = "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
    <meta charset='UTF-8'>
    <title>Lets Routine</title>
    <style type='text/css'>
    * {
        margin: 0;
        padding: 0;
    }
    body {
        margin: 0;
        padding: 0;
        font: normal 12px arial;
    }
    .table_center {
        margin: auto;
        border: 1px solid #ccc;
    }
    .table_center_top {
        margin: auto;
        padding-bottom: 3px;
    }

    a {
        text-decoration: none;
    }
    </style>
    </head>
    <body>
    <table cellpadding='0' cellspacing='0' style='border:1px solid #000; padding:10px;margin:auto;width:100%'>
    <tbody><tr><td><div><header>
    <div style='text-align:center;padding:30px 0'>
    <img src='$logo_path' style='margin: auto; display: block;' />
    </div>
    </header>
    <p style='font: normal 30px arial; line-height: 20px; padding: 0px 40px 15px 40px; text-align: center; color: #b22329; font-weight: bold;'></p>
            
    <section>
    <p style='color:#000;font-weight:bold;margin-top:15px;margin-bottom:15px; padding:0 0 0 14px;'>Dear $username,</p>
    <p style='margin-top:15px;margin-bottom:15px;padding:0 0 0 14px;'>Ohh seems that you forgot your password. Click the button below to retrieve new password.
    <br>
    
    </p>
        
    <div>
    <p style='margin:35px 0; text-align: center;'><a href='$varification_code' style='border: solid;
    padding: 10px 20px;
    background: #b61d22;
    text-decoration: none;
    color: #fff;
    margin: auto;'>Change Password</a></p>
    </div></section></div><span class='m_1398701988460775340im'>
    <div style='text-align:left;padding:0px 0;margin:10px 0 0 0;float:left;border-right:8px;border-right:solid 1px #ccc'>
    <img src='$logo_path' alt='Logo' style='width:110px;margin:40px;' class=''>
    </div>
    <div style='padding:50px 2px;margin:0 2px;float:left'>
    <p style='font-size:12px;line-height:25px'><b>Lets Routine Support Team</b></p>
    <a href='#' target='_blank'><p style='font-size:13px;line-height:5px'>$baseurl</p></a>
    </div>
    </span></td></tr></tbody></table>
    </body>
    </html>
    ";  
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: Lets Routine <info@letsroutine.com>' . "\r\n";
    $headers .= 'Bcc:'.$admin_mail.','.$admin_mail2.','.$admin_mail3.'' . "\r\n";
    if(mail($to, $subject, $message, $headers))
    {
    $status="success";
    return($status);
    }
    else
    {
    $status="Error";
    return($status);
    }
        
        
        }// end of ForgotPasswordEmail\
        

    function WelcomeEmail($name,$email,$token)
    {
    $to = $email;
    $varification_code=url('/').'/vendor/verify-email/'.$token;
    $username=$name;
    $subject ='Welcome To Let\'s Routine';
    $baseurl=url('/');
    $logo_path=url('/').'/public/website/img/mailer-logo.png';
    $admin_mail="";
    $admin_mail3="rituraj.kumar@karmatech.in";
    $admin_mail2="sweta.gupta@karmatech.in";
    $message = "
   <!DOCTYPE html>
    <html lang='en'>
    <head>
    <meta charset='UTF-8'>
    <title>Let's Routine</title>
    <style type='text/css'>
    * {
    margin: 0;
    padding: 0;
    }
    body {
    margin: 0;
    padding: 0;
    font: normal 12px arial;
    }
    .table_center {
    margin: auto;
    border: 1px solid #ccc;
    }
    .table_center_top {
    margin: auto;
    padding-bottom: 3px;
    }

    a {
    text-decoration: none;
    }
    </style>
    </head>
    <body>
    <table cellpadding='0' cellspacing='0' style='border:1px solid #21d6e0; padding:10px;margin:auto;width:100%; max-width: 100%;'>
    <tbody><tr><td><div><header>
    <div style='text-align:center;padding:30px 0'>
    <img src='$logo_path' style='margin: auto; display: block; max-width: 100px;' />
    </div>
    </header>

    <p style='font: normal 30px arial; line-height: 20px; padding: 0px 40px 15px 40px; text-align: center; color: #b22329; font-weight: bold;'></p>

    <section>
    <p style='color:#000;font-weight:bold;margin-top:15px;margin-bottom:15px; padding:0 0 0 0px;'>Hi $username,</p>
    <p style='margin-top:15px;margin-bottom:15px;padding:0 0 0 14px;'>

    <p>Thanks for opening an account with Let's Routine! </p>
    <p>We just need you to <a href='$varification_code' style='border: solid;
    padding: 2px 10px;
   background: #6dcfd8;
    text-decoration: none;
    color: #fff;
    font-size:12px;
    display:inline-block;
    margin: auto;'>Verify Email-ID</a> and you’re good to go! </p>
    <div>

    </div></section></div><span class='m_1398701988460775340im'>

    <div style='text-align:left;padding:0px 0;margin:10px 0 0 0;float:left;border-right:8px;border-right:solid 1px #ccc'>
    <img src='$logo_path' alt='Logo' style='width:70px;margin:20px;' class=''>
    </div>
    <div style='padding:50px 2px;margin:0 2px;float:left'>
    <p style='font-size:12px;line-height:25px'><b>LetsRoutine Support Team</b></p>

    <a href='#' target='_blank'><p style='font-size:13px;line-height:5px'>$baseurl</p></a>
    </div>
    </span></td></tr></tbody></table>

    </body>
    </html>
    ";

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: Let\'s Routine <info@letsroutine.com>' . "\r\n";
    $headers .= 'Bcc:'.$admin_mail.','.$admin_mail2.','.$admin_mail3.'' . "\r\n";
    if(mail($to, $subject, $message, $headers))
    {
    $status="success";
    // return($status);
    }
    else
    {
    $status="Error";
    // return($status);
    }


    }// end of WelcomeEmail

    function sendlogindetails($name,$email,$password)
    {
        $to = $email;
        $username=$name;
        $subject ='Welcome To Let\'s Routine';
        $baseurl=url('/');
        $logo_path=url('/').'/public/website/img/mailer-logo.png';
        $admin_mail="";
        $admin_mail3="rituraj.kumar@karmatech.in";
        $admin_mail2="sweta.gupta@karmatech.in";
        $message = "
       <!DOCTYPE html>
        <html lang='en'>
        <head>
        <meta charset='UTF-8'>
        <title>Let's Routine</title>
        <style type='text/css'>
        * {
        margin: 0;
        padding: 0;
        }
        body {
        margin: 0;
        padding: 0;
        font: normal 12px arial;
        }
        .table_center {
        margin: auto;
        border: 1px solid #ccc;
        }
        .table_center_top {
        margin: auto;
        padding-bottom: 3px;
        }
    
        a {
        text-decoration: none;
        }
        </style>
        </head>
        <body>
        <table cellpadding='0' cellspacing='0' style='border:1px solid #21d6e0; padding:10px;margin:auto;width:100%; max-width: 100%;'>
        <tbody><tr><td><div><header>
        <div style='text-align:center;padding:30px 0'>
        <img src='$logo_path' style='margin: auto; display: block; max-width: 100px;' />
        </div>
        </header>
    
        <p style='font: normal 30px arial; line-height: 20px; padding: 0px 40px 15px 40px; text-align: center; color: #b22329; font-weight: bold;'></p>
    
        <section>
        <p style='color:#000;font-weight:bold;margin-top:15px;margin-bottom:15px; padding:0 0 0 0px;'>Hi $username,</p>
        <p style='margin-top:15px;margin-bottom:15px;padding:0 0 0 14px;'>
    
        <p>Your email : $email </p>
        <p>Your email : $password </p>
        <div>
    
        </div></section></div><span class='m_1398701988460775340im'>
    
        <div style='text-align:left;padding:0px 0;margin:10px 0 0 0;float:left;border-right:8px;border-right:solid 1px #ccc'>
        <img src='$logo_path' alt='Logo' style='width:70px;margin:20px;' class=''>
        </div>
        <div style='padding:50px 2px;margin:0 2px;float:left'>
        <p style='font-size:12px;line-height:25px'><b>LetsRoutine Support Team</b></p>
    
        <a href='#' target='_blank'><p style='font-size:13px;line-height:5px'>$baseurl</p></a>
        </div>
        </span></td></tr></tbody></table>
    
        </body>
        </html>
        ";
    
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: Let\'s Routine <info@letsroutine.com>' . "\r\n";
        $headers .= 'Bcc:'.$admin_mail.','.$admin_mail2.','.$admin_mail3.'' . "\r\n";
        if(mail($to, $subject, $message, $headers))
        {
        $status="success";
        // return($status);
        }
        else
        {
        $status="Error";
        // return($status);
        }
    }