<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Validation\Rule;

class UserListLw extends Component
{
    public $users;
    public $musers = [];

    public function deleteUser($index)
    {
        $id = $this->musers[$index]['id'];
        $user = User::find($id);
        $user->delete();
        $this->reset('musers');
        $this->emit('alertaDeBorrado', 'Registro Borrado');
        // $this->dispatchBrowserEvent('alertaDeBorrado', ['message' => "Registro Borrado"]);
    }

    public function modifyUser($index)
    {
        $id = $this->musers[$index]['id'];
        $user = User::find($id);
        $user->email = $this->musers[$index]['email'];
        $user->name = $this->musers[$index]['name'];

        $rules = [
            'musers.'.$index.'.email' => ['required', 'string', 'email', 'max:35', Rule ::unique('users','email')->ignore($user->id, 'id')],
            'musers.'.$index.'.name' => ['required', 'string', 'max:20', Rule::unique('users','name')->ignore($user->id, 'id')]
        ];
        $messages = [
            'musers.'.$index.'.email.max' => 'El email ha de ser de 35 caracteres máximo',
            'musers.'.$index.'.email.unique' => 'Ya existe este email en la lista de usuarios',
            'musers.'.$index.'.email.required' => 'El email es requerido',
            'musers.'.$index.'.email.email' => 'El email está mal formado',
            'musers.'.$index.'.name.required' => 'El nombre es requerido',
            'musers.'.$index.'.name.max' => 'El nombre ha de ser de 20 caracteres máximo',
            'musers.'.$index.'.name.unique' => 'Ya existe este nombre en la lista de usuarios',
        ];
        $this->validate($rules, $messages);

        $user->save();

        $this->reset('musers');
        $this->emit('alertaDeModificacion', 'Registro Modificado', $index);
        // $this->dispatchBrowserEvent('alertaDeModificacion', ['message' => "Registro Modificado", 'indice' => $index]);
    }

    public function render()
    {
        $this->users = User::all();
        foreach ($this->users as $user) {
            array_push( $this->musers, [
                'id' => $user->id,
                "email" => $user->email,
                "name" => $user->name
            ]);
        }

        return view('livewire.user-list-lw');
    }
}
