<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pátios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-flow-col grid-rows-4 gap-4">
                        @foreach ($patioData as $patio)
                        <div>
                            {{$id = $patio['id']}}
                                <a class="w-10" href="{{ route('patio', ['patio_id'=> $id])}}">
                                    {{ $patio['descricao'] }}
                                </a>
                            </div>
                        
                        @endforeach
                        
                    </div>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>