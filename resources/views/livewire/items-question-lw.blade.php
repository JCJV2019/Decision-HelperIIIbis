<div class="container">
    <h1 class="m-4 text-4xl font-medium text-center">¿Que duda tienes?</h1>

    <div class="w-full flex justify-center mt-16">
        <input class="w-3/4 text-sm text-gray-500 p-2 borde-focus {{is_null($questionId) ? '' : 'bg-gray-200'}}"
            type="text" placeholder="Pregunta..." {{is_null($questionId) ? '' : 'disabled'}}
            wire:model.defer="questionQuestion">

        <button class="text-white flex justify-center items-center w-9 h-9 outline-2 outline outline-amber-500 border-0 rounded-r {{is_null($questionId) ? 'bg-gray-200 outline-gray-100' : 'bg-amber-500' }}"
            wire:click="deleteQuestion('{{ $questionId }}')" {{is_null($questionId) ? 'disabled' : ''}}>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
            </svg>
        </button>
    </div>

    <br>

    <div class="w-full flex justify-center mt-4">
        <div class="w-11/12">
            <span>Descripción Aspecto:</span>

            @if ($errors->has('questionQuestion') OR  $errors->has('aspecto') OR $errors->has('valorPuntos'))
                <div class="text-red-500 text-sm italic inline-block">TODOS LOS CAMPOS SON OBLIGATORIOS</div>
            @endif

            <input class="w-full my-3 text-sm text-gray-500 p-2 borde-focus"
                type="text" placeholder="Tu concepto..."
                wire:model.defer="aspecto">
            <div class="min-w-max">
                <span class="ml-3">Asignar un valor</span>
                @for ($i = 1; $i <=4; $i++)
                    <label>
                        <input class="mx-1" type="radio" value='{{$i}}'
                            wire:model.lazy="valorPuntos">
                    </label>
                @endfor
                <span id="valorPuntos" class='m-1'>{{$valorPuntos}}</span>
            </div>
        </div>
    </div>

    <div class="w-full flex justify-center">
        <div class="w-11/12 mt-4 inline-flex">
            <button class="p-2 w-full text-white bg-amber-500 mr-2 rounded"
                wire:click="storeItemsQuestion('Positive')">
                Aspecto Positivo
            </button>
            <button class="p-2 w-full text-white bg-amber-500 ml-2 rounded"
                wire:click="storeItemsQuestion('Negative')">
                Aspecto Negativo
            </button>
        </div>
    </div>

    <br>

    <div class="w-full flex justify-center">
        <div class="w-11/12 block text-center sm:flex sm:justify-around">

            <div>
                @livewire('item-basic-lw', [
                    'typeItem' => 'Positive',
                    'questionId' => $questionId,
                    'questionUserId' => $questionUserId,
                    'userAuth' => $userAuth,
                ], key('Positive'))
                <p id="message_borrado_positivo" class="py-1 px-3 text-xs text-amber-600"></p>
            </div>

            <div>
                @livewire('item-basic-lw', [
                    'typeItem' => 'Negative',
                    'questionId' => $questionId,
                    'questionUserId' => $questionUserId,
                    'userAuth' => $userAuth,
                ], key('Negative'))
                <p id="message_borrado_negativo" class="py-1 px-3 text-xs text-amber-600"></p>
            </div>

        </div>
    </div>
    <br>

    @if (!is_null($questionId))
        <div class="w-full h-auto flex justify-center">
            <button class="text-white bg-amber-500 flex justify-center rounded h-10 px-2/5 w-2/5 text-3xl font-medium"
                wire:click="verConsejo({{$questionId}})">Consejo
            </button>
        </div>
    @endif

    <br>
</div>

