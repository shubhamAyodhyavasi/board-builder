<?php
$flower = $emb_json_decode['flower'];
$cactus = $emb_json_decode['cactus'];
$wreaths = $emb_json_decode['wreaths'];
$flowercolor =  $emb_json_decode['flowercolor'];
$cactuscolor = $emb_json_decode['cactuscolor'];
$wreathscolor = $emb_json_decode['wreathscolor'];
$taxture = $emb_json_decode['taxture'];

$firstword = $first_json_decode['firstword'];
$f_size = $first_json_decode['f_size'];
$f_color = $first_json_decode['f_color'];
$f_font =  $first_json_decode['f_font'];

$secondword = $second_json_decode['secondword'];
$s_size = $second_json_decode['s_size'];
$s_color = $second_json_decode['s_color'];
$s_font = $second_json_decode['s_font'];
$admin_email = get_option( 'admin_email' );
$to_email    = $emailid;
$url = home_url();
 $subject     = 'Board Builder Order Notification';
 $headers = array('Content-Type: text/html; charset=UTF-8', 'From: Board Builder <' . $admin_email . '>', 'Cc: '.$admin_email);
// $headers[] = 'From: Board Builder <' . $admin_email . '>';
// $headers[] = array('Content-Type: text/html; charset=UTF-8');
// $headers[] = 'Cc: '.$admin_email;
 $message = '
 <table width="640" cellspacing="0" cellpadding="0" border="0" align="center" style="max-width:640px; width:100%; background-color:#efeef3; margin:0; padding:0;">
     <tr>
         <th>
             <h1 style="font-family: Arial; font-size:24px; color:#fff; background-color:#1b5a79; padding:25px; font-weight:normal; text-align:left; margin:0;">' . $subject . '</h1>
         </th>
     </tr>
     <tr>
         <td>
             <h2 style="font-family: Arial; font-size:22px; color:#333333; padding:10px 0 20px 0; font-weight:bold; text-align:left; margin:0;">Hello ' . $username . ',</h2>
                <p style="font-family: Arial; font-size:15px; color:#333333; padding:0 0 20px 0; font-weight:normal; text-align:left; margin:0;">You have successfully Design your board.</span></p>
             <p style="font-family: Arial; font-size:15px; color:#333333; padding:0 0 20px 0; font-weight:normal; text-align:left; margin:0;">The Download Limit Remain for you is:' . $new_limit . '.</p>
             <p style="font-family: Arial; font-size:15px; color:#333333; padding:0 0 20px 0; font-weight:normal; text-align:left; margin:0;">Order ID: ' . $order_id . '.</p>
             <p style="font-family: Arial; font-size:15px; color:#333333; padding:0 0 20px 0; font-weight:normal; text-align:left; margin:0;">You can download the design pdf by <a href="' . $url . '/board-builder?file=' . $newfilename . '">Download the pdf</a></p>
         </td>
     </tr>
     <tr>
        <td>
            <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border:1px solid #dedede">
                <thead>
                    <tr style="background-color:#f4f3f7; border:1px solid #dedede; font-family: Arial; font-size:12px; color:#333333; text-align:left;">
                        <th style="padding:5px; width:20%;">Taxture Selected</th>
                        <th style="padding:5px; width:25%;">Board First Word Details</th>
                        <th style="padding:5px; width:15%;">Board Second Word Details</th>
                        <th style="padding:5px; width:25%;">Board Emblishment Details</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="font-family: Arial; font-size:12px; color:#333333; text-align:left;">
                        <td style="padding:5px;"> ' . $taxture . '</td>
                        <td style="padding:5px;"> First Word is:' . $firstword . ' 
                        Font size: ' . $f_size . '
                        Font color: ' . $f_color . '
                        Font Used: ' . $f_font . '</td>
                        <td style="padding:5px;"> Second Word is:' . $secondword . ' 
                        Font size: ' . $s_size . '
                        Font color: ' . $s_color . '
                        Font Used: ' . $s_font . '</td>
                        <td style="padding:5px;"> Flower used :' . $flower . ' 
                        Flower Color: ' . $flowercolor . '
                        Cactus Used: ' . $cactus . '
                        Cactus Color: ' . $cactuscolor . '
                        Wreaths Used: ' . $wreaths . '
                        Wreaths Color: ' . $wreathscolor . '</td>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr>
     <tr>
         <td>
                <p style="font-family: Arial; font-size:15px; color:#333333; padding:30px 0 20px; font-weight:normal; text-align:left; margin:0;"><span style="font-weight:bold;">For further inquiry you can contact us on following details.</span></p>
               <p style="font-family: Arial; font-size:15px; color:#333333; padding:0; font-weight:normal; text-align:left; margin:0;">Email: <a href="mailto:' . $admin_email . '" style="color:#1a8ec5; text-decoration:none;">' . $admin_email . '</a></p>
         </td>
     </tr>	 
 </table>';
 $clientmailresult = false;
 $clientmailresult  = wp_mail( $to_email, $subject, $message, $headers );
 if ( $clientmailresult == 1 ) {
     $clientmailresult = 'Client mail Send successfully';
     echo esc_attr( $clientmailresult );
 } else {
     $clientmailresult = 'problem in sending Client mail';
     echo esc_attr( $clientmailresult );
 }