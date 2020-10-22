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


          DB::beginTransaction();

         try{

         if ($user!=null) {

           $password       = str_random(8);
           $user->password = bcrypt($password);

           $user->save();

           DB::commit();

           $user->notify(new \App\Notifications\UserForgotPassword($user,$password));

         }

         else {

            flash('Ooops','tu correo electrónico no existe','error');
            Session::flash('warning', 'tu correo electrónico no existe');
             return redirect(URL_USERS_LOGIN);
         }
      }

      catch(Exception $ex){
          DB::rollBack();

         flash('oops...!', $ex->getMessage(), 'error');
         Session::flash('warning', $ex->getMessage());

      }

        flash('Success', 'se envía una nueva contrasena a su cuenta de correo electronico', 'success');
        Session::flash('succes', 'se envía una nueva contrasena a su cuenta de correo electronico');
        return redirect(URL_USERS_LOGIN);

     }
}
