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

            <div class="w-full px-2 mx-1">
                <p class="mt-4 w-full text-3xl font-medium">Aspectos Positivos</p>
                @foreach ( $itemsPositives as $index=>$itemPositive )
{{--
                    <div class="flex justify-center">
                        <input class="w-full my-3 text-sm text-gray-500 p-2 mr-1 borde-focus" type="text"
                            wire:model.defer="mItemsPositives.{{$index}}.desc" value="{{ $itemPositive->desc }}">
                        <input class="w-14 my-3 text-sm text-gray-500 p-2 borde-focus" type="number" min="1" max="4"
                            wire:model.defer="mItemsPositives.{{$index}}.point" value="{{ $itemPositive->point }}">
                    </div>
                    <div class="flex justify-end">
                        <p id="{{ 'message_modificado_positivo' . $index }}" class="py-1 px-3 text-amber-600"></p>
                        @error('mItemsPositives.'.$index.'.desc') <span class="py-1 px-3 text-amber-600">{{ $message }}</span> @enderror
                        <button class="text-white bg-amber-500 flex justify-center items-center rounded w-10 h-10 mr-1"
                            wire:click="modifyItem('{{ $index }}', 'Positive')">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                <path d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32l8.4-8.4z" />
                                <path d="M5.25 5.25a3 3 0 00-3 3v10.5a3 3 0 003 3h10.5a3 3 0 003-3V13.5a.75.75 0 00-1.5 0v5.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5V8.25a1.5 1.5 0 011.5-1.5h5.25a.75.75 0 000-1.5H5.25z" />
                            </svg>
                        </button>
                        <button class="text-white bg-amber-500 flex justify-center items-center rounded w-10 h-10 ml-1"
                            wire:click="deleteItem('{{ $index }}', 'Positive')">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                <path fill-rule="evenodd"
                                    d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-1.72 6.97a.75.75 0 10-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 101.06 1.06L12 13.06l1.72 1.72a.75.75 0 101.06-1.06L13.06 12l1.72-1.72a.75.75 0 10-1.06-1.06L12 10.94l-1.72-1.72z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
 --}}
                    @livewire('item-basic-lw', [
                        'typeItem' => 'Positive',
                        'idItem' => $itemPositive->id,
                        'itemDesc' => $itemPositive->desc,
                        'itemPoint' => $itemPositive->point,
                        'index' => $index,
                    ], key('positive-' . $index))

                @endforeach
                <p id="message_borrado_positivo" class="py-1 px-3 text-amber-600"></p>
            </div>

            <div class="w-full px-2 mx-1">
                <p class="mt-4 w-full text-3xl font-medium">Aspectos Negativos</p>
                @foreach ( $itemsNegatives as $index=>$itemNegative)
{{--
                    <div class="flex justify-center">
                        <input class="w-full my-3 text-sm text-gray-500 p-2 mr-1 borde-focus" type="text"
                            wire:model.defer="mItemsNegatives.{{$index}}.desc" value="{{ $itemNegative->desc }}">
                        <input class="w-14 my-3 text-sm text-gray-500 p-2 borde-focus" type="number" min="1" max="4"
                            wire:model.defer="mItemsNegatives.{{$index}}.point" value="{{ $itemNegative->point }}">
                    </div>
                    <div class="flex justify-end">
                        <p id="{{ 'message_modificado_negativo' . $index }}" class="py-1 px-3 text-amber-600"></p>
                        @error('mItemsNegatives.'.$index.'.desc') <span class="py-1 px-3 text-amber-600">{{ $message }}</span> @enderror
                        <button class="text-white bg-amber-500 flex justify-center items-center rounded w-10 h-10 mr-1"
                            wire:click="modifyItem('{{ $index }}', 'Negative')">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                <path
                                    d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32l8.4-8.4z" />
                                <path
                                    d="M5.25 5.25a3 3 0 00-3 3v10.5a3 3 0 003 3h10.5a3 3 0 003-3V13.5a.75.75 0 00-1.5 0v5.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5V8.25a1.5 1.5 0 011.5-1.5h5.25a.75.75 0 000-1.5H5.25z" />
                            </svg>
                        </button>
                        <button class="text-white bg-amber-500 flex justify-center items-center rounded w-10 h-10 ml-1"
                            wire:click="deleteItem('{{ $index }}', 'Negative')">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                <path fill-rule="evenodd"
                                    d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-1.72 6.97a.75.75 0 10-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 101.06 1.06L12 13.06l1.72 1.72a.75.75 0 101.06-1.06L13.06 12l1.72-1.72a.75.75 0 10-1.06-1.06L12 10.94l-1.72-1.72z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
 --}}
                    @livewire('item-basic-lw', [
                        'typeItem' => 'Negative',
                        'idItem' => $itemNegative->id,
                        'itemDesc' => $itemNegative->desc,
                        'itemPoint' => $itemNegative->point,
                        'index' => $index,
                    ], key('negative-' . $index))

                @endforeach
                <p id="message_borrado_negativo" class="py-1 px-3 text-amber-600"></p>
            </div>

        </div>
    </div>
    <br>
    @if (!is_null($questionId) AND (count(iterator_to_array($itemsPositives)) > 0 OR count(iterator_to_array($itemsNegatives)) > 0))
        <div class="w-full h-auto flex justify-center">
            <button class="text-white bg-amber-500 flex justify-center rounded h-10 px-2/5 w-2/5 text-3xl font-medium"
                wire:click="verConsejo({{$questionId}})">Consejo
            </button>
        </div>
    @endif
    <br>
</div>

