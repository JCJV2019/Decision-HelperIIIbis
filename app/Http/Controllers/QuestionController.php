<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('questionListPage');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show($question=null)
    {
        if (is_null($question)) {
            $questionNew = new Question;
        } else {
            $userAuth = Auth::user();
            $questionNew=Question::findOrFail($question);
            if ($questionNew->user_id <> $userAuth->id) {
                return to_route('questionUser.list');
            }
        }
        return view('itemsQuestionPage', ['question' => $questionNew]);
    }
}
