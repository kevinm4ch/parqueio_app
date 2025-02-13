<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use PhpParser\Node\Stmt\TryCatch;

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

    public function getTicket(Request $request){

        $client = new Client(['base_uri' => $this->apiUrl]);

        if(isset($request->ticket)){
            try {

                $response = $client->request('GET', "ticket/". $request->ticket);

                $ticket = json_decode($response->getBody(), true);

                if(!$ticket['ativo']){
                    return view('pagar_ticket', ['msg' => ['label' => 'Ticket não encontrado', 'text' => "Não foi possível encontrar o ticket informado"]]);
                }
                
                return view('pagar_ticket', ['ticket' => $ticket]);

            } catch (\Exception $e) {
                return view('pagar_ticket', ['msg' => ['label' => 'Ticket não encontrado', 'text' => "Não foi possível encontrar o ticket informado"]]);
            }
        }

        if(isset($request->valor_total)){

            try {
                $body = json_encode(["valor_pago" => intval($request->valor_total)]);
                
                $response = $client->request('PUT', ("ticket/pay/" . $request->codigo), ['body' => $body]);
                
                return view('pagar_ticket', ['msg' => ['label' => 'Ticket Pago com Sucesso', 'text' => "O ticket foi pago com sucesso"]]);

            } catch (\Exception $e) {

                return view('pagar_ticket', ['msg' => ['label' => 'Ticket não encontrado', 'text' => "Não foi possível encontrar o ticket informado"]]);
            }
        }

        return view('pagar_ticket');

    }
}
