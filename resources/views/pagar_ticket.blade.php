<?php

function calcularTarifa($horas)
{
    if ($horas >= 5) {
        //Valor da diária R$ 50,00
        return (intdiv($horas, 24) || 1) * 50;
    }

    return ($horas + 1) * 10;
}

$input_style = "border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm";

if (isset($ticket)) {
    $header = "Pagar Ticket";
} else {
    $header = "Buscar Ticket";
}
?>
<x-app-layout header={{$header}}>
    @if(isset($ticket))

    <?php
    $data = new DateTime($ticket['entrada']);
    $data_atual = new Datetime();
    $dataEntrada = $data->format('d/m/Y');
    $horaEntrada = $data->format('H:i');
    $dataSaida = $data_atual->format('d/m/Y');
    $horaSaida = $data_atual->format('H:i');

    $valor_total = calcularTarifa($data->diff($data_atual)->h);
    ?>
    <form method="post" action="{{route('pay')}}">
        @csrf
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; row-gap: 1em;">

            <div>
                <x-input-label>Código</x-input-label>
                <input type="text" name="codigo" id="codigo" class="{{$input_style}}" value="{{$ticket['codigo']}}" readonly>
            </div>
            <div>
                <x-input-label>Veículo</x-input-label>
                <input type="text" name="veiculo" id="veiculo" class="{{$input_style}}" value="{{$ticket['veiculo']['descricao']}}" disabled>
            </div>
            <div>
                <x-input-label>Pátio</x-input-label>
                <input type="text" name="patio" id="patio" class="{{$input_style}}" value="{{$ticket['patio']['descricao']}}" disabled>
            </div>
            <div>
                <x-input-label>Data de Entrada</x-input-label>
                <input type="text" name="data-entrada" id="data-entrada" class="{{$input_style}}" value="{{$dataEntrada}}" disabled>
            </div>
            <div>
                <x-input-label>Data de Saída</x-input-label>
                <input type="text" name="data-saida" id="data-saida" class="{{$input_style}}" value="{{$dataSaida}}" disabled>
            </div>
            <div>
                <x-input-label>Valor total</x-input-label>
                <input type="text" name="valor_total" id="valor_total" class="{{$input_style}}" value='{{"$valor_total,00"}}' readonly>
            </div>
            <div>
                <x-input-label>Hora de Entrada</x-input-label>
                <input type="text" name="hora-entrada" id="hora-entrada" class="{{$input_style}}" value="{{$horaEntrada}}" disabled>
            </div>
            <div>
                <x-input-label>Hora de Saída</x-input-label>
                <input type="text" name="hora-saida" id="hora-saida" class="{{$input_style}}" value="{{$horaSaida}}" disabled>
            </div>

        </div>
        <div style="text-align: center; margin-top: 40px;">
            <x-primary-button>Pagar</x-primary-button>
        </div>
    </form>

    @else
    <form method="post" action="{{route('pay')}}">
        @csrf
        <div style="display: flex; align-items: last baseline;">
            <div>
                <x-input-label>Insira o código do Ticket:</x-input-label>
                <input type="text" name="ticket" id="ticket" class="{{$input_style}}">
            </div>
            <div style="width: 20px;"></div>
            <div>
                <x-primary-button>Buscar</x-primary-button>
            </div>
        </div>
    </form>

    @endif

    @if(isset($msg))
    <x-modal show="true" name="Ticket">
        <div class="p-5 dark:text-white">
            <div style="font-size: 24px; font-weight: bold;">{{$msg['label']}}</div>
            {{$msg['text']}}
        </div>
    </x-modal>
    @endif

</x-app-layout>