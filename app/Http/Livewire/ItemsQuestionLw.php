<?php

namespace App\Http\Livewire;

use App\Models\Item;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Validation\Rule;

class ItemsQuestionLw extends Component
{

    public $questionId;
    public $questionQuestion;
    public $questionUserId;
    public $userAuth;
    //
    public $aspecto;
    public $valorPuntos;

    public function mount(Question $question)
    {
        $this->questionId = $question->id;
        $this->questionQuestion = $question->question;
        $this->questionUserId = $question->user_id;
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

            $this->emit('registroAlta', $typeItem, 0);
        } else {
            // Se ha creado ya la IdQuestion

            $this->saveItem($typeItem);

            $this->emit('registroAlta', $typeItem, -1);

        }
    }

    public function render()
    {
        $this->userAuth = Auth::user();

        return view('livewire.items-question-lw');
    }
}
