<?php

require 'PHPMailerAutoload.php';

include 'MailServices/constraint.php';
include 'MailServices/validation.php';


// Subscriber User Profile  Detail
$contact_name=validate_input($_POST["subscriber_name"]);
$contact_email=validate_input($_POST["subscriber_email"]);
$contact_mobile=validate_input($_POST["subscriber_mobile"]);
$contact_address=$_POST["subscriber_address"];
$contact_occupation=validate_input($_POST["subscriber_occupation"]);
$contact_message=$_POST["subscriber_message"];

// Subscriber User Plan  Detail
$contact_duration=$_POST["subscriber_plan"];
$contact_product=$_POST["subscriber_product"];
$contact_type=$_POST["subscriber_type"];
$contact_size=$_POST["subscriber_size"];
$contact_type_image="lknl";

// echo "hejbkb";
if($contact_name === NULL) {
echo 'null';
}else {
date_default_timezone_set('Asia/Kolkata');
$now = new DateTime();
$currentDate= $now->format('Y-m-d H:i:s');
if(!file_exists("SubscribedUserList.csv")) {
    $list=array(
    array(
        "Subscriber_Name",
        "Subscriber_Email",
        "Subscriber_Mobile",
        "Subscriber_Address",
        "Subscriber_Occupation",
        "Subscriber_Message",
        "Subscribe_Date",
        "Subscriber_Pack",
        "Subscriber_Product",
        "Subscriber_Type",
        "Subscriber_Size"
    ),array(
        $contact_name, 
        $contact_email, 
        $contact_mobile,
        $contact_address,
        $contact_occupation,
        $contact_message,
        $currentDate,
        $contact_duration,
        $contact_product,
        $contact_type,
        $contact_size
    )
);
}else {
    $list=array(
        array(
            $contact_name, 
            $contact_email, 
            $contact_mobile,
            $contact_address,
            $contact_occupation,
            $contact_message,
            $currentDate,
            $contact_duration,
            $contact_product,
            $contact_type,
            $contact_size
        )
    );
}


$fp=fopen("SubscribedUserList.csv", "a");
$count_row=count($fp);
// echo $count_row;


// echo $count_row;

foreach($list as $field) {
    fputcsv($fp,$field);
}

$count_row=1;

$mail = new PHPMailer;

$mail->SMTPDebug = 0;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
// $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
$mail->Host = $hostName;
$mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = $userName;                 // SMTP username
$mail->Password = $userPassword;                           // SMTP password
$mail->SMTPSecure = $SMTPSecure;                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = $port;                                    // TCP port to connect to

// Maillin details
$mail->setFrom($userName, $hostDisplayName);
$mail->addAddress($contact_email, $contact_name);     // Add a recipient
$mail->addReplyTo($userName, $hostDisplayName);
$mail->addCC($userName, $hostDisplayName);
//$mail->addBCC('bcc@example.com');

//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML
$mail->Subject = $defaultSubject;
// <= PHP 5
// $file = file_get_contents('MailServices/mail_templet.txt', true);
// > PHP 5
// $file = file_get_contents('MailServices/mail_templet.txt', FILE_USE_INCLUDE_PATH);



// echo $file;



$mail->header = "MIME-Version: 1.0\r\n Content-type: text/html\r\n";
// $mail->header = "";

$composeMail='<html>

<body>
    <div align="center">
        <h1 style="font-family:Arial, Helvetica, sans-serif">Thank you for subscribing from
            <a style="color:#ff6347; text-decoration: none;" href="http://didiJaisi.com">DidiJaisi</a></h1>

        <img src="http://didijaisi.com/images/logo.png" width="130 " height="39 " title="DidiJaisi" />
        <table width="100% " border="1" cellspacing="2" cellpadding="2 " style="font-family:Arial, Helvetica, sans-serif; border-color:#f5f5f5;">
            <caption style="font-size: 18px;">
                <strong>YOUR SUBSCRIPTION DETAILS</strong>
            </caption>
            <tr>
                <td style="color:#ff6347; font-size:14px; ">Subscription For</td>
                <td style="font-size:12px ">' .$contact_duration .'</td>
            </tr>
            <tr>
                <td style="color:#ff6347; font-size:14px; ">Subscribed Product</td>
                <td style="font-size:12px ">' .$contact_product .'</td>
            </tr>
            <tr>
                <td style="color:#ff6347; font-size:14px; ">Subscribed Product Type</td>
               <td style="font-size:12px ">' .$contact_type .'</td>
            </tr>
            <tr>
                <td style="color:#ff6347; font-size:14px; ">Subscribed Product Size</td>
                <td style="font-size:12px "> ' .$contact_size .'</td>
            </tr>
            <tr>
                <td colspan="2 " style="background-color:#ff6347; color:#ffffff ">
                    <div align="center " style="font-size: 16px;"><strong>Your Personal Information</strong></div>
                </td>
            </tr>
            <tr>
                <td style="color:#ff6347; font-size:14px; ">Subscribed By</td>
                <td style="font-size:12px ">'.$contact_name.'</td>
            </tr>
            <tr>
                <td style="color:#ff6347; font-size:14px; ">Occupation</td>
                <td style="font-size:12px ">'.$contact_occupation.'</td>
            </tr>
            <tr>
                <td style="color:#ff6347; font-size:14px; ">Subscribed Email</td>
                <td style="font-size:12px ">'.$contact_email.'</td>
            </tr>
            <tr>
                <td style="color:#ff6347; font-size:14px; ">Contact Number</td>
                <td style="font-size:12px ">'.$contact_mobile.'</td>
            </tr>
            <tr>
                <td style="color:#ff6347; font-size:14px; ">Address</td>
                <td style="font-size:12px ">'.$contact_address.'</td>
            </tr>
            <tr>
                <td style="color:#ff6347; font-size:14px; ">Additional Info (if any)</td>
                <td style="font-size:12px ">'.$contact_message.'</td>
            </tr>
        </table>
        <h4 style="font-size:12px;color:#3d3d3d; font-family:Arial, Helvetica, sans-serif ">"YOUR FRIEND THAT TIME AND ALL THE TIME "</h4>
    </div>
</body>

</html>';

// echo $composeMail;
$mail->Body = $composeMail;
$mail->AltBody =   $contact_message;
// echo $contact_message;
if(!$mail->send()) {
    echo '{
        "responseCode": 0,
        "msg": "Some Error Occured"
    }';
} else {
    echo '{
        "responseCode": 1,
        "msg": "Mailed sent successfully "
    }';

}


}

?>