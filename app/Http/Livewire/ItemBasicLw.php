<?php

namespace App\Http\Livewire;

use App\Models\Item;
use Livewire\Component;
use Illuminate\Validation\Rule;

class ItemBasicLw extends Component
{
    public $typeItem;
    public $questionId;
    public $questionUserId;
    public $userAuth;
    //
    public $items;
    public $mItems = [];

    protected $listeners = ['refreshComponent' => '$refresh', 'registroAlta'];

    public function registroAlta($typeItem, $index)
    {
        if ($typeItem == $this->typeItem) {
            if ($index < 0){
                $index = count($this->mItems);

            } else {

            }
            $this->emitSelf('refresComponent');
            $this->emit('alertaDeAltaItem', 'Registro dado de alta', $index, $typeItem);
            //$this->dispatchBrowserEvent('alertaDeAlta', ['message' => "Registro dado de alta", 'indice' => $index, 'tipo' => $typeItem]);
        }
    }

    public function modifyItem($index)
    {
        $rules = [
            'mItems.*.desc' => 'required|string',
            'mItems.*.point' => ['required', Rule::in(['1','2','3','4'])]
        ];
        $messages = [
            'mItems.*.desc.required' => 'La descripción es requerida',
            'mItems.*.point.required' => 'La puntuación es requerida',
            'mItems.*.point.in' => 'La puntuación ha de ser entre 1 y 4',
        ];

        $this->validate($rules, $messages);

        $id = $this->items[intval($index)]['id'];
        $item = Item::findOrFail($id);
        $item->desc = $this->mItems[intval($index)]['desc'];
        $item->point = $this->mItems[intval($index)]['point'];

        $item->save();

        $this->emit('alertaDeModificacionItem', 'Registro modificado', $index, $this->typeItem);
        // $this->dispatchBrowserEvent('alertaDeModificacion', ['message' => "Registro modificado", 'indice' => $index, 'tipo' => $typeItem]);
    }

    public function deleteItem($index)
    {
        $id = $this->items[intval($index)]['id'];
        $item = Item::findOrFail($id);

        $item->delete();

        $this->emitSelf('refreshComponent');

        $this->emit('alertaDeBorradoItem', 'Registro dado de baja', $this->typeItem);
        // $this->dispatchBrowserEvent('alertaDeBorrado', ['message' => "Registro dado de baja", 'indice' => $index, 'tipo' => $typeItem]);
    }

    public function render()
    {
        $this->items = [];
        $this->mItems = [];

        if (is_null($this->questionId)) {
            $this->items = [];
            $this->mItems = [];
        } else {
            if ($this->questionUserId == $this->userAuth->id) {
                $this->items = Item::where('question_id', $this->questionId)
                                        ->where('type', $this->typeItem)->get();
                foreach ($this->items as $item) {
                    array_push( $this->mItems, [
                        "id" => $item->id,
                        "desc" => $item->desc,
                        "point" => $item->point,
                        "type" => $item->type,
                    ]);
                }
            } else {
                return to_route('questionUser.list');
            }
        }

        return view('livewire.item-basic-lw');
    }
}
