<?php

namespace TrimaxHelp\Http\Controllers;
use Illuminate\Http\Request;
Use Mail;

class ServiceRequestController extends Controller
{
    public function mailer( Request $request ){

        //$all_response = $request->json()->all();
        $machine = $request->json()->get('equipo');
		$solicitante = $request->json()->get('solicitante');
        $caracteristicas = $request->json()->get('caracteristicas');

        try {
			Mail::send('emails.serviceRequest', ['serviceRequest' 		=> $request->json()->all(),
												'equipo'			=> $machine,
												'caracteristicas'	=> $caracteristicas,
												'solicitante'		=> $solicitante
											], function($message){
                                                global $request;
												$serviceRequest = $request->json()->all();
												$solicitante = $request->json()->get('solicitante');
												
				$message->to('desarrollo.trimax@gmail.com', 'Atención a Clientes TRIMAX')->subject(
					$solicitante['nombre']." ".$solicitante['apellido']." ha solicitado ".$serviceRequest['tipoDeSolicitud']
				)->setCharset('UTF-8');
			});
			$mailSent = 'true';
			$errors = null;
		} catch (Exception $e) {
			$mailSent = 'false';
			$errors[] = $e->getMessage();
		}    

        $response = [
            "mailSent" =>  $mailSent, 
            "errors"=>$errors 
        ];

        return response( $response, 200)
        ->withHeaders([
            'Access-Control-Allow-Origin'  => '*',
            'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Headers' => 'accept, Content-Type, x-xsrf-token, x-csrf-token',
        ]);
    }
}