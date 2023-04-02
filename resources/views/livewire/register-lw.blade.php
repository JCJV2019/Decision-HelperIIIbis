<div class="w-52 h-96 mt-14 mx-auto border border-gray-200 rounded shadow-lg">
    <h1 class="text-xl font-medium mt-5 ml-8">Register Page</h1>

    <div class="w-full py-1 px-3">
        <label class="tracking-wide text-amber-500 text-xs font-medium pl-1" for="name">
            User
        </label>
        <input class="w-full uppercase border-b-2 text-sm text-gray-500 p-1 borde-focus" type="text" placeholder="Name"
            wire:model.defer="name">
        @error('name')
            <div class="text-red-500 text-xs italic">{{ $message }}</div>
        @enderror
    </div>

    <br>

    <div class="w-full py-1 px-3">
        <label class="tracking-wide text-amber-500 text-xs font-medium pl-1" for="email">
            Email
        </label>
        <input class="w-full border-b-2 text-sm text-gray-500 p-1 borde-focus" type="email" placeholder="Email"
            wire:model.defer="email">
        @error('email')
            <div class="text-red-500 text-xs italic">{{ $message }}</div>
        @enderror
    </div>

    <br>

    <div class="w-full py-1 px-3">
        <label class="tracking-wide text-amber-500 text-xs font-medium pl-1" for="password">
            Password
        </label>
        <input class="w-full text-sm border-b-2 text-gray-500 p-1 borde-focus" type="password" placeholder="Password"
            wire:model.defer="password">
        @error('password')
            <div class="text-red-500 text-xs italic">{{ $message }}</div>
        @enderror
    </div>

    {{-- <p id="{{ 'message_error' }}" class="py-1 px-3 text-red-500 text-xs italic"></p> --}}

    <div class="mt-2 grid place-content-end">
        <div class="w-full px-3">
            <button type="submit" class="bg-amber-500 font-medium text-sm text-white py-2 px-4 border-gray-500 rounded borde-focus"
                wire:click="accesoRegister()">
                Register
            </button>
    </div>
</div>

