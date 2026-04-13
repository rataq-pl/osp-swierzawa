<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class Mailing extends Controller
{
    public static function mail($do_kogo, $temat, $tresc){
        require base_path("vendor/autoload.php");
        $mail = new PHPMailer(true);     // Passing `true` enables exceptions

        try {

            // Email server settings
            $mail->SMTPDebug = 0; //Alternative to above constant = 2 - enable
            $mail->isSMTP();
            $mail->Host = 'h22.seohost.pl';             //  smtp host
            $mail->SMTPAuth = true;
            $mail->Username = 'powiadomienia@osp-swierzawa.pl';   //  sender username
            $mail->Password = 'jxB0s3NKy';       // sender password
            //$mail->Username = 'powiadomienia@kortezoo.pl';   //  sender username
            //$mail->Password = 'taIoVO0f';       // sender password
            $mail->SMTPSecure = 'tls';                  // encryption - ssl/tls
            $mail->Port = 587;                          // port - 587/465
            $mail->CharSet = 'UTF-8';
            
            $mail->setFrom('powiadomienia@kortezoo.pl', 'OSP Świerzawa');
            $mail->addAddress($do_kogo);
            $mail->addReplyTo('biuro@osp-swierzawa.pl', 'OSP Świerzawa');

            $mail->isHTML(true);                // Set email content format to HTML

            $mail->Subject = $temat;
            $mail->Body    = $tresc;
            $mail -> send();
            // $mail->AltBody = plain text version of email body;
        } catch (Exception $e) {
             echo 'Błąd';
        }
    }
}
