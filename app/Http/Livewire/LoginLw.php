<?php

namespace App\Http\Livewire;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LoginLw extends Component
{
    public $email;
    public $password;
    public $remember;

    protected $listeners = ['logout', 'accesoLogin' => '$refresh'];

    public function accesoLogin()
    {
        $rules = [
            'email' => 'required|string|email|max:35',
            'password' => 'required|string|min:5|max:10'
        ];
        $messages = [
            'email.max' => 'El email ha de ser de 35 caracteres máximo',
            'email.required' => 'El email es requerido',
            'email.email' => 'El email está mal formado',
            'password.required' => 'El password es requerido',
            'password.max' => 'El password ha de ser de 10 caracteres máximo',
            'password.min' => 'El password ha de ser de 5 caracteres mínimo',
        ];

        $this->validate($rules, $messages);

        $credentials = [
            'email' => $this->email,
            'password' => $this->password,
        ];
        // retorna booleano si esta este parametro y como está
        $remember = filled($this->remember);
        if (Auth::attempt($credentials, $remember)) {
            //$request->session()->regenerate();
            $this->reset('password');
            return redirect()->to('home');
        } else {
            $this->reset('password');
            $this->emit('alertaDeError', 'Credenciales incorrectas');
            //$this->dispatchBrowserEvent('alertaDeError', ['message' => "Credenciales incorrectas"]);
        }
    }

    public function render()
    {
        return view('livewire.login-lw');
    }
}
