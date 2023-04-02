<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Question;
use Illuminate\Support\Facades\Auth;

class QuestionListLw extends Component
{
    public $questions;
    public $mquestions = [];

    public function deleteQuestion($index)
    {
        $id = $this->mquestions[$index]['id'];
        $question = Question::find($id);
        $question->delete();
        $this->reset('mquestions');
        $this->emit('alertaDeBorrado', 'Registro Borrado');
        // $this->dispatchBrowserEvent('alertaDeBorrado', ['message' => "Registro Borrado"]);
    }

    public function modifyQuestion($index)
    {
        $id = $this->mquestions[$index]['id'];
        $question = Question::find($id);
        $question->question = $this->mquestions[$index]['question'];

        $rules = [
            'mquestions.*.question' => 'required|string'
        ];
        $messages = [
            'mquestions.*.question.required' => 'La pregunta es requerida',
        ];
        $this->validate($rules, $messages);

        $question->save();

        $this->reset('mquestions');
        $this->emit('alertaDeModificacion', 'Registro Modificado', $index);
        // $this->dispatchBrowserEvent('alertaDeModificacion', ['message' => "Registro Modificado", 'indice' => $index]);
    }

    public function render()
    {
        $userAuth = Auth::user();
        $this->questions = Question::where('user_id', $userAuth->id)->get();
        foreach ($this->questions as $question) {
            array_push( $this->mquestions, [
                "id" => $question->id,
                "question" => $question->question
            ]);
        }
        return view('livewire.question-list-lw', compact('userAuth'));
    }
}
