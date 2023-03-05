<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\sendMail; 
use Illuminate\Support\Facades\Mail;

class SendEmailController extends BaseController
{
    protected $dataEmail = '';
    protected $subject = '';

    public function sendEmail(Request $request){
        
        /*$emails = [];
        $i=0;
        foreach ($request->get('emailPersonas') as $email) {
            $emails[] = $email[$i];
            $i++;
        }*/
          
            
        $dataEmail = array(
                    'email'         => $request->get('email'),
                    'date'          => $request->get('date'),
                    'rol'           => $request->get('rol'),
                    'encargo'       => $request->get('encargo'),
                    'caratulado'    => $request->get('caratulado'),
                    'tribunal'      => $request->get('tribunal'),
                    'msg'           => $request->get('msg'),
        );

            $subject = $request->get('asunto');
        if($request->get('emailPersonas')){
            
            $emails = explode(',',implode($request->get('emailPersonas')));

            Mail::to($dataEmail['email'])
            ->cc($emails)
            ->send(new sendMail($dataEmail,$subject));
        }else{
            Mail::to($dataEmail['email'])
            ->send(new sendMail($dataEmail,$subject));
        }

            
            
            return $this->sendResponse($dataEmail, 'El Correo fue enviado!');
        
        

        
    }

}
