<div class="w-full px-2 mx-1">
    <p class="mt-4 w-full text-3xl font-medium">Aspectos {{substr($typeItem, 0, -1) . 'os'}}</p>
    @foreach ( $items as $index=>$item )
        <div class="flex justify-center">
            <input class="w-full my-3 text-sm text-gray-500 p-2 mr-1 borde-focus" type="text"
                wire:model.defer="mItems.{{$index}}.desc" value="{{ $item->desc }}">
            <input class="w-14 my-3 text-sm text-gray-500 p-2 borde-focus" type="number" min="1" max="4"
                wire:model.defer="mItems.{{$index}}.point" value="{{ $item->point }}">
        </div>
        <div class="flex justify-end">
            <p id="{{ 'message_modificado_' . strtolower(substr($typeItem, 0, -1)) . 'o' . $index }}" class="py-1 px-3 text-xs text-amber-600"></p>
            @error('mItems.'.$index.'.desc') <span class="py-1 px-3 text-xs text-amber-600">{{ $message }}</span> @enderror
            @error('mItems.'.$index.'.point') <span class="py-1 px-3 text-xs text-amber-600">{{ $message }}</span> @enderror
            <button class="text-white bg-amber-500 flex justify-center items-center rounded w-10 h-10 mr-1"
                wire:click="modifyItem('{{ $index }}')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                    <path d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32l8.4-8.4z" />
                    <path d="M5.25 5.25a3 3 0 00-3 3v10.5a3 3 0 003 3h10.5a3 3 0 003-3V13.5a.75.75 0 00-1.5 0v5.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5V8.25a1.5 1.5 0 011.5-1.5h5.25a.75.75 0 000-1.5H5.25z" />
                </svg>
            </button>
            <button class="text-white bg-amber-500 flex justify-center items-center rounded w-10 h-10 ml-1"
                wire:click="deleteItem('{{ $index }}')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                    <path fill-rule="evenodd"
                        d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-1.72 6.97a.75.75 0 10-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 101.06 1.06L12 13.06l1.72 1.72a.75.75 0 101.06-1.06L13.06 12l1.72-1.72a.75.75 0 10-1.06-1.06L12 10.94l-1.72-1.72z"
                        clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    @endforeach
</div>

