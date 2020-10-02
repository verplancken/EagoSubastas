<?php

namespace App\Http\Controllers\Auth;

use \App;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use \Auth;
use DB;
use Exception;
use Session;

use PHPMailer\PHPMailer\PHPMailer;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';


class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Controlador de restablecimiento de contraseña
    |--------------------------------------------------------------------------
    |
    | Este controlador es responsable de manejar los correos electrónicos de restablecimiento de contraseña y
    | incluye un rasgo que ayuda a enviar estas notificaciones desde
    | su aplicación a sus usuarios. No dude en explorar este rasgo.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Cree una nueva instancia de controlador.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    public function resetUsersPassword(Request $request)
    {


         $user  = User::where('email','=',$request->fp_email)->first();
        // dd($user);

          DB::beginTransaction();

           date_default_timezone_set("America/Mexico_City");
            $mail = new PHPMailer(true);

      try {
        if ($user!=null) {
            //Server settings
            $mail->SMTPDebug = 0;                               // Enable verbose debug output
            $mail->isSMTP();                                    // Send using SMTP
            $mail->Host = 'smtp.gmail.com';               // Set the SMTP server to send through

            $mail->SMTPAuth = true;                            // Enable SMTP authentication ACCESO A CUENTA
            $mail->Username = 'dinopiza@gmail.com';            // SMTP username ACCESO A CUENTA
            $mail->Password = 'Ytumamatambien16486&';           // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;   // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port = 587;                              // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setfrom('contacto@eago.com.mx', 'EAGO'); //DESDE DONDE SE VA AENVIAR
            $mail->addaddress("$request->fp_email");//aldiazm.11@gmail.com

            $password = str_random(8);
            $user->password = bcrypt($password);
            $user->save();
            DB::commit();

            // Add a recipient
            //  $mail->addaddress('contacto_webtech@yahoo.com', 'Information-copia');
            $mail->isHTML(true);                               // Set email format to HTML
            $mail->Subject = 'Recuperacion de contrasena Subastas';

            $mail->Body = '<div style="width:100%; background:#eee; position:relative; font-family:sans-serif; padding-bottom:40px">

								<center>

									<img style="padding:20px; width:10%" src="https://eago.com.mx/general/1595621309.png">

								</center>

								<div style="position:relative; margin:auto; width:600px; background:white; padding:20px">

									<center>


									<h3 style="font-weight:100; color:#999">SOLICITUD DE NUEVA CONTRASEÑA</h3>

									<hr style="border:1px solid #ccc; width:80%">

									<h4 style="font-weight:100; color:#999; padding:0 20px"><strong>Su nueva contraseña temporal: </strong>'.$password.'</h4>

									<a href="https://escuderiaservicios.com/eagosubastas/login" target="_blank" style="text-decoration:none">

									<div style="line-height:60px; background:#0aa; width:60%; color:white">Ingrese nuevamente al sitio</div>

									</a>

									<br>

									<hr style="border:1px solid #ccc; width:80%">

									<h5 style="font-weight:100; color:#999">Si no se inscribió en esta cuenta, puede ignorar este correo electrónico y la cuenta se eliminará.</h5>

									</center>

								</div>

							</div>';
            //dd($mail);

            if ($mail->send()) {
                $messages[] = "correo  ha sido enviado con éxito.";
                var_dump($messages);
                // dd($messages);
            } else {
                $errors[] = "Lo sentimos, el correo falló. Por favor, regrese y vuelva a intentarlo.";
                //dd($errors);
            }
        }else {
            flash('Ooops','tu correo electrónico no existe','error');
            Session::flash('warning', 'tu correo electrónico no existe');
             return redirect(URL_USERS_LOGIN);
       }
      } catch (Exception $e) {
            echo "Hubo un error al enviar el mensaje: {$mail->ErrorInfo}";
           // dd($e);
      }
        flash('Success', 'se envía una nueva contrasena a su cuenta de correo electronico', 'success');
        Session::flash('succes', 'se envía una nueva contrasena a su cuenta de correo electronico');
        return redirect(URL_USERS_LOGIN);

     }
}
