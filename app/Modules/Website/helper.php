<?php


function isemail_exist($tablename,$colname,$email)
{
  $sql=DB::table($tablename)->where($colname,$email)->count();
  
    return $sql;
} 


function contactemail($name)
		{
			$to = "sweta.gupta@karmatech.in"; 
			$subject ='Welcome To Let\'s Routine Contact Form';
			$baseurl=url('/');
			$logo_path=url('/').'/public/website/img/mailer-logo.png';
			$admin_mail="rituraj.kumar@karmatech.in";
            $message = "
            <!DOCTYPE html>
            <html lang='en'>
            <head>
            <meta charset='UTF-8'>
            <title>A new query has been submit</title>
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
            <tbody><tr><td><div><header> </header>
    
            <p style='font: normal 30px arial; line-height: 20px; padding: 0px 40px 15px 40px; text-align: center; color: #b22329; font-weight: bold;'></p>
								 
            <section>
            <p style='color:#000;font-weight:bold;margin-top:15px;margin-bottom:15px; padding:0 0 0 14px;'>Dear Admin,</p>
            <p style='margin-top:15px;margin-bottom:15px;padding:0 0 0 14px;'>".ucfirst($name)." has a query.</p>
            <div>
											
        </div></section></div><span class='m_1398701988460775340im'>
        
        <div style='text-align:left;padding:0px 0;margin:10px 0 0 0;float:left;border-right:8px;border-right:solid 1px #ccc'>
        <img src='$logo_path' alt='Logo' style='width:200px,padding:35px 0' class=''>
        </div>
        <div style='padding:50px 2px;margin:0 2px;float:left'>
        <p style='font-size:12px;line-height:25px'><b>Let's Routine</b></p>
        
        <a href='#' target='_blank'><p style='font-size:13px;line-height:5px'>$baseurl</p></a>
        </div>
        </span></td></tr></tbody></table>
		
        </body>
        </html>
            ";
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: Let\'s Routine. <info@letsroutine.com>' . "\r\n";
        $headers .= 'Bcc:'.$admin_mail. "\r\n";
        if(mail($to, $subject, $message, $headers))
        {
        $status="success"; 
        
        }
        else
        {
        $status="Error";
        }
        }// end of contact form function
        
        