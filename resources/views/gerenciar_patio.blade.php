<?php 

    $lotado = $patio['vagas_ocupadas'] == $patio['quantidade_vagas'];
    
    $btn_style = "mt-8 inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150";

?>
<x-app-layout header="{{$patio['descricao']}}">
    <div class="flex justify-between">
        <div class="dark:text-white">
            <h1>Vagas ocupadas: {{$patio['vagas_ocupadas']}}/{{$patio['quantidade_vagas']}}</h1>
        </div>
        <form method="post" action="{{route('gerar', ['patio_id'=> $patio['id']])}}" class="p-5">
            @csrf
            <input style="display: none;" type="text" name="patio" value="{{$patio['id']}}">
            <div class="flex justify-between dark:text-white">
                <div>
                    <input class="m-5" type="radio" name="veiculo" id="carro" value="1" checked>
                    <label for="carro">Carro</label>
                </div>
                <div>
                    <input type="radio" name="veiculo" id="moto" value="2">
                    <label for="moto">Moto</label>
                </div>
            </div>

            @if($lotado)
             <x-modal show="true" name="patio lotado">
                <div class="p-5 dark:text-white">
                    <div style="font-size: 24px; font-weight: bold;">Pátio Lotado</div>
                    Não é possível gerar novos tickets no momento
                </div>
             </x-modal>
                <button disabled="disabled" style="background-color: red;" class="{{$btn_style}}">Gerar Ticket</button>
            @else
                <button type="submit" class="{{$btn_style}}">Gerar Ticket</button>
            @endif

        </form>
    </div>


    <h1 style="font-size: x-large; padding: 20px 0;" class="dark:text-white">Tickets ativos neste Pátio</h1>


    <div class="dark:text-white">
        <div style="display: flex;" class="dark:bg-gray-700">
            <div style="flex: 1; text-align: center; font-weight: bold; font-size: 20px;">Código</div>
            <div style="flex: 1; text-align: center; font-weight: bold; font-size: 20px;">Veículo</div>
            <div style="flex: 1; text-align: center; font-weight: bold; font-size: 20px;">Gerado Em</div>
        </div>
        @foreach ($tickets as $ticket)

            <?php
            $data = new DateTime($ticket['entrada']);
            $geradoEm = $data->format('d/m/Y H:i');
            ?>
        <div style="display: flex; padding: 10px 0;" class="border-b border-b-gray-900">
            <div style="flex: 1; text-align: center;">{{$ticket['codigo']}}</div>
            <div style="flex: 1; text-align: center;">{{$ticket['veiculo']['descricao']}}</div>
            <div style="flex: 1; text-align: center;">{{$geradoEm}}</div>
        </div>
        @endforeach
    </div>
    </div>

</x-app-layout>