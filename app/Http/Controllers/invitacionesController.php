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
       //dd($sub);
        //$data['invitaciones'] = $invitacion;
        //dd($data);

        return view('admin.sub_catogories.invitaciones', $data, compact('invitacion'));
    }

    public function importExcel(Request $request){
//        $auction_id = $request->get('auction_id');
//        dd($auction_id);
//        $auction_id->save();

        $file = $request->file('file');
        Excel::import(new InvitacionesImport, $file);

        return back()->with('message',' Importacion de datos completada');
    }

    public function enviarCorreo(Request $request){
        $lote = $request->get('auction_id');//154
        $invitacion = Invitaciones:://154
                    where('auction_id',$lote)
                    ->select('email')
                    ->get();

        $email = $request->get('email');
        dd($email);

         $data['invitaciones'] = $invitacion;
         $data['invitaciones']->implode('email', ', ');

           //dd($data['invitaciones']);

          try {
              $mail = new PHPMailer(true);
                //Server settings
                $mail->SMTPDebug = 0;                               // Enable verbose debug output
                $mail->isSMTP();                                    // Send using SMTP
                $mail->Host = 'smtp.gmail.com';

                $mail->SMTPAuth = true;                            // Enable SMTP authentication ACCESO A CUENTA
                $mail->Username = 'dinopiza@gmail.com';            // SMTP username ACCESO A CUENTA
                $mail->Password = 'Ytumamatambien16486&';           // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;   // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port = 587;

                //Recipients
                $mail->setfrom('contacto@eago.com.mx', 'EAGO'); //DESDE DONDE SE VA AENVIAR
                $mail->addaddress($correo);//aldiazm.11@gmail.com

                // Add a recipient
                //  $mail->addaddress('contacto_webtech@yahoo.com', 'Information-copia');
                $mail->isHTML(true);                               // Set email format to HTML
                $mail->Subject = 'Recuperacion de contrasena Subastas';
                $mail->Body = 'Hola';

                if ($mail->send()) {
                    $messages[] = "correo  ha sido enviado con éxito.";
                    var_dump($messages);
                    // dd($messages);
                } else {
                    $errors[] = "Lo sentimos, el correo falló. Por favor, regrese y vuelva a intentarlo.";
                    //dd($errors);
                }

          } catch (Exception $e) {
                echo "Hubo un error al enviar el mensaje: {$mail->ErrorInfo}";
               // dd($e);
          }

        flash('Success', 'se envía una nueva contrasena a su cuenta de correo electronico', 'success');
           return back()->with('message',' Importacion de datos completada');

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
