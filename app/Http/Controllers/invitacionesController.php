<?php

namespace App\Http\Controllers;

use App\Invitaciones;
use DB;
use Session;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Imports\InvitacionesImport;

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

        $file = $request->file('file');
        Excel::import(new InvitacionesImport, $file);

        $lote = $request->get('auction_id');

       $invitacion = Invitaciones::
                    where('auction_id',$lote)
                    ->first();
                 //dd($invitacion);



        if($lote == $invitacion->auction_id){

         try {
            sendEmail('news_letter_subscription',
                array('title'=>$request->title,
                      'message'=> htmlspecialchars($request->message),
                      'to_email'=>$invitacion->email,
                      'site_url'=>PREFIX,
                      'date'=>date('d-m-Y')));

            flash('success','email_sent_successfully', 'success');

        } catch(Exception $ex) {

            flash('oops...!', $ex->getMessage(), 'error');
        }

          return back()->with('message',' Entro');
        }else{

       //return view('admin.sub_catogories.invitaciones');
       return back()->with('message',' Importacion de datos completada');
        }
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
