<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class PatioController extends Controller
{
    private $apiUrl = "https://kevinm4ch.pythonanywhere.com/parqueio/";
    
    
    
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


        $client = new Client(['base_uri' => $this->apiUrl]);

        try{

            $response = $client->request('GET', "patio/$patio_id");

            $data = json_decode($response->getBody(), true);

            return view('gerenciar_patio', ['patio' => $data]);

        }catch(\Exception $e){
            return view('api_error', ['error' => $e->getMessage()]);
        }


        return view('gerenciar_patio', ['patioId' => $patio_id]);
    }
}
