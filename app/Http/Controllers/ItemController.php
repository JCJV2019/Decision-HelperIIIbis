<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ItemController extends Controller
{
    public function tip(Question $question)
    {
        $userAuth = Auth::user();
        if ($question->user_id == $userAuth->id) {
            $itemsPositives = Item::where('question_id', $question->id)
                                    ->where('type', 'positive')->get();
            $itemsNegatives = Item::where('question_id', $question->id)
                                    ->where('type', 'negative')->get();

            $sumaP = 0;
            $sumaN = 0;
            foreach ($itemsPositives as $itemPositive) {
                $sumaP += $itemPositive->point;
            }
            foreach ($itemsNegatives as $itemNegative) {
                $sumaN += $itemNegative->point;
            }

            $mediaG = count($itemsPositives) + count($itemsNegatives) / 2;
            $mediaP = $sumaP / $mediaG;
            $mediaN = $sumaN / $mediaG;
            $puntuacionP = round(($mediaP / ($sumaP + $sumaN)) * 100, 2);
            $puntuacionN = round(($mediaN / ($sumaP + $sumaN)) * 100, 2);

            $diferencia = round($puntuacionP - $puntuacionN, 2);

            if (abs($diferencia) > 1) {
                if ($diferencia > 0 ) {
                    // Positivo
                    $semaforo = 3;
                } else {
                    // Negativo
                    $semaforo = 1;
                }
            } else {
                // Indiferente
                $semaforo = 2;
            }

            return view('questionTipPage', ['puntuacionP' => $puntuacionP, 'puntuacionN' => $puntuacionN, 'semaforo' => $semaforo, 'question' => $question]);
        } else {
            return to_route('questionUser.list');
        }
    }
}
