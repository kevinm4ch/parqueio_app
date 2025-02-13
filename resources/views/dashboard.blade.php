<x-app-layout header="Pátios">
@foreach ($patioData as $patio)
    <a href="{{ route('patio', ['patio_id'=> $patio['id']])}}" class="flex justify-between block px-4 py-2 border-b hover:text-red dark:text-white cursor-pointer ">
        <div class="font-bold">{{$patio['descricao']}}</div>
        <div class="text-xs text-center">Vagas Ocupadas<br>{{$patio['vagas_ocupadas']}}/{{$patio['quantidade_vagas']}}</div>
    </a>
@endforeach


</x-app-layout>