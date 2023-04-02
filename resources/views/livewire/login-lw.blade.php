<div class="w-64 h-auto mt-14 mx-auto border border-gray-200 rounded shadow-lg">
    <h1 class="text-xl font-medium mt-5 ml-8">Login Page</h1>

    <div class="w-full py-1 px-3">
        <label class="tracking-wide text-amber-500 text-xs font-medium pl-1" for="email">
            Email
        </label>
        <input class="w-full border-b-2 text-sm text-gray-500 p-1 borde-focus" type="email" autofocus placeholder="Email"
            wire:model.defer="email">
        @error('email')
            <div class="text-red-500 text-xs italic">{{ $message }}</div>
        @enderror
    </div>

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

    <label class="tracking-wide text-amber-500 text-xs font-medium pl-2" for="remember">
        <input type="checkbox" wire:model.defer="remember">
        Recuerda sesión
    </label>

    <p id="{{ 'message_error' }}" class="py-1 px-3 text-red-500 text-xs italic"></p>

    <div class="my-2 grid place-content-end">
        <div class="w-full px-3">
            <button type="submit" class="bg-amber-500 font-medium text-sm text-white py-2 px-4 border-gray-500 rounded borde-focus"
                wire:loading.attr="disabled" wire:target="accesoLogin"
                wire:click="accesoLogin()">
                Login
            </button>
        </div>
    </div>
    <div class="w-full flex justify-center items-center">
        <div class="loader" wire:loading.delay.long wire:target="accesoLogin">
            <div class="dot dot1"></div>
            <div class="dot dot2"></div>
            <div class="dot dot3"></div>
            <div class="dot dot4"></div>
        </div>
    </div>
</div>

