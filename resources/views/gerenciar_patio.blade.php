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

            @if($patio['vagas_ocupadas'] == $patio['quantidade_vagas'])
             <?php $lotado = "background-color:red;";?>
             <x-modal show="true" name="patio lotado">
                
                <div class="p-5 dark:text-white">
                    <div style="font-size: 24px; font-weight: bold;">Pátio Lotado</div>
                    Não é possível gerar novos tickets no momento
                </div>
             </x-modal>
            @else
                {{$lotado = ''}} 
            @endif
            
            <x-primary-button class="mt-8" style="{{$lotado}}">Gerar Ticket</x-primary-button>

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