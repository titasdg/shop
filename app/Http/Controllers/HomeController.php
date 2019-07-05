<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except("send",'sendOrderEmail');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function mail()
    {
        return view('mail');
    }


    public function send(Request $request)
    {
        $mail = new \PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 1;                                                                         // Enable verbose debug output
            $mail->isSMTP();                                                                       // Set mailer to use SMTP
            $mail->CharSet = 'UTF-8';
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $mail->Host = 'smtp.gmail.com';                                                          // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                                                                  // Enable SMTP authentication
            $mail->Username = env('MAIL_USERNAME','m.kaselionis@gmail.com');                      // SMTP username
            $mail->Password = env('MAIL_PASSWORD','default_value');                      // SMTP password
            $mail->SMTPSecure = 'tls';                                                                // Enable TLS encryption, `ssl` also accepted
            $mail->Port = env('MAIL_PORT',587);                                         // TCP port to connect to

            //Recipients
            $mail->setFrom($request->from);
            $mail->addAddress(env('MAIL_USERNAME','m.kaselionis@gmail.com'));         // Add a recipient
            // Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $request->subject;
            $mail->Body =  "<html>
                                <head>
                                </head>
                                <body>
                                    <h3>Gauta žinutė nuo: $request->name, <b>$request->from</b> </h3>
                                    <p>$request->message </p>
                                </body>
                            </html>";
            $mail->AltBody = $request->message;

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

}




