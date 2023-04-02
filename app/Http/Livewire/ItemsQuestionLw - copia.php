<?php

namespace App\Http\Livewire;

use App\Models\Item;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Validation\Rule;

class ItemsQuestionLw extends Component
{
    public $itemsPositives ;
    public $mItemsPositives = [];
    public $itemsNegatives;
    public $mItemsNegatives = [];
    //
    public $questionId;
    public $questionQuestion;
    public $questionUser_id;
    //
    public $userAuth;
    //
    public $aspecto;
    public $valorPuntos;

    protected $listeners = ['modifyItem', 'deleteItem', 'refreshComponent' => '$refresh'];

    public function mount(Question $question)
    {
        $this->questionId = $question->id;
        $this->questionQuestion = $question->question;
        $this->questionUser_id = $question->user_id;
        $this->valorPuntos = 1;
    }

    private function resetItem()
    {
        $this->reset('aspecto');
        $this->valorPuntos = 1;
    }

    private function saveItem($typeItem)
    {
        $newItem = new Item();
        $newItem->desc = $this->aspecto;
        $newItem->point =  $this->valorPuntos;
        $newItem->type = $typeItem;
        $newItem->question_id = $this->questionId;
        $newItem->user_id = $this->userAuth->id;

        $newItem->save();

        $this->resetItem();
    }

    public function verConsejo($questionId)
    {
        return to_route('questionTip.tip', ['question' => $questionId]);
    }

    public function deleteQuestion(Question $question)
    {
        $question->delete();

        return to_route('questionUser.list');
    }

    public function storeItemsQuestion($typeItem)
    {
        $rules = [
            'questionQuestion' => 'required|string',
            'aspecto' => 'required|string',
            'valorPuntos' => ['required', Rule::in(['1','2','3','4'])]
        ];
        $this->validate($rules);

        if (is_null($this->questionId)) {
            // No se ha creado aún la IdQuestion

            // Transacción????
            $question = new Question;
            $question->question = $this->questionQuestion;
            $question->user_id = $this->userAuth->id;
            $this->questionUser_id = $this->userAuth->id;

            $question->save();
            $this->questionId = $question->id;

            $this->saveItem($typeItem);

            $this->emit('alertaDeAltaItem', 'Registro dado de alta', 0, $typeItem);
            // $this->dispatchBrowserEvent('alertaDeAlta', ['message' => "Registro dado de alta", 'indice' => 0, 'tipo' => $typeItem]);

        } else {
            // Se ha creado ya la IdQuestion

            if ($typeItem == "Positive") {
                $index = count($this->itemsPositives);
            } elseif ($typeItem == "Negative") {
                $index = count($this->itemsNegatives);
            }

            $this->saveItem($typeItem);

            $this->emit('alertaDeAltaItem', 'Registro dado de alta', $index, $typeItem);
            //$this->dispatchBrowserEvent('alertaDeAlta', ['message' => "Registro dado de alta", 'indice' => $index, 'tipo' => $typeItem]);
        }
    }

    public function modifyItem($typeItem, $idItem, $itemDesc, $itemPoint, $index)
    {
        $item = Item::findOrFail($idItem);
        $item->desc = $itemDesc;
        $item->point = $itemPoint;

        $item->save();

        //$this->emit('alertaDeModificacionItem', 'Registro modificado', $index, $typeItem);
        // $this->dispatchBrowserEvent('alertaDeModificacion', ['message' => "Registro modificado", 'indice' => $index, 'tipo' => $typeItem]);
    }

    public function deleteItem($typeItem, $idItem, $itemDesc, $itemPoint, $index)
    {
        $item = Item::findOrFail($idItem);

        $item->delete();

        $this->emit('alertaDeBorradoItem', 'Registro dado de baja', $typeItem);

/*         if ($typeItem == 'Positive') {
            unset($this->itemsPositives[intval($index)]);
            unset($this->mItemsPositives[intval($index)]);
            //dd($this->itemsPositives, $this->mItemsPositives);
        } elseif ($typeItem == 'Negative') {
            unset($this->itemsNegatives[intval($index)]);
            unset($this->mItemsNegatives[intval($index)]);
        } */

        $this->emitSelf('refreshComponent');
        // $this->dispatchBrowserEvent('alertaDeBorrado', ['message' => "Registro dado de baja", 'indice' => $index, 'tipo' => $typeItem]);
    }

    public function render()
    {
        $this->itemsPositives = [];
        $this->itemsNegatives = [];
        $this->userAuth = Auth ::user();

        if (is_null($this->questionId)) {
            $this->itemsPositives = [];
            $this->itemsNegatives = [];
        } else {
            if ($this->questionUser_id == $this->userAuth->id) {
                $this->itemsPositives = Item::where('question_id', $this->questionId)
                                        ->where('type', 'positive')->get();
                $this->itemsNegatives = Item::where('question_id', $this->questionId)
                                        ->where('type', 'negative')->get();
                foreach ($this->itemsPositives as $itemPositive) {
                    array_push( $this->mItemsPositives, [
                        "id" => $itemPositive->id,
                        "desc" => $itemPositive->desc,
                        "point" => $itemPositive->point,
                        "type" => $itemPositive->type,
                    ]);
                }
                foreach ($this->itemsNegatives as $itemNegative) {
                    array_push( $this->mItemsNegatives, [
                        "id" => $itemNegative->id,
                        "desc" => $itemNegative->desc,
                        "point" => $itemNegative->point,
                        "type" => $itemNegative->type,
                    ]);
                }
            } else {
                return to_route('questionUser.list');
            }
        }

        return view('livewire.items-question-lw');
    }
}
