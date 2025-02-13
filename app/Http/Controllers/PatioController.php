<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class PatioController extends Controller
{
    private $apiUrl = "https://kevinm4ch.pythonanywhere.com/parqueio/";

    private function getTickets(){

        $client = new Client(['base_uri' => $this->apiUrl]);

        try{

            $response = $client->request('GET', 'ticket', );
            
            $data = json_decode($response->getBody(), true);

            return $data;

        }catch (\Exception $e){
            return view('api_error', ['error' => $e->getMessage()]);
        }
    }
    
    
    
    public function getPatios(){

        $client = new Client(['base_uri' => $this->apiUrl]);
        
        try{

            $response = $client->request('GET', 'patio', );
            
            $data = json_decode($response->getBody(), true);


            return view('dashboard', ['patioData' => $data, 'header' => 'Pátios']);

        }catch (\Exception $e){
            return view('api_error', ['error' => $e->getMessage()]);
        }
    }

    public function getPatio($patio_id){
        //Traz todos os tickets desse patio que estão ativos ordenados descendente
        $tickets = array_reverse(array_filter(self::getTickets(), fn($t) => $t['patio']['id'] == $patio_id && $t['ativo']));

        $client = new Client(['base_uri' => $this->apiUrl]);

        try{

            $response = $client->request('GET', "patio/$patio_id");

            $data = json_decode($response->getBody(), true);

            return view('gerenciar_patio', ['patio' => $data, 'tickets' => $tickets]);

        }catch(\Exception $e){
            return view('api_error', ['error' => $e->getMessage()]);
        }


    }

    public function gerarTicket(Request $request){

        
        $client = new Client(['base_uri' => $this->apiUrl]);

        try{
            $body = json_encode(["patio" => $request->patio, "veiculo" => $request->veiculo]);

            $response = $client->request('POST', "ticket", ['body' => $body]);

            $data = json_decode($response->getBody(), true);

            return redirect("patio/". $request->patio);

        }catch(\Exception $e){
            return view('api_error', ['error' => $e->getMessage()]);
        }


    }
}
