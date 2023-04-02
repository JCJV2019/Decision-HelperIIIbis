<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class RegisterLw extends Component
{
    public $name;
    public $email;
    public $password;

    public function accesoRegister()
    {
        $rules = [
            'name' => 'required|string|max:20|unique:users',
            'email' => 'required|string|email|max:35|unique:users',
            'password' => 'required|string|min:5|max:10'
        ];
        $messages = [
            'email.max' => 'El email ha de ser de 35 caracteres máximo',
            'email.unique' => 'Ya existe este email en la lista de usuarios',
            'email.required' => 'El email es requerido',
            'email.email' => 'El email está mal formado',
            'name.max' => 'El nombre de usuario ha de ser de 20 caracteres máximo',
            'name.unique' => 'Ya existe este nombre de usuario',
            'name.required' => 'El nombre de usuario es requerido',
            'password.required' => 'El password es requerido',
            'password.max' => 'El password ha de ser de 10 caracteres máximo',
            'password.min' => 'El password ha de ser de 5 caracteres mínimo',
        ];

        $this->validate($rules, $messages);

        $user = new User();

        $user->name = $this->name;
        $user->email = $this->email;
        $user->password = bcrypt($this->password);

        $user->save();

        $this->reset('password');
        return redirect()->to('home');
    }

    public function render()
    {
        return view('livewire.register-lw');
    }
}
