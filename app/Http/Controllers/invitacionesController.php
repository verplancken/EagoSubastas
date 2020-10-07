<?php

namespace App\Http\Controllers;

use App\Invitaciones;
use DB;
use Session;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Imports\InvitacionesImport;
use PHPMailer\PHPMailer\PHPMailer;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

use App\Auction;
use App\SubCatogory;

class InvitacionesController extends Controller
{
    function index($slug){
        if(!checkRole(getUserGrade(4)))
        {
            prepareBlockUserMessage();
            return back();
        }

        $data['title']        = getPhrase('edit');
        $data['active_class'] = 'auctions';

        $auction = Auction::getRecordWithSlug($slug);

        $subcategorias = SubCatogory::getRecordWithSlug($slug);

        
        $users = Auction::getSellerOptions();
        $data['users'] = $users;
        $data['sub']   = $subcategorias;
        $data['record']   = $auction;
        $data['layout']   = getLayOut();
        
        $invitacion = DB::table('invitaciones')
                 //   ->where('auction_id',$auction->id)
                    ->get();

        return view('admin.sub_catogories.invitaciones', $data, compact('invitacion'));
    }

    public function importExcel(Request $request){


        $file = $request->file('file');
        Excel::import(new InvitacionesImport, $file);

        return back()->with('message',' Importacion de datos completada');
    }

    public function enviarCorreo(Request $request){
        $lote = $request->get('auction_id');

        $invitacion = Invitaciones::
                    where('auction_id',$lote)
                    ->select('email')
                    ->get();

        $array = array_pluck($invitacion, 'email');
      //  dd($array);

            $invitacion3 = Invitaciones::
                    where('auction_id',$lote)
                    ->where('estatus',0)
                    ->select('email')
                    ->get();

            $array2 = array_pluck($invitacion3, 'email');
          // dd($array2);

 try {
                $mail = new PHPMailer(true);
                $mail->SMTPDebug = 0;                               // Enable verbose debug output
                $mail->isSMTP();                                    // Send using SMTP
                $mail->Host = 'smtp.gmail.com';

                $mail->SMTPAuth = true;                            // Enable SMTP authentication ACCESO A CUENTA
                $mail->Username = 'dinopiza@gmail.com';            // SMTP username ACCESO A CUENTA
                $mail->Password = 'Ytumamatambien16486&';           // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;   // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port = 587;

                $mail->setfrom('contacto@eago.com.mx', 'EAGO'); //DESDE DONDE SE VA AENVIAR

                //  $mail->addaddress('contacto_webtech@yahoo.com', 'Information-copia');
                $mail->isHTML(true);                               // Set email format to HTML

                $mail->Body = '<!doctype html>
                        <html lang="en">
                        <head>
                            <meta charset="UTF-8">
                            <meta name="viewport"
                                  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
                            <meta http-equiv="X-UA-Compatible" content="ie=edge">
                            <title>Document</title>
                        </head>
                        <body>
							<div style="width:100%; background:#fff; position:relative; font-family:sans-serif; padding-bottom:40px">
								<center>
									<img style="padding:20px; width:10%" src="https://eago.com.mx/general/1595961692.gif">
								</center>
								<div style="position:relative; margin:auto; width:600px; background:#fff; padding:20px">
									<center>
									<h1 style="font-weight:100; color:#000"><strong>Bienvenido a EAGO</strong></h1>
									<hr style="border:1px solid #ccc; width:80%">
									<h4 style="font-weight:100; color:#000; padding:0 20px;font-size: 20px">Usted fue invitado a participar en una subasta por favor concluya el registro para poder participar.</h4>
									<a href="https://escuderiaservicios.com/eagosubastas/login" target="_blank" style="text-decoration:none">
									<div style="line-height:50px; background:#0e1c66; width:50%; color:white">Aceptar Invitacion</div>
									</a>
									<br>
									<hr style="border:1px solid #ccc; width:80%">
									<img style="padding:20px; width:40%" src="https://eago.com.mx/Eago-frontend/vistas/img/subastas-persona-bg.png">
									</center>
								</div>
							</div>
                        </body>
                        </html>';

                foreach ($array2 as $email) {
                  $mail->Subject = 'Invitacion de subasta para '.$email.''  ;
                  $mail->AddAddress($email); // Cargamos el e-mail destinatario a la clase PHPMailer

                    $invitacion2 = Invitaciones::where('email', $email)
                        ->first();

                $invitacion2->estatus = 1;
                $invitacion2->save();

                if ($mail->send()) {
                    $messages[] = "correo  ha sido enviado con éxito.";
                    var_dump($messages);
                } else {
                    $errors[] = "Lo sentimos, el correo falló. Por favor, regrese y vuelva a intentarlo.";
                }

                  $mail->ClearAddresses(); // Limpia los "Address" cargados previamente para volver a cargar uno.
                }



          } catch (Exception $e) {
                echo "Hubo un error al enviar el mensaje: {$mail->ErrorInfo}";

          }




            flash('Success', 'Importacion de datos completada desde el sistema', 'success');
           return back()->with('message',' Importacion de datos completada desde el sistema');

    }


    public function destroy($id){
      $invitacion = Invitaciones::findOrFail($id);
      $invitacion->delete();

      return back()->with('message',' Eliminacion de dato completada');
    }


    public function massDestroy(Request $request){

        if (!checkRole(getUserGrade(1))) {
            prepareBlockUserMessage();
            return back();
        }

         $invitacion = Invitaciones::where('id',$request->id)->first();

        if ($isValid = $this->isValidRecord($invitacion)) {

            $response['status']  = 0;
            $response['message'] = getPhrase('record_not_found');

            return json_encode($response);
        }

        if ($redirect = $this->check_isdemo()) {

            $response['status']  = 0;
            $response['message'] = getPhrase('crud_operations_disabled_in_demo');
            return json_encode($response);
        }

        if ($request->id) {
            try {
                  if(!env('DEMO_MODE')) {
                    $entries = Invitaciones::where('id', $request->id)->get();

                        foreach ($entries as $entry) {
                            $entry->delete();
                        }
                  }
                $response['status'] = 1;
                $response['message'] = getPhrase('record_deleted_successfully');
            }
            catch( \Illuminate\Database\QueryException $e){

                   $response['status'] = 0;
                   if(getSetting('show_foreign_key_constraint','module'))
                    $response['message'] =  $e->errorInfo;
                   else
                    $response['message'] =  getPhrase('record_not_deleted');
            }

        } else {
            $response['status'] = 0;
            $response['message'] = getPhrase('invalid_operation');
        }

        return json_encode($response);
    }



    public function getRedirectUrl(){

      return URL_SUB_CATEGORIES;
    }
}